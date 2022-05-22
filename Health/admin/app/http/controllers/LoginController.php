<?php

/**
* Login Controller
*/
class LoginController extends Controller
{
	public function index()
	{
		$data['error'] = '';
		if (isset($this->session->data['error'])) {
			$data['error'] = $this->session->data['error'];
			unset($this->session->data['error']);
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		}

		$this->load->model('commons');
		$data['common'] = $this->model_commons->getSiteInfo();
		$data['theme'] = $this->model_commons->getAdminTheme();
		
		if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
			$this->session->data['refferal'] = $_SERVER['HTTP_REFERER'];
		}

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'login';
		
		$this->response->setOutput($this->load->view('auth/login', $data));
	}

	public function login()
	{
		$data = $this->url->post;
		if ($this->user_agent->isLogged()) {
			$this->url->redirect('dashboard');
		}

		$this->load->controller('common');
		if ($this->controller_common->validateToken($this->url->post('_token'))) {
			$this->session->data['error'] = 'Warning: Security token is missing.';
			$this->url->redirect('login');
		}
		
		if (!$this->validate($data['username'], $data['password'])) {
			$this->session->data['error'] = 'Warning: Please enter valid data in input box.';
			$this->url->redirect('login');
		}

		unset($this->session->data['user_id']);
		unset($this->session->data['login_token']);
		unset($this->session->data['role']);
		/** 
		* If the user exists
		* Check his account and login attempts
		* Get user data 
        **/
		$this->load->model('Login');

		if ($user = $this->model_login->checkUser($data['username'])) {

			/** 
			* User exists now We check if
			* The account is locked From too many login attempts 
            **/
			if (!$this->checkLoginAttempts($user['email'])) {
				$this->session->data['error'] = 'Warning: Your account has exceeded allowed number of login attempts. Please try again in 1 hour.';
				$this->url->redirect('login');
			}
			else if ($user['status'] === 1) {
				
	            /** 
	            * Check if the password in the database matches the password user submitted.
	            * We are using the password_verify function to avoid timing attacks.
	            **/
	            if (password_verify($data['password'], $user['password'])) {
	            	$this->model_login->deleteAttempt($user['email']);
	            	/** 
	            	* Start session for user create session varible 
		            * Create session login string for authentication
		            **/
	            	$this->session->data['user_id'] = preg_replace("/[^0-9]+/", "", $user['user_id']); 
	            	//$this->session->data['role'] = preg_replace("/[^0-9]+/", "", $user['user_role']);
	            	$this->session->data['login_token'] = hash('sha512', AUTH_KEY . LOGGED_IN_SALT);
	            	$this->url->Redirect('dashboard');
	            } else {
	            	
	            	/** 
	            	* Add login attemt to Db
		            * Redirect back to login page and set error for user
		            **/
	            	$this->model_login->addAttempt($user['email']);
	            	$this->session->data['error'] = 'Warning: No match for Username and/or Password.';
	            	$this->url->Redirect('login');
	            }
	        }
	        else {
	        	/** 
	        	* If account is disabled by admin 
		        * Then Show error to user
		        **/
	        	$this->session->data['error'] = 'Warning: Your account has disabled for more info contact us.';
	        	$this->url->redirect('login');
	        }
	    }
	    else {
	    	/** 
	        * If email address not found in DB 
		    * Show error to user for creating account
		    **/
	    	$this->session->data['error'] = 'Warning: No match for Username and/or Password.';
	    	$this->url->redirect('login');
	    }
	}

	public function logout()
	{
		$this->user_agent->logout();
		$this->url->redirect('login');
	}

	public function forgotpassword()
	{
		if ($this->user_agent->isLogged()) {
			$this->url->redirect('dashboard');
		}

		$data['error'] = '';
		if (isset($this->session->data['error'])) {
			$data['error'] = $this->session->data['error'];
			unset($this->session->data['error']);
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		}

		$this->load->model('commons');
		$data['common'] = $this->model_commons->getSiteInfo();
		$data['theme'] = $this->model_commons->getAdminTheme();

		if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
			$this->session->data['refferal'] = $_SERVER['HTTP_REFERER'];
		}

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'forgotpassword';
		
		$this->response->setOutput($this->load->view('auth/forgot', $data));
	}

	public function forgotAction()
	{
		if ($this->user_agent->isLogged()) {
			$this->url->redirect('dashboard');
		}
		$data = $this->url->post;

		/** 
		* If the user exists
		* Check his account and login attempts
		* Get user data 
        **/
		$this->load->model('login');
		if ($user = $this->model_login->checkAdminUser($data['mail'])) {
			/** 
			* Check Login attempt
			* The account is locked From too many login attempts 
            **/
			if (!$this->checkLoginAttempts($data['mail'])) {
				$this->session->data['error'] = 'Error: Your account has exceeded allowed number of login attempts. Please try again in 1 hour.';
				$this->url->redirect('login');
			} elseif ( $user['status'] === 1 ) {
				$user['temp_hash'] = md5(uniqid(mt_rand(), true));
				$this->model_login->editHash($user);
				$result = $this->sendForgotMail($user);
				
				if ($result) {
					$this->session->data['success'] = 'Success: Reset instruction sent to your E-mail address.';
				} else {
					$this->session->data['error'] = 'Error: Mail could not be sent. Please contact us for more info.';
				}
				$this->url->redirect('login');
			} else {
	        	/** 
	        	* If account is disabled by admin 
		        * Then Show error to user
		        **/
	        	$this->session->data['error'] = 'Error: Your account has disabled by admin, For more info contact us.';
	        	$this->url->redirect('login');
	        }
			/** 
			* User exists now We check if
			* Send Mail to user for reset password
            **/
		} else {
			$this->session->data['error'] = 'Error: Account does not exist.';
			$this->url->redirect('forgotpassword');
		}
	}

	public function sendForgotMail($data)
	{
		$this->load->model('commons');
		$result = $this->model_commons->getTemplateAndInfo('forgotpassword');

		$link = '<a href="'.URL.'">Click Here</a>';
		$contact_link = '<a href="'.URL.DIR_ROUTE.'contact">Click Here</a>';
		$reset_link = '<a href="'.URL_ADMIN.DIR_ROUTE.'resetpassword&id='.$data['email'].'&code='.$data['temp_hash'].'">Reset Link</a>';
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

	public function resetpassword()
	{
		$data['email'] = $this->url->get('id');
		$data['hash'] = $this->url->get('code');
		if (empty($data['email']) && empty($data['hash'])) {
			$this->url->redirect('login');
		}

		if (!$this->validateEmailAddress($data['email'])) {
			$this->url->redirect('login');
		}

		/**
		* Check Email and Hash value in DB
		**/
		$this->load->model('login');
		if ($this->model_login->checkEmailHash($data)) {
			$this->load->model('commons');
			$data['common'] = $this->model_commons->getSiteInfo();
			$data['theme'] = $this->model_commons->getAdminTheme();

			$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
			$data['action'] = URL_ADMIN.DIR_ROUTE.'resetpassword';

			$this->response->setOutput($this->load->view('auth/reset-password', $data));
		} else {
			$this->url->redirect('login');
		}
	}

	public function resetpasswordAction()
	{
		$data = $this->url->post;
		if (!$this->validateResetField($data)) {
			$this->url->redirect('login');
		}

		$data['email'] = $this->url->post('email');
		$data['password'] = $this->url->post('password');
		$data['hash'] = $this->url->post('hash');
		$this->load->model('login');

		$user = $this->model_login->checkEmailHash($data);
		if (empty($user)) {
			$this->url->redirect('home');
		}

		if ($this->model_login->resetPassword($data)) {
			$this->sendResetMail($user);
			$this->session->data['success'] = 'Success: Password changed successfully. Please login now.';
			$this->url->redirect('login');
		} else {
			$this->session->data['error'] = 'Error: Server Error!!! Please contact us for support.';
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
	* Validate login credentials on server side
	* Validation is also done on client side (Using html5 and javascripts)
	**/
	protected function validate($email, $password) 
	{
		/** 
		* Check if email and password contains valid phrases
		**/
		if (strlen($email) < 2 ) {
			/** 
			* If email is not valid
			* Return false
			**/
			return false;
		}
		elseif (strlen($password) < 6) {
			/** 
			* If password is not valid or minimum 6 character
			* Return false
			**/
			return false;
		}
		else {
			return true;
		}
	}

	protected function validateEmailAddress($email)
	{
		/** 
		* Check if email and password contains valid phrases
		**/
		if ((strlen($email) < 4) || (strlen($email) > 96) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
			/** 
			* If email is not valid
			* Return false
			**/
			return false;
		} else {
			return true;
		}
	}

	protected function validateResetField($data)
	{
		if ((strlen($data['email']) > 96) || !filter_var($this->url->post('email'), FILTER_VALIDATE_EMAIL)) {
			/** 
			* If email is not valid
			* Return false
			**/
			return false;
		} elseif (strlen($this->url->post('new')) < 8) {
			/** 
			* If Password is not valid ( min 6 character ) 
			* Return false
			**/
			return false;
		} elseif ($this->url->post('new') != $this->url->post('confirm')) {
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
		$login_attempts = $this->model_login->checkAttempts($email);
		if ($login_attempts && ($login_attempts['count'] >= 4) && strtotime('-1 hour') < strtotime($login_attempts['date_modified'])) {
			return false;
		} else {
			return true;
		}
	}
}