<?php

namespace App\View\Components;

use App\Models\Category;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use phpDocumentor\Reflection\Types\This;

class FrontLayout extends Component
{
    public $title;
    /**
     * Create a new component instance.
     */
    public function __construct($title=null)
    {
        $this->title = $title ?? config('app.name');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $categories = Category::all();
        return view('layouts.front',compact('categories'));
    }
}
