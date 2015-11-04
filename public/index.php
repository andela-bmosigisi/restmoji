<?php

/**
 *	@author brian.mosigisi
 *	Entry point for all the requests to the application.
 */

require __DIR__.'/../vendor/autoload.php';

// use Burayan\RestMoji\Controllers as Controllers;

$app = new \Slim\Slim();

$app->config(
   ['templates.path' =>  __DIR__.'/templates']
);

$app->get('/', function () use ($app) {
	// send back the authentication/documentation page
	$app->render('landing.php');
});

$app->get('/hello/:name', function ($name) {
    echo "Hello, $name";
});

$app->run();