<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    protected $guarded = [];
    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
            $model->serial_number = ProductVariation::max('serial_number')+1;
        });
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function combinations()
    {
        return $this->hasMany(ProductVariationCombination::class);
    }
}
