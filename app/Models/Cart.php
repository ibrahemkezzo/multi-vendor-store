<?php

namespace App\Models;

use App\Observers\CartObserver;

use Illuminate\Database\Eloquent\Builder ;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class Cart extends Model
{
    use HasFactory;
    protected $fillable=['cookie_id','product_id','user_id','quantity','options'];
    public $incrementing= false;

    public function user() {
        return $this->belongsTo(User::class)->withDefault(['name'=>'unregistered']);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
    protected static function booted()
    {
        //events
        // static::creating(function(Cart $cart){
        //     $cart->id = Str::uuid();
        // });
        static::observe(CartObserver::class);

        static::addGlobalScope('cookie',function(Builder $builder){
            $builder->where('cookie_id','=',Cart::getCookieId());
        });

    }

    public static function getCookieId(){
        $cookie_id = Cookie::get('cart_id');
        if(!$cookie_id){
            $cookie_id=Str::uuid();
            Cookie::queue('cart_id',$cookie_id,30*24*60);
        }
        return $cookie_id;
    }
}
