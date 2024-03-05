<?php

namespace App\Listeners;

use App\Events\OrderCreate;
use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderCreatedNotification as NotifiationsOrderCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class OrderCreatedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreate $event): void
    {
        $order = $event->order;

        $user=User::where('store_id',$order->store_id)->get();
        // $user->notify(new NotificationsOrderCreatedNotification($order));
// dd($user);
        if($user){
            Notification::sendNow($user,new NotifiationsOrderCreatedNotification($order));
        }
    }
}
