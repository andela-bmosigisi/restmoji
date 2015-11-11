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
     *  Emoji properties.
     *  @var array
     */
    public static $props = ['name', 'char', 'keywords', 'category'];

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

        $postFields['created_by'] = $createdBy;
        $postFields['date_created'] = date("Y-m-d H:i:s");
        $postFields['date_modified'] = date("Y-m-d H:i:s");

        $emoji = Emoji::create($postFields);

        return json_encode($emoji->getFields());
    }

    /**
     *  @param int $id
     *  @param string $fields
     *  @param int flag 1 represents full update (put).
     *  Update an Emoji.
     *  @return string $emojiJson
     */
    public static function update($id, $fields, $flag = 1)
    {
        // get json fields and decode it to array.
        $fields = (array)json_decode($fields);

        // Check whether it is a partial or full update
        if ($flag == 1 && !self::validate($fields)) {
            return;
        }

        // If partial update, check for fields.
        if ($flag == 2) {
            $prompt = true;
            foreach (self::$props as $value) {
                if (isset($fields[$value])) {
                    $prompt = true;
                    break;
                }
                $prompt = false;
            }

            if (!$prompt) {
                return;
            }
        }
        if (isset($fields['keywords'])) {
            $fields['keywords'] = explode(
                ',',
                $fields['keywords']
            );
        }
        $fields['date_modified'] = date("Y-m-d H:i:s");
        $emoji = Emoji::update($id, $fields);

        if (empty($emoji)) {
            return;
        }

        return json_encode($emoji->getFields());
    }

    /**
     *  @param string id
     *  Delete a particular emoji.
     *  @return boolean.
     */
    public static function delete($id)
    {
        $prompt = Emoji::delete($id);

        return $prompt;
    }

    /**
     *  @param $fields
     *  Validate the emoji fields passed.
     *  Return true if the validation is passed.
     *  @return boolean
     */
    private static function validate($fields)
    {
        foreach (self::$props as $value) {
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