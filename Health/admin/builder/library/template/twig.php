<?php
namespace Template;
final class Twig {
	private $twig;
	private $data = array();
	
	public function __construct() {
		// include and register Twig auto-loader
		require_once DIR_BUILDER.'vendor/autoload.php';

	}
	
	public function set($key, $value) {
		$this->data[$key] = $value;
	}
	
	public function render($template, $cache = false) {
		// specify where to look for templates
		$loader = new \Twig\Loader\FilesystemLoader(DIR_APP.'views/');


		// initialize Twig environment
		$config = array('autoescape' => false);

		$twig = new \Twig\Environment($loader, [
			'cache' => false,
		]);

		try {
			// load template
			return $twig->render($template.'.tpl.php', $this->data);
		} catch (Exception $e) {
			trigger_error('Error: Could not load template ' . $template . '!');
			exit();	
		}
	}	
}
