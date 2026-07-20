<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'category_id'       => 'required|exists:categories,id',
            'sub_category_id'   => 'required|exists:sub_categories,id',
            'brand_id'          => 'required|exists:brands,id',

            'name'              => 'required|max:255',

            'purchase_price'    => 'required|numeric|min:0',

            'mrp'               => 'required|numeric|min:0',

            'selling_price'     => 'required|numeric|min:0',

            'stock'             => 'required|integer|min:0',

            'weight'            => 'nullable|numeric',

            'unit'              => 'required',

            'thumbnail'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'gallery.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'status'            => 'required|boolean',

        ];
    }
}