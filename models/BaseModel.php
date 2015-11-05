<?php

/**
 *	The base model class.
 *	Other models extend this class.
 */

namespace Burayan\RestMoji\Models;

use \Sokil\Mongo\Client;

abstract class BaseModel
{

	// Persist the object to db
	public function save()
	{
		$client = self::getClient();
		$collection = $client->getCollection(static::$collection);

		$fields = $this->getFields();
		$document = $collection->createDocument($fields);

		$document->save();
	}

	/**
	 *	Get model's persistable fields.
	 *	@return string $fields
	 */
	abstract public function getFields();

	/**
	 *	Get mongo client instance.
	 * 	@return array $config
	 */
	public static function getClient()
	{
		// get config from config file here.

		$config =
		[
			'dns' => 'mongodb://127.0.0.1',
			'database' => 'restmoji'
		];

		$client = new Client($config['dns']);
		$client->useDatabase($config['database']);

		return $client;
	}
}
