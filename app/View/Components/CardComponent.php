<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardComponent extends Component
{
    public $col;
    public $title;
    public $subTitle;
    public $dataTable;

    // Constructor to initialize the properties
    public function __construct($col, $title = null, $subTitle = null, $dataTable = null)
    {
        $this->col = $col;
        $this->title = $title;
        $this->subTitle = $subTitle;
        $this->dataTable = $dataTable;
    }
    public function render(): View|Closure|string
    {
        return view('components.card-component');
    }
}
