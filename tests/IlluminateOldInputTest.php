<?php

use Illuminate\Contracts\Session\Session;
use Galahad\Forms\OldInput\IlluminateOldInputProvider;

class IlluminateOldInputTest extends TestCase
{
    public function test_has_old_input()
    {
        $session = Mockery::mock(Session::class);
        $session->shouldReceive('get')->with('_old_input', [])->andReturn(['foo' => 'bar']);

        $provider = new IlluminateOldInputProvider($session);

        $this->assertTrue($provider->hasOldInput());
        $this->assertTrue($provider->hasOldInput('foo'));
        $this->assertFalse($provider->hasOldInput('bar'));
    }

    public function test_does_not_have_old_input()
    {
        $session = Mockery::mock(Session::class);
        $session->shouldReceive('get')->with('_old_input', [])->andReturn([]);

        $provider = new IlluminateOldInputProvider($session);

        $this->assertFalse($provider->hasOldInput());
        $this->assertFalse($provider->hasOldInput('bar'));
    }

    public function test_get_old_input()
    {
        $session = Mockery::mock(Session::class);
        $session->shouldReceive('get')->with('_old_input', [])->andReturn(['foo' => 'bar']);

        $provider = new IlluminateOldInputProvider($session);

        $this->assertEquals(['foo' => 'bar'], $provider->getOldInput());
        $this->assertEquals('bar', $provider->getOldInput('foo'));
        $this->assertNull($provider->getOldInput('baz'));
        $this->assertEquals('foo', $provider->getOldInput('baz', 'foo'));
    }
}
