<?php

namespace App\Models;

use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;


class OrderProcessLog extends Model
{
    protected $fillable = ['order_id', 'user_id', 'old_stat', 'new_stat', 'order_code', 'user_name'];
    protected $table = 'order_process_logs';


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
