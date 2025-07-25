<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ImportComponent extends Component
{
    public $template;
    public $route;
    /**
     * Create a new component instance.
     */
    public function __construct($template, $route)
    {
        $this->template = $template;
        $this->route = $route;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.import-component');
    }
}
