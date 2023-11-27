<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShowcaseProductCategory extends Model
{

    public function product()
    {
        return $this->belongsTo(ShowcaseProduct::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
