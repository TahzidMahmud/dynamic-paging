<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferBrand extends Model
{
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
