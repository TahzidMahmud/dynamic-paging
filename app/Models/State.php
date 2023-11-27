<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class State extends Model
{
    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function cities(){
        return $this->hasMany(City::class);
    }
    
	public function zone(){
        return $this->belongsTo(Zone::class);
    }
    
    public function scopeStatus($query){
        return $query->where('status', 1);
    }
}
