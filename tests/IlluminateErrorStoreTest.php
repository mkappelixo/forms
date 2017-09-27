<?php

use Illuminate\Contracts\Session\Session;
use Galahad\Forms\ErrorStore\IlluminateErrorStore;
use Illuminate\Support\MessageBag;

class IlluminateErrorStoreTest extends TestCase
{
    public function test_it_converts_array_keys_to_dot_notation()
    {
        $errors = new MessageBag(['foo.bar' => 'Some error']);
        $session = Mockery::mock(Session::class);
        $session->shouldReceive('has')->with('errors')->andReturn(true);
        $session->shouldReceive('get')->with('errors', MessageBag::class)->andReturn($errors);

        $errorStore = new IlluminateErrorStore($session);
        $this->assertTrue($errorStore->hasError('foo[bar]'));
    }
}
