<?php

namespace App\View\Components\front;

use App\Models\Category;
use App\Models\Department;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navbar extends Component
{
    public $departments;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->departments = Department::all()->load('categories');
    // dd($this->departments);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.front.navbar');
    }
}
