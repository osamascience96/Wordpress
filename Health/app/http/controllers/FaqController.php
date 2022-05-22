<?php

/**
* FAQ Controller
*/
class FaqController extends Controller
{
	/**
	* FAQ controller index method
	* It will call getPage method of this controller
	**/
	public function index()
	{
		$this->load->model('pages');
		$data['page'] = $this->model_pages->pageData('faq');
		$data['page']['page_data'] = json_decode($data['page']['page_data'], true);
		
		$this->load->controller('common');
		$data = array_merge($data, $this->controller_common->index());
		$data['page']['breadcrumbs'] = array();
		$data['page']['breadcrumbs'][] = array(
			'label' => $data['lang']['text_home'],
			'link' => URL.DIR_ROUTE.'home',
		);
		$data['page']['breadcrumbs'][] = array(
			'label' => $data['page']['page_title'],
			'link' => '#',
		);
		
		$data['header'] = $this->controller_common->getHeader($data['page'], $data['pagetheme']['faq']['header']);
		$data['footer'] = $this->controller_common->getFooter(NULL, 'footer');
		$data['active'] = 'faq';
		
		/**
		* Load FAQ view
		* Pass data to view
		**/
		$this->response->setOutput($this->load->view('faq/'.$data['pagetheme']['faq']['theme'], $data));
	}
}