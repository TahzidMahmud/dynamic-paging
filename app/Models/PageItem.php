<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\ItemNameEnum;
use App\Models\PageItemAttribute;
class PageItem extends Model
{
    use HasFactory;

    protected $guarded=[];

    protected $fillable=['name','type','parent_id'];

    // protected $casts = [
    //     'type' => ItemNameEnum::class
    // ];
    public function attributes(){
        return $this->belongsToMany(PageItemAttribute::class, 'page_attribute_items','item_id','attribute_id');
    }
}
 