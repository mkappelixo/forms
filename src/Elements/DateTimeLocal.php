<?php

namespace Galahad\Forms\Elements;

use DateTime;

class DateTimeLocal extends Text
{
    protected $attributes = [
        'type' => 'datetime-local',
    ];

    protected function setValue($value)
    {
        if ($value instanceof DateTime) {
            $value = $value->format('Y-m-d\TH:i');
        }

        return parent::setValue($value);
    }
}
