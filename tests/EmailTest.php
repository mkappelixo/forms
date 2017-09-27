<?php

use Galahad\Forms\Elements\Email;

class EmailTest extends TestCase
{
    use TextSubclassContractTest;

    protected function newTestSubjectInstance($name)
    {
        return new Email($name);
    }

    protected function getTestSubjectType()
    {
        return 'email';
    }
}
