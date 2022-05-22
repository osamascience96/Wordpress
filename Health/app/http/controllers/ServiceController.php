<?php

/**
* Service Controller
*/
class ServiceController extends Controller
{
	/**
	* Service controller index method
	* It will call getPage method of this controller
	**/
	public function index() 
	{
		$this->load->model('pages');
		$data['page'] = $this->model_pages->pageData('services');
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

		$data['header'] = $this->controller_common->getHeader($data['page'], $data['pagetheme']['services']['header']);
		$data['footer'] = $this->controller_common->getFooter(NULL, 'footer');
		$data['facilities'] = $this->controller_common->serviceFacility($data['page']);
		
		$data['services'] = $this->model_pages->allServices();
		$data['active'] = 'service';

		$data['recentblog'] = $this->model_pages->recentBlog();
		$data['slider_doctor'] = $this->model_pages->getSliderDoctors();
		$data['active'] = 'service';
		
		$this->response->setOutput($this->load->view('service/'.$data['pagetheme']['services']['theme'], $data));
	}

	public function singleService() 
	{
		$name = $this->url->get('name');
		if (empty($name)) {
			$this->url->redirect('services');
		}
		/**
		* Get service page data from DB
		**/
		$this->load->model('pages');
		$data['service'] = $this->model_pages->getSingleService($name);

		if (empty($data['service'])) { $this->url->redirect('services'); }

		$this->load->controller('common');
		$data = array_merge($data, $this->controller_common->index());
		
		$data['page']['meta_tag'] = $data['service']['name'] . ' | ' .$data['siteinfo']['name'];
		$data['page']['meta_description'] = $data['service']['name'];
		$data['page']['page_title'] = $data['service']['name'];

		$data['page']['breadcrumbs'] = array();
		$data['page']['breadcrumbs'][] = array(
			'label' => $data['lang']['text_home'],
			'link' => URL.DIR_ROUTE.'home',
		);
		$data['page']['breadcrumbs'][] = array(
			'label' => $data['lang']['text_services'],
			'link' => URL.DIR_ROUTE.'services',
		);
		$data['page']['breadcrumbs'][] = array(
			'label' => $data['page']['page_title'],
			'link' => '#',
		);

		$data['header'] = $this->controller_common->getHeader($data['page'], $data['pagetheme']['services']['header']);
		$data['footer'] = $this->controller_common->getFooter(NULL, 'footer');

		if (isset($this->session->data['error'])) {
			$data['error'] = $this->session->data['error'];
			unset($this->session->data['error']);
		}
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		}

		$data['services'] = $this->model_pages->allServices();
		$data['reviews'] = $this->model_pages->allServiceReviews($data['service']['id']);

		
		$data['active'] = 'service';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$this->response->setOutput($this->load->view('service/service', $data));
	}

	public function reviewAction()
	{
		$data = $this->url->post;
		$this->load->controller('common');
		$lang = $this->controller_common->getLanguage();
		if (isset($_POST['submit']) && !$this->validateField()) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => $lang['text_please_enter_valid_data_in_input_box']);
			$this->url->abs_redirect($_SERVER['HTTP_REFERER']);
		}

		$token = $this->url->post('_token');
		$token_check = hash('sha512', TOKEN . TOKEN_SALT);
		if (hash_equals($token_check, $token) === false ) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => $lang['text_security_token_is_missing']);
			$this->url->abs_redirect($_SERVER['HTTP_REFERER']);
			exit();
		}

		//$this->formModel = new Forms();
		$this->load->model('forms');
		$result = $this->model_forms->createReview($this->url->post, $_SERVER['REMOTE_ADDR']);
		$this->session->data['message'] = array('alert' => 'success', 'value' => $lang['text_review_created_successfully']);
		$this->url->abs_redirect($_SERVER['HTTP_REFERER']);
	}

	protected function validateField()
	{
		if (filter_var($this->url->post('review_for_id'), FILTER_VALIDATE_INT) === false) {
			/**
			* If Blog id is not valid or integer 
			* Return false
			**/
			return false;
		} elseif ((strlen(trim($this->url->post('name'))) < 2) || (strlen(trim($this->url->post('name'))) > 52)) {
			/**
			* If Name is not valid ( min 3 character or max 52 ) 
			* Return false
			**/
			return false;
		} elseif ((strlen($this->url->post('email')) > 96) || !filter_var($this->url->post('email'), FILTER_VALIDATE_EMAIL)) {
			/** 
			* If email is not valid
			* Return false
			**/
			return false;
		} elseif ((strlen($this->url->post('content')) < 5)) {
			/** 
			* If Comment content is not valid
			* Return false
			**/
			return false;
		} else {
			/** 
			* Everthing looks good
			* Return True
			**/
			return true;
		}
	}
}