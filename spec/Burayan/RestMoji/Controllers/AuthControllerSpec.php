<?php

namespace spec\Burayan\RestMoji\Controllers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AuthControllerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Burayan\RestMoji\Controllers\AuthController');
    }

    function it_authenticates_a_user()
    {
        $this::authenticateToken('random')->shouldBe(False);
    }
}
