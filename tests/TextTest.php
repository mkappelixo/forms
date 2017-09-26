<?php

use Galahad\Forms\Elements\Text;

class TextTest extends \PHPUnit\Framework\TestCase
{
    use TextSubclassContractTest;

    protected function newTestSubjectInstance($name)
    {
        return new Text($name);
    }

    protected function getTestSubjectType()
    {
        return 'text';
    }
}
