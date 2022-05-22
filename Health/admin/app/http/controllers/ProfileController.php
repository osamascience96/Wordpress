<?php

/**
* Profile Controller
*/
class ProfileController extends Controller
{
	public function index()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		$this->load->model('profile');
		$data['result'] = $this->model_profile->getProfile($this->session->data['user_id']);
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['page_title'] = 'My Profile';
		/*call profile view*/
		$this->response->setOutput($this->load->view('profile/profile', $data));
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
		if (!isset($_POST['submit'])) {
			$this->url->redirect('profile');
		}

		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		$this->load->controller('common');
		$data = $this->url->post;
		if ($validate_field = $this->validateField($data)) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			$this->url->redirect('profile');
		}
		
		if ($this->controller_common->validateToken($this->url->post('_token'))){
			$this->url->redirect('profile');
		}

		$this->update($data);
	}

	public function indexPassword()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('profile');
		}
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		$this->load->controller('common');
		$data = $this->url->post;
		
		if ($validate_field = $this->validatePasswordField($data)) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => implode(", ",$validate_field).'!');
			$this->url->redirect('profile');
		}
		
		if ($this->controller_common->validateToken($data['_token'])){
			$this->url->redirect('profile');
		}

		$this->changePassword($data);
	}

	protected function update($data)
	{
		$this->load->model('profile');
		
		$check_user = $this->model_profile->checkUserName($data['username'], $data['email']);
		
		if ($check_user >= 1) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'User Name  \'' .$this->url->post('username').' \' already exist in database.');
			$this->url->redirect('profile');
		}
		$data['user_id'] = $this->session->data['user_id'];
		$data['username'] = $this->url->post('username');
		
		if ($this->model_profile->updateProfile($data)) {
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Profile updated successfully.');
			$this->url->redirect('profile');
		}
		else {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Profile does not updated (Server Error).');
			$this->url->redirect('profile');
		}
	}

	protected function changePassword($data)
	{
		$data['user_id'] = $this->url->post('id');
		$this->load->model('profile');
		$password = $this->model_profile->getUserData($data['user_id']);

		if (password_verify($data['old'], $password)) {
			$data['password'] = password_hash($data['new'], PASSWORD_DEFAULT);
			$result = $this->model_profile->updatePassword($data);
			if ($result) {
				$this->session->data['message'] = array('alert' => 'success', 'value' => 'Account Password updated successfully.');
				$this->url->redirect('profile');
			} else {
				$this->session->data['message'] = array('alert' => 'error', 'value' => 'Account Password does not updated(Server Error).');
				$this->url->redirect('profile');
			}
		} else {
			
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Current Password is not correct.');
			$this->url->redirect('profile');
		}
		
	}

	protected function validateField($data)
	{
		$error = [];
		$error_flag = false;
		if ($this->controller_common->validateText($data['username'])) {
			$error_flag = true;
			$error['username'] = 'User name!';
		}

		if ($this->controller_common->validateText($data['firstname'])) {
			$error_flag = true;
			$error['firstname'] = 'First Name';
		}

		if ($this->controller_common->validateText($data['lastname'])) {
			$error_flag = true;
			$error['lastname'] = 'Last Name';
		}

		if ($this->controller_common->validateEmail($data['email']) ) {
			$error_flag = true;
			$error['email'] = 'Email Address';
		}

		if ($this->controller_common->validatePhoneNumber($data['mobile']) ) {
			$error_flag = true;
			$error['mobile'] = 'Mobile Number';
		}

		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}

	protected function validatePasswordField($data)
	{
		$error = [];
		$error_flag = false;
		if (strlen($data['old']) < 6) {
			$error_flag = true;
			$error['username'] = 'Please enter minimum 6 letters for Old Password';
		}

		if (strlen($data['new']) < 8) {
			$error_flag = true;
			$error['firstname'] = 'Please enter minimum 8 letters for New Password';
		}

		if (strlen($data['confirm']) < 8) {
			$error_flag = true;
			$error['lastname'] = 'Please enter minimum 8 letters for Confirm Password';
		}

		if ($data['confirm'] != $data['new']) {
			$error_flag = true;
			$error['match'] = 'Confirm Password does not match with new password';
		}

		if ($error_flag) {
			return $error;
		}
		else {
			return false;
		}
	}
}