<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        if (!$user->is_active) {
            abort(404);
        }

        $links = $user->activeLinks;
        
        return view('profile.show', compact('user', 'links'));
    }

    public function redirect(User $user, $linkId, Request $request)
    {
        $link = $user->activeLinks()->findOrFail($linkId);
        
        $link->incrementClicks($request);
        
        return redirect($link->url);
    }
}