<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PageItem;
class PageItemAttribute extends Model
{
    use HasFactory;
    protected $guarded=[];

    protected $fillable=['name','type','value'];
    public function items(){
        return $this->belongsToMany(PageItem::class, 'page_attribute_items', 'attribute_id','item_id');
    }
    
    
}
