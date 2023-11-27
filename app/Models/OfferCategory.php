<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferCategory extends Model
{
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
