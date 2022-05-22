<?php

/**
 * PrescriptionController
 */
class PrescriptionController extends Controller
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

		$this->load->model('prescription');
		if ($data['common']['user']['role_id'] == '3' && $data['common']['info']['doctor_access'] == '1') {
			$data['result'] = $this->model_prescription->getPrescriptions($data['period'], $data['common']['user']['doctor']);
		} else {
			$data['result'] = $this->model_prescription->getPrescriptions($data['period']);
		}

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['page_title'] = 'Prescriptions';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action_delete'] = URL_ADMIN.DIR_ROUTE.'prescription/delete';
		$data['action_new_appointment'] = URL_ADMIN.DIR_ROUTE.'prescription/add';

		$data['page_add'] = $this->user_agent->hasPermission('prescription/add') ? true:false;
		$data['page_view'] = $this->user_agent->hasPermission('prescription/view') ? true:false;
		$data['page_pdf'] = $this->user_agent->hasPermission('prescription/pdf') ? true:false;
		$data['page_edit'] = $this->user_agent->hasPermission('prescription/edit') ? true:false;
		$data['page_delete'] = $this->user_agent->hasPermission('prescription/delete') ? true:false;

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/*call appointment list view*/
		$this->response->setOutput($this->load->view('prescription/prescription_list', $data));
	}

	public function indexView()
	{
		/**
		* Check if id exist in url if not exist then redirect to blog list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('prescriptions');
		}

		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		$this->load->model('prescription');
		if ($data['common']['user']['role_id'] == '3' && $data['common']['info']['doctor_access'] == '1') {
			$data['result'] = $this->model_prescription->getPrescriptionView($id, $data['common']['user']['doctor']);
		} else {
			$data['result'] = $this->model_prescription->getPrescriptionView($id);
		}

		if (empty($data['result'])) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Prescription does not exist in database!');
			$this->url->redirect('prescriptions');
		}
		$data['result']['prescription'] = json_decode($data['result']['prescription'], true);
		$data['doctors'] = $this->model_prescription->getDoctors();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = 'Prescription View';
		/*Render Blog add view*/
		$this->response->setOutput($this->load->view('prescription/prescription_view', $data));
	}

	public function indexAdd()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		$data['result'] = NULL;
		$this->load->model('prescription');
		$data['doctors'] = $this->model_prescription->getDoctors();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		/* Set page title */
		$data['page_title'] = 'Add Prescription';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'prescription/add';
		/*Render Blog add view*/
		$this->response->setOutput($this->load->view('prescription/prescription_form', $data));
	}

	public function indexPdf()
	{
		$id = (int)$this->url->get('id');
		
		if (empty($id)) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Prescription does not exist in database!');
			$this->url->redirect('prescriptions');
		}

		$this->load->model('commons');
		$common = $this->model_commons->getSiteInfo();
		$user = $this->model_commons->getUserInfo($this->session->data['user_id']);

		$this->load->model('prescription');
		
		if ($user['role_id'] == '3' && $common['doctor_access'] == '1') {
			$result = $this->model_prescription->getPrescriptionView($id, $user['doctor']);
		} else {
			$result = $this->model_prescription->getPrescriptionView($id);
		}

		if (empty($result)) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Prescription does not exist in database!');
			$this->url->redirect('prescriptions');
		}
		
		$result['prescription'] = json_decode($result['prescription'], true);
		

		$meta_title = 'Prescription';
		ob_start();
		if (!empty($common['prescription_template'])) {
			include DIR_APP.'views/prescription/prescription_pdf_'.(int)$common['prescription_template'].'.tpl.php';
		} else {
			include DIR_APP.'views/prescription/prescription_pdf_1.tpl.php';
		}
		
		$data['html'] = ob_get_clean();
		
		if(ob_get_length() > 0) {
			ob_end_flush();
		}
		
		$pdf = new PDF();
		$pdf->createPDF($data);
	}

	public function indexEdit()
	{
		/**
		* Check if id exist in url if not exist then redirect to blog list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('prescriptions');
		}

		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		$user = $this->model_commons->getUserInfo($this->session->data['user_id']);

		$this->load->model('prescription');
		if ($user['role_id'] == '3' && $common['info']['doctor_access'] == '1') {
			$data['result'] = $this->model_prescription->getPrescription($id, $user['doctor']);
		} else {
			$data['result'] = $this->model_prescription->getPrescription($id);
		}
		
		if (empty($data['result'])) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Prescription does not exist in database!');
			$this->url->redirect('prescriptions');
		}
		$data['result']['prescription'] = json_decode($data['result']['prescription'], true);
		$data['doctors'] = $this->model_prescription->getDoctors();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = 'Edit Prescription';
		$data['action'] = URL_ADMIN.DIR_ROUTE.'prescription/edit';
		/*Render Blog add view*/
		$this->response->setOutput($this->load->view('prescription/prescription_form', $data));
	}

	public function indexAction()
	{
		$data = $this->url->post;
		$this->load->controller('common');
		
		if ($validate_field = $this->validateField($data['prescription'])) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter/select valid '.implode(", ",$validate_field).'!');
			if (!empty($data['prescription']['id'])) {
				$this->url->redirect('prescription/edit&id='.$data['prescription']['id']);
			} else {
				$this->url->redirect('prescription/add');
			}
		}
		$data['prescription']['medicine'] = json_encode($data['prescription']['medicine']);
		$data['prescription']['datetime'] = date('Y-m-d H:i:s');
		$data['prescription']['user_id'] = $this->session->data['user_id'];

		$this->load->model('prescription');
		if (!empty($data['prescription']['id'])) {
			$this->model_prescription->updatePrescription($data['prescription']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Prescription updated successfully.');

		} else {
			$data['prescription']['id'] = $this->model_prescription->createPrescription($data['prescription']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Prescription created successfully.');
		}
		$this->url->redirect('prescription/view&id='.$data['prescription']['id']);
	}
	/**
	* Item index Delete method
	* This method will be called on Prescription Delete view
	**/
	public function indexDelete()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id')) ) {
			$this->url->redirect('prescriptions');
		}
		$this->load->model('prescription');
		$result = $this->model_prescription->deletePrescription($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Prescription deleted successfully.');
		$this->url->redirect('prescriptions');
	}
	/** 
	* Validate form input field on server side
	**/
	protected function validateField($data)
	{
		$error = [];
		$error_flag = false;
		if ($this->controller_common->validateText($data['name'])) {
			$error_flag = true;
			$error['title'] = 'Paitent Name!';
		}

		if ($this->controller_common->validateNumber($data['doctor'])) {
			$error_flag = true;
			$error['author'] = 'Doctor!';
		}

		if ($this->controller_common->validateEmail($data['email'])) {
			$error_flag = true;
			$error['short_post'] = 'Email Address!';
		}

		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}