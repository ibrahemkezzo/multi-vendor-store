<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name' ,'description' , 'image'];

    public function stores()
    {
        return $this->hasMany(Store::class);
    }

    public function products()
{
    return $this->hasManyThrough(Product::class, Store::class);
}
}
