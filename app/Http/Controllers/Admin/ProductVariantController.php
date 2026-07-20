<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Storage;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Product $product)
    {
        $query = ProductVariant::where('product_id', $product->id);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('variant_name', 'like', '%' . $request->search . '%')
                ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }

        $variants = $query->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.product_variants.index', compact(
            'product',
            'variants'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $product = Product::findOrFail($request->product);

        $lastVariant = ProductVariant::latest('id')->first();

        $nextId = $lastVariant ? $lastVariant->id + 1 : 1;

        $productCode = strtoupper(substr(Str::slug($product->name,''),0,4));

        $sku = $productCode.'-'.date('ymd').'-'.str_pad($nextId,4,'0',STR_PAD_LEFT);

        return view('admin.product_variants.create',compact(
            'product',
            'sku'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id'     => 'required',
            'variant_name'   => 'required',
            'sku'            => 'required|unique:product_variants',
            'selling_price'  => 'required|numeric',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $image = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('variants', 'public');
        }

        ProductVariant::create([
            'product_id'      => $request->product_id,
            'variant_name'    => $request->variant_name,
            'sku'             => $request->sku,
            'purchase_price'  => $request->purchase_price,
            'mrp'             => $request->mrp,
            'selling_price'   => $request->selling_price,
            'stock'           => $request->stock,
            'weight'          => $request->weight,
            'unit'            => $request->unit,
            'status'          => $request->status,
            'image'           => $image,
        ]);

        return redirect()
            ->route('admin.products.variants', $request->product_id)
            ->with('success', 'Variant Added Successfully');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductVariant $productVariant)
    {
        $product = Product::findOrFail($productVariant->product_id);

        $variant = $productVariant;

        $sku = $variant->sku;

        return view('admin.product_variants.edit', compact(
            'product',
            'variant',
            'sku'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductVariant $productVariant)
    {
        $request->validate([
            'variant_name'   => 'required',
            'selling_price'  => 'required|numeric',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $image = $productVariant->image;

        if ($request->hasFile('image')) {

            if ($image && Storage::disk('public')->exists($image)) {
                Storage::disk('public')->delete($image);
            }

            $image = $request->file('image')->store('variants', 'public');
        }

        $productVariant->update([
            'variant_name'   => $request->variant_name,
            'purchase_price' => $request->purchase_price,
            'mrp'            => $request->mrp,
            'selling_price'  => $request->selling_price,
            'stock'          => $request->stock,
            'weight'         => $request->weight,
            'unit'           => $request->unit,
            'status'         => $request->status,
            'image'          => $image,
        ]);

        return redirect()
            ->route('admin.products.variants', $productVariant->product_id)
            ->with('success', 'Variant Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductVariant $productVariant)
    {
        $productId = $productVariant->product_id;

        if ($productVariant->image &&
            Storage::disk('public')->exists($productVariant->image)) {

            Storage::disk('public')->delete($productVariant->image);
        }

        $productVariant->delete();

        return redirect()
            ->route('admin.products.variants', $productId)
            ->with('success', 'Variant Deleted Successfully');
    }

    public function changeStatus(ProductVariant $variant)
    {
        $variant->status = !$variant->status;

        $variant->save();

        return response()->json([
            'success' => true,
            'status'  => $variant->status,
            'message' => 'Variant status updated successfully.'
        ]);
    }
}
