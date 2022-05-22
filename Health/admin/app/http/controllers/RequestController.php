<?php

/**
* Request Controller
*/
class RequestController extends Controller
{
	/**
	* Request index method
	* This method will be called on Request list view
	**/
	public function index()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Get all request and store in array
		* That array will be passed on to view
		**/
		$this->load->model('request');
		$data['result'] = $this->model_request->allRequests();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = 'Request';
		$data['page_add'] = $this->user_agent->hasPermission('request/add') ? true : false;
		$data['page_edit'] = $this->user_agent->hasPermission('request/edit') ? true : false;
		$data['page_view'] = $this->user_agent->hasPermission('request/view') ? true : false;
		$data['page_delete'] = $this->user_agent->hasPermission('request/delete') ? true : false;

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action_delete'] = URL_ADMIN.DIR_ROUTE.'request/delete';
		/*Render Request list view*/
		$this->response->setOutput($this->load->view('request/request_list', $data));
	}
	public function indexView()
	{
		/**
		* Check if id exist in url if not exist then redirect to reuqest list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('request');
		}
		/**
		* Call getRequest method from Request model to get data from DB for single Request
		* If reuqest does not exist then redirect it to reuqest list view
		**/
		$this->load->model('request');
		$data['result'] = $this->model_request->getRequest($id);
		if (empty($data['result'])) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Request does not exist in database!');
			$this->url->redirect('request');
		}
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set reuest data to array to pass to view */
		$data['page_title'] = 'Request View';
		$data['page_edit'] = $this->user_agent->hasPermission('request/edit') ? true : false;
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'request/edit';
		/*Render Request edit view*/
		$this->response->setOutput($this->load->view('request/request_view', $data));
	}
	/**
	* Request index add method
	* This method will be called on Request add
	**/
	public function indexAdd()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/* Set page title */
		$data['page_title'] = 'Add Request';
		/* Set empty data to array */
		$data['result'] =  NULL;
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'request/add';
		/*Render Blog add view*/
		$this->response->setOutput($this->load->view('request/request_form', $data));
	}
	/**
	* Request index edit method
	* This method will be called on Request edit view
	**/
	public function indexEdit()
	{
		/**
		* Check if id exist in url if not exist then redirect to reuqest list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('request');
		}
		/**
		* Call getRequest method from Request model to get data from DB for single Request
		* If reuqest does not exist then redirect it to reuqest list view
		**/
		$this->load->model('request');
		$request = $this->model_request->getRequest($id);
		if (!$request) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Request does not exist in database!');
			$this->url->redirect('request');
		}
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/* Set reuest data to array to pass to view */
		$data['page_title'] = 'Edit Request';
		$data['result'] = $request;
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'request/edit';
		/*Render Request edit view*/
		$this->response->setOutput($this->load->view('request/request_form', $data));
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
		if (!isset($_POST['submit'])) { $this->url->redirect('request'); }
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		$data = $this->url->post;
		
		$this->load->controller('common');
		if ($validate_field = $this->validateField($data['request'])) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			if (!empty($data['request']['id'])) {
				$this->url->redirect('request/edit&id='.$data['request']['id']);
			} else {
				$this->url->redirect('request/add');
			}
		}
		
		$this->load->model('request');
		$data['request']['user_id'] = $this->session->data['user_id'];
		if (!empty($data['request']['id'])) {
			$this->model_request->updateRequest($data['request']);
			$this->url->redirect('request/view&id='.$data['request']['id']);
		} else {
			//$result = $this->requestModel->createRequest($data);
			$this->url->redirect('request');
		}
	}
	/**
	* Request index delete method
	* This method will be called on Request delete action
	**/
	public function indexDelete()
	{
		$this->load->controller('common');
		if ($this->controller_common->validateToken($this->url->post('_token'))) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			$this->url->redirect('request');
		}

		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id')) ) {
			$this->url->redirect('request');
		}
		$this->load->model('request');
		$result = $this->model_request->deleteRequest($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Request deleted successfully.');
		$this->url->redirect('request');
	}


	public function indexMail()
	{
		if (!isset($_POST['submit'])) {
			$this->url->redirect('request');
		}
		$data = $this->url->post;
		$this->load->controller('common');
		$this->load->model('request');
		$result = $this->model_request->getRequest($data['mail']['id']);
		if (empty($result)) {
			$this->url->redirect('appointments');
		}

		$data['mail']['email'] = $result['email'];
		$data['mail']['name'] = $result['name'];
		$data['mail']['redirect'] = 'appointment/view&id='.$result['id'];

		$this->load->controller('mail');
		$mail_result = $this->controller_mail->sendMail($data['mail']);
		if ($mail_result == 1) {

			$data['mail']['type'] = 'request';
			$data['mail']['type_id'] = $data['mail']['id'];
			$data['mail']['user_id'] = $this->session->data['user_id'];
			$this->controller_mail->createMailLog($data['mail']);

			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Success: Message sent successfully.');
			$this->url->redirect('request/view&id='.$result['id']);
		} else {
			$this->session->data['message'] = array('alert' => 'error', 'value' => $mail_result);
			$this->url->redirect('request/view&id='.$result['id']);
		}
	}

	protected function validateField($data)
	{
		$error = [];
		$error_flag = false;
		if ($name = $this->controller_common->validateText($data['name'])) {
			$error_flag = true;
			$error['name'] = 'Name';
		}

		if ($email = $this->controller_common->validateEmail($data['mail'])) {
			$error_flag = true;
			$error['email'] = 'Email Address';
		}

		if ($mobile = $this->controller_common->validatePhoneNumber($data['mobile'])) {
			$error_flag = true;
			$error['mobile'] = 'Mobile Number';
		}

		if ($subject = $this->controller_common->validateText($data['subject'])) {
			$error_flag = true;
			$error['subject'] = 'Subject';
		}
		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}