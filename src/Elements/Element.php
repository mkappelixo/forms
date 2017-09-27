<?php

namespace Galahad\Forms\Elements;

/**
 *
 */
abstract class Element
{
    /** @var array */
    protected $attributes = [];

    /**
     * @return mixed
     * @param string $key
     * @param mixed $default
     */
    public function getAttribute($key, $default = null)
    {
        if ($this->hasAttribute($key)) {
            return $this->attributes[$key];
        }

        return $default;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasAttribute($key)
    {
        return $key && isset($this->attributes[$key]);
    }

    /**
     * @param string $attribute
     * @return $this
     */
    public function removeAttribute($attribute)
    {
        unset($this->attributes[$attribute]);

        return $this;
    }

    /**
     * @param string $attribute
     * @param string $value
     * @return $this
     */
    public function attribute($attribute, $value)
    {
        if (null !== $value) {
            $this->attributes[$attribute] = $value;
        }

        return $this;
    }

    /**
     * @param string|array $attribute
     * @param string $value
     * @return $this
     */
    public function data($attribute, $value = null)
    {
        $attributes = is_array($attribute) ? $attribute : [$attribute => $value];

        foreach ($attributes as $key => $val) {
            $this->attribute("data-{$key}", $val);
        }

        return $this;
    }

    /**
     * @param string $attribute
     * @return $this
     */
    public function clear($attribute)
    {
        return $this->removeAttribute($attribute);
    }

    /**
     * @param string $class
     * @return $this
     */
    public function addClass($class)
    {
        if ($existing = $this->getAttribute('class')) {
            $class = "$existing $class";
        }

        return $this->attribute('class', $class);
    }

    /**
     * @param string|array $class
     * @return $this
     */
    public function removeClass($class)
    {
        if ($existing = $this->getAttribute('class')) {
            $this->removeAttribute('class');

            $next = array_diff(
                explode(' ', $existing),
                is_array($class) ? $class : explode(' ', $class)
            );

            if (!empty($next)) {
                $this->attribute('class', implode(' ', $next));
            }
        }

        return $this;
    }

    /**
     * @param string $id
     * @return $this
     */
    public function id($id)
    {
        return $this->attribute('id', $id);
    }

    /**
     * @return string
     */
    abstract public function render();

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * $element->foo('bar') -> $element->attribute('foo', 'bar')
     * $element->foo() -> $element->attribute('foo', 'foo')
     * $element->setAttribute -> $element->attribute
     *
     * @param string $method
     * @param array $params
     * @return $this|\Galahad\Forms\Elements\Element
     */
    public function __call($method, $params)
    {
        if (0 === strpos($method, 'set') && method_exists($this, $setMethod = substr($method, 3))) {
            trigger_error("Please use $setMethod instead of $method", E_USER_DEPRECATED);
            return call_user_func_array([$this, $setMethod], $params);
        }

        return $this->attribute($method, count($params) ? $params[0] : $method);
    }

    /**
     * @return string
     */
    protected function renderAttributes()
    {
        if (empty($this->attributes)) {
            return '';
        }

        return collect($this->attributes)
            ->map(function($value, $key) {
                return sprintf(' %s="%s"', $key, $this->escape($value));
            })
            ->implode('');
    }

    /**
     * @param string $attribute
     * @param bool $value
     * @return $this
     */
    protected function setBooleanAttribute($attribute, $value)
    {
        if ($value) {
            return $this->attribute($attribute, $attribute);
        }

        return $this->removeAttribute($attribute);
    }

    /**
     * @param string $value
     * @return string
     */
    protected function escape($value)
    {
        return htmlentities($value, ENT_QUOTES, 'UTF-8');
    }
}
