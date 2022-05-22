<?php
/**
* Loader class
*/
final class Loader {
	protected $repository;

	public function __construct($repository)
	{
		$this->repository = $repository;
	}

	public function controller($controller, $data = array())
	{
		$controller = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$controller);
		
		if (!$this->repository->has('controller_'.strtolower($controller))) {
			$file  = DIR_APP . 'http/controllers/' . ucfirst($controller) . 'Controller.php';
			$class = $controller . 'Controller';
			if (is_file($file)) {
				include_once($file);
				$this->repository->set('controller_' . strtolower($controller), new $class($this->repository));
			}
		}
	}

	public function model($model)
	{
		$model = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$model);
		
		if (!$this->repository->has('model_'.strtolower($model))) {
			$file  = DIR_APP . 'http/models/' . ucfirst($model) . '.php';
			if (is_file($file)) {
				include_once($file);
				$this->repository->set('model_' . strtolower($model), new $model($this->repository));
			}
		}
	}

	public function view($view, $data = array())
	{
		$template = new Template('template');
		if (!empty($data)) {
			foreach ($data as $key => $value) {
				$template->set($key, $value);
			}
		}
		$output = $template->render(DIR_VIEW . $view);
		return $output;
	}

	public function library($library)
	{
		$library = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$library);

		$file = DIR_BUILDER . 'library/' . $library . '.php';

		if (is_file($file)) {
			include_once($file);

			$this->repository->set(basename($route), new $library($this->repository));
		}
	}

	public function language($route, $key = '')
	{
		// Sanitize the call
		$route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route);
		
		$output = $this->repository->get('language')->load($route, $key);

		return $output;
	}
}