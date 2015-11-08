<?php

/**
 *  @author brian.mosigisi
 *  Entry point for all the requests to the application.
 */

require __DIR__.'/../vendor/autoload.php';

use Burayan\RestMoji\Controllers as Controllers;
use Burayan\RestMoji\Middleware\Auth;

$app = new \Slim\Slim();

$app->config(
   ['templates.path' =>  __DIR__.'/../templates']
);

$app->add(new Auth()); // add middleware here

$app->get('/', function () use ($app) {
    // send back the authentication/documentation page
    $app->render('landing.php');
});

$app->group('/auth', function () use ($app) {

    $app->post('/login', function () use ($app) {
        $app->response->headers
            ->set('Content-Type', 'application/json');
        $username = $app->request()->post('username');

        if (empty($username)) {
            $app->response->setStatus(400);
            $app->response->body(
                '{"error" : "Provide a username"}'
            );

            return $app->response();
        }

        // login the user and return auth token
        $json = Controllers\AuthController::login($username);

        $app->response->body($json);

        return $app->response();
    });

    $app->get('/logout', function() use ($app) {
        $app->response->headers
            ->set('Content-Type', 'application/json');
        // Delete auth token from DB.
        $token = $app->request->headers->get('token');
        if (empty($token)) {
            $app->response->setStatus(400);
            $app->response->body(
                '{"error" : "Provide a token to remove"}'
            );

            return $app->response();
        }

        $prompt = Controllers\AuthController::logout($token);

        if (!$prompt) {
            $app->response->setStatus(400);
            $app->response->body(
                '{"error" : "Invalid token"}'
            );

            return $app->response();
        }

        $app->response->body(
            '{"success" : "Logged out successfuly"}'
        );

        return $app->response();
    });
});

$app->group('/emojis', function () use ($app) {
    $app->response->headers
        ->set('Content-Type', 'application/json');

    // Get an emoji with ID
    $app->get('/', function () use ($app) {
        $emoji = Controllers\EmojiController::get();
        if (empty($emoji)) {
            $app->response->setStatus(404);
            $app->response->body(
                '{"error" : "Emoji not found"}'
            );

            return $app->response();
        }

        $app->response->body($emoji);

        return $app->response(); 
    });

    // Get an emoji with ID
    $app->get('/:id', function ($id) use ($app) {
        $emoji = Controllers\EmojiController::get($id);
        if (empty($emoji)) {
            $app->response->setStatus(404);
            $app->response->body(
                '{"error" : "Emoji not found"}'
            );

            return $app->response();
        }

        $app->response->body($emoji);

        return $app->response(); 
    });

    // Create an Emoji.
    $app->post('/', function () use ($app) {
        $postVars = null;
        if ($app->request->headers->get('Content-Type')
            == 'application/json') {
            $postVars = (array)json_decode($app->request->getBody());
        } else {
            $postVars = $app->request->post();
        }
        $emoji = Controllers\EmojiController::create(
            $postVars,
            $app->request->headers->get('token')
        );
        if (empty($emoji)) {
            $app->response->setStatus(400);
            $app->response->body(
                '{"error" : "Validation failed. Check fields."}'
            );

            return $app->response();
        }

        $app->response->setStatus(201);
        $app->response->body($emoji);

        return $app->response(); 
    });

    // Update emoji with ID.
    $app->put('/:id', function ($id) use ($app) {
        $putVars = $app->request->getBody();
        $emoji = Controllers\EmojiController::update(
            $id,
            $putVars,
            1
        );
        if (empty($emoji)) {
            $app->response->setStatus(304);
            $app->response->body(
                '{"error" : "Not Modified."}'
            );

            return $app->response();
        }

        $app->response->body($emoji);

        return $app->response(); 
    });

    // Partially update an emoji with ID.
    $app->patch('/:id', function ($id) {
        $patchVars = $app->request->getBody();
        $emoji = Controllers\EmojiController::update(
            $id,
            $patchVars,
            2
        );
        if (empty($emoji)) {
            $app->response->setStatus(304);
            $app->response->body(
                '{"error" : "Not Modified."}'
            );

            return $app->response();
        }

        $app->response->body($emoji);

        return $app->response(); 
    });

    // Delete emoji with ID.
    $app->delete('/:id', function ($id) use ($app) {
        $prompt = Controllers\EmojiController::delete($id);

        if (!$prompt) {
            $app->response->setStatus(400);
            $app->response->body(
                '{"error" : "Not deleted. Emoji does not exist."}'
            );

            return $app->response();
        }

        $app->response->body(
            '{"success" : "Emoji '.$id.' deleted successfully."}'
        );

        return $app->response();
    });
});

$app->run();
