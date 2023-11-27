<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    public function offer_products()
    {
        return $this->hasMany(OfferProduct::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'offer_products');
    }
    public function offer_brands()
    {
        return $this->hasMany(OfferBrand::class);
    }
    public function offer_categorys()
    {
        return $this->hasMany(OfferCategory::class);
    }
}

