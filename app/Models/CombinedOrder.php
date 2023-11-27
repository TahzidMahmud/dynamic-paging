<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CombinedOrder extends Model
{

    protected $fillable = [
        'serial_number',
        'code'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
            $model->serial_number = CombinedOrder::max('serial_number')+1;
            $model->code =  rand(100000, 999999).'-'.'1'.str_pad($model->serial_number,5,0,STR_PAD_LEFT);

        });
    }
    public function orders(){
    	return $this->hasMany(Order::class);
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }
}
