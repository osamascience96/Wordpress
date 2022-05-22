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
$query['route'] = $url->get('route');
$query['method'] = $url->server['REQUEST_METHOD'];

// Response
$response = new Response();
$response->addHeader('Content-Type: text/html; charset=utf-8');
$response->setCompression(0);
$repository->set('response', $response);

// Session
$session = new Session($repository);
$session->start();
$repository->set('session', $session);

//User Agent
$user_agent = new Useragent($repository);
$repository->set('user_agent', $user_agent);

if (!$user_agent->isLogged()) {
	if ($query['route'] == '') {
		$query['route'] = 'login';
	} elseif ($query['route'] != 'login' && $query['route'] != 'forgotpassword' && $query['route'] != 'resetpassword') {
		$url->redirect('login');
	}
}

if ($user_agent->isLogged()) {
	if ($query['route'] == "") {
		$query['route'] = 'dashboard';
	} elseif ($query['route'] == 'login' || $query['route'] == 'forgotpassword' || $query['route'] == 'resetpassword') {
		$url->redirect('dashboard');
	}
}

if (!empty($timezone = $user_agent->getTimezone())) { 
	date_default_timezone_set($timezone); 
}

if ($url->server['REQUEST_METHOD'] == 'POST') {
	$token_value = !empty($url->post('_token')) ? $url->post('_token') : '0';
	if ($user_agent->validateToken($token_value)) {
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			exit('Secuirty Token missing!');
		}
		$session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
		$url->redirect('dashboard');
	}
}

// Router
$routes = new Router($repository);
$routes->load(DIR_BUILDER. 'routes.php')->route($query['route'], $query['method']);

//Output
$response->output();