<?php

namespace spec\Burayan\RestMoji\Models;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EmojiSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Burayan\RestMoji\Models\Emoji');
    }

    function it_returns_persistable_fields()
    {
        $this->getFields()->shouldBeArray();
    }
}
