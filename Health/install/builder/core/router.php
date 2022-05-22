<?php
/**
* Router
*/
class Router
{
	protected $repository;
	protected $routes = [ 'GET' => [], 'POST' => [] ];

	public function __construct($repository) {
		$this->repository = $repository;
	}

	public function load($file)
	{
		$router = new static($this->repository);
		require $file;
		return $router;
	}

	public function get($uri, $controller)
	{
		$this->routes['GET'][$uri] = $controller;
	}

	public function post($uri, $controller)
	{
		$this->routes['POST'][$uri] = $controller;
	}

	public function route($uri, $method)
	{
		$check = $this->check_requirements();
		if ($check[0]) {
			$uri = 'showerror';
			$session = $this->repository->get('session');
			$session->data['servererror'] = $check[1];
		}
		if (array_key_exists($uri, $this->routes[$method])) {
			$route = explode('@', $this->routes[$method][$uri]);
			$route_array = array('controller' => $route[0], 'method' => $route[1]);
			$this->dispatch($route_array);
		} else {
			$route_array = array('controller' => 'StepController', 'method' => 'firstStep');
			$this->dispatch($route_array);
		}
	}

	protected function dispatch($route)
	{
		$action = new Action();
		if (!$action->execute($this->repository, $route)) {
			$this->dispatch(array('controller' => 'StepController', 'method' => 'firstStep'));
		}
	}

	/*Check application requirments*/
	public function check_requirements() {
		$error = null;
		$flag = null;
		if (phpversion() < '5.6') {
			$flag = 1;
			$error = 'Error: You need to use PHP 5.6 or above for Klinikal theme to work! Please upgrade your php version.';
		}

		if (!ini_get('file_uploads')) {
			$flag = 1;
			$error = 'Error: file_uploads needs to be enabled!';
		}

		if (ini_get('session.auto_start')) {
			$flag = 1;
			$error = 'Error: Klinikal will not work with session.auto_start enabled!';
		}

		if (!extension_loaded('mysqli')) {
			$flag = 1;
			$error = 'Error: MySQLi extension needs to be loaded for Klinikal to work!';
		}

		if (!extension_loaded('gd')) {
			$flag = 1;
			$error = 'Error: GD extension needs to be loaded for Klinikal to work!';
		}

		if (!extension_loaded('zlib')) {
			$flag = 1;
			$error = 'Error: ZLIB extension needs to be loaded for Klinikal to work!';
		}

		return array($flag, $error);
	}
}