<?php

namespace Galahad\Forms\OldInput;

interface OldInputInterface
{
    public function hasOldInput();

    public function getOldInput($key);
}
