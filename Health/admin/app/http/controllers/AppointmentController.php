<?php
/**
* Appointment Controller
*/
class AppointmentController extends Controller
{
	public function index()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		
		$this->load->controller('common');
		$data['period']['start'] = $this->url->get('start');
		$data['period']['end'] = $this->url->get('end');

		if (!empty($data['period']['start']) && !empty($data['period']['end']) && !$this->controller_common->validateDate($data['period']['start']) && !$this->controller_common->validateDate($data['period']['end'])) {
			$data['period']['start'] = date_format(date_create($data['period']['start'].'00:00:00'), "Y-m-d H:i:s");
			$data['period']['end'] = date_format(date_create($data['period']['end'].'23:59:59'), "Y-m-d H:i:s");
		} else {
			$data['period']['start'] = date('Y-m-d '.'00:00:00');
			$data['period']['end'] = date('Y-m-d '.'23:59:59');
		}

		$this->load->model('appointment');
		
		if ($data['common']['user']['role_id'] == '3' && $data['common']['info']['doctor_access'] == '1') {
			$data['result'] = $this->model_appointment->getAppointments($data['period'], $data['common']['user']['doctor']);
		} else {
			$data['result'] = $this->model_appointment->getAppointments($data['period']);
		}

		$data['doctors'] = $this->model_commons->getAppointmentDoctors();
		
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['page_title'] = 'Appointments';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action_delete'] = URL_ADMIN.DIR_ROUTE.'appointment/delete';
		$data['delete_msg'] = 'All Docuements and Records Related to this appointment will be deleted.';
		$data['action_new_appointment'] = URL_ADMIN.DIR_ROUTE.'appointment/add';

		$data['page_add'] = $this->user_agent->hasPermission('appointment/add') ? true:false;
		$data['page_view'] = $this->user_agent->hasPermission('appointment/view') ? true:false;
		$data['page_edit'] = $this->user_agent->hasPermission('appointment/edit') ? true:false;
		$data['page_delete'] = $this->user_agent->hasPermission('appointment/delete') ? true:false;
		$data['invoice_add'] = $this->user_agent->hasPermission('invoice/add') ? true:false;
		$data['invoice_view'] = $this->user_agent->hasPermission('invoice/view') ? true:false;

		/*call appointment list view*/
		$this->response->setOutput($this->load->view('appointment/appointment_list', $data));
	}

	public function indexView()
	{
		/**
		* Check if id exist in url if not exist then redirect to list view
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('appointments');
		}
		
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		
		$this->load->model('appointment');
		if ($data['common']['user']['role_id'] == '3') {
			$data['result'] = $this->model_appointment->getAppointmentView($id, $data['common']['user']['doctor']);
		} else {
			$data['result'] = $this->model_appointment->getAppointmentView($id);
		}
		
		if (!$data['result']) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Appointment does not exist in database!');
			$this->url->redirect('appointments');
		}

		$data['page_title'] = 'Appointment View';
		$data['page_add'] = $this->user_agent->hasPermission('appointment/add') ? true:false;
		$data['page_view'] = $this->user_agent->hasPermission('appointment/view') ? true:false;
		$data['page_edit'] = $this->user_agent->hasPermission('appointment/edit') ? true:false;
		$data['page_sendmail'] = $this->user_agent->hasPermission('appointment/sendmail') ? true:false;
		$data['page_delete'] = $this->user_agent->hasPermission('appointment/delete') ? true:false;
		$data['invoice_add'] = $this->user_agent->hasPermission('invoice/add') ? true:false;
		$data['invoice_view'] = $this->user_agent->hasPermission('invoice/view') ? true:false;
		$data['page_notes'] = $this->user_agent->hasPermission('appointment/notes') ? true:false;
		$data['page_documents'] = $this->user_agent->hasPermission('appointment/documents') ? true:false;
		$data['page_prescriptions'] = $this->user_agent->hasPermission('prescriptions') ? true : false;

		$data['notes'] = $this->model_appointment->getClinicalNotes($id);
		if (!empty($data['notes'])) {
			$data['notes']['notes'] = json_decode($data['notes']['notes'], true);
		} else {
			$data['notes'] = NULL;
		}

		$data['doctors'] = $this->model_appointment->getDoctors();
		if ($data['page_prescriptions']) {
			$data['prescription'] = $this->model_appointment->getPrescription($id);
			$data['prescription']['prescription'] = json_decode($data['prescription']['prescription'], true);			
		}
		if ($data['page_documents']) {
			$data['reports'] = $this->model_appointment->getReports($id);
		}
		
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'appointment/edit&id='.$data['result']['id'];
		
		/*Render Blog edit view*/
		$this->response->setOutput($this->load->view('appointment/appointment_view', $data));
	}
	/**
	* Appointment index add method
	* This method will be called on Appointment add
	**/
	public function indexAdd()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		/* Set empty data to array */
		$patient = (int)$this->url->get('patient');
		$this->load->model('appointment');
		if (empty($patient)) {
			$data['result'] = NULL;
		} else {
			$data['result'] = $this->model_appointment->getPatientInfo($patient);
		}
		
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['doctors'] = $this->model_appointment->getDoctors();

		/* Set page title */
		$data['page_title'] = 'Add Appointment';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'appointment/add';
		/*Render Blog add view*/
		$this->response->setOutput($this->load->view('appointment/appointment_add', $data));
	}
	/**
	* Appointment index edit method
	* This method will be called on Appointment edit view
	**/
	public function indexEdit()
	{
		/**
		* Check if id exist in url if not exist then redirect to blog list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('appointments');
		}

		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Call getBlog method from Blog model to get data from DB for single blog
		* If blog does not exist then redirect it to blog list view
		**/
		$this->load->model('appointment');
		if ($data['common']['user']['role_id'] == '3') {
			$data['result'] = $this->model_appointment->getAppointment($id, $data['common']['user']['doctor']);
		} else {
			$data['result'] = $this->model_appointment->getAppointment($id);
		}

		if (!$data['result']) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Appointment does not exist in database!');
			$this->url->redirect('appointments');
		}

		$data['doctors'] = $this->model_appointment->getDoctors();
		$data['prescription'] = $this->model_appointment->getPrescription($id);
		if (!empty($data['prescription'])) {
			$data['prescription']['prescription'] = json_decode($data['prescription']['prescription'], true);
		} else {
			$data['prescription'] = NULL;
		}

		$data['notes'] = $this->model_appointment->getClinicalNotes($id);
		if (!empty($data['notes'])) {
			$data['notes']['notes'] = json_decode($data['notes']['notes'], true);
		} else {
			$data['notes'] = NULL;
		}

		$data['reports'] = $this->model_appointment->getReports($id);
		
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['page_title'] = 'Edit Appointment';
		$data['invoice_add'] = $this->user_agent->hasPermission('invoice/add') ? true:false;
		$data['invoice_view'] = $this->user_agent->hasPermission('invoice/view') ? true:false;
		$data['page_document_upload'] = $this->user_agent->hasPermission('report/reportUpload') ? true:false;
		$data['page_document_remove'] = $this->user_agent->hasPermission('report/removeReport') ? true:false;
		$data['page_notes'] = $this->user_agent->hasPermission('appointment/notes') ? true:false;
		$data['page_documents'] = $this->user_agent->hasPermission('appointment/documents') ? true:false;
		$data['page_prescriptions'] = $this->user_agent->hasPermission('prescriptions') ? true : false;

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'appointment/edit';
		/*Render Blog edit view*/
		$this->response->setOutput($this->load->view('appointment/appointment_form', $data));
	}
	/**
	* Appointment index action method
	* This method will be called on appointment submit/save view
	**/
	public function indexAction()
	{
		/**
		* Validate form input field
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		$data = $this->url->post;

		$this->load->controller('common');
		if ($this->controller_common->validateToken($data['_token'])) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			$this->url->redirect('appointments');
		}

		$this->load->model('commons');
		$data['common'] = $this->model_commons->getSiteInfo();
		$data['appointment']['date'] = DateTime::createFromFormat($data['common']['date_format'], $data['appointment']['date'])->format('Y-m-d');
		
		if ($validate_field = $this->validateField($data['appointment'])) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter/select valid '.implode(", ",$validate_field).'!');
			$this->url->redirect('appointment/edit&id='.$data['appointment']['id']);
		}
		$data['appointment']['datetime'] = date('Y-m-d H:i:s');
		$data['appointment']['user_id'] = $this->session->data['user_id'];

		$this->load->model('appointment');
		if (!empty($data['appointment']['id'])) {
			$result = $this->model_appointment->updateAppointment($data['appointment']);

			$data['prescription']['medicine'] = array_values($data['prescription']['medicine']);
			if (!empty($data['prescription']['medicine'][0]['name']) || !empty($data['prescription']['medicine'][0]['description'])) {
				$data['prescription']['medicine'] = json_encode($data['prescription']['medicine']);
				if (!empty($data['prescription']['id'])) {
					$this->model_appointment->updatePrescription($data);
				} else {
					$this->model_appointment->createPrescription($data);
				}
			}

			if (!empty($data['notes']['notes'])) {
				$data['notes']['notes'] = json_encode($data['notes']['notes']);
				if (!empty($data['notes']['id'])) {
					$this->model_appointment->updateNotes($data);
				} else {
					$this->model_appointment->createNotes($data);
				}
			}
			
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Appointment updated successfully.');
			$this->url->redirect('appointment/view&id='.$data['appointment']['id']);
		}
		$this->url->redirect('appointments');
	}

	public function getMedicine()
	{
		$data = $this->url->get;
		$this->load->model('appointment');
		$result = $this->model_appointment->getSearchedMedicine($data['term']);
		echo json_encode($result);
		exit();
	}

	public function appointmentSidebar()
	{
		$data = $this->url->post;
		$this->load->controller('common');
		if ($this->controller_common->validateToken($data['_token'])) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			$this->url->abs_redirect('dashboard');
		}

		$this->load->model('commons');
		$data['common'] = $this->model_commons->getSiteInfo();
		$data['user'] = $this->model_commons->getUserInfo($this->session->data['user_id']);
		$data['appointment']['date'] = DateTime::createFromFormat($data['common']['date_format'], $data['appointment']['date'])->format('Y-m-d');
		if ($validate_field = $this->validateField($data['appointment'])) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter/select valid '.implode(", ",$validate_field).'!');
			$this->url->abs_redirect($_SERVER['HTTP_REFERER']);
		}

		$data['appointment']['user_id'] = $this->session->data['user_id'];
		$data['appointment']['datetime'] = date('Y-m-d H:i:s');

		$this->load->model('appointment');
		if (!empty($data['appointment']['id'])) {
			$this->model_appointment->updateSideBarAppointment($data['appointment']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Appointment updated successfully.');
		} else {
			$data['appointment']['appointment_id'] = date('Ymd').rand(10,100).date('his');
			$data['appointment']['id'] = $this->model_appointment->createAppointment($data['appointment']);
			if ($data['appointment']['id']) {
				$mail_result = $this->appointmentMail($data['appointment']['id']);
				// if ($data['user']['role_id'] == '3') {
				// 	$this->model_appointment->createPatientDoctor($data);
				// }
				$this->session->data['message'] = array('alert' => 'success', 'value' => 'Appointment created successfully.');
			} else {
				$this->session->data['message'] = array('alert' => 'error', 'value' => 'Appointment does not created. Server Error');
			}
		}

		$this->url->abs_redirect($_SERVER['HTTP_REFERER']);
	}
	/**
	* Appointment index delete method
	* This method will be called on blog delete action
	**/
	public function indexDelete()
	{
		$this->load->controller('common');
		if ($this->controller_common->validateToken($this->url->post('_token'))) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			$this->url->redirect('appointments');
		}
		
		if (!isset($_POST['delete']) || empty($this->url->post('id')) ) {
			$this->url->redirect('appointments');
		}
		$this->load->model('appointment');
		$result = $this->model_appointment->deleteAppointment((int)$this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Appointment deleted successfully.');
		$this->url->redirect('appointments');
	}

	public function indexMail()
	{
		if (!isset($_POST['submit'])) {
			$this->url->redirect('appointments');
		}

		$data = $this->url->post;

		$this->load->controller('common');
		if ($this->controller_common->validateToken($data['_token'])){
			$this->url->redirect('appointments');
		}

		$this->load->model('appointment');
		$result = $this->model_appointment->getAppointment($data['mail']['id']);
		if (empty($result)) {
			$this->url->redirect('appointments');
		}

		$data['mail']['email'] = $result['email'];
		$data['mail']['name'] = $result['name'];
		$data['mail']['redirect'] = 'appointment/view&id='.$result['id'];
		
		$this->load->controller('mail');
		
		$mail_result = $this->controller_mail->sendMail($data['mail']);
		if ($mail_result == 1) {
			$data['mail']['type'] = 'appointment';
			$data['mail']['type_id'] = $data['mail']['id'];
			$data['mail']['user_id'] = $this->session->data['user_id'];
			$this->controller_mail->createMailLog($data['mail']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Success: Message sent successfully.');
			$this->url->redirect('appointment/view&id='.$result['id']);
		} else {
			$this->session->data['message'] = array('alert' => 'error', 'value' => $mail_result);
			$this->url->redirect('appointment/view&id='.$result['id']);
		}
	}

	public function indexAppointment()
	{
		$data = $this->url->post;
		/** 
		* Check if request is POST or not 
		* Validate input field
		**/
		$this->load->controller('common');
		if (!$this->validate($data)) {
			echo '<div class="font-14 text-danger">Please enter valid Doctor and Date.</div>';
			exit();
		}
		
		$this->load->model('appointment');
		if (!$time = json_decode($this->model_appointment->getDoctorTime($data['doctor']), true)) {
			echo '<div class="font-14 text-danger">No slot available.</div>';
			exit();
		}
		
		$slot_html = '<input type="hidden" name="appointment[slot]" value="'.$time[$data['day']]['slot'].'" required>';
		$time_slot = $this->makeSlot($time[$data['day']]);
		$booked_slot = $this->model_appointment->bookedSlot($data['date'], $data['doctor']);
		if (empty($time_slot)) {
			echo '<div class="font-14 text-danger">No slot available.</div>';
			exit();
		}
		$count = 0;
		$booked = '';
		foreach ($time_slot as $key => $time) {
			foreach ($booked_slot as $booked) { if ($time === $booked) { $count++; } }
			if ($count > 0) { $booked = '<span>'.$count.'</span>'; }
			else { $booked = ''; }
			
			$slot_html .= '<div><input type="radio" name="appointment[time]" id="apnt-time-'.$key.'" value="'.$time.'" required><label for="apnt-time-'.$key.'">'.$time.$booked.'</label></div>';
			$count = 0;
			$booked = '';
		}
		echo $slot_html;
		exit();
	}

	public function pdfRecords()
	{
		$id = $this->url->get('id');
		if (empty($id)) {
			$this->url->redirect('appointments');
		}

		if (!$this->user_agent->hasPermission('appointment/records') || !$this->user_agent->hasPermission('patient/notes')) {
			$this->url->redirect('appointments');
		}

		$this->load->model('commons');
		$this->load->model('appointment');

		$result = $this->model_appointment->clinicalNotesPDF($id);
		if (empty($result)) {
			$this->url->redirect('appointments');
		} else {
			$result['notes'] = json_decode($result['notes'], true);
		}
		
		$common = $this->model_commons->getSiteInfo();
		$meta_title = 'Clinical Notes';

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

	public function documentUpload()
	{
		$data = $this->url->post;
		$data['user_id'] = $this->session->data['user_id'];

		$file = $this->url->files['file'];
		$data['ext'] = pathinfo($file['name'], PATHINFO_EXTENSION);

		$data['filedir'] = DIR.'public/uploads/reports/';
		$data['file_name'] = 'Doc-'.uniqid(rand()).$data['id'];

		$filesystem = new Filesystem();
		$result = $filesystem->moveUpload($file, $data);

		if ($result['error'] === false) {
			$data['report'] = $result['name'];
			$this->load->model('appointment');
			$this->model_appointment->createReport($data);
			$result['ext'] = $data['ext'];
			echo json_encode($result);
		} else {
			echo json_encode($result);
		}
	}

	public function documentRemove()
	{
		$file = $this->url->post('name');
		if (!is_string($file)) {
			echo "2";
			exit();
		}

		if (!unlink(DIR.'/public/uploads/reports/'.$file)) {
			echo ("Error deleting $file");
		} else {
			$data['report'] = $this->url->post('name');
			$data['appointment_id'] = $this->url->post('id');
			$this->load->model('appointment');
			$result = $this->model_appointment->deleteReport($data);
			echo $result;
		}
	}

	public function appointmentMail($id)
	{
		$this->load->controller('mail');
		$result = $this->controller_mail->getTemplate('newappointment');
		if (empty($result['template']) || $result['template']['status'] == '0') {
			return false;
		}

		$appointment = $this->model_appointment->getAppointmentView($id);
		
		$link = '<a href="'.URL.'">Click Here</a>';

		$result['template']['message'] = str_replace('{name}', $appointment['name'], $result['template']['message']);
		$result['template']['message'] = str_replace('{appointment_id}', $result['common']['appointment_prefix'].str_pad($appointment['id'], 4, '0', STR_PAD_LEFT), $result['template']['message']);
		$result['template']['message'] = str_replace('{email}', $appointment['email'], $result['template']['message']);
		$result['template']['message'] = str_replace('{mobile}', $appointment['mobile'], $result['template']['message']);
		$result['template']['message'] = str_replace('{doctor}', $appointment['doctor_name'], $result['template']['message']);
		$result['template']['message'] = str_replace('{date}', $appointment['date'], $result['template']['message']);
		$result['template']['message'] = str_replace('{time}', $appointment['time'], $result['template']['message']);
		$result['template']['message'] = str_replace('{link}', $link, $result['template']['message']);
		$result['template']['message'] = str_replace('{clinic_name}', $result['common']['name'], $result['template']['message']);
		$result['template']['message'] = str_replace('{patient}', $appointment['name'], $result['template']['message']);
		$result['template']['message'] = str_replace('{reason}', $appointment['message'], $result['template']['message']);
		
		$data['name'] = $appointment['name'];
		$data['email'] = $appointment['email'];
		$data['bcc'] = $appointment['doctor_email'];
		$data['subject'] = $result['template']['subject'];
		$data['message'] = $result['template']['message'];
		
		return $this->controller_mail->sendMail($data);
	}

	protected function makeSlot($time)
	{
		$time_slot = [];
		$st1 = strtotime($time['st1']);
		$et1 = strtotime($time['et1']);
		$st2 = strtotime($time['st2']);
		$et2 = strtotime($time['et2']);
		if (!empty($time['slot'])) {
			if ($st1 < $et1) {
				while ($st1 < $et1) {
					$time_slot[] = date ("H:i", $st1);
					$st1 += $time['slot']*60;
				}
			}

			if ($st2 < $et2) {
				while ($st2 < $et2) {
					$time_slot[] = date ("H:i", $st2);
					$st2 += $time['slot']*60;
				}
			}
		}
		return $time_slot;
	}
	/** 
	* Validate form input field on server side
	**/
	protected function validate($data)
	{
		if ($this->controller_common->validateNumber($data['doctor'])) {
			/** 
			* If doctor is not int 
			* Return false
			**/
			return false;
		} elseif (!$this->validateDate($data['date']) || strtotime($data['date']) < strtotime(date('Y-m-d'))) {
			/** 
			* If date is not valid
			* also date is less than today 
			* Return false
			**/
			return false;
		} elseif ($this->controller_common->validateNumber($data['day'])) {
			/** 
			* If date is not valid
			* also date is less than today 
			* Return false
			**/
			return false;
		} else {
			return true;
		}
	}

	protected function validateField($data)
	{
		$error = [];
		$error_flag = false;
		if ($this->controller_common->validateText($data['name'])) {
			$error_flag = true;
			$error['name'] = 'name';
		}

		if ($this->controller_common->validateEmail($data['mail'])) {
			$error_flag = true;
			$error['email'] = 'email address';
		}

		if ($this->controller_common->validatePhoneNumber($data['mobile'])) {
			$error_flag = true;
			$error['mobile'] = 'mobile number';
		}

		if ($this->controller_common->validateNumber($data['doctor'])) {
			$error_flag = true;
			$error['doctor'] = 'doctor';
		}

		if ($this->controller_common->validateDate($data['date'])) {
			$error_flag = true;
			$error['date'] = 'date';
		}

		if ($this->controller_common->validateText($data['time'])) {
			$error_flag = true;
			$error['time'] = 'time';
		}

		if ($this->controller_common->validateNumber($data['department'])) {
			$error_flag = true;
			$error['department'] = 'department';
		}

		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
	/** 
	* function to check Date format 
	* If matches then good else invalidate
	**/
	protected function validateDate($date, $format = 'Y-m-d')
	{
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}
}