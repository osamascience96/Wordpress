<?php

/**
* Not_found Controller
*/
class ErrorController extends Controller
{
	public function index($error)
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		if ($error == '403') {
			$data['page_title'] = '403 Not Found';
			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 403');
			$this->response->setOutput($this->load->view('not_found/403', $data));
		}
		if ($error == '404') {
			$data['page_title'] = '404';
			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Page Not Found');
			$this->response->setOutput($this->load->view('not_found/404', $data));
		}
	}

	public function pageNotFound()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		$data['page_title'] = '404 Page Not Found';
		$this->response->addHeader($this->request['server']['SERVER_PROTOCOL'] . ' 404 Page Not Found');
		$this->response->setOutput($this->load->view('not_found/404', $data));
	}

	public function forbidden($data = NULL)
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		$data['page_title'] = 'Forbidden';
		$this->response->addHeader($this->request['server']['SERVER_PROTOCOL'] . ' Forbidden');

		$this->response->setOutput($this->load->view('not_found/403', $data));
	}
}