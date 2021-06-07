<?php

namespace SimonMarcelLinden\LaravelMultiSelect\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MultiSelect extends Component {

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct() { }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View
     */
    public function render(): view{
        return view('SimonMarcelLinden::components.multiSelect');
    }
}
