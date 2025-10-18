<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Intl\Countries;

class OrderAddress extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable =['type','first_name','last_name','email','street_adress',
                            'phone_number','city','postal_code','status','country',
    ];
    public function billingOrders(){
        return $this->hasMany(Order::class,'billing_id');
    }
    public function shippingOrders(){
        return $this->hasMany(Order::class,'shipping_id');
    }
    public function getNameAttribute(){
        return $this->first_name.$this->last_name;
    }
    public function getCountryNameAttribute(){
        return Countries::getName($this->country);
    }

}
