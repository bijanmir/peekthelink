<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Link;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display the public profile page
     */
    public function show(User $user)
    {
        if (!$user->is_active) {
            abort(404);
        }

        $links = $user->activeLinks;
        
        return view('profile.show', compact('user', 'links'));
    }

    /**
     * Redirect to external link with tracking
     * Note: $link parameter name must match the route parameter {link}
     */
    public function redirect(User $user, Link $link, Request $request)
    {
        // Verify the link belongs to this user and is active
        if ($link->user_id !== $user->id || !$link->is_active) {
            abort(404);
        }
        
        // Track the click
        $link->incrementClicks($request);
        
        // Ensure the URL has a proper protocol
        $url = $link->url;
        if (!preg_match('/^https?:\/\//', $url)) {
            $url = 'https://' . $url;
        }
        
        // Redirect to the external URL
        return redirect()->away($url);
    }
}