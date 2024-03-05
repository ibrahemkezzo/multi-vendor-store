<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::before(function($user,$ability){
            if($user->super_admin){
                return true;
            }
        });
        $this->registerPolicies();
        // foreach(config('abilities') as $ability_code =>$ability_name){
        //     Gate::define($ability_code,function($user)use($ability_code){
        //         return $user->hasAbility($ability_code);
        //     });
        // }

        // Gate::define('category.view',function($user){
        //     return true;
        // });
        // Gate::define('category.create',function($user){
        //     return true;
        // });
        // Gate::define('category.edite',function($user){
        //     return true;
        // });
        // Gate::define('category.delete',function($user){
        //     return true;
        // });
        // Gate::define('category.update',function($user){
        //     return true;
        // });

    }
}
