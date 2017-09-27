<?php

namespace Galahad\Forms\Elements;

class FormOpen extends Element
{
    /** @var array */
    protected $attributes = [
        'method' => 'POST',
        'action' => '',
    ];

    /** @var string */
    protected $token;

    /** @var \Galahad\Forms\Elements\Hidden */
    protected $hiddenMethod;

    /**
     * @return string
     */
    public function render()
    {
        $tags = [sprintf('<form%s>', $this->renderAttributes())];

        if ($this->hasToken() && 'GET' !== $this->getAttribute('method')) {
            $tags[] = $this->token->render();
        }

        if ($this->hasHiddenMethod()) {
            $tags[] = $this->hiddenMethod->render();
        }

        return implode($tags);
    }

    /**
     * @return bool
     */
    protected function hasToken()
    {
        return null !== $this->token;
    }

    /**
     * @return bool
     */
    protected function hasHiddenMethod()
    {
        return null !== $this->hiddenMethod;
    }

    /**
     * @return $this
     */
    public function post()
    {
        $this->setMethod('POST');

        return $this;
    }

    /**
     * @return $this
     */
    public function get()
    {
        $this->setMethod('GET');

        return $this;
    }

    /**
     * @return \Galahad\Forms\Elements\FormOpen
     */
    public function put()
    {
        return $this->setHiddenMethod('PUT');
    }

    /**
     * @return \Galahad\Forms\Elements\FormOpen
     */
    public function patch()
    {
        return $this->setHiddenMethod('PATCH');
    }

    /**
     * @return \Galahad\Forms\Elements\FormOpen
     */
    public function delete()
    {
        return $this->setHiddenMethod('DELETE');
    }

    /**
     * @param $token
     * @return $this
     */
    public function token($token)
    {
        $this->token = new Hidden('_token');
        $this->token->value($token);

        return $this;
    }

    /**
     * @param $method
     * @return $this
     */
    protected function setHiddenMethod($method)
    {
        $this->setMethod('POST');
        $this->hiddenMethod = new Hidden('_method');
        $this->hiddenMethod->value($method);

        return $this;
    }

    /**
     * @param $method
     * @return $this
     */
    public function setMethod($method)
    {
        $this->setAttribute('method', $method);

        return $this;
    }

    /**
     * @param $action
     * @return $this
     */
    public function action($action)
    {
        $this->setAttribute('action', $action);

        return $this;
    }

    /**
     * @param string $name
     * @param array $parameters
     * @param bool $absolute
     * @return \Galahad\Forms\Elements\FormOpen
     */
    public function route($name, $parameters = [], $absolute = true)
    {
        return $this->action($this->route($name, $parameters, $absolute));
    }

    /**
     * @param string $type
     * @return $this
     */
    public function encodingType($type)
    {
        $this->setAttribute('enctype', $type);

        return $this;
    }

    /**
     * @return $this
     */
    public function multipart()
    {
        return $this->encodingType('multipart/form-data');
    }
}
