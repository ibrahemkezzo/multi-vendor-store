<?php

namespace App\View\Components;

use App\Models\Role;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class nav extends Component
{
    public $items;
    // public $active;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->items=$this->prepareitem(config('nav'));
        // $this->active=Route::currentRouteName();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.nav');
    }
    public function prepareitem($items){
        $user = Auth::user();
    //     $roles = $user->roles()->first();
    // //    $role=Role::where('id','5')->first();
    // $abilities=$roles->abilities()->pluck('type','ability')->toArray();
    // dd($abilities);
    // dd($roles);
    // dd($items);
    // dd($user->hasAbility('users.view'));
    if(!$user->super_admin){
        foreach($items as $key => $item){
            if(isset($item['ability']) && $item['ability']!= 'dashboard' && !($user->hasAbility($item['ability']))){

                unset($items[$key]);
            }
        }}
        // dd($items);
        return $items;
    }
}
