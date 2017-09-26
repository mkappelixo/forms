<?php

namespace Galahad\Forms\ErrorStore;

interface ErrorStoreInterface
{
    public function hasError($key);

    public function getError($key);
}
