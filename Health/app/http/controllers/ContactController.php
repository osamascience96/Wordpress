<?php

/**
* Contact Controller
*/
class ContactController extends Controller
{
	/**
	* Contact controller index method
	* It will call getPage method of this controller
	**/
	public function index() {
		$this->load->model('pages');
		$data['page'] = $this->model_pages->pageData('contact');
		$data['page']['page_data'] = json_decode($data['page']['page_data'], true);

		$this->load->controller('common');
		$data = array_merge($data, $this->controller_common->index());
		$data['page']['breadcrumbs'] = array();
		$data['page']['breadcrumbs'][] = array(
			'label' => $data['lang']['text_home'],
			'link' => URL.DIR_ROUTE.'home',
		);
		$data['page']['breadcrumbs'][] = array(
			'label' => $data['page']['page_title'],
			'link' => '#',
		);
		
		$data['header'] = $this->controller_common->getHeader($data['page'], $data['pagetheme']['contact']['header']);
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
		$data['active'] = 'contact';

		$this->response->setOutput($this->load->view('contact/'.$data['pagetheme']['contact']['theme'], $data));
	}

	public function indexAction()
	{
		$data = $this->url->post;
		$this->load->controller('common');
		$lang = $this->controller_common->getLanguage();
		
		if (!isset($_POST['make-request']) || !$this->validate($data)) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => $lang['text_please_enter_valid_data_in_input_box']);
			$this->url->redirect('contact');
		}

		$token = $this->url->post('_token');
		$token_check = hash('sha512', TOKEN . TOKEN_SALT);
		if (hash_equals($token_check, $token) === false ) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => $lang['text_security_token_is_missing']);
			$this->url->redirect('contact');
		}

		if ($this->user_agent->isLogged()) {
			$data['user_id'] = $this->session->data['user_id'];
		} else {
			$data['user_id'] = 0;
		}

		$this->load->model('user');
		if ($this->model_user->createRequest($data)) {
			$this->sendRequestMail($data);
			$this->session->data['message'] = array('alert' => 'success', 'value' => $lang['text_your_request_created_succefully']);
			$this->url->redirect('contact');
		} else {
			$this->session->data['message'] = array('alert' => 'error', 'value' => $lang['text_server_error']);
			$this->url->redirect('contact');
		}
	}

	public function sendRequestMail($data)
	{
		$this->load->model('commons');
		$result = $this->model_commons->getTemplateAndInfo('newrequest');
		
		$link = '<a href="'.URL.'">Click Here</a>';
		$request_link = '<a href="'.URL.DIR_ROUTE.'user/request">Click Here</a>';
		
		$result['template']['message'] = str_replace('{name}', $data['name'], $result['template']['message']);
		$result['template']['message'] = str_replace('{email}', $data['email'], $result['template']['message']);
		$result['template']['message'] = str_replace('{mobile}', $data['mobile'], $result['template']['message']);
		$result['template']['message'] = str_replace('{subject}', $data['subject'], $result['template']['message']);
		$result['template']['message'] = str_replace('{message}', $data['message'], $result['template']['message']);
		$result['template']['message'] = str_replace('{clinic_name}', $result['common']['name'], $result['template']['message']);
		$result['template']['message'] = str_replace('{request_link}', $request_link, $result['template']['message']);

		$mail['name'] = $data['name'];
		$mail['email'] = $data['email'];
		$mail['subject'] = $result['template']['subject'];
		$mail['message'] = $result['template']['message'];
		
		$this->load->controller('mail');
		$mail_result = $this->controller_mail->sendMail($mail);
	}


	/**
	* Validate contact form credentials on server side
	* Validation is also done on client side (Using html5 and javascripts)
	**/
	protected function validate($data) {
		/** 
		* Check if email and password contains valid phrases
		**/
		if ((strlen($data['email']) > 96) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			/** 
			* If email is not valid
			* Return false
			**/
			return false;
		} elseif (strlen($data['name']) < 2) {
			/** 
			* If name is not valid (min 2 character)
			* Return false
			**/
			return false;
		} elseif ((strlen($data['mobile']) < 4) || (strlen($data['mobile']) > 32)) {
			/** 
			* If Mobile number is not valid ( min 4 character or max 32 ) 
			* Return false
			**/
			return false;
		} elseif (strlen($data['subject']) < 5) {
			/** 
			* If Subject is not valid (min 5 character)
			* Return false
			**/
			return false;
		} else {
			return true;
		}
	}
}