<?php

/**
* 
*/
class ErrorController extends Controller
{
	public function index($error)
	{
		$this->load->controller('common');
		$data = array();
		$data = array_merge($data, $this->controller_common->index());

		$data['page']['page_title'] = $data['lang']['text_profile'];
		$data['page']['meta_tag'] = $data['page']['page_title'].' | ' .$data['siteinfo']['name'];
		$data['page']['meta_description'] = $data['page']['page_title'].', '.$data['siteinfo']['name'];

		$data['header'] = $this->controller_common->getHeader($data['page'], $data['pagetheme']['other']['header']);
		$data['footer'] = $this->controller_common->getFooter(NULL, 'footer');
		
		if ($error == '403') {
			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 403 Not Found');
			$this->response->setOutput($this->load->view('not_found/403', $data));
		}
		if ($error == '404') {
			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Page Not Found');
			$this->response->setOutput($this->load->view('not_found/404', $data));
		}
	}

	public function pageNotFound()
	{
		$this->load->controller('common');
		$data = array();
		$data = array_merge($data, $this->controller_common->index());
		
		$data['page']['page_title'] = $data['lang']['text_page_not_found'];
		$data['page']['meta_tag'] = $data['page']['page_title'].' | ' .$data['siteinfo']['name'];
		$data['page']['meta_description'] = $data['page']['page_title'].', '.$data['siteinfo']['name'];

		$data['header'] = $this->controller_common->getHeader($data['page'], $data['pagetheme']['other']['header']);
		$data['footer'] = $this->controller_common->getFooter(NULL, 'footer');
		$this->response->addHeader($this->request['server']['SERVER_PROTOCOL'] . ' 404 Page Not Found');
		$this->response->setOutput($this->load->view('not_found/404', $data));
	}

	public function forbidden()
	{
		$this->load->controller('common');
		$data = array();
		$data = array_merge($data, $this->controller_common->index());

		$data['page']['page_title'] = $data['lang']['text_access_denied'];
		$data['page']['meta_tag'] = $data['page']['page_title'].' | ' .$data['siteinfo']['name'];
		$data['page']['meta_description'] = $data['page']['page_title'].', '.$data['siteinfo']['name'];

		$data['header'] = $this->controller_common->getHeader($data['page'], $data['pagetheme']['other']['header']);
		$data['footer'] = $this->controller_common->getFooter(NULL, 'footer');

		$this->response->addHeader($this->request['server']['SERVER_PROTOCOL'] . ' Forbidden');

		$this->response->setOutput($this->load->view('not_found/403', $data));
	}
}