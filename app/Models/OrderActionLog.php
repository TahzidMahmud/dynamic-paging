<?php

namespace App\Models;

use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class OrderActionLog extends Model
{
    protected $fillable = ['order_id', 'data', 'user_id','guest_id', 'action','data_change', 'type', 'order_code', 'user_name'];
    protected $table = 'order_action_logs';


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
