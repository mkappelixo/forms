<?php

namespace Galahad\Forms\Elements;

abstract class FormControl extends Element
{
    protected static $tabIndex = 1;

    /**
     * @param $name
     */
    public function __construct($name)
    {
        $this->setName($name);
    }

    /**
     * @param $name
     * @return $this
     */
    protected function setName($name)
    {
        return $this->setAttribute('name', $name);
    }

    /**
     * @param bool $conditional
     * @return $this
     */
    public function required($conditional = true)
    {
        return $this->setBooleanAttribute('required', $conditional);
    }

    /**
     * @return $this
     */
    public function optional()
    {
        return $this->removeAttribute('required');
    }

    /**
     * @param bool $conditional
     * @return $this
     */
    public function disable($conditional = true)
    {
        return $this->setBooleanAttribute('disabled', $conditional);
    }

    /**
     * @param bool $conditional
     * @return $this
     */
    public function readonly($conditional = true)
    {
        return $this->setBooleanAttribute('readonly', $conditional);
    }

    /**
     * @return $this
     */
    public function enable()
    {
        return $this->removeAttribute('disabled')
            ->removeAttribute('readonly');
    }

    /**
     * @return $this
     */
    public function autofocus()
    {
        return $this->setAttribute('autofocus', 'autofocus');
    }

    /**
     * @return $this
     */
    public function unfocus()
    {
        return $this->removeAttribute('autofocus');
    }

    /**
     * @param int|null $index
     * @return $this
     */
    public function tabindex($index = null)
    {
        return $this->attribute('tabindex', $index ?? static::$tabIndex++);
    }

    /**
     * @return $this
     */
    public function untabbable()
    {
        return $this->tabindex(0);
    }
}
