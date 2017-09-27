<?php

namespace Galahad\Forms\OldInput;

use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Arr;

class IlluminateOldInputProvider implements OldInputInterface
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
     * @return bool
     * @param string|null $key
     */
    public function hasOldInput($key = null)
    {
        $old = $this->getOldInput($key);

        return null === $key ? count($old) > 0 : null !== $old;
    }

    /**
     * @return mixed
     * @param string $key
     * @param null $default
     */
    public function getOldInput($key = null, $default = null)
    {
        return Arr::get(
            $this->session->get('_old_input', []),
            $this->transformKey($key),
            $default
        );
    }

    /**
     * @param string $key
     * @return string|null
     */
    protected function transformKey($key = null)
    {
        if (null === $key) {
            return $key;
        }

        return str_replace(['.', '[]', '[', ']'], ['_', '', '.', ''], $key);
    }
}
