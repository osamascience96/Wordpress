<?php

/**
* Doctor Controller
*/
class DoctorController extends Controller
{
	/**
	* Doctor controller index method
	* It will call getPage method of this controller
	**/
	public function index() {
		$this->load->model('pages');
		$data['page'] = $this->model_pages->pageData('doctors');
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
		
		$data['header'] = $this->controller_common->getHeader($data['page'], $data['pagetheme']['doctors']['header']);
		$data['footer'] = $this->controller_common->getFooter(NULL, 'footer');

		$data['departments'] = $this->controller_common->getDepartments($data['page']);
		$data['doctors'] = $this->model_pages->allDoctors();
		
		$data['recentblog'] = $this->model_pages->recentBlog();
		$data['slider_services'] = $this->model_pages->getSliderServices();
		$data['active'] = 'doctor';

		$this->response->setOutput($this->load->view('doctor/'.$data['pagetheme']['doctors']['theme'], $data));
	}
}