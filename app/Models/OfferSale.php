<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferSale extends Model
{
    protected $guarded = [];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function order(){
        return $this->belongsTo(Order::class);
    }
}

