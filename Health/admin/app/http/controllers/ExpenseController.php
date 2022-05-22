<?php

/**
* ExpenseController
*/
class ExpenseController extends Controller
{
	/**
	* Expense index method
	* This method will be called on Expense list view
	**/
	public function index()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		
		$this->load->controller('common');
		$data['period']['start'] = $this->url->get('start');
		$data['period']['end'] = $this->url->get('end');

		if (!empty($data['period']['start']) && !empty($data['period']['end']) && !$this->controller_common->validateDate($data['period']['start']) && !$this->controller_common->validateDate($data['period']['end'])) {
			$data['period']['start'] = date_format(date_create($data['period']['start'].'00:00:00'), "Y-m-d H:i:s");
			$data['period']['end'] = date_format(date_create($data['period']['end'].'23:59:59'), "Y-m-d H:i:s");
		} else {
			$data['period']['start'] = date('Y-m-d '.'00:00:00');
			$data['period']['end'] = date('Y-m-d '.'23:59:59');
		}

		/**
		* Get all Expenses data from DB using User model 
		**/
		$this->load->model('expense');
		$data['result'] = $this->model_expense->getExpenses($data['period']);

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		
		/* Set page title */
		$data['page_title'] = 'Expenses';
		$data['page_add'] = $this->user_agent->hasPermission('expense/add') ? true : false;
		$data['page_edit'] = $this->user_agent->hasPermission('expense/edit') ? true : false;
		$data['page_delete'] = $this->user_agent->hasPermission('expense/delete') ? true : false;

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action_delete'] = URL_ADMIN.DIR_ROUTE.'expense/delete';

		/*Render User list view*/
		$this->response->setOutput($this->load->view('expense/expense_list', $data));
	}
	/**
	* Expense index ADD method
	* This method will be called on Expense ADD view
	**/
	public function indexAdd()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Get all User data from DB using User model 
		**/
		$data['result'] = NULL;
		
		$this->load->model('expense');
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['expensetype'] = $this->model_expense->expensesType();
		$data['method'] = $this->model_expense->paymentMethod();

		/* Set page title */
		$data['page_title'] = 'Add Expense';
		$data['action'] = URL_ADMIN.DIR_ROUTE.'expense/add';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);

		/*Render User list view*/
		$this->response->setOutput($this->load->view('expense/expense_form', $data));
	}
	/**
	* Expense index Edit method
	* This method will be called on Expense Edit view
	**/
	public function indexEdit()
	{
		/**
		* Check if id exist in url if not exist then redirect to Expenses list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) { $this->url->redirect('expenses'); }
		
		$this->load->model('expense');
		$data['result'] = $this->model_expense->getExpense($id);

		if (empty($data['result'])) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Expense does not exist in database!');
			$this->url->redirect('expenses');
		}

		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['expensetype'] = $this->model_expense->expensesType();
		$data['method'] = $this->model_expense->paymentMethod();
		$data['receipt'] = $this->model_expense->getReceipt($id);
		
		/* Set page title */
		$data['page_title'] = 'Edit Expense';
		$data['action'] = URL_ADMIN.DIR_ROUTE.'expense/edit';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);

		/*Render User list view*/
		$this->response->setOutput($this->load->view('expense/expense_form', $data));
	}
	/**
	* Expense index Action method
	* This method will be called on Expense Save or Update view
	**/
	public function indexAction()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('expenses');
		}
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		$data = $this->url->post;
		$this->load->controller('common');
		$this->load->model('commons');
		$data['info'] = $this->model_commons->getSiteInfo();

		if ($validate_field = $this->validateField($data)) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			if (!empty($data['invoice']['id'])) {
				$this->url->redirect('expense/edit&id='.$data['id']);
			} else {
				$this->url->redirect('expense/add');
			}
		}

		$data['expense']['date'] = DateTime::createFromFormat($data['info']['date_format'], $data['expense']['date'])->format('Y-m-d');
		$data['expense']['datetime'] = date('Y-m-d H:i:s');

		$this->load->model('expense');
		if (!empty($data['expense']['id'])) {
			$result = $this->model_expense->updateExpense($data['expense']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Expense created successfully.');
		}
		else {
			$data['expense']['user_id'] = $this->session->data['user_id'];
			$data['expense']['id'] = $this->model_expense->createExpense($data['expense']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Expense created successfully.');
		}
		$this->url->redirect('expense/edit&id='.$data['expense']['id']);
	}
	/**
	* Expense index Delete method
	* This method will be called on Expense Delete view
	**/
	public function indexDelete()
	{
		$this->load->controller('common');
		if ($this->controller_common->validateToken($this->url->post('_token'))) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			$this->url->redirect('expenses');
		}
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id')) ) {
			$this->url->redirect('expenses');
		}
		
		$this->load->model('expense');
		$this->model_expense->deleteExpense($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Expense deleted successfully.');
		$this->url->redirect('expenses');
	}
	/**
	* Expense Validate method
	* Validate input field
	**/
	public function validateField($data)
	{
		$error = [];
		$error_flag = false;

		if ($this->controller_common->validateText($data['expense']['name'])) {
			$error_flag = true;
			$error['name'] = 'Name!';
		}
		if ($this->controller_common->validateDate($data['expense']['date'], $data['info']['date_format'])) {
			$error_flag = true;
			$error['date'] = 'Date!';
		}
		if ($this->controller_common->validateNumeric($data['expense']['amount'])) {
			$error_flag = true;
			$error['amount'] = 'Amount!';
		}

		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}