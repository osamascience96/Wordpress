<?php

/**
* About Controller
*/
class AboutController extends Controller
{
	/**
	* About Controller index method
	* It will call getPage method of this controller
	**/
	public function index() 
	{
		/**
		* Intilize common controller
		* Get common data from DB
		* We used header variable to represent common data
		**/
		$this->load->model('pages');
		$data['page'] = $this->model_pages->pageData('about');
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
		
		$data['header'] = $this->controller_common->getHeader($data['page'], $data['pagetheme']['about']['header']);
		$data['footer'] = $this->controller_common->getFooter(NULL, 'footer');
		$data['doctor'] = $this->controller_common->getDoctors();
		$data['testimonial'] = $this->controller_common->getTestimonials();
		$data['active'] = 'about';
		/**
		* Load about view
		* Pass data to view
		**/
		$this->response->setOutput($this->load->view('about/'.$data['pagetheme']['about']['theme'], $data));
	}
}