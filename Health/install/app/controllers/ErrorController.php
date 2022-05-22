<?php

/**
* ErrorController
*/
class ErrorController extends Controller
{
	public function showError()
	{
		$data = array();
		if (isset($this->session->data['servererror'])) {
			$data['error'] = $this->session->data['servererror'];
		} else {
			$data['error'] = 'Unknown Error';
		}
		$this->response->setOutput($this->load->view('not_found/error', $data));
	}
}