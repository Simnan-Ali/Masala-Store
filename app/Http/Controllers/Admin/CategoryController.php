<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $categories = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(CategoryRequest $request)
    {
        $image = null;

        if ($request->hasFile('image')) {

            $image = $request->file('image')
                ->store('categories', 'public');
        }

        Category::create([

            'name' => $request->name,

            'slug' => Str::slug($request->name),

            'image' => $image,

            'status' => $request->status,

        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category Added Successfully');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $image = $category->image;

        if ($request->hasFile('image')) {

            if ($image) {
                Storage::disk('public')->delete($image);
            }

            $image = $request->file('image')
                ->store('categories', 'public');
        }

        $category->update([

            'name' => $request->name,

            'slug' => Str::slug($request->name),

            'image' => $image,

            'status' => $request->status,

        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category Updated Successfully');
    }

    public function destroy(Category $category)
    {
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return back()->with('success', 'Category Deleted Successfully');
    }
}