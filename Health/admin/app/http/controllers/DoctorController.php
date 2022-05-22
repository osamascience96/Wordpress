<?php

/**
* Doctor Controller
*/
class DoctorController extends Controller
{
	/**
	* Doctor index method
	* This method will be called on doctor list view
	**/
	public function index()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Get all Doctor data from Db using Doctor Model method 
		**/
		$this->load->model('doctor');

		if ($data['common']['user']['role_id'] == '3') {
			$data['result'] = $this->model_doctor->allDoctors($data['common']['user']['doctor']);
		} else {
			$data['result'] = $this->model_doctor->allDoctors();
		}

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['page_title'] = 'Doctors';
		$data['page_add'] = $this->user_agent->hasPermission('doctor/add') ? true : false;
		$data['page_edit'] = $this->user_agent->hasPermission('doctor/edit') ? true : false;
		$data['page_delete'] = $this->user_agent->hasPermission('doctor/delete') ? true : false;

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action_delete'] = URL_ADMIN.DIR_ROUTE.'doctor/delete';

		/*Render Doctor list view*/
		$this->response->setOutput($this->load->view('themeoption/doctor_list', $data));
	}
	/**
	* Doctor index add method
	* This method will be called on Department add
	**/
	public function indexAdd()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/* Set page title */
		$data['page_title'] = 'Add Doctor';
		/* Set empty data to array */
		$data['result'] =  NULL;
		$data['week_days'] = array('1' => 'Monday', '2' => 'Tuesday', '3' => 'Wednesday', '4' => 'Thursday', '5' => 'Friday', '6' => 'Saturday', '0' => 'Sunday');
		/* Set department in array */
		$this->load->model('doctor');
		$data['departments'] = $this->model_doctor->getDepartmentByName();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'doctor/add';
		/*Render Doctor add view*/
		$this->response->setOutput($this->load->view('themeoption/doctor_form', $data));
	}
	/**
	* Doctor index edit method
	* This method will be called on doctor edit view
	**/
	public function indexEdit()
	{
		/**
		* Check if id exist in url if not exist then redirect to Doctor list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('doctors');
		}
		/**
		* Call getDoctor method from Blog model to get data from DB for single doctor
		* If Doctor does not exist then redirect it to doctor list view
		**/
		$this->load->model('doctor');
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		if ($data['common']['user']['role_id'] == '3' && $data['common']['user']['doctor'] != $id) {
			$data['result'] = NULL;
		} else {
			$data['result'] = $this->model_doctor->getDoctor($id);
		}
		
		if (empty($data['result'])) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Doctor does not exist in database!');
			$this->url->redirect('doctors');
		}

		/* Set Doctor edit view page title in array */
		$data['page_title'] = 'Edit Doctor';
		$data['week_days'] = array('1' => 'Monday', '2' => 'Tuesday', '3' => 'Wednesday', '4' => 'Thursday', '5' => 'Friday', '6' => 'Saturday', '0' => 'Sunday');

		/* Set about doctor in array */
		$data['result']['about'] = json_decode($data['result']['about'], true);
		$data['result']['time'] = json_decode($data['result']['time'], true);
		$data['result']['weekly'] = json_decode($data['result']['weekly'], true);
		$data['result']['national'] = json_decode($data['result']['national'], true);
		$data['result']['social'] = json_decode($data['result']['social'], true);
		$data['result']['address'] = json_decode($data['result']['address'], true);
		
		/* Set department in array */
		$data['departments'] = $this->model_doctor->getDepartmentByName();
		
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'doctor/edit';
		/*Render Doctor edit view*/
		$this->response->setOutput($this->load->view('themeoption/doctor_form', $data));
	}
	/**
	* Info index action method
	* This method will be called on Info submit/save view
	**/
	public function indexAction()
	{
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		$data = $this->url->post;
		
		$this->load->controller('common');
		
		$this->load->model('commons');
		$data['info'] = $this->model_commons->getSiteInfo();

		if ($validate_field = $this->validateField($data)) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter/select valid '.implode(", ",$validate_field).'!');
			if (!empty($data['doctor']['id'])) {
				$this->url->redirect('doctor/edit&id='.$data['doctor']['id']);
			} else {
				$this->url->redirect('doctor/add');
			}
		}

		if (!empty($data['doctor']['dob'])) {
			$data['doctor']['dob'] = DateTime::createFromFormat($data['info']['date_format'], $data['doctor']['dob'])->format('Y-m-d');
		} else {
			$data['doctor']['dob'] = '';
		}

		$data['user'] = $this->model_commons->getUserInfo($this->session->data['user_id']);
		if ($data['user']['role_id'] == "3" && $data['doctor']['user_id'] != $this->session->data['user_id']) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'You can not change other doctors info!');
			$this->url->redirect('doctors');
		}

		$this->load->model('user');
		$this->load->model('doctor');
		/**
		* Check if @user_name already exist or not in database
		**/
		$check_user = $this->model_user->checkUserName($data['doctor']['user_name'], $data['doctor']['user_id']);
		if ($check_user >= 1) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'User Name '.$data['doctor']['user_name'].' already exist in database.');
			if (!empty($data['doctor']['id'])) {
				$this->url->redirect('doctor/edit&id='.$data['doctor']['id']);
			} else {
				$this->url->redirect('doctor/add');
			}
		}
		/**
		* Check if @email already exist or not in database
		**/
		
		if ($this->model_user->checkUserEmail($data['doctor']['mail'], $data['doctor']['user_id']) >= 1) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Email  \'' . $data['doctor']['mail'] . '\'  already exist in database.');
			if (!empty($data['doctor']['id'])) {
				$this->url->redirect('doctor/edit&id='.$data['doctor']['id']);
			} else {
				$this->url->redirect('doctor/add');
			}
		}

		$weekly_holiday = array();
		if (!empty($data['doctor']['time'])) {
			foreach ($data['doctor']['time'] as $key => $value) {
				if (!empty($value['holiday'])) {
					array_push($weekly_holiday, $key);
				}
			}
		}
		
		$data['doctor']['about'] = json_encode($data['doctor']['about']);
		$data['doctor']['social'] = json_encode($data['doctor']['social']);
		$data['doctor']['address'] = json_encode($data['doctor']['address']);

		$data['doctor']['time'] = json_encode($data['doctor']['time']);
		$data['doctor']['weekly'] = json_encode($weekly_holiday);
		$data['doctor']['national'] = json_encode($data['doctor']['national']);

		$data['doctor']['priority'] = !empty($data['doctor']['priority']) ? $data['doctor']['priority'] : 99999;
		$data['doctor']['user_role'] = 3;

		$data['doctor']['datetime'] = date('Y-m-d H:i:s');
		
		if (!empty($data['doctor']['id'])) {
			$this->model_doctor->updateDoctor($data['doctor']);
			$this->model_user->updateUser($data['doctor']);

			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Doctor updated successfully.');
			$this->url->redirect('doctor/edit&id='.$data['doctor']['id']);
		} else {
			$data['doctor']['hash'] = md5(uniqid(mt_rand(), true));
			if ($validate_field = $this->validatePassword($data['doctor'])) {
				$this->session->data['message'] = array('alert' => 'error', 'value' => implode(", ",$validate_field));
				$this->url->redirect('doctor/add');
			}
			
			$data['doctor']['password'] = password_hash($data['doctor']['password'], PASSWORD_DEFAULT);
			$data['doctor']['user_id'] = $this->model_user->createUser($data['doctor']);
			$result = $this->model_doctor->createDoctor($data['doctor']);

			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Doctor created successfully.');
			$this->url->redirect('doctor/edit&id='.$result);
		}
	}

	public function indexDelete()
	{
		$this->load->controller('common');
		if ($this->controller_common->validateToken($this->url->post('_token'))) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			$this->url->redirect('doctors');
		}
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id')) ) {
			$this->url->redirect('doctors');
		}

		$this->load->model('doctor');
		$result = $this->model_doctor->getDoctor($this->url->post('id'));
		$this->model_doctor->deleteUser($result['user_id']);
		$this->model_doctor->deleteDoctor($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Doctor deleted successfully.');
		$this->url->redirect('doctors');
	}

	public function searchDoctor()
	{
		$data = $this->url->get;
		$this->load->model('doctor');
		$result = $this->model_doctor->getSearchedDoctor($data['term']);
		echo json_encode($result);
	}

	protected function validateField($data)
	{
		$error = [];
		$error_flag = false;
		if ( $this->controller_common->validateText($data['doctor']['firstname'])) {
			$error_flag = true;
			$error['fname'] = 'Please enter valid first name!';
		}

		if ( $this->controller_common->validateText($data['doctor']['lastname'])) {
			$error_flag = true;
			$error['fname'] = 'Please enter valid last name!';
		}

		if ($this->controller_common->validateEmail($data['doctor']['mail'])) {
			$error_flag = true;
			$error['email'] = 'Please enter valid email address!';
		}

		if ($this->controller_common->validatePhoneNumber($data['doctor']['mobile'])) {
			$error_flag = true;
			$error['mobile'] = 'Please enter valid Mobile Number!';
		}

		if ($this->controller_common->validateNumeric($data['doctor']['department'])) {
			$error_flag = true;
			$error['department'] = 'Please enter valid Mobile Number!';
		}

		if (!empty($data['doctor']['dob'])) {
			if ($this->controller_common->validateDate( $data['doctor']['dob'], $data['info']['date_format'] )) {
				$error_flag = true;
				$error['date'] = 'Date of Birth';
			}
		}
		if (!empty($data['doctor']['social']['facebook'])) {
			if ( $facebook = $this->controller_common->validateUrl($data['doctor']['social']['facebook']) ) {
				$error_flag = true;
				$error['facebook'] = 'Please enter valid facebook address!';
			}
		}
		if (!empty($data['doctor']['social']['twitter'])) {
			if ( $twitter = $this->controller_common->validateUrl($data['doctor']['social']['twitter']) ) {
				$error_flag = true;
				$error['twitter'] = 'Please enter valid twitter address!';
			}
		}
		if (!empty($data['doctor']['social']['google'])) {
			if ( $google = $this->controller_common->validateUrl($data['doctor']['social']['google']) ) {
				$error_flag = true;
				$error['google'] = 'Please enter valid google address!';
			}
		}
		if (!empty($data['doctor']['social']['instagram'])) {
			if ( $instagram = $this->controller_common->validateUrl($data['doctor']['social']['instagram']) ) {
				$error_flag = true;
				$error['instagram'] = 'Please enter valid instagram address!';
			}
		}

		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
	/**
	* Validate Register data on server side
	* Validation is also done on client side (Using html5 and javascripts)
	**/
	protected function validatePassword($data)
	{
		$error = [];
		$error_flag = false;
		if (strlen($data['password']) < 6) {
			$error_flag = true;
			$error['password'] = 'Minimum 6 characters required for password!';
		} elseif ($data['cpassword'] != $data['password']) {
			$error_flag = true;
			$error['cpassword'] = 'Both password does not match!';
		}

		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}