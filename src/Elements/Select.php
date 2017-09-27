<?php

namespace Galahad\Forms\Elements;

class Select extends FormControl
{
    /** @var array */
    protected $options;

    /** @var string */
    protected $selected;

    /**
     * @param string $name
     * @param array $options
     */
    public function __construct($name, $options = [])
    {
        $this->setName($name);
        $this->setOptions($options);
    }

    /**
     * @param string $option
     * @return $this
     */
    public function select($option)
    {
        $this->selected = $option;

        return $this;
    }

    /**
     * @param $options
     * @return $this
     */
    public function options($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return string
     */
    public function render()
    {
        return sprintf('<select%s>%s</select>', $this->renderAttributes(), $this->renderOptions());
    }

    /**
     * @param string $value
     * @param string $label
     * @return $this
     */
    public function addOption($value, $label)
    {
        $this->options[$value] = $label;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function defaultValue($value)
    {
        if (null === $this->selected) {
            $this->select($value);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function multiple()
    {
        $name = $this->attributes['name'];
        if (substr($name, -2) !== '[]') {
            $name .= '[]';
        }

        $this->setName($name);
        $this->attribute('multiple', 'multiple');

        return $this;
    }

    /**
     * @param array $options
     * @return $this
     */
    protected function setOptions($options)
    {
        return $this->options($options);
    }

    /**
     * @return string
     */
    protected function renderOptions()
    {
        if (empty($this->options)) {
            return '';
        }

        return collect($this->options)->map(function ($label, $value) {
                return is_array($label) ? $this->renderOptGroup($value, $label) : $this->renderOption($value, $label);
            })->implode('');
    }

    /**
     * @param string $label
     * @param array|string $options
     * @return string
     */
    protected function renderOptGroup($label, $options)
    {
        $options = collect($options)->map(function ($label, $value) {
                return $this->renderOption($value, $label);
            })->implode('');

        return sprintf('<optgroup label="%s">%s</optgroup>', $label, $options);
    }

    /**
     * @param string $value
     * @param string $label
     * @return string
     */
    protected function renderOption($value, $label)
    {
        return vsprintf('<option value="%s"%s>%s</option>', [
            $this->escape($value),
            $this->isSelected($value) ? ' selected' : '',
            $this->escape($label),
        ]);
    }

    /**
     * @param string $value
     * @return bool
     */
    protected function isSelected($value)
    {
        return in_array($value, (array)$this->selected);
    }
}
