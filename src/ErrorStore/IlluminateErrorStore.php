<?php

namespace Galahad\Forms\ErrorStore;

use Illuminate\Contracts\Session\Session;
use Illuminate\Support\MessageBag;

class IlluminateErrorStore implements ErrorStorInterface
{
    /** @var \Illuminate\Contracts\Session\Session */
    protected $session;

    /**
     * @param \Illuminate\Contracts\Session\Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasError($key)
    {
        if (! $this->hasErrors()) {
            return false;
        }

        return $this->getErrors()->has($this->transformKey($key));
    }

    /**
     * @param $key
     * @return string|null
     */
    public function getError($key)
    {
        if (! $this->hasError($key)) {
            return null;
        }

        return $this->getErrors()->first($this->transformKey($key));
    }

    /**
     * @return bool
     */
    protected function hasErrors()
    {
        return $this->session->has('errors');
    }

    /**
     * @return \Illuminate\Support\MessageBag
     */
    protected function getErrors()
    {
        return $this->session->get('errors', new MessageBag());
    }

    /**
     * @param $key
     * @return mixed
     */
    protected function transformKey($key)
    {
        return str_replace(['.', '[]', '[', ']'], ['_', '', '.', ''], $key);
    }
}
