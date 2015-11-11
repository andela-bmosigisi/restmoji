<?php

/**
 *  @author brian.mosigisi
 *  Represents a single emoji object.
 */

namespace Burayan\RestMoji\Models;

class Emoji extends BaseModel
{
    /**
     *  @var int
     */
    public $id;

    /**
     *  @var string
     */
    public $name;

    /**
     *  @var string
     */
    public $char;

    /**
     *  @var array
     */
    public $keywords;

    /**
     *  @var string
     */
    public $category;

    /**
     *  @var string
     */
    public $date_created;

    /**
     *  @var string
     */
    public $date_modified;

    /**
     *  @var string
     */
    public $created_by;

    /**
     *  The mongo collection for the class.
     *  @var string
     */
    public static $collection = 'emojis';

    /**
     *  @param array $match
     *  Find the emoji matching the parameter.
     *  @return string $emoji
     */
    public static function find($match = null)
    {
        $collection = self::getCollection();
        if (empty($match)) {
            $emojis = $collection->find()->findAll();
            $finalEmojis = [];
            foreach ($emojis as $doc_id => $emoji) {
                $finalEmojis[] = self::serialize($emoji);
            }
            return $finalEmojis;
        }

        $emoji = $collection->find()
            ->where(key($match), (int)reset($match))
            ->findOne();

        if (empty($emoji)) {
            return;
        }

        return self::serialize($emoji);
    }

    /**
     *  @param array $fields
     *  Create an emoji with given fields.
     *  @return string
     */
    public static function create($fields)
    {
        $collection = self::getCollection();

        // add date_created and date_modified fields

        // add id field
        $cursor = $collection->find()->limit(1)->sort(['id' => -1]);
        $max = $cursor->findAll();

        if (empty($max)) {
            $fields['id'] = 1;
        } else {
            $max = reset($max);
            $fields['id'] = $max->id + 1;
        }

        $emoji = $collection->createDocument($fields)->save();

        return self::serialize($emoji);
    }

    /**
     *  @param array $fields
     *  Create an emoji with given fields.
     *  @return string
     */
    public static function update($id, $fields)
    {
        $collection = self::getCollection();
        $emoji = $collection->find()
            ->where('id', (int)$id)
            ->findOne();

        if (empty($emoji)) {
            return;
        }

        foreach ($fields as $key => $value) {
            $emoji->{$key} = $value;
        }

        $emoji->save();

        return self::serialize($emoji);
    }

    /**
     *  @param string $id
     *  Delete a model with the given id.
     *  @return boolean
     */
    public static function delete($id)
    {
        $collection = self::getCollection();
        $emoji = $collection->find()
            ->where('id', (int)$id)
            ->findOne();

        if (empty($emoji)) {
            return false;
        }

        $emoji->delete();

        return true;
    }

    /**
     *  Implementation of the abstract getFields().
     *  @return array $fields
     */
    public function getFields()
    {
        return (array)$this;
    }

    /**
     *  Get an instance of the \Sokil\Mongo\Collection class.
     *  @return 
     */
    private static function getCollection()
    {
        $client = static::getClient();
        $collection = $client->getCollection(self::$collection);

        return $collection;
    }

    /**
     *  @param \Sokil\Mongo\Document $emo
     *  Takes an instance of the document class and
     *  returns an emoji instance.
     *  @return Emoji $emoji
     */
    private static function serialize($emo)
    {
        $emoji = new self();
        $emoji->id = $emo->id;
        $emoji->name = $emo->name;
        $emoji->char = $emo->char;
        $emoji->keywords = $emo->keywords;
        $emoji->category = $emo->category;
        $emoji->date_created = $emo->date_created;
        $emoji->date_modified = $emo->date_modified;
        $emoji->created_by = $emo->created_by;

        return $emoji;
    }
}
