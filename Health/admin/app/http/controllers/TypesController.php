<?php

/**
* TypeController
*/
class TypesController extends Controller
{
	public function expenseType()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		
		/**
		* Get all Tax data from DB using Tax model 
		**/
		$this->load->model('types');
		$data['result'] = $this->model_types->getExpenseTypes();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		/* Set page title */
		$data['page_title'] = 'Expense Types';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'expensetype/add';
		$data['action_delete'] = URL_ADMIN.DIR_ROUTE.'expensetype/delete';
		
		$data['page_add'] = $this->user_agent->hasPermission('expensetype/add') ? true:false;
		$data['page_edit'] = $this->user_agent->hasPermission('expensetype/edit') ? true:false;
		$data['page_delete'] = $this->user_agent->hasPermission('expensetype/delete') ? true:false;
		
		/*Render User list view*/
		$this->response->setOutput($this->load->view('expense/expense_type', $data));
	}

	public function expenseTypeAction()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('expensetype');
		}
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		$data = $this->url->post;
		
		$this->load->controller('common');
		if ($validate_field = $this->validateExpenseTypeField($data)) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			$this->url->redirect('expensetype');
		}
		
		if ($this->controller_common->validateToken($data['_token'])) {
			$this->url->redirect('expensetype');
		}

		$data['datetime'] =  date('Y-m-d H:i:s');
		$this->load->model('types');
		if (!empty($data['id'])) {
			$result = $this->model_types->updateExpenseType($data);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Expense Type updated successfully.');
		}
		else {
			$result = $this->model_types->createExpenseType($data);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Expense Type created successfully.');
		}
		$this->url->redirect('expensetype');
	}

	public function expenseTypeDelete()
	{
		$this->load->controller('common');
		if ($this->controller_common->validateToken($this->url->post('_token'))) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			$this->url->redirect('expensetype');
		}
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id')) ) {
			$this->url->redirect('expensetype');
		}

		$this->load->model('types');
		$result = $this->model_types->deleteExpenseType($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Expense Type deleted successfully.');
		$this->url->redirect('expensetype');
	}

	public function validateExpenseTypeField($data)
	{
		$error = [];
		$error_flag = false;
		if ($this->controller_common->validateText($data['name'])) {
			$error_flag = true;
			$error['title'] = 'Name!';
		}
		
		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}