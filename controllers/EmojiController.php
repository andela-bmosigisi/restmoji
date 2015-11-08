<?php

/**
 *  @author brian.mosigisi  
 *  Handles the operations for Emojis.
 */
namespace Burayan\RestMoji\Controllers;

use Burayan\RestMoji\Models\Emoji;

class EmojiController
{
    /**
     *  Get emojis, either using id or all of them.
     *  @return string $emojiJson
     */
    public static function get($id = null)
    {
        if ($id === null) {
            $emojis = Emoji::find();
            return json_encode($emojis);
        } 
        $emoji = Emoji::find(['id' => $id]);
        if (empty($emoji)) {
            return;
        }

        return json_encode($emoji->getFields());
    }

    /**
     *  Create an Emoji.
     *  @return string $emojiJson
     */
    public static function create($postFields, $createdBy)
    {
        $prompt = self::validate($postFields);
        if (! $prompt) {
            return;
        }

        // convert keywords to array.
        $postFields['keywords'] = explode(
            ',',
            $postFields['keywords']
        );

        // add created by
        $postFields['created_by'] = $createdBy;

        $emoji = Emoji::create($postFields);

        return json_encode($emoji->getFields());
    }

    /**
     *  @param $fields
     *  Validate the emoji fields passed.
     *  Return true if the validation is passed.
     *  @return boolean
     */
    private static function validate($fields)
    {
        $props = ['name', 'char', 'keywords', 'category'];

        foreach ($props as $value) {
            if (!isset($fields[$value])) {
                return false;
            }
            if (gettype($fields[$value]) != 'string') {
                return false;
            }
        }

        return true;
    }
}