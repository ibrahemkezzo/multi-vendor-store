<?php

namespace App\Concernes;

use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;

trait HasRoles {
    public function roles(){
       return $this->morphToMany(Role::class,'authorizable','role_user');
    }
    public function hasAbility($ability){
        $denied = $this->roles()->whereHas('abilities',function(Builder $query) use ($ability){
            $query->where('ability',$ability)->where('type','deny');
        })->exists();
        if($denied){
            return false;
        }

        return $this->roles()->whereHas('abilities',function(Builder $query) use ($ability){
            $query->where('ability',$ability)->where('type','allows');
        })->exists();
    }
}
