<?php

/**
* Home Controller
*/
class ForgotController extends Controller
{
	public function index() 
	{
		if ($this->user_agent->isLogged()) {
			$this->url->redirect('user/appointments');
		}
		$this->load->model('pages');
		$this->load->controller('common');
		$data = array();
		$data = array_merge($data, $this->controller_common->index());
		$data['page']['page_title'] = $data['lang']['text_forgot_password'];
		$data['page']['meta_tag'] = $data['page']['page_title'].' | ' .$data['siteinfo']['name'];
		$data['page']['meta_description'] = $data['page']['page_title'].', '.$data['siteinfo']['name'];
		
		$data['page']['breadcrumbs'] = array();
		$data['page']['breadcrumbs'][] = array(
			'label' => $data['lang']['text_home'],
			'link' => URL.DIR_ROUTE.'home',
		);
		$data['page']['breadcrumbs'][] = array(
			'label' => $data['page']['page_title'],
			'link' => '#',
		);

		$data['header'] = $this->controller_common->getHeader($data['page'], $data['pagetheme']['other']['header']);
		$data['footer'] = $this->controller_common->getFooter(NULL, 'footer');

		if (isset($this->session->data['error'])) {
			$data['error'] = $this->session->data['error'];
			unset($this->session->data['error']);
		}
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		}

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['active'] = 'forgot';
		/**
		* Load Forgot view
		* Pass data to view
		**/
		$this->response->setOutput($this->load->view('auth/forgot', $data));
	}
	/**
	* Forgot controller forgot method
	* This method will be called on submit request
	**/
	public function forgot() 
	{
		if ($this->user_agent->isLogged()) {
			$this->url->redirect('user/appointments');
		}
		/**
		* Intilize Url class for post and get request
		**/
		$email = $this->url->post('email');

		/** 
		* Check submit is POST request 
		* Validate input field
        **/
		$this->load->controller('common');
		$lang = $this->controller_common->getLanguage();
		if (!isset($_POST['forgot']) || !$this->validate($email)) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => $lang['text_please_enter_valid_data_in_input_box']);
			$this->url->redirect('forgot');
		}

		$token = $this->url->post('_token');
		$token_check = hash('sha512', TOKEN . TOKEN_SALT);
		if (hash_equals($token_check, $token) === false ) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => $lang['text_security_token_is_missing']);
			$this->url->redirect('forgot');
		}

		/** 
		* If the user exists
		* Check his account and login attempts
		* Get user data 
        **/
		$this->load->model('login');
		if ($user = $this->model_login->checkUser($email)) {
			/** 
			* Check Login attempt
			* The account is locked From too many login attempts 
            **/
			if (!$this->checkLoginAttempts($email)) {
				$this->session->data['message'] = array('alert' => 'error', 'value' => $lang['text_account_exceeded_allowed_attempts']);
				$this->url->redirect('login');
			} elseif ( $user['status'] === 1 ) {
				$user['temp_hash'] = md5(uniqid(mt_rand(), true));
				$this->model_login->editHash($user);
				$result = $this->sendForgotMail($user);
				if ($result) {
					$this->session->data['message'] = array('alert' => 'success', 'value' => $lang['text_reset_instruction_sent_to_your_email_address']);
				} else {
					$this->session->data['message'] = array('alert' => 'error', 'value' => $lang['text_mail_could_not_be_sent']);
				}
				$this->url->redirect('login');
			} else {
	        	/** 
	        	* If account is disabled by admin 
		        * Then Show error to user
		        **/
	        	$this->session->data['message'] = array('alert' => 'warning', 'value' => $lang['text_account_disabled_by_admin']);
	        	$this->url->redirect('login');
	        }
			/** 
			* User exists now We check if
			* Send Mail to user for reset password
            **/
		} else {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => $lang['text_account_does_not_exists']);
			$this->url->redirect('forgot');
		}
	}

	public function sendForgotMail($data)
	{
		$this->load->model('commons');
		$result = $this->model_commons->getTemplateAndInfo('forgotpassword');
		
		$link = '<a href="'.URL.'">Click Here</a>';
		$contact_link = '<a href="'.URL.DIR_ROUTE.'contact">Click Here</a>';
		$reset_link = '<a href="'.URL.DIR_ROUTE.'profile/changepassword&id='.$data['email'].'&code='.$data['temp_hash'].'">Reset Link</a>';
		$result['template']['message'] = str_replace('{firstname}', $data['firstname'], $result['template']['message']);
		$result['template']['message'] = str_replace('{email}', $data['email'], $result['template']['message']);
		$result['template']['message'] = str_replace('{reset_link}', $reset_link, $result['template']['message']);
		$result['template']['message'] = str_replace('{clinic_name}', $result['common']['name'], $result['template']['message']);

		$mail['name'] = $data['firstname'].' '.$data['lastname'];
		$mail['email'] = $data['email'];
		$mail['subject'] = $result['template']['subject'];
		$mail['message'] = $result['template']['message'];
		$this->load->controller('mail');
		$mail_result = $this->controller_mail->sendMail($mail);

		if ($mail_result == 1) {
			return true;
		} else {
			return false;
		}
	}

	public function passwordResetPage() 
	{
		$data['email'] = $this->url->get('id');
		$data['hash'] = $this->url->get('code');
		if (empty($data['email']) && empty($data['hash'])) {
			$this->url->redirect('home');
		}
		/**
		* Check Email and Hash value in DB
		**/
		$this->load->model('register');
		if ($this->model_register->checkEmailHash($data)) {
			
			$this->load->model('pages');
			$this->load->controller('common');

			$data = array_merge($data, $this->controller_common->index());
			$data['page']['page_title'] = $data['lang']['text_reset_password'];
			$data['page']['meta_tag'] = $data['page']['page_title'].' | ' .$data['siteinfo']['name'];
			$data['page']['meta_description'] = $data['siteinfo']['name'];

			$data['header'] = $this->controller_common->getHeader($data['page'], $data['pagetheme']['other']['header']);
			$data['footer'] = $this->controller_common->getFooter(NULL, 'footer');

			$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
			/**
			* Load Forgot view
			* Pass data to view
			**/
			$this->response->setOutput($this->load->view('user/change-password', $data));
		} else {
			$this->url->redirect('home');	
		}
	}

	public function passwordReset()
	{
		/** 
		* Check submit is POST request 
		* Validate input field
        **/
        $this->load->controller('common');
		$lang = $this->controller_common->getLanguage();

		if (!$this->validatePasswordField()) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => $lang['text_please_enter_valid_data_in_input_box']);
			$this->url->redirect('forgot');
		}

		$token = $this->url->post('_token');
		$token_check = hash('sha512', TOKEN . TOKEN_SALT);
		if (hash_equals($token_check, $token) === false) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => $lang['text_security_token_is_missing']);
			$this->url->redirect('forgot');
		}
		$data['email'] = $this->url->post('email');
		$data['password'] = $this->url->post('password');
		$data['hash'] = $this->url->post('hash');
		$this->load->model('register');
		$user = $this->model_register->checkUser($data['email']);
		
		if (empty($user)) {
			$this->url->redirect('home');
		}
		if ($this->model_register->changepassword($data)) {
			$this->sendResetMail($user);
			$this->session->data['message'] = array('alert' => 'success', 'value' => $lang['text_password_changed_successfully']);
			$this->url->redirect('login');
		} else {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => $lang['text_server_error']);
			$this->url->redirect('login');	
		}
	}

	public function sendResetMail($data)
	{
		$this->load->model('commons');
		$result = $this->model_commons->getTemplateAndInfo('resetpassword');
		
		$link = '<a href="'.URL.'">Click Here</a>';
		$contact_link = '<a href="'.URL.DIR_ROUTE.'contact">Click Here</a>';
		$result['template']['message'] = str_replace('{firstname}', $data['firstname'], $result['template']['message']);
		$result['template']['message'] = str_replace('{email}', $data['email'], $result['template']['message']);
		$result['template']['message'] = str_replace('{contact_link}', $contact_link, $result['template']['message']);
		$result['template']['message'] = str_replace('{clinic_name}', $result['common']['name'], $result['template']['message']);

		$mail['name'] = $data['firstname'].' '.$data['lastname'];
		$mail['email'] = $data['email'];
		$mail['subject'] = $result['template']['subject'];
		$mail['message'] = $result['template']['message'];

		$this->load->controller('mail');
		$mail_result = $this->controller_mail->sendMail($mail);
		if ($mail_result == 1) {
			return true;
		} else {
			return false;
		}
	}
	/** 
	* Validate input field on server side
	* Check if email and password contains valid phrases
	**/
	protected function validate($email)
	{
		if ((strlen($email) > 96) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
			/** 
			* If email is not valid
			* Return false
			**/
			return false;
		} else {
			/** 
			* If email looks good
			* Return true for further info
			**/
			return true;
		}
	}

	public function validatePasswordField()
	{
		if ((strlen($this->url->post('email')) > 96) || !filter_var($this->url->post('email'), FILTER_VALIDATE_EMAIL)) {
			/** 
			* If email is not valid
			* Return false
			**/
			return false;
		} elseif (strlen($this->url->post('password')) < 6) {
			/** 
			* If Password is not valid ( min 6 character ) 
			* Return false
			**/
			return false;
		} elseif ($this->url->post('password') != $this->url->post('confirmpassword')) {
			/** 
			* If Password does not match with confirmpassword 
			* Return false
			**/
			return false;
		} else {
			/** 
			* Everything looks good 
			* Return True
			**/
			return true;
		}
	}

	/** 
	* Check login attempts of user for brute force attacks 
	**/
	protected function checkLoginAttempts($email)
	{
		/**
		* Get attempts from DB and check with predefined field
		* All login attempts are counted from the past 1 hours. 
		**/
		$this->load->model('login');
		$login_attempts = $this->model_login->checkAttempts($email);
		if ($login_attempts && ($login_attempts['count'] >= 4) && strtotime('-1 hour') < strtotime($login_attempts['date_modified'])) {
			return false;
		} else {
			return true;
		}
	}
}