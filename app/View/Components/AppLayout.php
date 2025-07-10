<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    public $title;
    public $subTitle;
    public $modal;

    // Constructor to initialize the properties
    public function __construct($title = null, $subTitle = null)
    {
        $this->title = $title;
        $this->subTitle = $subTitle;
    }

    public function render(): View
    {
        return view('layouts.admin.app');
    }
}
