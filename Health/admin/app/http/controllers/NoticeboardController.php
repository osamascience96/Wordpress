<?php

/**
 * NoticeboardController
 */
class NoticeboardController extends Controller
{
	public function index()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Get all blogs data from DB using blog model 
		**/
		$this->load->model('noticeboard');
		$data['result'] = $this->model_noticeboard->getNotices();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['page_title'] = 'Noticeboard';
		$data['page_view'] = $this->user_agent->hasPermission('noticeboard/view') ? true:false;
		$data['page_add'] = $this->user_agent->hasPermission('noticeboard/add') ? true:false;
		$data['page_edit'] = $this->user_agent->hasPermission('noticeboard/edit') ? true:false;
		$data['page_delete'] = $this->user_agent->hasPermission('noticeboard/delete') ? true:false;

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action_delete'] = URL_ADMIN.DIR_ROUTE.'noticeboard/delete';

		/*Render Blog view*/
		$this->response->setOutput($this->load->view('noticeboard/noticeboard_list', $data));
	}

	public function indexView()
	{
		/**
		* Check if id exist in url if not exist then redirect to Notice list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('noticeboard');
		}
		/**
		* Call getNotice method from Notice model to get data from DB for single Notice
		* If Notice does not exist then redirect it to Notice list view
		**/
		$this->load->model('noticeboard');
		$data['result'] = $this->model_noticeboard->getNotice($id);
		if (empty($data['result'])) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Notice does not exist in database!');
			$this->url->redirect('noticeboard');
		}
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['page_title'] = 'Notice View';
		$data['page_edit'] = $this->user_agent->hasPermission('noticeboard/edit') ? true:false;
		/*Render Notice edit view*/
		$this->response->setOutput($this->load->view('noticeboard/noticeboard_view', $data));
	}

	public function indexAdd()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/* Set page title */
		$data['page_title'] = 'New Notice';
		/* Set empty data to array */
		$data['result'] =  NULL;
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'noticeboard/add';
		/*Render Department add view*/
		$this->response->setOutput($this->load->view('noticeboard/noticeboard_form', $data));
	}

	public function indexEdit()
	{
		/**
		* Check if id exist in url if not exist then redirect to Notice list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('noticeboard');
		}
		/**
		* Call getNotice method from Notice model to get data from DB for single Notice
		* If Notice does not exist then redirect it to Notice list view
		**/
		$this->load->model('noticeboard');
		$data['result'] = $this->model_noticeboard->getNotice($id);
		if (empty($data['result'])) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Notice does not exist in database!');
			$this->url->redirect('noticeboard');
		}
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['page_title'] = 'Edit Notice';

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'noticeboard/edit';
		/*Render Notice edit view*/
		$this->response->setOutput($this->load->view('noticeboard/noticeboard_form', $data));
	}

	public function indexAction()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('noticeboard');
		}
		$data = $this->url->post;
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		
		$this->load->controller('common');
		$this->load->model('commons');
		$data['info'] = $this->model_commons->getSiteInfo();
		
		if ($validate_field = $this->validateField($data)) {
			$this->session->data['message'] = array('alert' => 'danger', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			
			if (!empty($data['notice']['id'])) {
				$this->url->redirect('noticeboard/edit&id='.$data['notice']['id']);
			} else {
				$this->url->redirect('noticeboard/add');
			}
		}

		$data['notice']['start_date'] = DateTime::createFromFormat($data['info']['date_format'], $data['notice']['start_date'])->format('Y-m-d');
		$data['notice']['end_date'] = DateTime::createFromFormat($data['info']['date_format'], $data['notice']['end_date'])->format('Y-m-d');

		$data['notice']['datetime'] = date('Y-m-d H:i:s');
		$this->load->model('noticeboard');
		$data['notice']['user_id'] = $this->session->data['user_id'];
		if (!empty($data['notice']['id'])) {
			$this->model_noticeboard->updateNotice($data['notice']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Notice updated successfully.');
			$this->url->redirect('noticeboard/edit&id='.$data['notice']['id']);
		}
		else {
			$result = $this->model_noticeboard->createNotice($data['notice']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Notice created successfully.');
			$this->url->redirect('noticeboard/edit&id='.$result);
		}
	}

	public function indexDelete()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id'))) {
			$this->url->redirect('noticeboard');
		}
		$this->load->model('noticeboard');
		$this->model_noticeboard->deleteNotice($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Notice deleted successfully.');
		$this->url->redirect('noticeboard');
	}

	protected function validateField($data)
	{
		$error = [];
		$error_flag = false;
		if ($name = $this->controller_common->validateText($data['notice']['title'])) {
			$error_flag = true;
			$error['name'] = 'Name';
		}

		if ($description = $this->controller_common->validateText($data['notice']['description'])) {
			$error_flag = true;
			$error['description'] = 'Description';
		}

		if ($date = $this->controller_common->validateDate($data['notice']['start_date'], $data['info']['date_format'])) {
			print_r($date);
			$error_flag = true;
			$error['start_date'] = 'Start Date';
		}

		if ($this->controller_common->validateDate($data['notice']['end_date'], $data['info']['date_format'])) {
			$error_flag = true;
			$error['end_date'] = 'End Date';
		}

		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}