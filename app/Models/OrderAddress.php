<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Intl\Countries;

class OrderAddress extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable =['order_id','type','first_name','last_name','email','street_adress',
                            'phone_number','city','postal_code','status','country',
    ];
    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function getNameAttribute(){
        return $this->first_name.$this->last_name;
    }
    public function getCountryNameAttribute(){
        return Countries::getName($this->country);
    }

}
