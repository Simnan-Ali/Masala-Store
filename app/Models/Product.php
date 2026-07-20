<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [

        'category_id',

        'sub_category_id',

        'brand_id',

        'name',

        'slug',

        'sku',

        'purchase_price',

        'mrp',

        'selling_price',

        'stock',

        'weight',

        'unit',

        'thumbnail',

        'short_description',

        'description',

        'featured',

        'trending',

        'status'

    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}