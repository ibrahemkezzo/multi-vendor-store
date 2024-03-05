<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Order extends Model
{
    use HasFactory;
    protected $fillable =['store_id','user_id','number','status',
    'payment_status','payment_method','shipping','tax','discount','total',
    ];
    public function before($user,$ability){
        if($user->super_admin){return true;}
    }
    public function store(){
        return $this->belongsTo(Store::class);
    }

    public function user(){
        return $this->belongsTo(User::class)->withDefault(['name'=>'guest costumer']);
    }

    public function addresses(){
        return $this->hasMany(OrderAddress::class);
    }

    public function shippingaddress(){
        return $this->hasOne(OrderAddress::class)->where('type','=','shipping');
    }
    public function billingaddress(){
        return $this->hasOne(OrderAddress::class)->where('type','=','billing');
    }

    public function products(){
        return $this->belongsToMany(Product::class,'order_items','order_id','product_id','id','id')
                    ->using(OrderItem::class)
                    ->as('order_item')
                    ->withPivot(['product_name','price','quantity','options']);
    }
    public function items(){
        return $this->hasMany(OrderItem::class,'order_id');
    }

    protected static function booted()
    {
        static::creating(function(Order $order){
            $order->number = Order::getNextOrderNumber();
        });
    }

    public static function getNextOrderNumber(){
        $year=Carbon::now()->year;
        $number = Order::whereyear('created_at',$year)->max('number');
        if($number){
            return (integer)$number+1;
        }
        return $year.'0001';
    }
}
