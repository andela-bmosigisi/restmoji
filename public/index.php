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
        $username = $app->request()->post('username');

        if (empty($username)) {
            $app->response->setStatus(400);
            $app->response->headers
                ->set('Content-Type', 'application/json');
            $app->response->body(
                '{"error" : "Provide a username"}'
            );

            return $app->response();
        }

        // login the user and return auth token
        $json = Controllers\AuthController::login($username);

        $app->response->headers
            ->set('Content-Type', 'application/json');
        $app->response->body($json);

        return $app->response();
    });

    $app->get('/logout', function() use ($app) {
        // Delete auth token from DB.
        $token = $app->request->headers->get('token');
        if (empty($token)) {
            $app->response->setStatus(400);
            $app->response->headers
                ->set('Content-Type', 'application/json');
            $app->response->body(
                '{"error" : "Provide a token to remove"}'
            );

            return $app->response();
        }

        $prompt = Controllers\AuthController::logout($token);

        if (!$prompt) {
            $app->response->setStatus(400);
            $app->response->headers
                ->set('Content-Type', 'application/json');
            $app->response->body(
                '{"error" : "Invalid token"}'
            );

            return $app->response();
        }

        $app->response->headers
            ->set('Content-Type', 'application/json');
        $app->response->body(
            '{"success" : "Logged out successfuly"}'
        );

        return $app->response();
    });
});

$app->group('/emojis', function () use ($app) {

     // Get an emoji with ID
    $app->get('/', function () use ($app) {
        $emoji = Controllers\EmojiController::get();
        if (empty($emoji)) {
            $app->response->setStatus(404);
            $app->response->headers
                ->set('Content-Type', 'application/json');
            $app->response->body(
                '{"error" : "Emoji not found"}'
            );

            return $app->response();
        }

        $app->response->headers
            ->set('Content-Type', 'application/json');
        $app->response->body($emoji);

        return $app->response(); 
    });

    // Get an emoji with ID
    $app->get('/:id', function ($id) use ($app) {
        $emoji = Controllers\EmojiController::get($id);
        if (empty($emoji)) {
            $app->response->setStatus(404);
            $app->response->headers
                ->set('Content-Type', 'application/json');
            $app->response->body(
                '{"error" : "Emoji not found"}'
            );

            return $app->response();
        }

        $app->response->headers
            ->set('Content-Type', 'application/json');
        $app->response->body($emoji);

        return $app->response(); 
    });

    // Create an Emoji.
    $app->post('/', function () use ($app) {
        $postVars = $app->request->post();
        $emoji = Controllers\EmojiController::create(
            $postVars,
            $app->request->headers->get('token')
        );
        if (empty($emoji)) {
            $app->response->setStatus(400);
            $app->response->headers
                ->set('Content-Type', 'application/json');
            $app->response->body(
                '{"error" : "Validation failed. Check fields."}'
            );

            return $app->response();
        }

        $app->response->setStatus(201);
        $app->response->headers
            ->set('Content-Type', 'application/json');
        $app->response->body($emoji);

        return $app->response(); 
    });

    // Update emoji with ID.
    $app->put('/:id', function ($id) {

    });

    // Partially update an emoji with ID.
    $app->patch('/:id', function ($id) {

    });

    // Delete emoji with ID.
    $app->delete('/:id', function ($id) {

    });
});

$app->run();
