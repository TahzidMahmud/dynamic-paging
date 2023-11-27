<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageItemAttribute extends Model
{
    use HasFactory;
    protected $guarded=[];

    protected $fillable=['name','type','value'];
    
}
