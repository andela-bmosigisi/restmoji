<?php

/**
 *	@author brian.mosigisi
 *	Represents a single auth token.
 */

namespace Burayan\RestMoji\Models;

class AuthToken extends BaseModel
{

	/**
	 *	The owner of the token.
	 *	@var string
	 */
	public $username;

	/**
	 *	The random generated token.
	 *	@var string
	 */
	public $token;

	/**
	 *	The expiry unix timestamp of the token.
	 *	@var int
	 */
	public $expiry;

	/**
	 *	The mongo collection for the class.
	 *	@var string
	 */
	public static $collection = 'tokens';

	public function __construct($username, $token)
	{
		$this->username = $username;
		$this->token = $token;

		// Tokens expire 1 hour after their creation.
		$this->expiry = time() + 3600;
	}

	/**
	 *	Implementation of the abstract getFields().
	 *	@return array $fields
	 */
	public function getFields()
	{
		return [
			'token' => $this->token,
			'username' => $this->username,
			'expiry' => $this->expiry,
		];
	}

	/**
	 *	Delete a model with the given token.
	 *	@return boolean
	 */
	public static function delete($token)
	{
		$client = static::getClient();
		$collection = $client->getCollection(self::$collection);

		$auth_instance = $collection->find()
			->where('token', $token)
			->findOne();

		if (empty($auth_instance)) {
			return false;
		}

		$auth_instance->delete();
		return true;
	}
}
