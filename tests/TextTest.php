<?php

use Galahad\Forms\Elements\Text;

class TextTest extends PHPUnit_Framework_TestCase
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
