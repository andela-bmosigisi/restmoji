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
     *  @param string $token
	 *	Delete a model with the given token.
	 *	@return boolean
	 */
	public static function delete($token)
	{
		$authInstance = self::find($token);

		if (empty($authInstance)) {
			return false;
		}

		$authInstance->delete();
		return true;
	}

	/**
     *  @param array $match
	 *	Find whether token is there on db and return it.
	 *	@return AuthToken $authInstance
	 */
	public static function find($match)
	{
		$client = static::getClient();
		$collection = $client->getCollection(self::$collection);

		$authInstance = $collection->find()
			->where(key($match), reset($match))
			->findOne();

		return $authInstance;
	}
}
