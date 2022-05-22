<?php

/**
* Home Controller
*/
class RegisterController extends Controller
{
	public function index() 
	{
		if ($this->user_agent->isLogged()) {
			$this->url->redirect('user/appointments');
		}
		/**
		* Get service page data from DB
		**/
		$this->load->model('pages');
		$this->load->controller('common');
		$data = array();
		$data = array_merge($data, $this->controller_common->index());

		$data['page']['page_title'] = $data['lang']['text_register'];
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
		$data['active'] = 'register';
		/**
		* Load register view
		* Pass data to view
		**/
		$this->response->setOutput($this->load->view('auth/register', $data));
	}
	/**
	* Register method
	* It will call on Register submit
	**/
	public function register() 
	{
		if ($this->user_agent->isLogged()) {
			$this->url->redirect('user/appointments');
		}
		/**
		* Intilize Url class for post and get request
		**/
		$data = $this->url->post;
		/** 
		* Check submit is POST request 
		* Validaate input field
        **/

		$this->load->controller('common');
		$lang = $this->controller_common->getLanguage();
		if (!isset($_POST['register']) || !$this->validate($data)) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => $lang['text_please_enter_valid_data_in_input_box']);
			$this->url->redirect('register');
		}

		$token = $this->url->post('_token');
		$token_check = hash('sha512', TOKEN . TOKEN_SALT);
		
		if (hash_equals($token_check, $token) === false) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => $lang['text_security_token_is_missing']);
			$this->url->redirect('register');
		}

		/*Intiate login Model*/
		/** 
		* Check if user already registerd or not
		* If the user exists Show error 
        **/
		$this->load->model('register');
		if ($user = $this->model_register->checkUser($data['email'])) { 
			$this->session->data['message'] = array('alert' => 'warning', 'value' => $lang['text_account_already_exist_login_now_or_use_forgot_password_to_reset_password']);
			$this->url->redirect('login');
		} else {
			/**
			* Unique hash value for email verification
			**/
			$data['temp_hash'] = md5(uniqid(mt_rand(), true));
			/**
			* Create user account
			* Insert value in DB
			**/
			$data['datetime'] = date('Y-m-d H:i:s');
			$user = $this->model_register->createAccount($data);
			if ($user) {
				$this->sendMail($data);
				/**
				* Set success message 
				* Redirect to login page for login
				**/
				$this->session->data['message'] = array('alert' => 'success', 'value' => $lang['text_account_created_succefully_check_your_mail_for_more_info']);
				$this->url->redirect('login');
			} else {
				$this->session->data['message'] = array('alert' => 'error', 'value' => $lang['text_server_error']);
				$this->url->redirect('register');
			}
			$this->url->redirect('login');
		}
	}

	private function sendMail($data)
	{
		$this->load->model('commons');
		$result = $this->model_commons->getTemplateAndInfo('newwebuser');

		$link = '<a href="'.URL.'">Click Here</a>';
		$contact_link = '<a href="'.URL.DIR_ROUTE.'contact">Click Here</a>';
		$verify_link = '<a href="'.URL.DIR_ROUTE.'register/verify&id='.$data['email'].'&code='.$data['temp_hash'].'">Verify</a>';

		$result['template']['message'] = str_replace('{firstname}', $data['firstname'], $result['template']['message']);
		$result['template']['message'] = str_replace('{name}', $data['firstname'].' '.$data['lastname'], $result['template']['message']);
		$result['template']['message'] = str_replace('{email}', $data['email'], $result['template']['message']);
		$result['template']['message'] = str_replace('{mobile}', $data['mobile'], $result['template']['message']);
		$result['template']['message'] = str_replace('{clinic_name}', $result['common']['name'], $result['template']['message']);
		$result['template']['message'] = str_replace('{contact_link}', $contact_link, $result['template']['message']);
		$result['template']['message'] = str_replace('{verify_link}', $verify_link, $result['template']['message']);

		$mail['name'] = $data['firstname'].' '.$data['lastname'];
		$mail['email'] = $data['email'];
		$mail['subject'] = $result['template']['subject'];
		$mail['message'] = $result['template']['message'];

		$this->load->controller('mail');
		$mail_result = $this->controller_mail->sendMail($mail);
		if ($mail_result == 1) {
			//$this->session->data['message'] = array('alert' => 'error', 'value' => 'Success: Message sent successfully.');
		} else {
			//$this->session->data['message'] = array('alert' => 'error', 'value' => $mail_result);
		}
	}

	public function userVerfiy() 
	{
		$data['email'] = $this->url->get('id');
		$data['hash'] = $this->url->get('code');

		if ((strlen($data['email']) > 96) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			$this->url->redirect('home');
		} elseif (empty($data['hash'])) {
			$this->url->redirect('home');
		}

		$this->load->controller('common');
		$lang = $this->controller_common->getLanguage();

		$this->load->model('register');
		if ($this->model_register->checkEmailHash($data)) {
			$confirmAccount = $this->model_register->confirmAccount($data);
			$this->session->data['message'] = array('alert' => 'success', 'value' => $lang['text_your_email_address_has_been_confirmed']);
			$this->url->redirect('login');
		} else {
			$this->url->redirect('login');
		}
	}

	/**
	* Validate Register data on server side
	* Validation is also done on client side (Using html5 and javascripts)
	**/
	protected function validate($data) {
		/** 
		* Validate input field on server side
		* Check if email and password contains valid phrases
		**/
		if ((strlen(trim($data['firstname'])) < 2) || (strlen(trim($data['firstname'])) > 48)) {
			/** 
			* If First name is not valid ( min 2 character or max 48 ) 
			* Return false
			**/
			return false;
		} elseif ((strlen(trim($data['lastname'])) < 1) || (strlen(trim($data['lastname'])) > 48)) {
			/** 
			* If Last name is not valid ( min 2 character or max 48 ) 
			* Return false
			**/
			return false;
		} elseif ((strlen($data['email']) > 96) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			/** 
			* If email is not valid
			* Return false
			**/
			return false;
		} elseif ((strlen($data['mobile']) < 4) || (strlen($data['mobile']) > 32)) {
			/** 
			* If Mobile number is not valid ( min 4 character or max 32 ) 
			* Return false
			**/
			return false;
		} elseif (strlen($data['password']) < 6) {
			/** 
			* If Password is not valid ( min 6 character ) 
			* Return false
			**/
			return false;
		} elseif ($data['confirmpassword'] != $data['password']) {
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
}