<?php

/**
 *	This controller handles the authentication of requests.
 */
namespace Burayan\RestMoji\Controllers;

use Burayan\RestMoji\Models as Models;

class AuthController
{

	/**
	 *	Login the user with given username.
	 *	@return string $json
	 */
	public static function login($username)
	{
		// make a random token
		$token = md5(uniqid(mt_rand(), true));

		$auth_token = new Models\AuthToken($username, $token);
		$auth_token->save();

		$fields = $auth_token->getFields();

		return json_encode($fields);
	}

	/**
	 *	Logout the user with the token.
	 *	@return boolean $prompt
	 */
	public static function logout($token)
	{
		return Models\AuthToken::delete($token);
	}
}
