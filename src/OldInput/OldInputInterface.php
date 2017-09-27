<?php

namespace Galahad\Forms\OldInput;

interface OldInputInterface
{
    public function hasOldInput($key = null);

    public function getOldInput($key = null, $default = null);
}
