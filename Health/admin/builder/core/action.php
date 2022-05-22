<?php
/**
* Action class
*/
class Action {
	private $controller;
	private $method;

	public function execute($repository, $route = array(), array $args = array())
	{
		$file  = DIR_APP . 'http/controllers/' . $route['controller'] . '.php';	
		$class = preg_replace('/[^a-zA-Z0-9]/', '', $route['controller']);
		if (is_file($file)) {
			include_once($file);
			$this->controller = new $class($repository);
			$this->method = $route['method'];
		} else {
			return false;
		}

		// Stop any magical methods being called
		if (substr($this->method, 0, 2) == '__') {
			return false;
		}

		$reflection = new ReflectionClass($class);
		if ($reflection->hasMethod($this->method)) {
			call_user_func_array(array($this->controller, $this->method), $args);
			return true;
		} else {
			return false;
		}
	}
}
