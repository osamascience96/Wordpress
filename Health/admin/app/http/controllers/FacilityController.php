<?php

/**
* Facility Controller
*/
class FacilityController extends Controller
{
	/**
	* Facility index method
	* This method will be called on Facility list view
	**/
	public function index()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Get all Facilities from DB using facility model
		**/
		$this->load->model('facility');
		$data['result'] = $this->model_facility->allFacilities();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		/* Set page title */
		$data['page_title'] = 'Facility';
		$data['page_add'] = $this->user_agent->hasPermission('facility/add') ? true : false;
		$data['page_edit'] = $this->user_agent->hasPermission('facility/edit') ? true : false;
		$data['page_delete'] = $this->user_agent->hasPermission('facility/delete') ? true : false;

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action_delete'] = URL_ADMIN.DIR_ROUTE.'facility/delete';
		/*Render facility list view*/
		$this->response->setOutput($this->load->view('themeoption/facility_list', $data));
	}
	/**
	* Facility index add method
	* This method will be called on Facility add
	**/
	public function indexAdd()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/* Set page title */
		$data['page_title'] = 'Add Facility';
		/* Set empty data to array */
		$data['result'] =  NULL;
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'facility/add';
		/*Render Blog add view*/
		$this->response->setOutput($this->load->view('themeoption/facility_form', $data));
	}
	/**
	* Facility index edit method
	* This method will be called on Facility edit view
	**/
	public function indexEdit()
	{
		/**
		* Check if id exist in url if not exist then redirect to Facility list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('facility');
		}
		/**
		* Call getFacility method from Facility model to get data from DB for single Facility
		* If Facility does not exist then redirect it to Facility list view
		**/
		$this->load->model('facility');
		$facility = $this->model_facility->getFacility($id);
		if (!$facility) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Facility does not exist in database!');
			$this->url->redirect('facility');
		}
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/* Set Facility edit apge title */
		$data['page_title'] = 'Edit Facility';
		/* Set Facility data in array to pass */
		$data['result'] = $facility;
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'facility/edit';
		/*Render Facility edit view*/
		$this->response->setOutput($this->load->view('themeoption/facility_form', $data));
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
			$this->url->redirect('facility');
		}
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		$data = $this->url->post;
		$this->load->controller('common');
		if ( $this->controller_common->validateToken($data['_token']) ) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			if (!empty($data['facility']['id'])) {
				$this->url->redirect('facility/edit&id='.$data['facility']['id']);
			} else {
				$this->url->redirect('facility/add');
			}
		}

		if ($validate_field = $this->validateField($data['facility'])) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter/select valid '.implode(", ",$validate_field).'!');
			if (!empty($data['facility']['id'])) {
				$this->url->redirect('facility/edit&id='.$data['facility']['id']);
			} else {
				$this->url->redirect('facility/add');
			}
		}

		$data['facility']['datetime'] = date('Y-m-d H:i:s');
		$this->load->model('facility');
		if (!empty($data['facility']['id'])) {
			$this->model_facility->updateFacility($data['facility']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Facility updated successfully.');
			$this->url->redirect('facility/edit&id='.$data['facility']['id']);
		} else {
			$result = $this->model_facility->createFacility($data['facility']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Facility created successfully.');
			$this->url->redirect('facility/edit&id='.$result);
		}
	}
	
	/**
	* Facility index delete method
	* This method will be called on facility delete action
	**/
	public function indexDelete()
	{
		$this->load->controller('common');
		if ($this->controller_common->validateToken($this->url->post('_token'))) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			$this->url->redirect('facility');
		}
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id')) ) {
			$this->url->redirect('facility');
			exit();
		}
		$this->load->model('facility');
		$result = $this->model_facility->deleteFacility($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Facility deleted successfully.');
		$this->url->redirect('facility');
	}

	protected function validateField($data)
	{
		$error = [];
		$error_flag = false;
		if ($this->controller_common->validateText($data['name'])) {
			$error_flag = true;
			$error['name'] = 'Name!';
		}

		if ($this->controller_common->validateText($data['description'])) {
			$error_flag = true;
			$error['description'] = 'Description!';
		}

		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}