<?php

namespace spec\Burayan\RestMoji\Models;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AuthTokenSpec extends ObjectBehavior
{
    function let()
    {
        $username = 'random';
        $token = 'random';
        $this->beConstructedWith($username, $token);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Burayan\RestMoji\Models\AuthToken');
    }

    function it_returns_persistable_fields()
    {
        $this->getFields()->shouldBeArray();
        $this->getFields()->shouldContain('random');
    }

    function it_should_find_tokens()
    {
        $this->save();
        $this->find(['username' => 'random'])
            ->shouldReturnAnInstanceOf('\Sokil\Mongo\Document');

        $this::delete(['token' => $this->token])->shouldBe(true);
    }
}
