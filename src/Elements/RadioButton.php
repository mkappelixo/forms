<?php

namespace Galahad\Forms\Elements;

class RadioButton extends Checkbox
{
    protected $attributes = [
        'type' => 'radio',
    ];

    /**
     * @param string $name
     * @param string|null $value
     */
    public function __construct($name, $value = null)
    {
        parent::__construct($name);

        $this->setValue($value ?? $name);
    }
}
