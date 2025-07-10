<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InputFormComponent extends Component
{
    public $col;
    public $title;
    public $id;
    public $name;
    public $type;
    public $max;
    public $value;
    public $options;
    public $multiple;
    public $readonly;
    public $filter;
    public $required;
    public $step;

    // Constructor to initialize the properties
    public function __construct($col, $title, $id, $name = null, $type = 'text', $max = 255, $value = null, $options = null, $multiple = null, $readonly = null, $filter = null, $required = null, $step = 1)
    {
        $this->col = $col;
        $this->title = $title;
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->max = $max;
        $this->value = $value;
        $this->options = $options;
        $this->multiple = $multiple;
        $this->readonly = $readonly;
        $this->filter = $filter;
        $this->required = $required;
        $this->step = $step;
    }

    public function render(): View|Closure|string
    {
        return view('components.input-form-component');
    }
}
