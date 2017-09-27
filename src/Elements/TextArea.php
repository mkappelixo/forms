<?php

namespace Galahad\Forms\Elements;

class TextArea extends FormControl
{
    protected $attributes = [
        'name' => '',
        'rows' => 10,
        'cols' => 50,
    ];

    /** @var string */
    protected $value;

    /**
     * @return string
     */
    public function render()
    {
        return sprintf(
            '<textarea%s>%s</textarea>',
            $this->renderAttributes(),
            $this->escape($this->value)
        );
    }

    /**
     * @param string|int $rows
     * @return $this
     */
    public function rows($rows)
    {
        return $this->attribute('rows', $rows);
    }

    /**
     * @param string|int $cols
     * @return $this
     */
    public function cols($cols)
    {
        return $this->attribute('cols', $cols);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function value($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @param string $placeholder
     * @return $this
     */
    public function placeholder($placeholder)
    {
        return $this->attribute('placeholder', $placeholder);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function defaultValue($value)
    {
        if (! $this->hasValue()) {
            $this->value($value);
        }

        return $this;
    }

    /**
     * @return bool
     */
    protected function hasValue()
    {
        return isset($this->value);
    }
}
