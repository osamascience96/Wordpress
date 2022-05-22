<?php

/**
 * PatientController.php
 */
class PatientController extends Controller
{
	/**
	* patient index method
	* This method will be called on @PatientList view
	**/
	public function index()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Get all Patient data from DB using User model 
		**/
		$this->load->controller('common');
		$data['period']['start'] = $this->url->get('start');
		$data['period']['end'] = $this->url->get('end');

		if (!empty($data['period']['start']) && !empty($data['period']['end']) && !$this->controller_common->validateDate($data['period']['start']) && !$this->controller_common->validateDate($data['period']['end'])) {
			$data['period']['start'] = date_format(date_create($data['period']['start'].'00:00:00'), "Y-m-d H:i:s");
			$data['period']['end'] = date_format(date_create($data['period']['end'].'23:59:59'), "Y-m-d H:i:s");
		} else {
			$data['period']['start'] = date('Y-m-d '.'00:00:00', strtotime("-1 month"));
			$data['period']['end'] = date('Y-m-d '.'23:59:59');
		}

		$this->load->model('patient');
		if ($data['common']['user']['role_id'] == "3" && $data['common']['info']['doctor_access'] == '1') {
			$data['result'] = $this->model_patient->getPatients($data['period'], $data['common']['user']['doctor']);
		} else {
			$data['result'] = $this->model_patient->getPatients($data['period']);
		}

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		/* Set page title */
		$data['page_title'] = 'Patients';
		$data['page_view'] = $this->user_agent->hasPermission('patient/view') ? true : false;
		$data['page_add'] = $this->user_agent->hasPermission('patient/add') ? true : false;
		$data['page_edit'] = $this->user_agent->hasPermission('patient/edit') ? true : false;
		$data['page_delete'] = $this->user_agent->hasPermission('patient/delete') ? true : false;

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action_delete'] = URL_ADMIN.DIR_ROUTE.'patient/delete';

		/*Render User list view*/
		$this->response->setOutput($this->load->view('patient/patient_list', $data));
	}

	public function indexView()
	{
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) { $this->url->redirect('patients'); }

		$this->load->model('patient');
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		if ($data['common']['user']['role_id'] == "3") {
			$data['result'] = $this->model_patient->getPatient($id, $data['common']['user']['doctor']);
		} else {
			$data['result'] = $this->model_patient->getPatient($id);
		}

		if (empty($data['result'])) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Patient does not exist in database!');
			$this->url->redirect('patients');
		}
		$data['result']['history'] = json_decode($data['result']['history'], true);
		$data['result']['address'] = json_decode($data['result']['address'], true);

		$data['page_title'] = 'Patient View';
		$data['page_edit'] = $this->user_agent->hasPermission('patient/edit') ? true : false;
		$data['page_appointments'] = $this->user_agent->hasPermission('appointments') ? true : false;
		$data['appointment_view'] = $this->user_agent->hasPermission('appointment/view') ? true : false;
		$data['appointment_add'] = $this->user_agent->hasPermission('appointment/add') ? true : false;
		$data['page_invoices'] = $this->user_agent->hasPermission('invoices') ? true : false;
		$data['invoice_view'] = $this->user_agent->hasPermission('invoice/view') ? true : false;
		$data['invoice_add'] = $this->user_agent->hasPermission('invoice/add') ? true : false;
		$data['invoice_delete'] = $this->user_agent->hasPermission('invoice/delete') ? true : false;
		$data['page_sendmail'] = $this->user_agent->hasPermission('patient/sendmail') ? true : false;
		$data['page_prescriptions'] = $this->user_agent->hasPermission('prescriptions') ? true : false;
		$data['page_notes'] = $this->user_agent->hasPermission('patient/notes') ? true : false;
		$data['page_documents'] = $this->user_agent->hasPermission('patients/documents') ? true : false;


		$data['history'] = $this->medicalHistoryData();
		if ($data['page_appointments']) {
			$data['appointments'] = $this->model_patient->getAppointments($data['result']);	
		}
		if ($data['page_invoices']) {
			$data['invoices'] = $this->model_patient->getInvoices($data['result']);
		}
		if ($data['page_prescriptions']) {
			$data['prescriptions'] = $this->model_patient->getPrescriptions($data['result']);	
		}
		if ($data['page_notes']) {
			$data['notes'] = $this->model_patient->getClinicalNotes($data['result']);	
		}
		if ($data['page_documents']) {
			$data['reports'] = $this->model_patient->getDocuments($data['result']);	
		}
		
		
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['action'] = URL_ADMIN.DIR_ROUTE.'patient/add';
		$data['doctors'] = $this->model_commons->getAppointmentDoctors();
		$data['action_new_appointment'] = URL_ADMIN.DIR_ROUTE.'appointment/add';

		/*Render User add view*/
		$this->response->setOutput($this->load->view('patient/patient_view', $data));
	}

	public function indexAdd()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		$data['result'] = NULL;
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['history'] = $this->medicalHistoryData();
		
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		
		$data['page_title'] = 'Add Patient';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'patient/add';
		/*Render User add view*/
		$this->response->setOutput($this->load->view('patient/patient_form', $data));
	}

	public function indexEdit()
	{
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) { $this->url->redirect('patients'); }

		$this->load->model('patient');
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		if ($data['common']['user']['role_id'] == "3") {
			$data['result'] = $this->model_patient->getPatient($id, $data['common']['user']['doctor']);
		} else {
			$data['result'] = $this->model_patient->getPatient($id);
		}

		if (empty($data['result'])) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Patient does not exist in database!');
			$this->url->redirect('patients');
		}

		$data['result']['history'] = json_decode($data['result']['history'], true);
		$data['result']['address'] = json_decode($data['result']['address'], true);
		$data['history'] = $this->medicalHistoryData();
		
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['page_title'] = 'Edit Patient';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'patient/edit&id='.$data['result']['id'];
		
		/*Render User add view*/
		$this->response->setOutput($this->load->view('patient/patient_form', $data));
	}

	public function indexAction()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) { $this->url->redirect('patients'); }

		$data = $this->url->post('patient');
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		$this->load->model('commons');
		$data['info'] = $this->model_commons->getSiteInfo();

		$this->load->controller('common');
		if ($validate_field = $this->validateField($data)) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			if (!empty($data['id'])) {
				$this->url->redirect('patient/edit&id='.$data['id']);
			} else {
				$this->url->redirect('patient/add');
			}
		}

		$data['user'] = $this->model_commons->getUserInfo($this->session->data['user_id']);

		if (!empty($data['dob'])) {
			$data['dob'] = DateTime::createFromFormat($data['info']['date_format'], $data['dob'])->format('Y-m-d');
		} else {
			$data['dob'] = '';
		}
		
		$data['address'] = json_encode($data['address']);
		$data['user_id'] = $this->session->data['user_id'];
		
		$this->load->model('patient');
		if (!empty($data['history'])) {
			$data['history'] = json_encode($data['history']);
		} else {
			$data['history'] = json_encode(array());
		}
		
		$data['datetime'] = date('Y-m-d H:i:s');
		if (!empty($data['id'])) {
			if ($this->model_patient->checkPatientEmail($data['mail'], $data['id']) >= 1) {
				$this->session->data['message'] = array('alert' => 'error', 'value' => 'Email  \'' . $this->url->post('email') . '\'  already exist in database.');
				$this->url->redirect('patient/edit&id='.$data['id']);
			}
			$result = $this->model_patient->updatePatient($data);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Patient updated successfully.');
		} else {
			if ($this->model_patient->checkPatientEmail($data['mail']) >= 1) {
				$this->session->data['message'] = array('alert' => 'error', 'value' => 'Email  \'' . $this->url->post('email') . '\'  already exist in database.');
				$this->url->redirect('patient/add');
			}
			$data['hash'] = md5(uniqid(mt_rand(), true));
			$data['id'] = $this->model_patient->createPatient($data);
			if ($data['id']) {
				$this->patientMail($data['id']);
				if ($data['user']['role_id'] == '3') {
					$this->model_patient->createPatientDoctor($data);
				}
			}
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Patient created successfully.');
		}
		$this->url->redirect('patient/view&id='.$data['id']);
	}

	public function patientMail($id)
	{
		$this->load->controller('mail');
		$result = $this->controller_mail->getTemplate('newpatient');
		
		if (empty($result['template']) || $result['template']['status'] == '0') {
			return false;
		}
		$patient = $this->model_patient->getPatient($id);
		
		$link = '<a href="'.URL.DIR_ROUTE.'contact">Click Here</a>';
		$password_link = '<a href="'.URL.DIR_ROUTE.'profile/changepassword&id='.$patient['email'].'&code='.$patient['temp_hash'].'">Create Password</a>';
		$result['template']['message'] = str_replace('{firstname}', $patient['firstname'], $result['template']['message']);
		$result['template']['message'] = str_replace('{name}', $patient['firstname'].' '.$patient['lastname'], $result['template']['message']);
		$result['template']['message'] = str_replace('{email}', $patient['email'], $result['template']['message']);
		$result['template']['message'] = str_replace('{mobile}', $patient['mobile'], $result['template']['message']);
		$result['template']['message'] = str_replace('{password_link}', $password_link, $result['template']['message']);
		$result['template']['message'] = str_replace('{clinic_name}', $result['common']['name'], $result['template']['message']);

		$data['name'] = $patient['firstname'].' '.$patient['lastname'];
		$data['email'] = $patient['email'];
		$data['subject'] = $result['template']['subject'];
		$data['message'] = $result['template']['message'];

		return $this->controller_mail->sendMail($data);
	}

	public function indexDelete()
	{
		$this->load->controller('common');
		if ($this->controller_common->validateToken($this->url->post('_token'))) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			$this->url->redirect('patients');
		}
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id')) ) {
			$this->url->redirect('patients');
		}
		$this->load->model('patient');
		$this->model_patient->deletePatient($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Patient deleted successfully.');
		$this->url->redirect('patients');
	}

	public function indexMail()
	{
		if (!isset($_POST['submit'])) {
			$this->url->redirect('patients');
		}

		$data = $this->url->post;
		$this->load->controller('common');
		$this->load->model('patient');
		$result = $this->model_patient->getPatient($data['mail']['id']);
		if (empty($result)) {
			$this->url->redirect('patients');
		}

		$data['mail']['email'] = $result['email'];
		$data['mail']['name'] = $result['firstname'].' '.$result['lastname'];
		$data['mail']['redirect'] = 'patient/view&id='.$result['id'];
		
		$this->load->controller('Mail');
		$mail_result = $this->controller_mail->sendmail($data['mail']);

		if ($mail_result == 1) {
			$data['mail']['type'] = 'patient';
			$data['mail']['type_id'] = $data['mail']['id'];
			$data['mail']['user_id'] = $this->session->data['user_id'];
			
			$this->controller_mail->createMailLog($data['mail']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Success: Message sent successfully.');
			$this->url->redirect('patient/view&id='.$result['id']);
		} else {
			$this->session->data['message'] = array('alert' => 'error', 'value' => $mail_result);
			$this->url->redirect('patient/view&id='.$result['id']);
		}
	}

	public function searchPatient()
	{
		$data = $this->url->get;
		$this->load->model('patient');
		$result = $this->model_patient->getSearchedPatient($data['term']);
		echo json_encode($result);
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

	public function validateField($data)
	{
		$error = [];
		$error_flag = false;
		if ($this->controller_common->validateText($data['firstname'])) {
			$error_flag = true;
			$error['firstname'] = 'First Name';
		}
		if ($this->controller_common->validateText($data['lastname'])) {
			$error_flag = true;
			$error['lastname'] = 'Last Name';
		}
		if ($this->controller_common->validateEmail($data['mail'])) {
			$error_flag = true;
			$error['email'] = 'Email Address';
		}
		if (!empty($data['dob'])) {
			if ($this->controller_common->validateDate( $data['dob'], $data['info']['date_format'] )) {
				$error_flag = true;
				$error['date'] = 'Date of Birth';
			}
		}

		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}