<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LinksController extends Controller
{
    public function index()
    {
        $links = auth()->user()->links;
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
        $linkIds = $request->input('links', []);
        
        foreach ($linkIds as $index => $linkId) {
            auth()->user()->links()->where('id', $linkId)->update([
                'order' => $index + 1
            ]);
        }

        return response()->json(['success' => true]);
    }
}