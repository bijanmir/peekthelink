<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $links = $user->links;
        $totalClicks = $links->sum('clicks');
        
        return view('dashboard', compact('user', 'links', 'totalClicks'));
    }
}