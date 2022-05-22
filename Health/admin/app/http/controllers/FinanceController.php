<?php

/**
* FinanceController
*/
class FinanceController extends Controller
{
	public function currency()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		
		$this->load->model('finance');
		$data['result'] = $this->model_finance->getCurrency();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['page_title'] = 'Currencies';
		$data['page_add'] = $this->user_agent->hasPermission('currency/add') ? true : false;
		$data['page_edit'] = $this->user_agent->hasPermission('currency/edit') ? true : false;
		$data['page_delete'] = $this->user_agent->hasPermission('currency/delete') ? true : false;

		$data['action'] = URL_ADMIN.DIR_ROUTE.'currency/add';
		$data['action_delete'] = URL_ADMIN.DIR_ROUTE.'currency/delete';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		

		/*call appointment list view*/
		$this->response->setOutput($this->load->view('finance/currency', $data));
	}

	public function currencyAction()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('currency');
			exit();
		}
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		$this->load->controller('common');
		if ($validate_field = $this->validateField()) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			$this->url->redirect('currency');
		}
		if ($this->controller_common->validateToken($this->url->post('_token'))) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			$this->url->redirect('currency');
		}

		$data = $this->url->post;
		$data['datetime'] =  date('Y-m-d H:i:s');
		$this->load->model('finance');
		if (!empty($this->url->post('id'))) {
			$result = $this->model_finance->updateCurrency($data);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Currency updated successfully.');
			$this->url->redirect('currency');
		} else {
			$result = $this->model_finance->createCurrency($data);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Currency created successfully.');
			$this->url->redirect('currency');
		}
	}

	public function currencyDelete()
	{
		$this->load->controller('common');
		if ($this->controller_common->validateToken($this->url->post('_token'))) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			$this->url->redirect('currency');
		}

		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id')) ) {
			$this->url->redirect('currency');
		}
		$this->load->model('finance');
		$result = $this->model_finance->deleteCurrency($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Currency deleted successfully.');
		$this->url->redirect('currency');
	}

	public function paymentGateway()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		
		$this->load->model('finance');
		$data['result'] = $this->model_finance->getPaymenyGateways();
		$data['result']['data'] = json_decode($data['result']['data'], true); 
		
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['page_title'] = 'Payment Gatways';

		$data['action'] = URL_ADMIN.DIR_ROUTE.'paymentgateway';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);

		/*call appointment list view*/
		$this->response->setOutput($this->load->view('finance/payment_gateway', $data));
	}

	public function paymentGatewayAction()
	{
		
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('paymentgateway');
			exit();
		}

		$this->load->controller('common');
		$data = $this->url->post;
		
		if ($validate_field = $this->validatePaymentGatewayField($data)) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			$this->url->redirect('paymentgateway');
		}
		if ($this->controller_common->validateToken($this->url->post('_token'))) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			$this->url->redirect('paymentgateway');
		}
		$data['gateways']['paypal'] = $data['paypal'];
		$data['gateways'] = json_encode($data['gateways']);

		$data['datetime'] =  date('Y-m-d H:i:s');
		$this->load->model('finance');
		
		$result = $this->model_finance->updatePaymentGateway($data);
		
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Payment Gateway updated successfully.');
		$this->url->redirect('paymentgateway');
	}

	public function validatePaymentGatewayField($data)
	{
		$error = [];
		$error_flag = false;
		if (!empty($data['username']) && $this->controller_common->validateText($data['username'])) {
			$error_flag = true;
			$error['username'] = 'Username!';
		}
		if (!empty($data['password']) && $this->controller_common->validateText($data['password'])) {
			$error_flag = true;
			$error['password'] = 'password!';
		}
		if (!empty($data['signature']) && $this->controller_common->validateText($data['signature'])) {
			$error_flag = true;
			$error['signature'] = 'signature!';
		}
		if (!empty($data['email']) && $this->controller_common->validateEmail($data['email'])) {
			$error_flag = true;
			$error['email'] = 'email!';
		}

		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}


	public function paymentMethod()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Get all Tax data from DB using Tax model 
		**/
		$this->load->model('finance');
		$data['result'] = $this->model_finance->getPaymentMethod();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = 'Payment Method';
		$data['page_add'] = $this->user_agent->hasPermission('paymentmethod/add') ? true : false;
		$data['page_edit'] = $this->user_agent->hasPermission('paymentmethod/edit') ? true : false;
		$data['page_delete'] = $this->user_agent->hasPermission('paymentmethod/delete') ? true : false;

		$data['action'] = URL_ADMIN.DIR_ROUTE.'paymentmethod/add';
		$data['action_delete'] = URL_ADMIN.DIR_ROUTE.'paymentmethod/delete';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		/*Render User list view*/
		$this->response->setOutput($this->load->view('finance/payment_method', $data));
	}

	public function paymentMethodAction()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('paymentmethod');
			exit();
		}
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		$this->load->controller('common');
		if ($validate_field = $this->validateField()) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			$this->url->redirect('paymentmethod');
		}
		if ($this->controller_common->validateToken($this->url->post('_token'))) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			$this->url->redirect('paymentmethod');
		}
		$data = $this->url->post;
		$data['datetime'] =  date('Y-m-d H:i:s');
		$this->load->model('finance');
		if (!empty($this->url->post('id'))) {
			$result = $this->model_finance->updatePaymentMethod($data);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Payment Method updated successfully.');
			$this->url->redirect('paymentmethod');
		}
		else {
			$result = $this->model_finance->createPaymentMethod($data);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Payment Method created successfully.');
			$this->url->redirect('paymentmethod');
		}
	}

	public function paymentMethodDelete()
	{
		$this->load->controller('common');
		if ($this->controller_common->validateToken($this->url->post('_token'))) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			$this->url->redirect('paymentmethod');
		}

		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id')) ) {
			$this->url->redirect('paymentmethod');
		}
		$this->load->model('finance');
		$result = $this->model_finance->deletePaymentMethod($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Payment Method deleted successfully.');
		$this->url->redirect('paymentmethod');
	}

	public function validateField()
	{
		$error = [];
		$error_flag = false;
		if ($this->controller_common->validateText($this->url->post('name'))) {
			$error_flag = true;
			$error['title'] = 'Name!';
		}

		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}

	/**
	* Contact index method
	* This method will be called on Contact list view
	**/
	public function tax()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Get all Tax data from DB using Tax model 
		**/
		$this->load->model('finance');
		$data['result'] = $this->model_finance->getTaxes();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = 'Tax Rates';
		$data['page_add'] = $this->user_agent->hasPermission('tax/add') ? true : false;
		$data['page_edit'] = $this->user_agent->hasPermission('tax/edit') ? true : false;
		$data['page_delete'] = $this->user_agent->hasPermission('tax/delete') ? true : false;
		
		$data['action'] = URL_ADMIN.DIR_ROUTE.'tax/add';
		$data['action_delete'] = URL_ADMIN.DIR_ROUTE.'tax/delete';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		
		/*Render User list view*/
		$this->response->setOutput($this->load->view('finance/tax', $data));
	}

	public function taxAction()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('tax');
			exit();
		}
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		$this->load->controller('common');
		if ($validate_field = $this->validateTaxField()) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			$this->url->redirect('tax');
		}

		if ($this->controller_common->validateToken($this->url->post('_token'))) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			$this->url->redirect('tax');
		}

		$data = $this->url->post;
		$data['datetime'] =  date('Y-m-d H:i:s');
		$this->load->model('finance');
		if (!empty($this->url->post('id'))) {
			$result = $this->model_finance->updateTax($data);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Tax Rate updated successfully.');
			$this->url->redirect('tax');
		}
		else {
			$result = $this->model_finance->createTax($data);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Tax Rate created successfully.');
			$this->url->redirect('tax');
		}
	}

	public function taxDelete()
	{
		$this->load->controller('common');
		if ($this->controller_common->validateToken($this->url->post('_token'))) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			$this->url->redirect('tax');
		}

		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id')) ) {
			$this->url->redirect('tax');
		}
		$this->load->model('finance');
		$result = $this->model_finance->deleteTax($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Tax Rate deleted successfully.');
		$this->url->redirect('tax');
	}

	public function validateTaxField()
	{
		$error = [];
		$error_flag = false;
		if ($this->controller_common->validateText($this->url->post('name'))) {
			$error_flag = true;
			$error['title'] = 'Tax Name!';
		}

		if ($this->controller_common->validateNumeric($this->url->post('rate'))) {
			$error_flag = true;
			$error['author'] = 'Tax Rate!';
		}
		
		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}