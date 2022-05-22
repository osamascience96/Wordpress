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
		$user_agent = $this->repository->get('user_agent');
		if (array_key_exists($uri, $this->routes[$method])) {
			$route = explode('@', $this->routes[$method][$uri]);
			$route_array = array('controller' => $route[0], 'method' => $route[1]);
			$this->dispatch($route_array);
		} elseif ($user_agent->isRoutePage($uri)) {
			$this->dispatch(array('controller' => 'PageController', 'method' => 'index'));
		} else {
			$this->dispatch(array('controller' => 'ErrorController', 'method' => 'pageNotFound'));
		}
	}

	protected function dispatch($route)
	{
		$action = new Action();
		if (!$action->execute($this->repository, $route)) {
			$this->dispatch(array('controller' => 'ErrorController', 'method' => 'pageNotFound'));
		}
	}
}