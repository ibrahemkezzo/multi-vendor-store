<?php

namespace App\Notifications;

use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Broadcast;

class OrderCreatedNotification extends Notification
{
    use Queueable;
    protected $order;
    protected $addr;
    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order=$order;
        $this->addr= $this->order->billingaddress;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail','database','broadcast'];
        $chanel=['database'];
        if($notifiable->notification_prefrences['order_created']['sms'] ?? false){
            $chanel[]='vonage';
        }
        if($notifiable->notification_prefrences['order_created']['mail'] ?? false){
            $chanel[]='mail';
        }
        if($notifiable->notification_prefrences['order_created']['broadcast'] ?? false){
            $chanel[]='broadcast';
        }
        return $chanel;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {

        return (new MailMessage)
                    ->subject("new order #{$this->order->number}")
                    ->from('notification@ajyal.com','ajyal_store')
                    ->greeting("hi {$notifiable->name}")
                    ->line("A new order #{$this->order->number} created by {$this->addr->name} from country{$this->addr->country_name}")
                    ->action('view order', url('/dashboard'))
                    ->line('Thank you for using our application!');
    }
    public function toDatabase($notifiable){
        return [
            'body'=>"A new order #{$this->order->number} created by {$this->addr->name} from country{$this->addr->country_name}",
            'icon'=>'fas fa-file',
            'url'=>url('/dashboard'),
            'order'=>$this->order->id,
        ];
    }
    public function toBroadcast($notifiable){
        return new BroadcastMessage([
            'body'=>"A new order #{$this->order->number} created by {$this->addr->name} from country{$this->addr->country_name}",
            'icon'=>'fas fa-file',
            'url'=>url('/dashboard'),
            'order'=>$this->order->id,
        ]);
    }
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
