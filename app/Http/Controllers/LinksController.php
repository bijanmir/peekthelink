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
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $maxOrder = auth()->user()->links()->max('order') ?? 0;

        auth()->user()->links()->create([
            'title' => $request->title,
            'url' => $request->url,
            'description' => $request->description,
            'order' => $maxOrder + 1,
        ]);

        return redirect()->route('links.index')
            ->with('success', 'Link created successfully!');
    }

    public function edit(Link $link)
    {
        $this->authorize('update', $link);
        return view('links.edit', compact('link'));
    }

    public function update(Request $request, Link $link)
    {
        $this->authorize('update', $link);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'url' => 'required|url|max:500',
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $link->update([
            'title' => $request->title,
            'url' => $request->url,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('links.index')
            ->with('success', 'Link updated successfully!');
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

            // Validate the request
            if (empty($orderData)) {
                return response()->json(['success' => false, 'message' => 'No order data provided']);
            }

            // Update each link's order
            foreach ($orderData as $item) {
                $linkId = $item['id'];
                $newOrder = $item['order'];

                // Only update links that belong to the authenticated user
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
}