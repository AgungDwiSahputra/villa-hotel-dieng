<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TableComponent extends Component
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
    public function render(): View|Closure|string
    {
        return view('components.table-component');
    }
}
