<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\ItemNameEnum;
class PageItem extends Model
{
    use HasFactory;

    protected $guarded=[];

    protected $fillable=['name','type','parent_id'];

    protected $casts = [
        'type' => ItemNameEnum::class
    ];

}
