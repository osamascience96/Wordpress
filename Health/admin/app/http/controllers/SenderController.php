<?php
/**
* Sender Controller
*/
class SenderController extends Controller
{
	public function indexMail()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		$this->load->model('sender');
		$data['roles'] = $this->model_sender->getRole();

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['page_title'] = 'Send Email';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'send/email';
		/*call appointment list view*/
		$this->response->setOutput($this->load->view('sender/sender_email', $data));
	}

	public function indexMailAction()
	{
		/**
		 * Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('dashboard');
			exit();
		}
		$data = $this->url->post;
		$this->load->controller('common');
		if ($this->controller_common->validateToken($data['_token'])){
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security Token is missing!');
			$this->url->redirect('send/email');
		}

		if ($validate_field = $this->validateMailField($data['receiver'])) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			$this->url->redirect('send/email');
		}

		$this->load->model('sender');

		$data['mail']['name'] = $data['receiver']['name'];
		$data['mail']['email'] = $data['receiver']['email'];
		$data['mail']['subject'] = $data['receiver']['subject'];
		$data['mail']['message'] = $data['receiver']['message'];	

		$this->load->controller('mail');
		$mail_result = $this->controller_mail->sendMail($data['mail']);

		if ($mail_result == 1) {
			$data['mail']['type'] = 'sendemail';
			$data['mail']['type_id'] = 0;
			$data['mail']['user_id'] = $this->session->data['user_id'];
			$this->controller_mail->createMailLog($data['mail']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Success: Message sent successfully.');
		} else {
			$this->session->data['message'] = array('alert' => 'error', 'value' => $mail_result);
		}
		$this->url->redirect('send/email');
	}

	public function indexBulkMail()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		$this->load->model('sender');
		$data['roles'] = $this->model_sender->getRole();
		$this->load->controller('common');


		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['page_title'] = 'Send Bulk Email';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'sendbulk/email';
		/*call appointment list view*/
		$this->response->setOutput($this->load->view('sender/sender_bulk_email', $data));
	}

	public function indexBulkMailAction()
	{
		/**
		 * Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('dashboard');
			exit();
		}
		$data = $this->url->post;
		$this->load->controller('common');
		if ($this->controller_common->validateToken($data['_token'])){
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security Token is missing!');
			$this->url->redirect('sendbulk/email');
		}

		if ($validate_field = $this->validateBulkMailField($data['receiver'])) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			$this->url->redirect('sendbulk/email');
		}

		$this->load->model('sender');
		if (!empty($data['receiver']['user'])) {
			foreach ($data['receiver']['user'] as $key => $value) {
				if ($this->controller_common->validateNumber($value)) {
					$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please select valid Receiver!');
					$this->url->redirect('sendbulk/email');
				}
			}
		}
		
		if ($data['receiver']['user_type'] == 'patient') {
			$data['mail']['addresses'] = $this->model_sender->getPatientReceiver($data['receiver']);
		} elseif (!filter_var($data['receiver']['user_type'], FILTER_VALIDATE_INT) === false) {
			$data['mail']['addresses'] = $this->model_sender->getUserReceiver($data['receiver']);
		} else {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Error: Please select valid user type.');
			$this->url->redirect('sendbulk/email');
		}
		
		$data['mail']['subject'] = $data['receiver']['subject'];
		$data['mail']['message'] = $data['receiver']['message'];
		
		$this->load->controller('mail');
		$mail_result = $this->controller_mail->sendBulkMail($data['mail']);
		
		if ($mail_result == 1) {
			$data['mail']['type'] = 'sendbulkemail';
			$data['mail']['type_id'] = 0;
			$data['mail']['user_id'] = $this->session->data['user_id'];
			$this->controller_mail->createBulkMailLog($data['mail']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Success: Message sent successfully.');
		} else {
			$this->session->data['message'] = array('alert' => 'error', 'value' => $mail_result);
		}
		$this->url->redirect('sendbulk/email');
	}

	public function indexUsers()
	{
		$data = $this->url->post;
		$this->load->model('sender');
		if ($data['user'] == 'patient') {
			$result	= $this->model_sender->getPatients();
			$result = array_merge(array('0' => array('id' => 'all', 'name' => 'All Patient', 'type' => 'patient')), $result);
			echo json_encode($result);
		} elseif (!filter_var($data['user'], FILTER_VALIDATE_INT) === false) {
			$result	= $this->model_sender->getUsers($data['user']);
			$result = array_merge(array(0 => array('id' => 'all', 'name' => 'All Users', 'type' => $result[0]['type'])), $result);
			echo json_encode($result);
		}
	}

	public function validateMailField($data)
	{
		$error = [];
		$error_flag = false;

		if ($this->controller_common->validateText($data['name'])) {
			$error_flag = true;
			$error['name'] = 'Name';
		}

		if ($this->controller_common->validateEmail($data['email'])) {
			$error_flag = true;
			$error['email'] = 'Email Address';
		}

		if ($this->controller_common->validateText($data['subject'])) {
			$error_flag = true;
			$error['subject'] = 'Subject!';
		}

		if ($this->controller_common->validateText($data['message'])) {
			$error_flag = true;
			$error['message'] = 'Message!';
		}
		
		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}

	public function validateBulkMailField($data)
	{
		$error = [];
		$error_flag = false;

		if (!is_array($data['user'])) {
			$error_flag = true;
			$error['user_type'] = 'Receiver';
		}

		if (is_array($data['user'])) {
			foreach ($data['user'] as $key => $value) {
				if (filter_var($value, FILTER_VALIDATE_INT) === false) {
					$error_flag = true;
					$error['user'] = 'User Value';
				}
			}
		}

		if ($this->controller_common->validateText($data['subject'])) {
			$error_flag = true;
			$error['subject'] = 'Subject!';
		}

		if ($this->controller_common->validateText($data['message'])) {
			$error_flag = true;
			$error['message'] = 'Message!';
		}
		
		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}

	public function indexEmailLog()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		$data['period']['start'] = $this->url->get('start');
		$data['period']['end'] = $this->url->get('end');
		
		$this->load->controller('common');
		if (!empty($data['period']['start']) && !empty($data['period']['end']) && !$this->controller_common->validateDate($data['period']['start']) && !$this->controller_common->validateDate($data['period']['end'])) {
			$data['period']['start'] = date_format(date_create($data['period']['start'].'00:00:00'), "Y-m-d H:i:s");
			$data['period']['end'] = date_format(date_create($data['period']['end'].'23:59:59'), "Y-m-d H:i:s");
		} else {
			$data['period']['start'] = date('Y-m-d '.'00:00:00', strtotime("-1 month"));
			$data['period']['end'] = date('Y-m-d '.'23:59:59');
		}
		
		$this->load->model('sender');
		$data['result'] = $this->model_sender->getEmailLog($data['period']);

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['page_title'] = 'Email Logs';
		/*call appointment list view*/
		$this->response->setOutput($this->load->view('sender/email_log', $data));
	}
}