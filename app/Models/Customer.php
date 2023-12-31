<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Customer extends Model
{
    protected $fillable = [
      'user_id',
    ];
    public function user(){
    	return $this->belongsTo(User::class);
    }
}
