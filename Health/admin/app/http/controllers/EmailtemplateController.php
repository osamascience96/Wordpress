<?php

/**
* TemplateController
*/
class EmailtemplateController extends Controller
{
	public function emailTemplate()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		$data['template'] = $this->url->get('for');

		if (empty($data['template'])) {
			$this->url->redirect('dashbaord');
		}

		$this->load->model('emailtemplate');
		$data['result'] = $this->model_emailtemplate->getTemplate($data['template']);
		$data['template_menu'] = $this->model_emailtemplate->getTemplateMenu();

		if (empty($data['result'])) {
			$this->url->redirect('dashbaord');
		}

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['page_title'] = 'Email Template';
		/* Set Page title and action */
		$data['action'] = URL_ADMIN.DIR_ROUTE.'emailtemplate';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);

		/*Render Calendar list view*/
		//$this->view->render('template/template_form.tpl', $data);
		$this->response->setOutput($this->load->view('template/template_form', $data));
	}

	public function emailTemplateAction()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('dashbaord');
		}
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		$data = $this->url->post('mail');
		$this->load->controller('common');
		if ($validate_field = $this->validateField($data)) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			$this->url->redirect('emailtemplate&for='.$data['template']);
		}

		$this->load->model('Emailtemplate');
		$result = $this->model_emailtemplate->updateTemplate($data);

		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Template updated successfully.');
		$this->url->redirect('emailtemplate&for='.$data['template']);
	}

	public function emailSetting()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		$this->load->model('emailtemplate');
		$data['result'] = $this->model_emailtemplate->getEmailSetting();
		$data['result'] = json_decode($data['result'], true);
		
		if (empty($data['result'])) {
			$this->url->redirect('dashbaord');
		}

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['page_title'] = 'Email Setting';
		/* Set Page title and action */
		$data['action'] = URL_ADMIN.DIR_ROUTE.'emailsetting';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		/*Render Calendar list view*/
		$this->response->setOutput($this->load->view('template/email_settings', $data));
	}

	public function emailSettingAction()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('emailsetting');
			exit();
		}
		$data = $this->url->post;
		
		$this->load->controller('common');
		
		if ($validate_field = $this->validateSMTPField($data)) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			$this->url->redirect('emailsetting');
		}
		
		$data['smtp'] = json_encode($data['smtp']);
		$this->load->model('emailtemplate');
		$result = $this->model_emailtemplate->updateEmailSetting($data['smtp']);
		
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Site Info updated successfully.');
		$this->url->redirect('emailsetting');
	}

	protected function validateField($data)
	{
		$error = [];
		$error_flag = false;

		if ($this->controller_common->validateText($data['subject'])) {
			$error_flag = true;
			$error['subject'] = 'Subject';
		}

		if ($this->controller_common->validateText($data['template'])) {
			$error_flag = true;
			$error['template'] = 'Template';
		}

		if ($this->controller_common->validateText($data['message'])) {
			$error_flag = true;
			$error['message'] = 'message';
		}

		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}

	protected function validateSMTPField($data)
	{
		$error = [];
		$error_flag = false;

		if ($this->controller_common->validateEmail($data['smtp']['fromemail'])) {
			$error_flag = true;
			$error['fromemail'] = 'From Email';
		}

		if ($this->controller_common->validateText($data['smtp']['fromname'])) {
			$error_flag = true;
			$error['fromname'] = 'From Name';
		}

		if (!empty($data['smtp']['reply'])) {
			if ($this->controller_common->validateEmail($data['smtp']['reply'])) {
				$error_flag = true;
				$error['reply'] = 'Reply Email Address';
			}
		}

		if ($data['smtp']['status'] == "2") {
			if ($this->controller_common->validateText($data['smtp']['host'])) {
				$error_flag = true;
				$error['host'] = 'SMTP Host';
			}

			if ($this->controller_common->validateNumber($data['smtp']['port'])) {
				$error_flag = true;
				$error['port'] = 'SMTP Port';
			}

			if ($this->controller_common->validateEmail($data['smtp']['username'])) {
				$error_flag = true;
				$error['username'] = 'SMTP Username';
			}

			if ($this->controller_common->validateText($data['smtp']['password'])) {
				$error_flag = true;
				$error['password'] = 'SMTP Password';
			}
		}
		
		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}