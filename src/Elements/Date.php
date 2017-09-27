<?php

namespace Galahad\Forms\Elements;

use DateTime;

class Date extends Text
{
    protected $attributes = [
        'type' => 'date',
    ];

    protected function setValue($value)
    {
        if ($value instanceof DateTime) {
            $value = $value->format('Y-m-d');
        }

        return parent::setValue($value);
    }
}
