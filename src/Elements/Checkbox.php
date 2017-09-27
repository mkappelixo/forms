<?php

namespace Galahad\Forms\Elements;

class Checkbox extends Input
{
    protected $attributes = [
        'type' => 'checkbox',
    ];

    /** @var bool */
    protected $checked;

    /** @var string */
    protected $oldValue;

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __construct($name, $value = 1)
    {
        parent::__construct($name);

        $this->setValue($value);
    }

    /**
     * @param $oldValue
     * @return $this
     */
    public function setOldValue($oldValue)
    {
        $this->oldValue = $oldValue;

        return $this;
    }

    /**
     * @return $this
     */
    public function unsetOldValue()
    {
        $this->oldValue = null;

        return $this;
    }

    /**
     * @return $this
     */
    public function defaultToChecked()
    {
        if (null === $this->checked && null === $this->oldValue) {
            $this->check();
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function defaultToUnchecked()
    {
        if (null === $this->checked && null === $this->oldValue) {
            $this->uncheck();
        }

        return $this;
    }

    /**
     * @param $state
     * @return $this
     */
    public function defaultCheckedState($state)
    {
        $state ? $this->defaultToChecked() : $this->defaultToUnchecked();

        return $this;
    }

    /**
     * @return $this
     */
    public function check()
    {
        $this->unsetOldValue();
        $this->setChecked(true);

        return $this;
    }

    /**
     * @return $this
     */
    public function uncheck()
    {
        $this->unsetOldValue();
        $this->setChecked(false);

        return $this;
    }

    /**
     * @param bool $checked
     * @return $this
     */
    protected function setChecked($checked = true)
    {
        $this->checked = $checked;
        $this->removeAttribute('checked');

        if ($checked) {
            $this->setAttribute('checked', 'checked');
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function checkBinding()
    {
        $current = (string) $this->getAttribute('value');

        collect($this->oldValue)
            ->first(function($old) use ($current) {
                return 0 === strcmp($old, $current) && $this->check();
            });

        return $this;
    }

    /**
     * @return string
     */
    public function render()
    {
        $this->checkBinding();

        return parent::render();
    }
}
