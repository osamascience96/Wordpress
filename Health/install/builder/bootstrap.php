<?php
//Initilise Repository Class to store all object & variable
$repository = new Repository();

//Loader
$loader = new Loader($repository);
$repository->set('load', $loader);

//Databse
//$repository->set('database', new Database(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE));
$database = new Database();
$repository->set('database', $database);

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

// Router
$routes = new Router($repository);
if (empty($url->get('route'))) {
	$routes->load(BUILDER. 'routes.php')->route('step_1', 'GET');
} else {
	$routes->load(BUILDER. 'routes.php')->route($url->get('route'), $url->server['REQUEST_METHOD']);
}

//Output
$response->output();