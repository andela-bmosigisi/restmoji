<?php

/**
 *  @author brian.mosigisi  
 *  This controller handles the authentication of requests.
 */
namespace Burayan\RestMoji\Controllers;

use Burayan\RestMoji\Models\AuthToken;

class AuthController
{

    /**
     *  Login the user with given username.
     *  @return string $json
     */
    public static function login($username)
    {
        // make a random token
        $token = md5(uniqid(mt_rand(), true));

        $auth_token = new AuthToken($username, $token);
        $auth_token->save();

        $fields = $auth_token->getFields();

        return json_encode($fields);
    }

    /**
     *  Logout the user with the token.
     *  @return boolean $prompt
     */
    public static function logout($token)
    {
        return AuthToken::delete($token);
    }

    /**
     *  Authenticates the passed token.
     *  Returns true if it is valid, false if not.
     *  @return boolean
     */
    public static function authenticateToken($token)
    {
        $authToken = AuthToken::find($token);
        if (empty($authToken)) {
            return false;
        }

        // check whether the expiry time date has passed.
        $expiry = $authToken->expiry;
        if (time() > $expiry) {
            return false;
        }

        return true;
    }
}
