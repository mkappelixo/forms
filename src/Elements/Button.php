<?php

namespace Galahad\Forms\Elements;

class Button extends FormControl
{
    protected $attributes = [
        'type' => 'button',
    ];

    /** @var string */
    protected $value;

    /**
     * @param $value
     * @param string|null $name
     */
    public function __construct($value, $name = null)
    {
        parent::__construct($name);

        $this->value($value);
    }

    /**
     * @return string
     */
    public function render()
    {
        return sprintf('<button%s>%s</button>', $this->renderAttributes(), $this->value);
    }

    /**
     * @param $value
     * @return $this
     */
    public function value($value)
    {
        $this->value = $value;

        return $this;
    }
}
