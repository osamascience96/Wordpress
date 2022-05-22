<?php

/**
* Service Controller
*/
class ServiceController extends Controller
{
	/**
	* Service index edit method
	* This method will be called on Service edit view
	**/
	public function index()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Get all Services 
		**/
		$this->load->model('service');
		$data['result'] = $this->model_service->allServices();;
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = 'Services';
		$data['page_add'] = $this->user_agent->hasPermission('service/add') ? true : false;
		$data['page_edit'] = $this->user_agent->hasPermission('service/edit') ? true : false;
		$data['page_delete'] = $this->user_agent->hasPermission('service/delete') ? true : false;

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action_delete'] = URL_ADMIN.DIR_ROUTE.'service/delete';
		
		/*call Service list view*/
		$this->response->setOutput($this->load->view('themeoption/service_list', $data));
	}
	/**
	* Service index add method
	* This method will be called on Blog add
	**/
	public function indexAdd()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/* Set page title */
		$data['page_title'] = 'Add Service';
		/* Set empty data to array */
		$data['result'] =  NULL;
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'service/add';
		/*Render Service add view*/
		$this->response->setOutput($this->load->view('themeoption/service_form', $data));
	}
	/**
	* Service index edit method
	* This method will be called on Service edit view
	**/
	public function indexEdit()
	{
		/**
		* Check if id exist in url if not exist then redirect to Service list view 
		**/		
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('services');
		}
		/**
		* Call getService method from Service model to get data from DB for single Service
		* If Service does not exist then redirect it to Service list view
		**/
		$this->load->model('service');
		$service = $this->model_service->getService($id);
		if (!$service) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Service does not exist in database!');
			$this->url->redirect('services');
		}
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/* Set Edit Service page title */
		$data['page_title'] = 'Edit Service';
		/* Set Service data to array */
		$data['result'] = $service;
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'service/edit';
		/*Render Service edit view*/
		$this->response->setOutput($this->load->view('themeoption/service_form', $data));
	}
	/**
	* Info index action method
	* This method will be called on Info submit/save view
	**/
	public function indexAction()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('services');
		}
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		$data = $this->url->post;
		
		$this->load->controller('common');
		if ($validate_field = $this->validateField($data['service'])) {
			$this->session->data['message'] = array('alert' => 'danger', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			if (!empty($data['service']['id'])) {
				$this->url->redirect('service/edit&id='.$data['service']['id']);
			} else {
				$this->url->redirect('service/add');
			}
		}
		
		if ($this->controller_common->validateToken($data['_token'])) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			if (!empty($data['service']['id'])) {
				$this->url->redirect('service/edit&id='.$data['service']['id']);
			} else {
				$this->url->redirect('service/add');
			}
		}
		$data['service']['priority'] = !empty($data['service']['priority']) ? $data['service']['priority'] : 99999;
		$data['service']['datetime'] =  date('Y-m-d H:i:s');

		$this->load->model('service');
		if (!empty($data['service']['id'])) {
			$this->model_service->updateService($data['service']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Service updated successfully.');
		} else {
			$data['service']['id'] = $this->model_service->createService($data['service']);
			$data['service']['url'] = $this->controller_common->url_slug($data['service']['name']);
			$count = $this->model_service->checkUrlinDb($data['service']);
			if ($count) {
				$data['service']['url'] = $data['service']['url'].'-'.$data['service']['id'];
				$this->model_service->updateServiceUrl($data['service']);
			} else {
				$this->model_service->updateServiceUrl($data['service']);
			}
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Service created successfully.');
		}
		$this->url->redirect('service/edit&id='.$data['service']['id']);
	}
	/**
	* Facility index delete method
	* This method will be called on blog delete action
	**/
	public function indexDelete()
	{
		$this->load->controller('common');
		if ($this->controller_common->validateToken($this->url->post('_token'))) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			$this->url->redirect('services');
		}
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id')) ) {
			$this->url->redirect('services');
		}

		$this->load->model('service');
		$result = $this->model_service->deleteService($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Service deleted successfully.');
		$this->url->redirect('services');
	}

	protected function validateField($data)
	{
		$error = [];
		$error_flag = false;
		if ($name = $this->controller_common->validateText($data['name'])) {
			$error_flag = true;
			$error['name'] = 'Name';
		}

		if ($description = $this->controller_common->validateText($data['short_post'])) {
			$error_flag = true;
			$error['short_post'] = 'Short Description';
		}

		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}