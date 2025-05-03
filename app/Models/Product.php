<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Product extends Model
{
    protected $hidden=['created_at','updated_at','deleted_at'];
    protected $appends=['image_url'];

protected $fillable=[
            'store_id',
            'category_id',
            'name',
            'description',
            'slug',
            'image',
            'price',
            'compare_price',
            'quantity',
            'option',
            'rate',
            'featured',
            'status',
        ];
        public function before($user,$ability){
            if($user->super_admin){return true;}
        }
// protected $guarded=['id'];
    use HasFactory;
    protected static function booted()
    {
     //   static::addGlobalScope('store',new StoreScope());
     static::creating(function(Product $product){
        $product->slug=Str::slug($product->name);
     });
    }
    public  function category(){
        return $this->belongsTo(Category::class,'category_id','id')->withDefault(['name'=>'-']);
    }

    public function store(){
        return $this->belongsTo(Store::class,'store_id','id');
    }

    public function tags(){
        return $this->belongsToMany(Tag::class,'product_tag','product_id','tag_id','id','id');
    }
    public function scopeActive(Builder $builder){

        return $builder->where('status','=','active');
    }
    public function scopeFilter(Builder $builder,$filters){
        $options = array_merge([
            'store_id'=>null,
            'category_id'=>null,
            'tag_id'=>null,
            'status'=>'active',
        ],$filters);
        $builder->when($options['store_id'],function ($builder,$value){
            $builder->where('store_id','=',$value);
        });
        $builder->when($options['category_id'],function ($builder,$value){
            $builder->where('category_id','=',$value);
        });
        $builder->when($options['status'],function ($builder,$value){
            $builder->where('status','=',$value);
        });
        $builder->when($options['tag_id'], function($builder,$value){
            $builder->whereExists(function($query) use($value){
                $query->select(1)->from('product_tag')
                ->whereRaw('product_id = product.id')
                ->where('tag_id',$value);
            // $builder->whereRaw("id in(select product_id form product_tag where tag_id = ? AND product_id = product.id)",$value);
            // $builder->whereRaw('EXISTS(select 1 from product_tag where tag_id = ? AND product_id = product_id = product.id)',$value);
            // $builder->whereHas('tags',function($builder)use($value){
            //     $buildeer->where('id',$value);

            // });
            });
        });
    }
    //acccessor
    public function getImageUrlAttribute(){
        if(!$this->image){
            return "https://cdn.vectorstock.com/i/preview-1x/65/30/default-image-icon-missing-picture-page-vector-40546530.jpg";
        }
        if(Str::startsWith($this->image, ['http://','https://'])){
            return $this->image;
        }
        return asset('store/',$this->image);
    }
    public function getSalePercentAttribute(){
        if($this->compare_price){
        return number_format(100 - (100*$this->price)/$this->compare_price,1);
    }
    }
}
