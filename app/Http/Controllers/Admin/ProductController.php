<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductImage;

class ProductController extends Controller
{
    public function getSubCategories($categoryId)
    {
        $subCategories = SubCategory::where('category_id', $categoryId)
            ->where('status', 1)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($subCategories);
    }

    public function index(Request $request)
    {
        $query = Product::with(['category', 'subCategory', 'brand']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }

        $products = $query->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Category::where('status',1)->get();
        $brands = Brand::where('status',1)->get();

        return view('admin.products.index', compact(
            'products',
            'categories',
            'brands'
        ));
    }

   
    public function create()
    {
        $lastProduct = Product::latest('id')->first();

        $nextId = $lastProduct ? $lastProduct->id + 1 : 1;

        $sku = 'MS-' . date('Ymd') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        return view('admin.products.create', [
            'categories'    => Category::where('status',1)->get(),
            'subCategories' => SubCategory::where('status',1)->get(),
            'brands'        => Brand::where('status',1)->get(),
            'sku'           => $sku,
        ]);
    }

    public function store(ProductRequest $request)
    {
        $thumbnail = null;

        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail')
                ->store('products', 'public');
        }
        $lastProduct = Product::latest('id')->first();

        $nextId = $lastProduct ? $lastProduct->id + 1 : 1;

        $sku = 'MS-' . date('Ymd') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        $product = Product::create([
            'category_id'       => $request->category_id,
            'sub_category_id'   => $request->sub_category_id,
            'brand_id'          => $request->brand_id,
            'name'              => $request->name,
            'slug'              => Str::slug($request->name),
            'sku'               => $sku,
            'purchase_price'    => $request->purchase_price,
            'mrp'               => $request->mrp,
            'selling_price'     => $request->selling_price,
            'stock'             => $request->stock,
            'weight'            => $request->weight,
            'unit'              => $request->unit,
            'thumbnail'         => $thumbnail,
            'short_description' => $request->short_description,
            'description'       => $request->description,
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords'    => $request->meta_keywords,
            'featured'          => $request->boolean('featured'),
            'trending'          => $request->boolean('trending'),
            'status'            => $request->status,
        ]);

        if ($request->hasFile('gallery')) {

            foreach ($request->file('gallery') as $image) {

                $product->images()->create([
                    'image' => $image->store('products/gallery', 'public')
                ]);
            }
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product Added Successfully');
    }

    public function edit(Product $product)
    {
        $product->load('images','variants');

        return view('admin.products.edit', [
            'product'       => $product,
            'categories'    => Category::where('status',1)->get(),
            'subCategories' => SubCategory::where('status',1)->get(),
            'brands'        => Brand::where('status',1)->get(),
        ]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $thumbnail = $product->thumbnail;

        if ($request->hasFile('thumbnail')) {

            if ($thumbnail && Storage::disk('public')->exists($thumbnail)) {
                Storage::disk('public')->delete($thumbnail);
            }

            $thumbnail = $request->file('thumbnail')
                ->store('products', 'public');
        }

        $product->update([

            'category_id'        => $request->category_id,
            'sub_category_id'    => $request->sub_category_id,
            'brand_id'           => $request->brand_id,

            'name'               => $request->name,
            'slug'               => Str::slug($request->name),

            'purchase_price'     => $request->purchase_price,
            'mrp'                => $request->mrp,
            'selling_price'      => $request->selling_price,
            'stock'              => $request->stock,
            'weight'             => $request->weight,
            'unit'               => $request->unit,

            'thumbnail'          => $thumbnail,

            'short_description'  => $request->short_description,
            'description'        => $request->description,
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords'    => $request->meta_keywords,
            'featured'           => $request->has('featured'),
            'trending'           => $request->has('trending'),

            'status'             => $request->status,

        ]);
        if ($request->hasFile('gallery')) {

            foreach ($request->file('gallery') as $image) {

                $product->images()->create([
                    'image' => $image->store('products/gallery', 'public')
                ]);
            }
        }
        return redirect()
            ->route('admin.products.index')
            ->with('success','Product Updated Successfully');
    }

    public function destroy(Product $product)
    {
        if ($product->thumbnail && Storage::disk('public')->exists($product->thumbnail)) {
            Storage::disk('public')->delete($product->thumbnail);
        }

        foreach ($product->images as $image) {

            if ($image->image && Storage::disk('public')->exists($image->image)) {
                Storage::disk('public')->delete($image->image);
            }
        }

        $product->images()->delete();

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product Deleted Successfully');
    }

    public function destroyGallery(ProductImage $image)
    {
        if ($image->image && Storage::disk('public')->exists($image->image)) {
            Storage::disk('public')->delete($image->image);
        }

        $image->delete();

        return back()->with('success', 'Gallery Image Deleted Successfully');
    }

    public function changeStatus(Product $product)
    {
        $product->status = !$product->status;

        $product->save();

        return response()->json([
            'success'=>true,
            'status'=>$product->status
        ]);
    }
}