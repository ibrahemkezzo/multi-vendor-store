<?php

namespace App\Providers;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        JsonResource::withoutWrapping();
    //    Validator::extend('filter',function($attribute,$value,$params){
    //     return !(in_array(strtolower($value),$params));
    //    },'this value is placed');
    Paginator::useBootstrapFour();
    }

}
