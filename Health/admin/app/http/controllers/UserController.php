<?php

/**
* User Controller
*/
class UserController extends Controller
{
	/**
	* User index method
	* This method will be called on User list view
	**/
	public function index()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Get all User data from DB using User model 
		**/
		$this->load->model('user');
		$data['result'] = $this->model_user->allUsers();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = 'Users';
		$data['page_add'] = $this->user_agent->hasPermission('user/add') ? true : false;
		$data['page_edit'] = $this->user_agent->hasPermission('user/edit') ? true : false;
		$data['page_delete'] = $this->user_agent->hasPermission('user/delete') ? true : false;
		
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action_delete'] = URL_ADMIN.DIR_ROUTE.'user/delete';
		/*Render User list view*/
		$this->response->setOutput($this->load->view('user/user_list', $data));
	}
	/**
	* User index add method
	* This method will be called on User add
	**/
	public function indexAdd()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/* Set empty data to array */
		$data['result'] =  NULL;
		$this->load->model('user');
		$data['roles'] = $this->model_user->getUserRoles();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = 'Add User';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'user/add';
		/*Render User add view*/
		$this->response->setOutput($this->load->view('user/user_form', $data));
	}
	/**
	* User index edit method
	* This method will be called on User edit view
	**/
	public function indexEdit()
	{
		/**
		* Check if id exist in url if not exist then redirect to User list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id) || $id == 1) {
			$this->url->redirect('users');
		}
		/**
		* Call getUser method from User model to get data from DB for single User
		* If User does not exist then redirect it to User list view
		**/
		$this->load->model('user');
		$data['result'] = $this->model_user->getUser($id);
		
		if (!$data['result']) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'User does not exist in database!');
			$this->url->redirect('users');
		}
		$data['result']['address'] = json_decode($data['result']['address'], true);
		$data['roles'] = $this->model_user->getUserRoles();

		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/*Create data array to pass to view*/
		$data['page_title'] = 'Edit User';
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'user/edit';
		/*Render User edit view*/
		$this->response->setOutput($this->load->view('user/user_form', $data));
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
			$this->url->redirect('users');
		}
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		$data = $this->url->post;
		
		$this->load->model('commons');
		$data['info'] = $this->model_commons->getSiteInfo();

		$this->load->controller('common');
		if ($validate_field = $this->validateField($data)) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter/select valid '.implode(", ",$validate_field).'!');
			if (!empty($data['user']['user_id'])) {
				$this->url->redirect('user/edit&id='.$data['user']['user_id']);
			} else {
				$this->url->redirect('user/add');
			}
		}

		$this->load->model('user');
		/**
		* Check if @user_name already exist or not in database
		**/
		$check_user = $this->model_user->checkUserName($data['user']['user_name'], $data['user']['user_id']);
		if ($check_user >= 1) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'User Name '.$data['user']['user_name'].' already exist in database.');
			if (!empty($data['user']['user_id'])) {
				$this->url->redirect('user/edit&id='.$data['user']['user_id']);
			} else {
				$this->url->redirect('user/add');
			}
		}
		/**
		* Check if @email already exist or not in database
		**/
		if ($this->model_user->checkUserEmail($data['user']['mail'], $data['user']['user_id']) >= 1) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Email ' . $data['user']['mail'] . ' already exist in database.');
			if (!empty($data['user']['user_id'])) {
				$this->url->redirect('user/edit&id='.$data['user']['user_id']);
			} else {
				$this->url->redirect('user/add');
			}
		}

		if (!empty($data['user']['dob'])) {
			$data['user']['dob'] = DateTime::createFromFormat($data['info']['date_format'], $data['user']['dob'])->format('Y-m-d');
		} else {
			$data['user']['dob'] = '';
		}
		
		$data['user']['address'] = json_encode($data['user']['address']);
		$data['user']['datetime'] = date('Y-m-d H:i:s');
		if (!empty($data['user']['user_id'])) {
			$this->model_user->updateUser($data['user']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Account updated successfully.');
		} else {
			$data['user']['hash'] = md5(uniqid(mt_rand(), true));
			$data['user']['password'] = password_hash($data['user']['password'], PASSWORD_DEFAULT);
			$data['user']['user_id'] = $this->model_user->createUser($data['user']);
			$this->userMail($data['user']['user_id']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Account created successfully.');
		}
		$this->url->redirect('user/edit&id='.$data['user']['user_id']);
	}
	/**
	* User index delete method
	* This method will be called on blog delete action
	**/
	public function indexDelete()
	{	
		$this->load->controller('common');
		if ($this->controller_common->validateToken($this->url->post('_token'))) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			$this->url->redirect('users');
		}

		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id')) ) {
			$this->url->redirect('users');
		}

		$this->load->model('user');
		$result = $this->model_user->deleteUser($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Account deleted successfully.');
		$this->url->redirect('users');
	}

	public function userMail($id)
	{
		$this->load->controller('mail');
		$result = $this->controller_mail->getTemplate('newuser');
		
		if (empty($result['template']) || $result['template']['status'] == '0') {
			return false;
		}
		$user = $this->model_user->getUser($id);
		$link = '<a href="'.URL_ADMIN.'">Click Here</a>';
		
		$result['template']['message'] = str_replace('{name}', $user['firstname'], $result['template']['message']);
		$result['template']['message'] = str_replace('{email}', $user['email'], $result['template']['message']);
		$result['template']['message'] = str_replace('{username}', $user['user_name'], $result['template']['message']);
		$result['template']['message'] = str_replace('{login_url}', $link, $result['template']['message']);
		$result['template']['message'] = str_replace('{clinic_name}', $result['common']['name'], $result['template']['message']);
		
		$data['name'] = $user['firstname'].' '.$user['lastname'];
		$data['email'] = $user['email'];
		$data['subject'] = $result['template']['subject'];
		$data['message'] = $result['template']['message'];
		
		return $this->controller_mail->sendMail($data);
	}

	/**
	* Validate user field from server side
	**/
	protected function validateField($data)
	{
		$error = [];
		$error_flag = false;
		if ($this->controller_common->validateText($data['user']['user_name'])) {
			$error_flag = true;
			$error['username'] = 'User Name';
		}
		if ($this->controller_common->validateText($data['user']['firstname'])) {
			$error_flag = true;
			$error['firstname'] = 'First Name';
		}
		if ($this->controller_common->validateText($data['user']['lastname'])) {
			$error_flag = true;
			$error['lastname'] = 'Last Name';
		}
		if (!empty($data['dob'])) {
			if ($this->controller_common->validateDate( $data['user']['dob'], $data['info']['date_format'] )) {
				
				$error_flag = true;
				$error['date'] = 'Date of Birth';
			}
		}
		if ($this->controller_common->validateEmail($data['user']['mail'])) {
			$error_flag = true;
			$error['email'] = 'Email Address';
		}
		if ($this->controller_common->validatePhoneNumber($data['user']['mobile'])) {
			$error_flag = true;
			$error['mobile'] = 'Mobile Number';
		}
		
		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}

	protected function random_str($length, $keyspace = '0123456789@#$%&*abcdefghijklmnopqrstuvwxyz@#$%&*ABCDEFGHIJKLMNOPQRSTUVWXYZ') 
	{
		$str = '';
		$max = mb_strlen($keyspace, '8bit') - 1;
		for ($i = 0; $i < $length; ++$i) { $str .= $keyspace[random_int(0, $max)];}
			return $str;
	}

	public function userRole()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		$this->load->model('user');
		$data['result'] = $this->model_user->getRoles();

		$data['page_title'] = 'User Roles';

		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action_delete'] = URL_ADMIN.DIR_ROUTE.'role/delete';
		/*Render User list view*/
		$this->response->setOutput($this->load->view('user/user_role', $data));
	}

	public function userRoleAdd()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		$data['result'] = NULL;
		$data['role'] = $this->roleList();
		$data['role_selected'] = array();

		$data['page_title'] = 'New User Role';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'role/add';
		/*Render User list view*/
		$this->response->setOutput($this->load->view('user/user_role_form', $data));
	}

	public function userRoleEdit()
	{
		/**
		* Check if id exist in url if not exist then redirect to User list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('role');
		}

		if ($id == "1") {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'You can not change Admin role setting.');
			$this->url->redirect('role');
		}
		$this->load->model('user');
		$data['result'] = $this->model_user->getRole($id);
		$data['role'] = $this->roleList();

		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		
		$data['role_selected'] = json_decode($data['result']['permission'], true);
		
		$data['page_title'] = 'Edit User Role';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'role/edit';
		/*Render User list view*/
		$this->response->setOutput($this->load->view('user/user_role_form', $data));
	}

	public function userRoleAction()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('role');
			exit();
		}
		$data = $this->url->post;

		$this->load->controller('common');
		if ($this->controller_common->validateToken($data['_token'])) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			$this->url->redirect('role');
		}

		if ($validate_field = $this->validateRoleField($data)) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			if (!empty($data['blog']['id'])) {
				$this->url->redirect('role/edit&id='.$data['blog']['id']);
			} else {
				$this->url->redirect('role/add');
			}
		}
		
		$this->load->model('user');
		
		if (!empty($data['id'])) {
			$data['role'] = json_encode($data['role']);
			$result = $this->model_user->updateUserRole($data);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'User role updated successfully.');
		} else {
			$data['role'] = json_encode($data['role']);
			$result = $this->model_user->addUserRole($data);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'User role created successfully.');
		}
		$this->url->redirect('role');
	}

	public function userRoleDelete()
	{
		$this->load->controller('common');
		if ($this->controller_common->validateToken($this->url->post('_token'))) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			$this->url->redirect('role');
		}

		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id')) ) {
			$this->url->redirect('role');
		}
		$this->load->model('user');
		$result = $this->model_user->deleteRole($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'User Role deleted successfully.');
		$this->url->redirect('role');
	}

	protected function validateRoleField($data)
	{
		$error = [];
		$error_flag = false;
		if ($this->controller_common->validateText($data['name'])) {
			$error_flag = true;
			$error['username'] = 'User Role Name';
		}

		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}

	private function roleList()
	{
		$data = array(
			'Dashboard' => array('dashboard' => 'Dashboard',
				'dashbaordappointment' => 'Calendar Appointment',
				'1' => '',
				'2' => '',
				'3' => ''),
			'Patient' => array('patients' => 'Patient List',
				'patient/add' => 'Patient Add',
				'patient/edit' => 'Patient Edit',
				'patient/delete' => 'Patient Delete',
				'patient/view' => 'Patient View'),
			'Patient Other' => array('patient/notes' => 'Patient Clinical Notes',
				'patients/documents' => 'Paitent Documents',
				'patient/sendmail' => 'Patient Sendmail',
				'3' => '',
				'4' => ''),
			'Appointment' => array('appointments' => 'Appointment List',
				'appointment/add' => 'Appointment Add',
				'appointment/edit' => 'Appointment Edit',
				'appointment/delete' => 'Appointment Delete',
				'appointment/view' => 'Appointment View'),
			'Appointment Other' => array('appointment/sendmail' => 'Appointment Sendmail',
				'appointment/notes' => 'Appointment Clinical Notes',
				'appointment/documents' => 'Appointment Documents',
				'report/reportUpload' => 'Document Upload',
				'report/removeReport' => 'Document Remove'),
			'Prescription' => array('prescriptions' => 'Prescription List',
				'prescription/add' => 'Prescription Add',
				'prescription/edit' => 'Prescription Edit',
				'prescription/delete' => 'Prescription Delete',
				'prescription/view' => 'Prescription View'),
			'Prescription Other' => array('prescription/pdf' => 'Prescription PDF',
				'1' => '',
				'2' => '',
				'3' => '',
				'4' => ''),
			'Invoice' => array('invoices' => 'Invoice List',
				'invoice/add' => 'Invoice Add',
				'invoice/edit' => 'Invoice Edit',
				'invoice/delete' => 'Invoice Delete',
				'invoice/view' => 'Invoice View'),
			'Invoice Other' => array('invoice/pdf' => 'Invoice PDF',
				'invoice/sentmail' => 'Invoice Sendmail',
				'addpayment' => 'Add Payment',
				'1' => '',
				'2' => ''),
			'Request' => array('request' => 'Request List',
				'request/edit' => 'Request Edit',
				'request/delete' => 'Request Delete',
				'request/view' => 'Request View',
				'request/mail' => 'Request Send Mail',),
			'POS/Bill' => array('medicine/billing' => 'POS/Bill List',
				'medicine/billing/add' => 'Bill Add',
				'medicine/billing/edit' => 'Bill Edit',
				'medicine/billing/delete' => 'Bill Delete',
				'medicine/billing/view' => 'Bill View'),
			'POS/Bill Other' => array('medicine/billing/pdf' => 'Bill PDF/Print',
				'1' => '',
				'2' => '',
				'3' => '',
				'4' => ''),
			'Purchase' => array('medicine/purchase' => 'Purchase List',
				'medicine/purchase/add' => 'Purchase Add',
				'medicine/purchase/edit' => 'Purchase Edit',
				'medicine/purchase/delete' => 'Purchase Delete',
				'medicine/purchase/view' => 'Purchase View'),
			'Purchase Other' => array('medicine/purchase/pdf' => 'Purchase PDF/Print',
				'1' => '',
				'2' => '',
				'3' => '',
				'4' => ''),
			'Stock adjustment' => array('medicine/stock' => 'Stock List',
				'medicine/stock/delete' => 'Stock Delete',
				'1' => '',
				'2' => '',
				'3' => ''),
			'Medicine' => array('medicines' => 'Medicine List',
				'medicine/add' => 'Medicine Add',
				'medicine/edit' => 'Medicine Edit',
				'medicine/delete' => 'Medicine Delete',
				'medicine/view' => 'Medicine View'),
			'Medicine Other' => array('medicine/upload' => 'Medicine Upload',
				'1' => '',
				'2' => '',
				'3' => '',
				'4' => ''),
			'Medicine Category' => array('medicine/category' => 'Medicine Category List',
				'medicine/category/add' => 'Medicine Category Add',
				'medicine/category/edit' => 'Medicine Category Edit',
				'medicine/category/delete' => 'Medicine Category Delete',
				'1' => ''),
			'Department' => array('departments' => 'Department List',
				'department/add' => 'Department Add',
				'department/edit' => 'Department Edit',
				'department/delete' => 'Department Delete',
				'1' => ''),
			'Doctor' => array('doctors' => 'Doctor List',
				'doctor/add' => 'Doctor Add',
				'doctor/edit' => 'Doctor Edit',
				'doctor/delete' => 'Doctor Delete',
				'1' => ''),
			'Expenses' => array('expenses' => 'Expense List',
				'expense/add' => 'Expense Add',
				'expense/edit' => 'Expense Edit',
				'expense/delete' => 'Expense Delete',
				'1' => ''),
			'Expenses Type' => array('expensetype' => 'Expenses Type List',
				'expensetype/add' => 'Expenses Type Add',
				'expensetype/edit' => 'Expenses Type Edit',
				'expensetype/delete' => 'Expenses Type Delete',
				'1' => ''),
			'Attendance' => array('staffattendance' => 'Attendance List',
				'staffattendance/add' => 'Attendance Add',
				'staffattendance/view' => 'Attendance View',
				'1' => '',
				'2' => ''),
			'Salarytemplate' => array('salarytemplate' => 'Salary Template List',
				'salarytemplate/add' => 'Salary Template Add',
				'salarytemplate/edit' => 'Salary Template Edit',
				'salarytemplate/delete' => 'Salary Template Delete',
				'1' => ''),
			'Manage Salary' => array('managesalary' => 'Manage Salary List',
				'managesalary/add' => 'Manage Salary Add',
				'managesalary/edit' => 'Manage Salary Edit',
				'managesalary/view' => 'Manage Salary View',
				'1' => ''),
			'Payment history' => array('managesalary/history' => 'Payment history List',
				'managesalary/history/view' => 'Payment View',
				'managesalary/history/delete' => 'Payment Delete',
				'managesalary/history/pdf' => 'Payment PDF',
				'1' => ''),
			'Make Payment' => array('makepayment' => 'Make payment List',
				'makepayment/add' => 'Make Payment Add',
				'1' => '',
				'2' => '',
				'3' => ''),
			'Birthrecords' => array('birthrecords' => 'Birthrecords List',
				'birthrecord/add' => 'Birthrecord Add',
				'birthrecord/edit' => 'Birthrecord Edit',
				'birthrecord/delete' => 'Birthrecord Delete',
				'birthrecord/view' => 'Birthrecord View'),
			'Birthrecords Other' => array('birthrecord/pdf' => 'Birthrecord PDF/Print',
				'1' => '',
				'2' => '',
				'3' => '',
				'4' => ''),
			'Deathrecords' => array('deathrecords' => 'Deathrecords List',
				'deathrecord/add' => 'Deathrecord Add',
				'deathrecord/edit' => 'Deathrecord Edit',
				'deathrecord/delete' => 'Deathrecord Delete',
				'deathrecord/view' => 'Deathrecord View'),
			'Deathrecords Other' => array('deathrecord/pdf' => 'Deathrecords PDF/Print',
				'1' => '',
				'2' => '',
				'3' => '',
				'4' => ''),
			'Noticeboard' => array('noticeboard' => 'Noticeboard List',
				'noticeboard/add' => 'Noticeboard Add',
				'noticeboard/edit' => 'Noticeboard Edit',
				'noticeboard/delete' => 'Noticeboard Delete',
				'noticeboard/view' => 'Noticeboard View'),
			'User' => array('users' => 'User List',
				'user/add' => 'User Add',
				'user/edit' => 'User Edit',
				'user/delete' => 'User Delete',
				'1' => ''),
			'Subscriber' => array('subscribers' => 'Subscriber List',
				'subscriber/add' => 'Subscriber Add',
				'subscriber/edit' => 'Subscriber Edit',
				'subscriber/delete' => 'Subscriber Delete',
				'1' => ''),
			'Page' => array('pages' => 'Page List',
				'page/add' => 'Page Add',
				'page/edit' => 'Page Edit',
				'page/delete' => 'Page Delete',
				'1' => ''),
			'Other Pages' => array('page/menu' => 'Web Menu',
				'page/footer' => 'Web Footer',
				'page/theme' => 'Web Theme',
				'page/settings' => 'Web Settings',
				'1' => ''),
			'Facility' => array('facility' => 'Facility List',
				'facility/add' => 'Facility Add',
				'facility/edit' => 'Facility Edit',
				'facility/delete' => 'Facility Delete',
				'1' => ''),
			'Service' => array('services' => 'Service List',
				'service/add' => 'Service Add',
				'service/edit' => 'Service Edit',
				'service/delete' => 'Service Delete',
				'1' => ''),
			'Review' => array('reviews' => 'Review List',
				'review/edit' => 'Review Edit',
				'review/delete' => 'Review Delete',
				'1' => '',
				'2' => ''),
			'Testimonial' => array('testimonials' => 'Testimonial List',
				'testimonial/add' => 'Testimonial Add',
				'testimonial/edit' => 'Testimonial Edit',
				'testimonial/delete' => 'Testimonial Delete',
				'1' => ''),
			'Blog' => array('blogs' => 'Blog List',
				'blog/add' => 'Blog Add',
				'blog/edit' => 'Blog Edit',
				'blog/delete' => 'Blog Delete',
				'1' => ''),
			'Category' => array('category' => 'Category List',
				'category/add' => 'Category Add',
				'category/edit' => 'Category Edit',
				'category/delete' => 'Category Delete',
				'1' => ''),
			'Comment' => array('comment' => 'Comment List',
				'comment/edit' => 'Comment Edit',
				'comment/delete' => 'Comment Delete',
				'1' => '',
				'2' => '',),
			'System Info' => array('info' => 'System Info',
				'1' => '',
				'2' => '',
				'3' => '',
				'4' => ''),
			'Taxes' => array('tax' => 'Taxes List',
				'tax/add' => 'Taxes Add',
				'tax/edit' => 'Taxes Edit',
				'tax/delete' => 'Taxes Delete',
				'1' => ''),
			'Payment Method' => array('paymentmethod' => 'Payment Methods',
				'paymentmethod/add' => 'Payment Method Add',
				'paymentmethod/edit' => 'Payment Method Edit',
				'paymentmethod/delete' => 'Payment Method Delete',
				'1' => ''),
			'Payment Gateway' => array('paymentgateway' => 'Payment Gateway',
				'1' => '',
				'2' => '',
				'3' => '',
				'4' => ''),
			'Clinical Notes' => array('notes' => 'Clinical Notes List',
				'note/add' => 'Clinical Note Add',
				'note/edit' => 'Clinical Note Edit',
				'note/delete' => 'Clinical Note Delete',
				'1' => ''),
			'Invoice Items' => array('items' => 'Items List',
				'item/add' => 'Items Add',
				'item/edit' => 'Items Edit',
				'item/delete' => 'Items Delete',
				'1' => ''),
			'Mail' => array('send/email' => 'Send Email',
				'sendbulk/email' => 'Send Bulk Email',
				'emaillogs' => 'Email Log',
				'emailsetting' => 'Email Settings',
				'emailtemplate' => 'Email Template'),
			'Media' => array('get/media' => 'Media on Modal',
				'media/upload' => 'Media Upload',
				'media/delete' => 'Media Delete',
				'upload/gallery' => 'Gallery Upload',
				'gallery/delete' => 'Gallery Delete'));

		return $data;
	}
}