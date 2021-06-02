<?php

namespace SimonMarcelLinden\LaravelMultiSelect\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelMultiSelect extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravelmultiselect';
    }
}
