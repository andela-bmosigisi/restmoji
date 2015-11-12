<?php

namespace spec\Burayan\RestMoji\Controllers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EmojiControllerSpec extends ObjectBehavior
{
    private static $emojiId;

    function let()
    {
        $emoji = [
            "name" => "testing",
            "char" => "test_unicode",
            "keywords" => 'a,b,c',
            "category" => "test"
        ];
        $emoji = $this::create($emoji, 'burayan');
        $emoji->shouldBeString();
        $emoji = $emoji->getWrappedObject();

        self::$emojiId =  json_decode($emoji)->id;
    }

    function letGo()
    {
        $this::delete(self::$emojiId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(
            'Burayan\RestMoji\Controllers\EmojiController'
        );
    }

    function it_returns_all_emojis()
    {
        $this::get()->shouldBeString();
    }

    function it_returns_specific_emojis()
    {
        $this::get(self::$emojiId)->shouldBeString();
    }

    function it_updates_emojis()
    {
        $update = '{"keywords" : "c,d"}';

        $newMoji = $this::update(self::$emojiId, $update, 2);
        $newMoji->shouldBeString();
    }
}
