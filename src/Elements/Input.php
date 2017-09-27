<?php

namespace Galahad\Forms\Elements;

abstract class Input extends FormControl
{
    /**
     * @return string
     */
    public function render()
    {
        return sprintf('<input%s>', $this->renderAttributes());
    }

    /**
     * @param string $value
     * @return $this
     */
    public function value($value)
    {
        return $this->setValue($value);
    }

    /**
     * @param string $value
     * @return $this
     */
    protected function setValue($value)
    {
        return $this->attribute('value', $value);
    }
}
