<?php

namespace Galahad\Forms\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \Galahad\Forms\FormBuilder
 */
class Form extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'galahad.forms';
    }
}
