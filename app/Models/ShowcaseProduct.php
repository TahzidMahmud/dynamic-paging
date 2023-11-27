<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShowcaseProduct extends Model
{
    use HasFactory;
    public function showcase_product_categories()
    {
        return $this->hasMany(ShowcaseProductCategory::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'showcase_product_categories', 'showcase_product_id', 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
