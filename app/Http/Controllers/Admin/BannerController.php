<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $banners = Banner::orderBy('order')->paginate(15);
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:2048',
            'link' => 'nullable|url',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('banners', 'public');
        }

        Banner::create($validated);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner created successfully');
    }

    public function edit(int $id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'link' => 'nullable|url',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $banner = Banner::findOrFail($id);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('banners', 'public');
        }

        $banner->update($validated);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner updated successfully');
    }

    public function destroy(int $id)
    {
        Banner::destroy($id);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner deleted successfully');
    }
}
