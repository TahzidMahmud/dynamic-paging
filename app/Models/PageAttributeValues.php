<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageAttributeValues extends Model
{
    use HasFactory;

    protected $fillable = [ 'pagte_id','section_id','item_id','attribute_id','value'];
}
