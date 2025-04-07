<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Store extends Model
{
    use Notifiable,HasFactory;

    // const CREATED_AT = 'created_at';
    // const UPDATED_AT = 'updated_at';

    // protected $connection = 'mysql';
    // protected $table = 'stores';
    // protected $primaryKey = 'id';
    // protected $keyType = 'int';

    // public $incrementing = true;
    // public $timestamps = true;


    protected $fillable = [
    'name',
    'slug',
    'department_id',
    'description',
    'logo_image',
    'cover_image',
    'status',
    ];

    public function products(){
       return $this->hasMany(Product::class,'store_id','id');
    }

    public function department(){                                                                                                             
        return $this->belongsTo(Department::class);
    }
}
