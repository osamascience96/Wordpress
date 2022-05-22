<?php
namespace Template;

final class Template {
	private $data = array();

	public function set($key, $value) {
		$this->data[$key] = $value;
	}

	public function render($template) {
		$file = $template.'.tpl.php';

		if (is_file($file)) {
			extract($this->data);
			
			ob_start();

			require($file);

			return ob_get_clean();
		}

		throw new \Exception('Error: Could not load template ' . $file . '!');
		exit();
	}
}
