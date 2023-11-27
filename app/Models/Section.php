<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $guarded=[];

    protected $fillable=['title','name','type','order','portion','parent_id'];

    public function parentSection()
    {
        return $this->belongsTo(Section::class, 'parent_id');
    }
}
