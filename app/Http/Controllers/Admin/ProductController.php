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

class ProductController extends Controller
{
    public function getSubCategories($categoryId)
    {
        return SubCategory::where('category_id',$categoryId)
            ->where('status',1)
            ->get();
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
        return view('admin.products.create',[
            'categories'=>Category::where('status',1)->get(),
            'subCategories'=>SubCategory::where('status',1)->get(),
            'brands'=>Brand::where('status',1)->get(),
        ]);
    }

    public function store(ProductRequest $request)
    {
        $thumbnail = null;

        if($request->hasFile('thumbnail')){

            $thumbnail = $request->file('thumbnail')
                ->store('products','public');
        }

        $product = Product::create([

            'category_id'=>$request->category_id,

            'sub_category_id'=>$request->sub_category_id,

            'brand_id'=>$request->brand_id,

            'name'=>$request->name,

            'slug'=>Str::slug($request->name),

            'sku'=>'SKU'.time(),

            'purchase_price'=>$request->purchase_price,

            'mrp'=>$request->mrp,

            'selling_price'=>$request->selling_price,

            'stock'=>$request->stock,

            'weight'=>$request->weight,

            'unit'=>$request->unit,

            'thumbnail'=>$thumbnail,

            'short_description'=>$request->short_description,

            'description'=>$request->description,

            'featured'=>$request->featured ?? 0,

            'trending'=>$request->trending ?? 0,

            'status'=>$request->status,

        ]);

        if($request->hasFile('gallery')){

            foreach($request->file('gallery') as $image){

                $product->images()->create([

                    'image'=>$image->store('products/gallery','public')

                ]);

            }

        }
        return redirect()
            ->route('admin.products.index')
            ->with('success','Product Added Successfully');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit',[
            'product'=>$product,
            'categories'=>Category::where('status',1)->get(),
            'subCategories'=>SubCategory::where('status',1)->get(),
            'brands'=>Brand::where('status',1)->get(),
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

            'featured'           => $request->has('featured'),
            'trending'           => $request->has('trending'),

            'status'             => $request->status,

        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('success','Product Updated Successfully');
    }

    public function destroy(Product $product)
    {
        if ($product->thumbnail && Storage::disk('public')->exists($product->thumbnail)) {
            Storage::disk('public')->delete($product->thumbnail);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success','Product Deleted Successfully');
    }
}