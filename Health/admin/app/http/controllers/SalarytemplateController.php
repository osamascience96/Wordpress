<?php

/**
 * SalarytemplateController
 */
class SalarytemplateController extends Controller
{
	public function index()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$this->load->model('salarytemplate');
		$data['result'] = $this->model_salarytemplate->getSalarytemplates();

		/* Set page title */
		$data['page_title'] = 'Salary Template';
		$data['page_add'] = $this->user_agent->hasPermission('salarytemplate/add') ? true : false;
		$data['page_edit'] = $this->user_agent->hasPermission('salarytemplate/edit') ? true : false;
		$data['page_delete'] = $this->user_agent->hasPermission('salarytemplate/delete') ? true : false;
		$data['action_delete'] = URL_ADMIN.DIR_ROUTE.'salarytemplate/delete';


		/*Render User list view*/
		$this->response->setOutput($this->load->view('salarytemplate/salarytemplate_list', $data));
	}

	public function indexAdd()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Get all User data from DB using User model 
		**/
		$data['result'] = NULL;
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		/* Set page title */
		$data['page_title'] = 'Add Salary Template';
		$data['action'] = URL_ADMIN.DIR_ROUTE.'salarytemplate/add';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);

		/*Render User list view*/
		$this->response->setOutput($this->load->view('salarytemplate/salarytemplate_form', $data));
	}

	public function indexEdit()
	{
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('invoice');
		}

		$this->load->model('salarytemplate');
		$data['result'] = $this->model_salarytemplate->getSalarytemplate($id);
		if (!$data['result']) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Invoice does not exist in database!');
			$this->url->redirect('salarytemplate');
		}
		$data['result']['allowance'] = json_decode($data['result']['allowance'], true);
		$data['result']['deduction'] = json_decode($data['result']['deduction'], true);
		// print_r($data['result']);
		// exit();

		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = 'Edit Salary Template';
		$data['action'] = URL_ADMIN.DIR_ROUTE.'salarytemplate/edit';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);

		/*Render User list view*/
		$this->response->setOutput($this->load->view('salarytemplate/salarytemplate_form', $data));
	}

	public function indexAction()
	{
		$data = $this->url->post;
		$this->load->controller('common');
		if ($this->controller_common->validateToken($data['_token'])) {
			$this->url->redirect('salarytemplate');
		}

		if ($validate_field = $this->validateSalarytemplate($data['salary'])) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			if (!empty($data['salary']['id'])) {
				$this->url->redirect('salarytemplate/edit&id='.$data['salary']['id']);
			} else {
				$this->url->redirect('salarytemplate/add');
			}
		}
		$data['salary']['allowance'] = json_encode($data['salary']['allowance']);
		$data['salary']['deduction'] = json_encode($data['salary']['deduction']);
		
		$this->load->model('salarytemplate');
		if (!empty($data['salary']['id'])) {
			$result = $this->model_salarytemplate->updateSalarytemplate($data['salary']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Salary Template updated successfully.');
			$this->url->redirect('salarytemplate/edit&id='.$data['salary']['id']);
		} else {
			$data['salary']['id'] = $this->model_salarytemplate->createSalarytemplate($data['salary']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Salary Template created successfully.');
			$this->url->redirect('salarytemplate/edit&id='.$data['salary']['id']);
		}
	}

	public function indexDelete()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id')) ) {
			$this->url->redirect('salarytemplate');
		}
		/**
		* Call delete method
		**/
		$this->load->model('salarytemplate');
		$result = $this->model_salarytemplate->deleteSalarytemplate($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Salary template deleted successfully.');
		$this->url->redirect('salarytemplate');
	}

	public function validateSalarytemplate($data)
	{
		$error = [];
		$error_flag = false;

		if ($this->controller_common->validateText($data['grade'])) {
			$error_flag = true;
			$error['author'] = 'Grade!';
		}
		if ($this->controller_common->validateNumeric($data['basic_salary'])) {
			$error_flag = true;
			$error['author'] = 'Basic Salary!';
		}
		if ($this->controller_common->validateNumeric($data['gross_salary'])) {
			$error_flag = true;
			$error['author'] = 'Gross Salary!';
		}
		if ($this->controller_common->validateNumeric($data['net_salary'])) {
			$error_flag = true;
			$error['author'] = 'Net Salary!';
		}
		
		if ($error_flag) {
			return $error;
		} else {
			return false;
		}

	}
}