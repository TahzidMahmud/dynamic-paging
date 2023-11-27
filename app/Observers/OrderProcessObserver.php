<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\OrderProcessLog;

class OrderProcessObserver
{
    /**
     * Handle the order "created" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function created(Order $order)
    {
        // OrderProcessLog::create([
        //     'order_id' => $order->id,
        //     'user_id' => auth()->user()->id,
        //     'action' => 'Created',
        //     'old_stat' => json_encode($order->toArray()),
        //     'new_stat' => json_encode($order->toArray()),
        //     'order_code' => $order->code,
        //     'user_name' => auth()->user()->name,
        // ]);
    }

    /**
     * Handle the order "updated" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        if(auth()->check()){
            if ($order->isDirty('delivery_status')) {
                OrderProcessLog::create([
                    'order_id' => $order->id,
                    'user_id' => auth()->user()->id,
                    'old_stat' => $order->getOriginal('delivery_status'),
                    'new_stat' => $order->delivery_status,
                    'order_code' => $order->code,
                    'user_name' => auth()->user()->name,
                ]);
             }

             if ($order->isDirty('payment_status')) {
                OrderProcessLog::create([
                    'order_id' => $order->id,
                    'user_id' => auth()->user()->id,
                    'old_stat' => $order->getOriginal('payment_status'),
                    'new_stat' => $order->payment_status,
                    'order_code' => $order->code,
                    'user_name' => auth()->user()->name,
                ]);
             }
        }
    }

    /**
     * Handle the order "deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        // OrderProcessLog::create([
        //     'order_id' => $order->id,
        //     'user_id' => auth()->user()->id,
        //     'action' => 'Deleted',
        //     'old_stat' => json_encode($order->toArray()),
        //     'new_stat' => json_encode($order->toArray()),
        //     'order_code' => $order->code,
        //     'user_name' => auth()->user()->name,
        // ]);
    }

    /**
     * Handle the order "restored" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        if(auth()->check()){
            OrderProcessLog::create([
                'order_id' => $order->id,
                'user_id' => auth()->user()->id,
                'action' => 'Restored',
                'old_stat' => json_encode($order->toArray()),
                'new_stat' => json_encode($order->toArray()),
                'order_code' => $order->code,
                'user_name' => auth()->user()->name,
            ]);
        }
    }

    /**
     * Handle the order "force deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        if(auth()->check()){
            OrderProcessLog::create([
                'order_id' => $order->id,
                'user_id' => auth()->user()->id,
                'action' => 'Force Deleted',
                'old_stat' => json_encode($order->toArray()),
                'new_stat' => json_encode($order->toArray()),
                'user_name' => auth()->user()->name,
            ]);
        }
    }
}
