<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $promotions = Promotion::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.promotions.index', compact('promotions'));
    }

    public function create()
    {
        return view('admin.promotions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:promotions,code|max:50',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
        ]);

        Promotion::create($validated);

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Promotion created successfully');
    }

    public function edit(int $id)
    {
        $promotion = Promotion::findOrFail($id);
        return view('admin.promotions.edit', compact('promotion'));
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:promotions,code,' . $id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
        ]);

        $promotion = Promotion::findOrFail($id);
        $promotion->update($validated);

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Promotion updated successfully');
    }

    public function destroy(int $id)
    {
        Promotion::destroy($id);

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Promotion deleted successfully');
    }
}
