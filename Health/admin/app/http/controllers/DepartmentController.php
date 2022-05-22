<?php

/**
* Department Controller
*/
class DepartmentController extends Controller
{
	/**
	* Department index method
	* This method will be called on department list view
	**/
	public function index()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Get all department value from Db using deparmtent model method 
		**/
		$this->load->model('department');
		$data['result'] = $this->model_department->allDepartments();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['page_title'] = 'Departments';
		$data['page_add'] = $this->user_agent->hasPermission('department/add') ? true: false;
		$data['page_edit'] = $this->user_agent->hasPermission('department/edit') ? true : false;
		$data['page_delete'] = $this->user_agent->hasPermission('department/delete') ? true : false;

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action_delete'] = URL_ADMIN.DIR_ROUTE.'department/delete';

		/*Render department list view*/
		$this->response->setOutput($this->load->view('themeoption/department_list', $data));
	}
	/**
	* Department index add method
	* This method will be called on Department add
	**/
	public function indexAdd()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/* Set page title */
		$data['page_title'] = 'Add Department';
		/* Set empty data to array */
		$data['result'] =  NULL;
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'department/add';
		/*Render Department add view*/
		$this->response->setOutput($this->load->view('themeoption/department_form', $data));
	}
	/**
	* Department index edit method
	* This method will be called on department edit view
	**/
	public function indexEdit()
	{
		/**
		* Check if id exist in url if not exist then redirect to department list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('departments');
		}
		/**
		* Call getDepartment method from Department model to get data from DB for single Department
		* If Department does not exist then redirect it to Department list view
		**/
		$this->load->model('department');
		$department = $this->model_department->getDepartment($id);
		if (!$department) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Department does not exist in database!');
			$this->url->redirect('departments');
		}
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/* Set Edit Department page title */
		$data['page_title'] = 'Edit Department';
		/* Set Department data to array tpo pass to view */
		$data['result'] = $department;
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'department/edit';
		/*Render Department edit view*/
		$this->response->setOutput($this->load->view('themeoption/department_form', $data));
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
			$this->url->redirect('departments');
		}
		$data = $this->url->post;
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		$this->load->controller('common');
		if ($this->controller_common->validateToken($data['_token'])) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			$this->url->redirect('departments');
		}
		if ($validate_field = $this->validateField($data['department'])) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			if (!empty($data['department']['id'])) {
				$this->url->redirect('department/edit&id='.$data['department']['id']);
			} else {
				$this->url->redirect('department/add');
			}
		}

		$data['department']['datetime'] = date('Y-m-d H:i:s');
		$this->load->model('department');
		if (!empty($data['department']['id'])) {
			$this->model_department->updateDepartment($data['department']);	
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Department updated successfully.');
			$this->url->redirect('department/edit&id='.$data['department']['id']);
		}
		else {
			$result = $this->model_department->createDepartment($data['department']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Department created successfully.');
			$this->url->redirect('department/edit&id='.$result);
		}
	}
	/**
	* BLog index delete method
	* This method will be called on Department delete action
	**/
	public function indexDelete()
	{
		$this->load->controller('common');
		if ($this->controller_common->validateToken($this->url->post('_token'))) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			$this->url->redirect('departments');
		}
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id'))) {
			$this->url->redirect('departments');
		}
		$this->load->model('department');
		$this->model_department->deleteDepartment($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Department deleted successfully.');
		$this->url->redirect('departments');
	}

	protected function validateField($data)
	{
		$error = [];
		$error_flag = false;
		if ($name = $this->controller_common->validateText($data['name'])) {
			$error_flag = true;
			$error['name'] = 'Name!';
		}

		if ($description = $this->controller_common->validateText($data['description'])) {
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