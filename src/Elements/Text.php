<?php

namespace Galahad\Forms\Elements;

class Text extends Input
{
    protected $attributes = [
        'type' => 'text',
    ];

    /**
     * @param string $placeholder
     * @return $this
     */
    public function placeholder($placeholder)
    {
        return $this->attribute('placeholder', $placeholder);
    }

    /**
     * @param $value
     * @return $this
     */
    public function defaultValue($value)
    {
        if (! $this->hasValue()) {
            $this->setValue($value);
        }

        return $this;
    }

    /**
     * @return bool
     */
    protected function hasValue()
    {
        return isset($this->attributes['value']);
    }
}
