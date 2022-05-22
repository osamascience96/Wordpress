<?php

/**
* User Controller
*/
class UserController extends Controller {
	/**
	* User controller construct method 
	* it will also called it's parent construct method
	**/
	private $user_id;

	public function dashboard()
	{
		if (!$this->user_agent->isLogged()) {
			$this->url->redirect('login');
		}
		/**
		* Get service page data from DB
		**/
		$this->load->model('user');
		$this->load->controller('common');
		$data = array();
		$data = array_merge($data, $this->controller_common->index());

		$data['page']['meta_tag'] = 'Dashboard | ' .$data['siteinfo']['name'];
		$data['page']['meta_description'] = 'Dashboard, '.$data['siteinfo']['name'];
		$data['page']['page_title'] = 'Dashboard';
		$data['page']['page_section'] = false;

		$data['page']['breadcrumbs'] = array();
		$data['page']['breadcrumbs'][] = array(
			'label' => $data['lang']['text_home'],
			'link' => URL.DIR_ROUTE.'home',
		);
		$data['page']['breadcrumbs'][] = array(
			'label' => $data['page']['page_title'],
			'link' => '#',
		);

		$data['header'] = $this->controller_common->getHeader($data['page'], 'header-5');
		$data['footer'] = $this->controller_common->getFooter(NULL, 'footer-1');
		$data['active'] = 'dashboard';
		$data['title'] = 'Dashboard';
		$data['user_page'] = $this->load->view('user/dashboard', $data);

		/**
		* Load my appointment view
		* Pass data to view
		**/
		//$this->view->render('user/appointment.tpl', $data);
		$this->response->setOutput($this->load->view('user/user_main', $data));
	}

	public function getAppointments() 
	{
		if (!$this->user_agent->isLogged()) {
			$this->url->redirect('login');
		}
		
		/**
		* Get service page data from DB
		**/
		$this->load->model('user');
		$this->load->controller('common');
		$data = array();
		$data = array_merge($data, $this->controller_common->index());
		$data['page']['page_title'] = $data['lang']['text_appointments'];
		$data['page']['meta_tag'] = $data['page']['page_title'].' | ' .$data['siteinfo']['name'];
		$data['page']['meta_description'] = $data['page']['page_title']. ' , '.$data['siteinfo']['name'];
		
		$data['page']['page_section'] = false;

		$data['page']['breadcrumbs'] = array();
		$data['page']['breadcrumbs'][] = array(
			'label' => $data['lang']['text_home'],
			'link' => URL.DIR_ROUTE.'home',
		);
		$data['page']['breadcrumbs'][] = array(
			'label' => $data['page']['page_title'],
			'link' => '#',
		);

		$data['header'] = $this->controller_common->getHeader($data['page'], 'header-5');
		$data['footer'] = $this->controller_common->getFooter(NULL, 'footer-1');

		$data['appointments'] = $this->model_user->getAppointment($data['user']['email'], $this->session->data['user_id']);

		$data['active'] = 'appointments';
		$data['title'] = $data['page']['page_title'];
		$data['user_page'] = $this->load->view('user/appointments', $data);

		/**
		* Load my appointment view
		* Pass data to view
		**/
		//$this->view->render('user/appointment.tpl', $data);
		$this->response->setOutput($this->load->view('user/user_main', $data));
	}

	public function getAppointment()
	{
		if (!$this->user_agent->isLogged()) {
			$this->url->redirect('login');
		}

		$id = $this->url->get('id');
		if (empty($id)) {
			$this->url->redirect('user/appointments');
		}
		/**
		* Get service page data from DB
		**/
		$this->load->model('user');
		$this->load->controller('common');
		
		$data = array();
		$data = array_merge($data, $this->controller_common->index());

		$data['appointment'] = $this->model_user->getAppointmentView($data['user']['email'], $this->session->data['user_id'], $id);
		if (empty($data['appointment'])) {
			$this->url->redirect('user/appointment');
		}
		$data['appointment']['notes'] = $this->model_user->getClinicalNotes($id);
		
		if (!empty($data['appointment']['notes'])) {
			$data['appointment']['notes'] = json_decode($data['appointment']['notes']['notes'], true);	
		}
		
		
		$data['page']['page_title'] = $data['lang']['text_appointment'].' '.$data['lang']['text_view'];
		$data['page']['meta_tag'] = $data['page']['page_title'].' | ' .$data['siteinfo']['name'];
		$data['page']['meta_description'] = $data['page']['page_title'].', '.$data['siteinfo']['name'];
		
		$data['page']['breadcrumbs'] = array();
		$data['page']['breadcrumbs'][] = array(
			'label' => $data['lang']['text_home'],
			'link' => URL.DIR_ROUTE.'home',
		);
		$data['page']['breadcrumbs'][] = array(
			'label' => 'My Appointments',
			'link' => URL.DIR_ROUTE.'user/appointment',
		);
		$data['page']['breadcrumbs'][] = array(
			'label' => $data['page']['page_title'],
			'link' => '#',
		);

		$footer['script'] = "<script>$('a.record-pdf').fancybox({
			'frameWidth': 800,
			'frameHeight': 800,
			'overlayShow': true,
			'hideOnContentClick': false,
			'type': 'iframe'
		});</script>";

		$data['header'] = $this->controller_common->getHeader($data['page'], 'header-5');
		$data['footer'] = $this->controller_common->getFooter($footer, 'footer-1');

		$data['prescription'] = $this->model_user->getAppointmentPrescription($data['user']['email'], $id);
		$data['reports'] = $this->model_user->getReports($id);

		$data['active'] = 'appointments';
		$data['title'] = $data['page']['page_title'];
		$data['user_page'] = $this->load->view('user/appointment', $data);

		$data['fancybox'] = 1;
		/**
		* Load my appointment view
		* Pass data to view
		**/
		//$this->view->render('user/appointment_view.tpl', $data);
		$this->response->setOutput($this->load->view('user/user_main', $data));
	}

	public function getPrescription()
	{
		if (!$this->user_agent->isLogged()) {
			$this->url->redirect('login');
		}

		$id = $this->url->get('id');
		if (empty($id)) {
			$this->url->redirect('user/appointments');
		}
		
		$this->load->controller('common');
		$data = array();
		$data = array_merge($data, $this->controller_common->index());
		$common = $data['siteinfo'];
		$this->load->model('user');
		/**
		* Intilize User Model
		* Get prescription from DB
		**/
		$data['user']['user_id'] = $this->session->data['user_id'];
		$result = $this->model_user->getPrescription($data['user'], $id);
		if (empty($result)) {
			$this->url->redirect('user/records');
		}
		$result['prescription'] = json_decode($result['prescription'], true);

		$meta_title = 'Prescription';
		
		ob_start();
		if (!empty($common['prescription_template'])) {
			include DIR_ADMIN.'app/views/prescription/prescription_pdf_'.(int)$common['prescription_template'].'.tpl.php';
		} else {
			include DIR_ADMIN.'app/views/prescription/prescription_pdf_1.tpl.php';
		}
		
		$data['html'] = ob_get_clean();
		
		if(ob_get_length() > 0) {
			ob_end_flush();
		}

		$pdf = new PDF();
		$pdf->createPDF($data);
	}
	/**
	* Request method for my request page
	**/
	public function request()
	{
		if (!$this->user_agent->isLogged()) {
			$this->url->redirect('login');
		}
		/**
		* Get service page data from DB
		**/
		$this->load->model('user');
		$this->load->controller('common');
		$data = array();
		$data = array_merge($data, $this->controller_common->index());

		$data['page']['page_title'] = $data['lang']['text_requests'];
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

		$data['header'] = $this->controller_common->getHeader($data['page'], 'header-5');
		$data['footer'] = $this->controller_common->getFooter(NULL, 'footer-1');

		$data['request'] = $this->model_user->getRequest($data['user']['email'], $this->session->data['user_id']);

		$data['active'] = 'request';
		$data['title'] = $data['page']['page_title'];
		$data['user_page'] = $this->load->view('user/request', $data);
		
		/**
		* Load my appointment view
		* Pass data to view
		**/
		$this->response->setOutput($this->load->view('user/user_main', $data));
	}
	/**
	* Profile method for my profile page
	**/
	public function profile()
	{
		if (!$this->user_agent->isLogged()) {
			$this->url->redirect('login');
		}
		/**
		* Get service page data from DB
		**/
		$this->load->model('user');
		$this->load->controller('common');
		$data = array();
		$data = array_merge($data, $this->controller_common->index());

		$data['page']['page_title'] = $data['lang']['text_profile'];
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

		$data['header'] = $this->controller_common->getHeader($data['page'], 'header-5');
		$data['footer'] = $this->controller_common->getFooter(NULL, 'footer-1');
		$data['user_data'] = $this->model_user->getUserData($this->session->data['user_id']);
		$data['user_data']['history'] = json_decode($data['user_data']['history'], true);
		$data['user_data']['address'] = json_decode($data['user_data']['address'], true);

		$data['history'] = $this->medicalHistoryData();

		$data['action'] = URL.DIR_ROUTE.'user/profile';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);

		$data['active'] = 'profile';
		$data['title'] = $data['page']['page_title'];
		$data['user_page'] = $this->load->view('user/profile', $data);

		if (!empty($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		}
		if (!empty($this->session->data['error'])) {
			$data['error'] = $this->session->data['error'];
			unset($this->session->data['error']);
		}

		$this->response->setOutput($this->load->view('user/user_main', $data));
	}

	public function medicalHistoryData()
	{
		return array(
			'diabetes' => 'Diabetes',
			'high-blood-pressure' => 'High Blood Pressure',
			'high-cholesterol' => 'High Cholesterol',
			'heart-problems' => 'Heart Problems',
			'asthma' => 'Asthma',
			'kidney-disease' => 'Kidney Disease',
			'kidney-stones' => 'Kidney Stones',
			'jaundice' => 'Jaundice',
			'rheumatic-fever' => 'Rheumatic Fever',
			'cancer' => 'Cancer',
			'hiv-aids' => 'HIV/AIDS',
			'epilepsy' => 'Epilepsy',
			'pregnancy' => 'Pregnancy',
			'blood-thinners' => 'Blood Thinners'
		);
	}

	public function profileUpdate()
	{
		if (!$this->validateProfile()) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Please enter valid details in input box!');
			$this->url->redirect('user/profile');
		}

		$token = $this->url->post('_token');
		$token_check = hash('sha512', TOKEN . TOKEN_SALT);
		if (hash_equals($token_check, $token) === false) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Invalid token. Please try again.');
			$this->url->redirect('user/profile');
		}

		$data = $this->url->post;
		$data['user_id'] = $this->session->data['user_id'];

		$this->load->controller('common');
		$common = $this->controller_common->index();
		$data['dob'] = DateTime::createFromFormat($common['siteinfo']['date_format'], $data['dob'])->format('Y-m-d');

		if (!empty($data['history'])) {
			$data['history'] = json_encode($data['history']);
		} else {
			$data['history'] = json_encode(array());
		}
		$data['address'] = json_encode($data['address']);

		$this->load->model('user');
		if ($this->model_user->checkUserEmail($data)) {
			$result = $this->model_user->updateUser($data);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Your Profile updated succefully.');
			$this->url->redirect('user/profile');
		} else {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Please enter valid data in input field.');
			$this->url->redirect('user/profile');
		}
	}
	/**
	* Profile edit method for profile edit page
	**/
	public function changePassword() 
	{
		if (!$this->user_agent->isLogged()) {
			$this->url->redirect('login');
		}
		/**
		* Get service page data from DB
		**/
		$this->load->model('user');
		$this->load->controller('common');
		$data = array();
		$data = array_merge($data, $this->controller_common->index());
		
		$data['page']['page_title'] = $data['lang']['text_change_password'];
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

		$data['header'] = $this->controller_common->getHeader($data['page'], 'header-5');
		$data['footer'] = $this->controller_common->getFooter(NULL, 'footer-1');

		$data['action'] = URL.DIR_ROUTE.'user/profile/password';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);

		$data['active'] = 'change-password';
		$data['title'] = $data['page']['page_title'];
		$data['user_page'] = $this->load->view('user/changepassword', $data);

		if (!empty($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		}
		if (!empty($this->session->data['error'])) {
			$data['error'] = $this->session->data['error'];
			unset($this->session->data['error']);
		}

		$this->response->setOutput($this->load->view('user/user_main', $data));
	}

	public function profileUpdatePassword() 
	{
		if (!$this->validateProfilePassword()) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Please enter valid password in input box.');
			$this->url->redirect('user/profile/password');
		}
		$token = $this->url->post('_token');
		$token_check = hash('sha512', TOKEN . TOKEN_SALT);
		if (hash_equals($token_check, $token) === false) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Invalid token. Please try again.');
			$this->url->redirect('user/profile/password');
		}

		$data = $this->url->post;
		$data['user_id'] = $this->session->data['user_id'];
		$this->load->model('user');
		$user = $this->model_user->getPassword($data);
		
		if (password_verify( $data['old'], $user['password'])) {
			$result = $this->model_user->updatePassword($data);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Account Password updated successfully.');
			$this->url->Redirect('user/profile/password');   
		} else {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Old Password is Wrong.');
			$this->url->Redirect('user/profile/password');
		}
	}

	public function getInvoices()
	{
		if (!$this->user_agent->isLogged()) {
			$this->url->redirect('login');
		}

		/**
		* Get service page data from DB
		**/
		$this->load->model('user');
		$this->load->controller('common');
		$data = array();
		$data = array_merge($data, $this->controller_common->index());

		$data['page']['page_title'] = $data['lang']['text_invoices'];
		$data['page']['meta_tag'] = $data['page']['page_title'].' | ' .$data['siteinfo']['name'];
		$data['page']['meta_description'] = $data['page']['page_title'].', '.$data['siteinfo']['name'];

		$data['invoices'] = $this->model_user->invoices($data['user']['email'], $this->session->data['user_id']);

		$data['header'] = $this->controller_common->getHeader($data['page'], 'header-5');
		$data['footer'] = $this->controller_common->getFooter(NULL, 'footer-1');

		$data['active'] = 'invoices';
		$data['title'] = $data['page']['page_title'];
		$data['user_page'] = $this->load->view('user/invoices', $data);
		/**
		* Load my appointment view
		* Pass data to view
		**/
		$this->response->setOutput($this->load->view('user/user_main', $data));
	}

	public function invoice() 
	{
		if (!$this->user_agent->isLogged()) {
			$this->url->redirect('login');
		}

		$id = $this->url->get('id');
		if (empty($id)) {
			$this->url->redirect('user/invoices');
		}

		$this->load->model('user');
		$this->load->controller('common');
		$data = array();
		$data = array_merge($data, $this->controller_common->index());

		$data['page']['page_title'] = $data['lang']['text_invoice'];
		$data['page']['meta_tag'] = $data['page']['page_title'].' | ' .$data['siteinfo']['name'];
		$data['page']['meta_description'] = $data['page']['page_title'].', '.$data['siteinfo']['name'];

		$this->load->model('user');
		$data['result'] = $this->model_user->getInvoice($id, $data['user']);
		
		if (empty($data['result'])) {
			$this->url->redirect('user/invoices');
		}
		$data['result']['items'] = json_decode($data['result']['items'], true);
		$data['attachments'] = $this->model_user->getAttachments($data['result']['id']);
		$data['payments'] = $this->model_user->getPayments($data['result']['id']);
	
		$data['header'] = $this->controller_common->getHeader($data['page'], 'header-5');
		$data['footer'] = $this->controller_common->getFooter(NULL, 'footer-1');
		
		$data['active'] = 'invoices';
		$data['title'] = $data['page']['page_title'];
		$data['user_page'] = $this->load->view('user/invoice', $data);
		$this->response->setOutput($this->load->view('user/user_main', $data));
	}

	public function invoicePdf()
	{
		if (!$this->user_agent->isLogged()) {
			$this->url->redirect('login');
		}

		$id = $this->url->get('id');
		if (empty($id)) {
			$this->url->redirect('user/invoices');
		}
		
		$this->load->controller('common');
		$data = array();
		$data = array_merge($data, $this->controller_common->index());

		$this->load->model('user');
		$result = $this->model_user->getInvoice($id, $data['user']);
		if (empty($result)) {
			$this->url->redirect('user/invoices');
		}

		$result['info'] = $data['siteinfo'];
		$result['items'] = json_decode($result['items'], true);
		$printInvoice = false;

		ob_start();
		if (!empty($result['info']['invoice_template'])) {
			include DIR_ADMIN.'app/views/invoice/invoice_pdf_'.$data['siteinfo']['invoice_template'].'.tpl.php';
		} else {
			include DIR_ADMIN.'app/views/invoice/invoice_pdf_1.tpl.php';
		}
		$html = ob_get_clean();

		if(ob_get_length() > 0) {
			ob_end_flush();
		}
		$string = array('html' => $html, 'result' => $result);;
		$pdf = new PDF();
		$pdf->createPDF($string);
	}

	public function records()
	{
		if (!$this->user_agent->isLogged()) {
			$this->url->redirect('login');
		}
		/**
		* Get service page data from DB
		**/
		$this->load->model('user');
		$this->load->controller('common');
		$data = array();
		$data = array_merge($data, $this->controller_common->index());
		$data['page']['page_title'] = $data['lang']['text_records'];
		$data['page']['meta_tag'] = $data['page']['page_title']. ' | ' .$data['siteinfo']['name'];
		$data['page']['meta_description'] = $data['page']['page_title'].', '.$data['siteinfo']['name'];
		$data['page']['page_section'] = false;

		$data['page']['breadcrumbs'] = array();
		$data['page']['breadcrumbs'][] = array(
			'label' => $data['lang']['text_home'],
			'link' => URL.DIR_ROUTE.'home',
		);
		$data['page']['breadcrumbs'][] = array(
			'label' => $data['page']['page_title'],
			'link' => '#',
		);
		$footer['script'] = "<script> $('a.record-pdf').fancybox({ 'frameWidth': 800, 'frameHeight': 800, 'overlayShow': true, 'hideOnContentClick': false, 'type': 'iframe' }); $('a.record-image').fancybox();</script>";

		$data['header'] = $this->controller_common->getHeader($data['page'], 'header-5');
		$data['footer'] = $this->controller_common->getFooter($footer, 'footer-1');
		$data['active'] = 'records';
		$data['title'] = $data['page']['page_title'];

		$data['records'] = $this->model_user->getRecords($data['user']['email'], $this->session->data['user_id']);

		$data['user_page'] = $this->load->view('user/records', $data);

		/**
		* Load my appointment view
		* Pass data to view
		**/
		$this->response->setOutput($this->load->view('user/user_main', $data));
	}

	public function recordsPrint()
	{
		if (!$this->user_agent->isLogged()) {
			$this->url->redirect('login');
		}

		$id = $this->url->get('id');
		if (empty($id)) {
			$this->url->redirect('user/records');
		}

		$this->load->controller('common');
		$data = array();
		$data = array_merge($data, $this->controller_common->index());
		$data['user']['user_id'] = $this->session->data['user_id'];
		$this->load->model('user');
		$result = $this->model_user->getSingleRecords($data['user'], $id);
		if (empty($result)) {
			$this->url->redirect('user/records');
		}
		$result['notes'] = json_decode($result['notes'], true);
		$meta_title = 'Clinical Notes';
		if (empty($result['notes'])) {
			$this->url->redirect('user/records');
		}

		$common = $data['siteinfo'];
		
		ob_start();
		include DIR_ADMIN.'app/views/appointment/records_pdf.tpl.php';
		$html = ob_get_clean();

		if(ob_get_length() > 0) {
			ob_end_flush();
		}

		$string = array('html' => $html, 'result' => $result);;
		$pdf = new PDF();
		$pdf->createPDF($string);
	}

	protected function validateProfile() 
	{
		if ((strlen(trim($this->url->post('firstname'))) < 1) || (strlen(trim($this->url->post('firstname'))) > 52)) {
			/** 
			* If Last name is not valid ( min 2 character or max 48 ) 
			* Return false
			**/
			return false;
		} elseif ((strlen(trim($this->url->post('lastname'))) < 1) || (strlen(trim($this->url->post('lastname'))) > 52)) {
			/** 
			* If Last name is not valid ( min 2 character or max 48 ) 
			* Return false
			**/
			return false;
		} elseif ((strlen($this->url->post('email')) > 96) || !filter_var($this->url->post('email'), FILTER_VALIDATE_EMAIL)) {
			/** 
			* If email is not valid
			* Return false
			**/
			return false;
		} else {
			return true;
		}
	}

	public function validateProfilePassword()
	{
		if (strlen($this->url->post('new')) < 6) {
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
			return true;
		}
	}
}