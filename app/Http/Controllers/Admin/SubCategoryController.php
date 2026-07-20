<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = SubCategory::with('category');

        if ($request->filled('search')) {

            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhereHas('category', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                });
        }

        $subCategories = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.subcategories.index', compact('subCategories'));
    }

    public function create()
    {
        $categories = Category::where('status',1)->get();

        return view('admin.subcategories.create', compact('categories'));
    }

    public function store(SubCategoryRequest $request)
    {
        $image = null;

        if($request->hasFile('image')){
            $image = $request->file('image')
                ->store('subcategories','public');
        }

        SubCategory::create([

            'category_id'=>$request->category_id,

            'name'=>$request->name,

            'slug'=>Str::slug($request->name),

            'image'=>$image,

            'status'=>$request->status

        ]);

        return redirect()
            ->route('admin.sub-categories.index')
            ->with('success','Sub Category Added Successfully');
    }

    public function edit(SubCategory $subCategory)
    {
        $categories = Category::where('status',1)->get();

        return view('admin.subcategories.edit',compact(
            'subCategory',
            'categories'
        ));
    }

    public function update(SubCategoryRequest $request, SubCategory $subCategory)
    {
        $image = $subCategory->image;

        if($request->hasFile('image')){

            if($image){
                Storage::disk('public')->delete($image);
            }

            $image = $request->file('image')
                ->store('subcategories','public');
        }

        $subCategory->update([

            'category_id'=>$request->category_id,

            'name'=>$request->name,

            'slug'=>Str::slug($request->name),

            'image'=>$image,

            'status'=>$request->status

        ]);

        return redirect()
            ->route('admin.sub-categories.index')
            ->with('success','Updated Successfully');
    }

    public function destroy(SubCategory $subCategory)
    {
        if($subCategory->image){
            Storage::disk('public')->delete($subCategory->image);
        }

        $subCategory->delete();

        return back()->with('success','Deleted Successfully');
    }
}