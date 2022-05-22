<?php

/**
* Login Controller
*/
class LoginController extends Controller
{
	/**
	* Login controller index method
	* It will call getPage method of this controller
	**/
	public function index()
	{
		if ($this->user_agent->isLogged()) {
			$this->url->redirect('user/appointment');
		}
		/**
		* Get service page data from DB
		**/
		$this->load->model('pages');
		$this->load->controller('common');
		$data = array();
		$data = array_merge($data, $this->controller_common->index());
		$data['page']['page_title'] = $data['lang']['text_login'];
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

		if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
			$this->session->data['refferal'] = $_SERVER['HTTP_REFERER'];
		}

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['active'] = 'login';
		/**
		* Load login view
		* Pass data to view
		**/
		$this->response->setOutput($this->load->view('auth/login', $data));
	}

	/**
	* Login controller login method
	* This method will call on login submit action
	**/
	public function login()
	{
		/**
		* Intilize Url class for post and get request
		**/
		
		unset($this->session->data['user_id']);
		unset($this->session->data['login_token']);
		/** 
		* Check submit is POST request 
		* Validaate input field
        **/
		$data = $this->url->post;

		$this->load->controller('common');
		$lang = $this->controller_common->getLanguage();

		if (!$this->validate($data)) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => $lang['text_please_enter_valid_data_in_input_box']);
			$this->url->redirect('login');
		}
		
		$token_check = hash('sha512', TOKEN . TOKEN_SALT);
		if (hash_equals($token_check, $data['_token']) === false) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => $lang['text_security_token_is_missing']);
			$this->url->redirect('login');
		}

		/*Intiate login Model*/
		$this->load->model('login');
		/**
		* If the user exists
		* Check his account and login attempts
		* Get user data 
        **/
		$email = $data['email'];
		$password = $data['password'];

		if ($user = $this->model_login->checkUser($email)) {

			/** 
			* User exists now We check if
			* The account is locked From too many login attempts 
            **/
			if (!$this->checkLoginAttempts($email)) {
				$this->session->data['message'] = array('alert' => 'warning', 'value' => $lang['text_account_exceeded_allowed_attempts']);
				$this->url->redirect('login');
			} elseif ($user['status'] === 1) {
	            /** 
	            * Check if the password in the database matches the password user submitted.
	            * We are using the password_verify function to avoid timing attacks.
	            **/
	            if (password_verify( $password, $user['password'])) {
	            	$this->model_login->deleteAttempt($email);
	            	/** 
	            	* Start session for user create session varible 
		            * Create session login string for authentication
		            **/
	            	$this->session->data['user_id'] = preg_replace("/[^0-9]+/", "", $user['id']); 
	            	$this->session->data['login_token'] = hash('sha512', AUTH_KEY . LOGGED_IN_SALT);
	            	
	            	if (isset($this->session->data['refferal'])) {
	            		$this->url->abs_redirect($this->session->data['refferal']);
	            	} else {
	            		$this->url->Redirect('user/appointments');
	            	}
	            } else {
	            	/** 
	            	* Add login attemt to Db
		            * Redirect back to login page
		            * Set error for user
		            **/
	            	$this->model_login->addAttempt($email);
	            	$this->session->data['message'] = array('alert' => 'warning', 'value' => $lang['text_no_match_for_email_address_and_or_Password']);
	            	$this->url->Redirect('login');
	            }
	        } else {
	        	/** 
	        	* If account is disabled by admin 
		        * Then Show error to user
		        **/
	        	$this->session->data['message'] = array('alert' => 'error', 'value' => $lang['text_account_disabled_by_admin']);
	        	$this->url->redirect('login');
	        }
	    } else {
	    	/** 
	        * If email address not found in DB 
		    * Show error to user for creating account
		    **/
	    	$this->session->data['message'] = array('alert' => 'warning', 'value' => $lang['text_no_match_for_email_address_and_or_Password']);
	    	$this->url->redirect('login');
	    }
	}

	/**
	* Validate login credentials on server side
	* Validation is also done on client side (Using html5 and javascripts)
	**/
	protected function validate($data)
	{
		/** 
		* Check if email and password contains valid phrases
		**/
		if ((strlen($data['email']) > 96) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			/** 
			* If email is not valid
			* Return false
			**/
			return false;
		} elseif (strlen($data['password']) < 6) {
			/** 
			* If password is not valid or minimum 6 character
			* Return false
			**/
			return false;
		} else {
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