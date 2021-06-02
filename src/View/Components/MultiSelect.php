<?php

namespace SimonMarcelLinden\LaravelMultiSelect\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MultiSelect extends Component {

    public $values;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($values) {
//        $this->values = $values;
        $this->values = ['test1', 'test2'];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View
     */
    public function render(): view{
        return view('SimonMarcelLinden::components.multiSelect');
    }
}
