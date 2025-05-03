<?php

namespace App\Models;

use App\Rules\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    //protected $guarded=[''];
    protected $fillable=['name','department_id','slug','description','image','status'];




    public function scopeFilter(Builder $builder , $filter) {

        $builder->when($filter['name']??false,function($builder,$value){
            $builder->where('categories.name','LIKE',"%{$value}%");
        });
        $builder->when($filter['categories.status']??false,function($builder,$value){
            $builder->where('status','=',$value);
        });




        // if($filter['name']??false){
        //     $builder->where('name','LIKE',"%{$filter['name']}%");
        // }
        // if($filter['status']??false){
        //     $builder->where('status','=',$filter['status']);
        // }
    }


    static public function rules($id=''){
        return[
            'name'=>['required','string','min:3','max:255','unique:categories,name,$id',
                        // function($attribute,$value,$fails){
                        //     if(strtolower($value)=='laravel');
                        //     return $fails('the value is not allowed');

                        // }
                        new Filter(['laravel','php','html'])
        ],
            'department_id'=>['nullable','integer','exists:departments,id'],
            'image'=>['image','max:10000'],
            'status'=>['required','in:active,archived'],
        ];
    }
    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function products(){
      return $this->hasMany(Product::class,'category_id','id');
    }
}
