<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::latest()->get();
        return view('admin.brands.index', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:brands,name|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            if (!File::exists(public_path('images/brands'))) {
                File::makeDirectory(public_path('images/brands'), 0755, true);
            }
            $file->move(public_path('images/brands'), $filename);
            $data['logo'] = 'images/brands/' . $filename;
        }

        $brand = Brand::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Brand created successfully!',
            'brand' => $brand
        ]);
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|max:255|unique:brands,name,' . $brand->id,
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('logo')) {
            if ($brand->logo && File::exists(public_path($brand->logo))) {
                File::delete(public_path($brand->logo));
            }
            
            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/brands'), $filename);
            $data['logo'] = 'images/brands/' . $filename;
        }

        $brand->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Brand updated successfully!',
            'brand' => $brand
        ]);
    }

    public function destroy(Brand $brand)
    {
        if ($brand->logo && File::exists(public_path($brand->logo))) {
            File::delete(public_path($brand->logo));
        }
        $brand->delete();
        
        return response()->json(['success' => true, 'message' => 'Brand deleted successfully!']);
    }
}