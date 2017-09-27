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
     * @param string $key
     * @return mixed
     */
    public function getOldInput($key)
    {
        return Arr::get(
            $this->session->get('_old_input', []),
            $this->transformKey($key)
        );
    }

    /**
     * @param string $key
     * @return string
     */
    protected function transformKey($key)
    {
        return str_replace(['.', '[]', '[', ']'], ['_', '', '.', ''], $key);
    }
}
