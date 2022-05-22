<?php

//Initilise Repository Class to store all object & variable
$repository = new Repository();

//Loader
$loader = new Loader($repository);
$repository->set('load', $loader);

//Databse
$repository->set('database', new Database(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE));

// URL
$url = new Url();
$repository->set('url', $url);

// Session
$session = new Session($repository);
$session->start();
$repository->set('session', $session);

// Response
$response = new Response();
$response->addHeader('Content-Type: text/html; charset=utf-8');
$response->setCompression(0);
$repository->set('response', $response);


//User Agent
$user_agent = new Useragent($repository);
$repository->set('user_agent', $user_agent);

if (!empty($timezone = $user_agent->getTimezone())) {
	date_default_timezone_set($timezone);
}

// Router
$routes = new Router($repository);

if (empty($url->get('route'))) {
	$routes->load(DIR_BUILDER. 'routes.php')->route('home', 'GET');
} else {
	$routes->load(DIR_BUILDER. 'routes.php')->route($url->get('route'), $url->server['REQUEST_METHOD']);
}

//Output
$response->output();