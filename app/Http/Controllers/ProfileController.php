<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Link;
use App\Models\LinkClick;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    protected $analyticsService;
    
    public function __construct(AnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'display_name' => ['nullable', 'string', 'max:255'],
            'username' => [
                'required', 
                'string', 
                'max:50', 
                'regex:/^[a-zA-Z0-9_-]+$/',
                Rule::unique('users')->ignore($user->id)
            ],
            'email' => [
                'required', 
                'string', 
                'lowercase', 
                'email', 
                'max:255', 
                Rule::unique(User::class)->ignore($user->id)
            ],
            'bio' => ['nullable', 'string', 'max:500'],
            'theme_color' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'is_active' => ['boolean'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // 2MB max
        ]);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }

            // Store new image
            $imagePath = $request->file('profile_image')->store('profile-images', 'public');
            $validated['profile_image'] = $imagePath;
        }

        // Handle checkbox for is_active
        $validated['is_active'] = $request->has('is_active');

        // Update user profile
        $user->fill($validated);

        // Reset email verification if email changed
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Delete profile image if exists
        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Check username availability (AJAX endpoint)
     */
    public function checkUsername(Request $request)
    {
        $username = $request->input('username');
        $currentUserId = Auth::id();
        
        if (empty($username)) {
            return response()->json(['available' => false, 'message' => 'Username is required']);
        }

        if (!preg_match('/^[a-zA-Z0-9_-]+$/', $username)) {
            return response()->json(['available' => false, 'message' => 'Only letters, numbers, hyphens, and underscores allowed']);
        }

        $exists = User::where('username', $username)
            ->when($currentUserId, function ($query) use ($currentUserId) {
                return $query->where('id', '!=', $currentUserId);
            })
            ->exists();

        return response()->json([
            'available' => !$exists,
            'message' => $exists ? 'Username is already taken' : 'Username is available'
        ]);
    }

    /**
     * Upload profile image via AJAX
     */
    public function uploadProfileImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = Auth::user();

        // Delete old image if exists
        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        // Store new image
        $imagePath = $request->file('profile_image')->store('profile-images', 'public');
        
        $user->update(['profile_image' => $imagePath]);

        return response()->json([
            'success' => true,
            'image_url' => Storage::url($imagePath),
            'message' => 'Profile image updated successfully!'
        ]);
    }

    /**
     * Remove profile image
     */
    public function removeProfileImage(Request $request)
    {
        $user = Auth::user();

        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
            $user->update(['profile_image' => null]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Profile image removed successfully!'
        ]);
    }

    /**
     * Display the user's public profile page
     */
    public function show(User $user, Request $request)
    {
        // Check if user profile is active
        if (!$user->is_active) {
            abort(404, 'Profile not found');
        }

        // Track the profile view with enhanced analytics
        try {
            $this->analyticsService->trackProfileView($user->id, $request);
        } catch (\Exception $e) {
            // Log the error but don't break the page load
            Log::warning("Failed to track profile view for user {$user->id}: " . $e->getMessage());
        }

        // Get active links ordered by their position
        $links = $user->links()
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        // Get basic profile stats for the user (optional display)
        $profileStats = [
            'total_views' => \App\Models\ProfileView::where('user_id', $user->id)
                ->realVisitors()
                ->count(),
            'total_clicks' => $user->links()->sum('clicks'),
            'links_count' => $links->count(),
        ];

        return view('profile.show', compact('user', 'links', 'profileStats'));
    }

    /**
     * Handle link redirects with enhanced tracking AND automatic revenue calculation
     */
    public function redirect(User $user, Link $link, Request $request)
    {
        // Verify the link belongs to the user
        if ($link->user_id !== $user->id) {
            abort(404, 'Link not found');
        }

        // Check if link is active
        if (!$link->is_active) {
            abort(404, 'Link not available');
        }

        // Track the click with enhanced analytics
        try {
            $this->analyticsService->trackLinkClick($link->id, $request);
        } catch (\Exception $e) {
            // Log the error but don't break the redirect
            Log::warning("Failed to track link click for link {$link->id}: " . $e->getMessage());
        }

        // Increment the simple click counter on the link
        $link->increment('clicks');

        // Update revenue automatically based on link type
        $this->updateAutomaticRevenue($link);

        // Handle different URL formats
        $url = $link->url;
        
        // Add protocol if missing
        if (!preg_match('/^https?:\/\//', $url)) {
            $url = 'https://' . $url;
        }

        // Redirect to the target URL
        return redirect()->away($url);
    }

   
    private function updateAutomaticRevenue(Link $link)
    {
        try {
            $newRevenue = 0;

            switch ($link->link_type) {
                case 'affiliate':
                    // Revenue = conversions × estimated_value × commission_rate
                    if ($link->conversions > 0 && $link->estimated_value > 0 && $link->commission_rate > 0) {
                        $newRevenue = $link->conversions * $link->estimated_value * ($link->commission_rate / 100);
                    }
                    break;

                case 'product':
                    // Revenue = conversions × product_price (estimated_value)
                    if ($link->conversions > 0 && $link->estimated_value > 0) {
                        $newRevenue = $link->conversions * $link->estimated_value;
                    }
                    break;

                case 'sponsored':
                    // Revenue = clicks × sponsored_rate
                    if ($link->sponsored_rate > 0) {
                        $newRevenue = $link->clicks * $link->sponsored_rate;
                    }
                    break;

                case 'regular':
                default:
                    $newRevenue = 0;
                    break;
            }

            // Update the total revenue
            $link->update(['total_revenue' => $newRevenue]);

        } catch (\Exception $e) {
            Log::error('Failed to calculate automatic revenue for link ' . $link->id . ': ' . $e->getMessage());
        }
    }



}