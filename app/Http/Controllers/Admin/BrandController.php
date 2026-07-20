<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $query = Brand::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $brands = $query->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(BrandRequest $request)
    {
        $logo = null;

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo')
                ->store('brands', 'public');
        }

        Brand::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'logo'        => $logo,
            'description' => $request->description,
            'status'      => $request->status,
        ]);

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand Added Successfully');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(BrandRequest $request, Brand $brand)
    {
        $logo = $brand->logo;

        if ($request->hasFile('logo')) {

            if ($logo) {
                Storage::disk('public')->delete($logo);
            }

            $logo = $request->file('logo')
                ->store('brands', 'public');
        }

        $brand->update([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'logo'        => $logo,
            'description' => $request->description,
            'status'      => $request->status,
        ]);

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand Updated Successfully');
    }

    public function destroy(Brand $brand)
    {
        if ($brand->logo) {
            Storage::disk('public')->delete($brand->logo);
        }

        $brand->delete();

        return back()->with('success', 'Brand Deleted Successfully');
    }
}