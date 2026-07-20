<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [

        'product_id',
        'variant_name',
        'sku',
        'purchase_price',
        'mrp',
        'selling_price',
        'stock',
        'weight',
        'unit',
        'image',
        'status'

    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
