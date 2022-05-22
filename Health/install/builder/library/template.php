<?php
/**
* Template class
*/
class Template {
	private $adaptor;
	
	public function __construct($adaptor) {
		$class = 'Template\\' . $adaptor;
		$this->adaptor = new $class();
	}
	
	public function set($key, $value) {
		$this->adaptor->set($key, $value);
	}

	public function render($template, $cache = false) {
		return $this->adaptor->render($template, $cache);
	}
}
