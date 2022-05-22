<?php

/**
* Home Controller
*/
class HomeController extends Controller
{
	public function index() {
		$this->getPage();
	}

	/**
	* Home controller index method
	* It will call getPage method of this controller
	**/
	protected function getPage()
	{
		/**
		* Intilize common controller
		* Get common data from DB
		* We used header variable to represent common data
		**/
		
		$this->load->model('pages');
		$data['page'] = $this->model_pages->pageData('home');
		$data['page']['page_data'] = json_decode($data['page']['page_data'], true);
		$this->load->controller('common');
		$data = array_merge($data, $this->controller_common->index());
		$data['page']['breadcrumbs'] = array();
		//$data['lang'] = $this->controller_common->getLanguage();
		$data['header'] = $this->controller_common->getHeader($data['page'], $data['pagetheme']['home']['header']);
		$data['footer'] = $this->controller_common->getFooter(NULL, 'footer');

		$data['testimonial'] = $this->controller_common->getTestimonials();
		$data['blog'] = $this->controller_common->getBlogs();
		$data['sliderdoctor'] = $this->controller_common->getSliderDoctors();

		$data['services'] = $this->model_pages->homeServices();
		$data['facilities'] = $this->model_pages->allFacilities();
		
		$data['active'] = 'home';
		
		/**
		* Load home view according to theme selected
		* Pass data to view
		**/
		$this->response->setOutput($this->load->view('home/'.$data['pagetheme']['home']['theme'], $data));
	}
}