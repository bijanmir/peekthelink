<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LinksController extends Controller
{
    public function index()
    {
        $links = Auth::user()->links()
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Recalculate revenue for all links to ensure they're up to date
        foreach ($links as $link) {
            $this->updateAutomaticRevenue($link);
        }

        return view('links.index', compact('links'));
    }

    public function create()
    {
        return view('links.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'url' => 'required|url|max:500',
            'description' => 'nullable|string|max:500',
            'order' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            
            // Revenue tracking SETTINGS
            'link_type' => 'nullable|string|in:regular,affiliate,product,sponsored',
            'commission_rate' => 'nullable|numeric|min:0|max:100',
            'estimated_value' => 'nullable|numeric|min:0',
            'sponsored_rate' => 'nullable|numeric|min:0',
            'affiliate_program' => 'nullable|string|max:255',
            'affiliate_tag' => 'nullable|string|max:255',
            'conversions' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Calculate max order if not provided
        $maxOrder = auth()->user()->links()->max('order') ?? 0;
        $order = $request->filled('order') ? $request->order : ($maxOrder + 1);

        // Create the link with proper default handling
        $linkData = [
            'title' => $request->title,
            'url' => $request->url,
            'description' => $request->description,
            'order' => $order,
            'is_active' => $request->boolean('is_active', true),
            
            // Revenue tracking SETTINGS with proper defaults
            'link_type' => $request->link_type ?? 'regular',
            'commission_rate' => $request->filled('commission_rate') ? $request->commission_rate : 0.00,
            'estimated_value' => $request->filled('estimated_value') ? $request->estimated_value : 0.00,
            'sponsored_rate' => $request->filled('sponsored_rate') ? $request->sponsored_rate : 0.00,
            'affiliate_program' => $request->affiliate_program, // nullable
            'affiliate_tag' => $request->affiliate_tag, // nullable
            'conversions' => $request->conversions ?? 0,
            
            // Initialize counters
            'clicks' => 0,
            'total_revenue' => 0.00,
        ];

        $link = auth()->user()->links()->create($linkData);

        // Calculate initial revenue based on conversions (if any were provided)
        $this->updateAutomaticRevenue($link);

        // Handle different submission actions
        if ($request->action === 'save_and_add') {
            return redirect()->route('links.create')
                ->with('success', 'Link created successfully! Add another one.');
        }

        return redirect()->route('links.index')
            ->with('success', 'Link created successfully!');
    }

    public function edit(Link $link)
    {
        $this->authorize('update', $link);
        
        // Ensure revenue is up to date before showing edit form
        $this->updateAutomaticRevenue($link);
        
        return view('links.edit', compact('link'));
    }

    public function update(Request $request, Link $link)
    {
        $this->authorize('update', $link);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'url' => 'required|url|max:500',
            'description' => 'nullable|string|max:500',
            'order' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            
            // Revenue tracking SETTINGS
            'link_type' => 'nullable|string|in:regular,affiliate,product,sponsored',
            'commission_rate' => 'nullable|numeric|min:0|max:100',
            'estimated_value' => 'nullable|numeric|min:0',
            'sponsored_rate' => 'nullable|numeric|min:0',
            'affiliate_program' => 'nullable|string|max:255',
            'affiliate_tag' => 'nullable|string|max:255',
            'conversions' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update the link with proper default handling
        $updateData = [
            'title' => $request->title,
            'url' => $request->url,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active'),
            
            // Revenue tracking SETTINGS with proper defaults
            'link_type' => $request->link_type ?? 'regular',
            'commission_rate' => $request->filled('commission_rate') ? $request->commission_rate : 0.00,
            'estimated_value' => $request->filled('estimated_value') ? $request->estimated_value : 0.00,
            'sponsored_rate' => $request->filled('sponsored_rate') ? $request->sponsored_rate : 0.00,
            'affiliate_program' => $request->affiliate_program, // nullable
            'affiliate_tag' => $request->affiliate_tag, // nullable
            'conversions' => $request->conversions ?? 0,
        ];

        // Only update order if provided
        if ($request->filled('order')) {
            $updateData['order'] = $request->order;
        }

        $link->update($updateData);

        // Recalculate revenue based on new settings
        $this->updateAutomaticRevenue($link);

        return redirect()->route('links.index')
            ->with('success', 'Link updated successfully! Revenue has been recalculated automatically.');
    }

    public function destroy(Link $link)
    {
        $this->authorize('delete', $link);
        $link->delete();

        return redirect()->route('links.index')
            ->with('success', 'Link deleted successfully!');
    }

    public function updateOrder(Request $request)
    {
        try {
            $user = Auth::user();
            $orderData = $request->input('order', []);

            if (empty($orderData)) {
                return response()->json(['success' => false, 'message' => 'No order data provided']);
            }

            foreach ($orderData as $item) {
                $linkId = $item['id'];
                $newOrder = $item['order'];

                $user->links()
                    ->where('id', $linkId)
                    ->update(['order' => $newOrder]);
            }

            return response()->json(['success' => true, 'message' => 'Link order updated successfully']);

        } catch (\Exception $e) {
            \Log::error('Failed to update link order: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update link order']);
        }
    }

    /**
     * Update revenue automatically based on link type, clicks, and conversions
     */
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
            \Log::error('Failed to calculate automatic revenue for link ' . $link->id . ': ' . $e->getMessage());
        }
    }

    /**
     * API endpoint to update just the conversions count
     */
    public function updateConversions(Request $request, Link $link)
    {
        $this->authorize('update', $link);

        $request->validate([
            'conversions' => 'required|integer|min:0',
        ]);

        // Update conversions
        $link->update(['conversions' => $request->conversions]);

        // Automatically recalculate revenue
        $this->updateAutomaticRevenue($link);
        $link->refresh();

        return response()->json([
            'success' => true,
            'conversions' => $link->conversions,
            'total_revenue' => $link->total_revenue,
            'conversion_rate' => $link->clicks > 0 ? round(($link->conversions / $link->clicks) * 100, 2) : 0,
        ]);
    }
}