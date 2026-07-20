<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'name' => 'required|max:255',

            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'description' => 'nullable',

            'status' => 'required|boolean'

        ];
    }
}