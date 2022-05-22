<?php
/**
 * ManagesalaryController
 */
class ManagesalaryController extends Controller
{
	public function index()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Get all Doctor data from Db using Doctor Model method 
		**/
		$this->load->model('managesalary');
		$data['result'] = $this->model_managesalary->getStaffs();
		
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['page_title'] = 'Manage Salary';
		$data['page_view'] = $this->user_agent->hasPermission('managesalary/view') ? true : false;
		$data['page_add'] = $this->user_agent->hasPermission('managesalary/add') ? true : false;
		$data['page_edit'] = $this->user_agent->hasPermission('managesalary/edit') ? true : false;
		$data['page_history'] = $this->user_agent->hasPermission('managesalary/history') ? true : false;

		/*Render Doctor list view*/
		$this->response->setOutput($this->load->view('managesalary/managesalary_list', $data));
	}

	public function indexAdd()
	{
		/**
		* Check if id exist in url if not exist then redirect to Doctor list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('managesalary');
		}

		$this->load->model('managesalary');
		$data['result'] = $this->model_managesalary->getStaff($id);
		$data['salarytemplate'] = $this->model_managesalary->getSalaryTemplates();

		if (empty($data['result'])) {
			$this->url->redirect('managesalary');
		}

		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['page_title'] = 'Add Manage Salary';
		$data['action'] = URL_ADMIN.DIR_ROUTE.'managesalary/add';
		/*Render Doctor list view*/
		$this->response->setOutput($this->load->view('managesalary/managesalary_form', $data));
	}

	public function indexEdit()
	{
		/**
		* Check if id exist in url if not exist then redirect to Doctor list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('managesalary');
		}

		$this->load->model('managesalary');
		$data['result'] = $this->model_managesalary->getStaff($id);
		$data['salarytemplate'] = $this->model_managesalary->getSalaryTemplates();

		if (empty($data['result'])) {
			$this->url->redirect('managesalary');
		}

		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['page_title'] = 'Edit Manage Salary';
		$data['action'] = URL_ADMIN.DIR_ROUTE.'managesalary/edit';
		/*Render Doctor list view*/
		$this->response->setOutput($this->load->view('managesalary/managesalary_form', $data));
	}

	public function indexView()
	{
		/**
		* Check if id exist in url if not exist then redirect to Doctor list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('managesalary');
		}

		$this->load->model('managesalary');
		$data['result'] = $this->model_managesalary->getStaff($id);
		if (empty($data['result'])) {
			$this->url->redirect('managesalary');
		}

		$data['salary'] = $this->model_managesalary->getSalaryTemplate($data['result']['salarytemplate_id']);
		if (empty($data['salary'])) {
			$this->url->redirect('managesalary');
		}

		$data['salary']['allowance'] = json_decode($data['salary']['allowance'], true);
		$data['salary']['deduction'] = json_decode($data['salary']['deduction'], true);

		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['page_title'] = 'Edit Manage Salary';
		$data['page_edit'] = $this->user_agent->hasPermission('managesalary/edit') ? true : false;
		$data['page_history'] = $this->user_agent->hasPermission('managesalary/history') ? true : false;

		$data['action'] = URL_ADMIN.DIR_ROUTE.'managesalary/edit';
		/*Render Doctor list view*/
		$this->response->setOutput($this->load->view('managesalary/managesalary_view', $data));
	}

	public function indexAction()
	{
		$data = $this->url->post;
		if (empty($data['id']) || empty($data['salarytemplate'])) {
			$this->url->redirect('managesalary');
		}

		$this->load->model('managesalary');
		$this->model_managesalary->updateStaffSalaryTemplate($data);
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Salary Template added to user successfully.');
		$this->url->redirect('managesalary');
	}

	public function history()
	{
		/**
		* Check if id exist in url if not exist then redirect to Doctor list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('managesalary');
		}

		$this->load->model('managesalary');
		$data['result'] = $this->model_managesalary->getStaff($id);
		if (empty($data['result'])) {
			$this->url->redirect('managesalary');
		}
		$data['history'] = $this->model_managesalary->getPaymentsHistory($id);
		
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		$data['page_title'] = 'Payment History';
		$data['page_add'] = $this->user_agent->hasPermission('managesalary/history') ? true : false;
		$data['page_view'] = $this->user_agent->hasPermission('managesalary/history/view') ? true : false;
		$data['page_delete'] = $this->user_agent->hasPermission('managesalary/history/delete') ? true : false;
		$data['action_delete'] = URL_ADMIN.DIR_ROUTE.'managesalary/history/delete';
		/*Render Doctor list view*/
		$this->response->setOutput($this->load->view('managesalary/history', $data));
	}

	public function historyView()
	{
		/**
		* Check if id exist in url if not exist then redirect to Doctor list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('managesalary');
		}

		$this->load->model('managesalary');
		$data['result'] = $this->model_managesalary->getPayments($id);
		$data['result']['salarytemplate'] = json_decode($data['result']['salarytemplate'], true);
		
		if (empty($data['result'])) {
			$this->url->redirect('managesalary');
		}

		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		$data['page_title'] = 'Payment History';
		$data['page_add'] = $this->user_agent->hasPermission('managesalary/history') ? true : false;
		$data['page_view'] = $this->user_agent->hasPermission('managesalary/history/view') ? true : false;
		$data['page_delete'] = $this->user_agent->hasPermission('managesalary/history/delete') ? true : false;
		/*Render Doctor list view*/
		$this->response->setOutput($this->load->view('managesalary/history_view', $data));
	}

	public function historyPdf()
	{
		
		/**
		* Check if id exist in url if not exist then redirect to Doctor list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('managesalary');
		}

		$this->load->model('managesalary');
		$result = $this->model_managesalary->getPayments($id);
		$result['salarytemplate'] = json_decode($result['salarytemplate'], true);
		
		if (empty($result)) {
			$this->url->redirect('managesalary');
		}

		$this->load->model('commons');
		$result['info'] = $this->model_commons->getCommonData($this->session->data['user_id'])['info'];
		
		ob_start();
		include DIR_APP.'views/managesalary/history_pdf.tpl.php';
		
		$html = ob_get_clean();
		
		if(ob_get_length() > 0) {
			ob_end_flush();
		}
		
		$data = array('html' => $html, 'result' => $result);
		$pdf = new PDF();
		$pdf->createPDF($data);
	}

	public function historyDelete($value='')
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id')) ) {
			$this->url->redirect('managesalary');
			exit();
		}
		
		$this->load->model('managesalary');
		$result = $this->model_managesalary->deleteStaffPayment($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Payment deleted successfully.');
		$this->url->abs_redirect($_SERVER['HTTP_REFERER']);
	}





	public function makepayment()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Get all Doctor data from Db using Doctor Model method 
		**/
		$this->load->model('managesalary');
		$data['result'] = $this->model_managesalary->getStaffs();
		
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['page_title'] = 'Make Payment';
		$data['page_view'] = $this->user_agent->hasPermission('makepayment/view') ? true : false;
		$data['page_add'] = $this->user_agent->hasPermission('makepayment/add') ? true : false;
		$data['page_edit'] = $this->user_agent->hasPermission('makepayment/edit') ? true : false;
		$data['page_delete'] = $this->user_agent->hasPermission('makepayment/delete') ? true : false;

		/*Render Doctor list view*/
		$this->response->setOutput($this->load->view('managesalary/makepayment_list', $data));
	}

	public function makepaymentAdd()
	{
		/**
		* Check if id exist in url if not exist then redirect to Doctor list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('makepayment');
		}

		$this->load->model('managesalary');
		$data['staff'] = $this->model_managesalary->getStaff($id);
		if (empty($data['staff']['salarytemplate_id'])) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Please add salary template in manage salary.');
			$this->url->redirect('makepayment');
		}
		$data['methods'] = $this->model_managesalary->getPaymentMethods();
		$data['salary'] = $this->model_managesalary->getSalaryTemplate($data['staff']['salarytemplate_id']);
		$data['history'] = $this->model_managesalary->getPaymentsHistory($id);
		
		if (empty($data['staff'])) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'User does not exist in database!');
			$this->url->redirect('makepayment');
		}

		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['page_title'] = 'Make Payment';
		$data['page_add'] = $this->user_agent->hasPermission('managesalary/history') ? true : false;
		$data['page_view'] = $this->user_agent->hasPermission('managesalary/history/view') ? true : false;
		$data['page_delete'] = $this->user_agent->hasPermission('managesalary/history/delete') ? true : false;
		$data['action_delete'] = URL_ADMIN.DIR_ROUTE.'managesalary/history/delete';
		$data['action'] = URL_ADMIN.DIR_ROUTE.'makepayment/add&id='.$data['staff']['user_id'];

		/*Render Doctor list view*/
		$this->response->setOutput($this->load->view('managesalary/makepayment_add', $data));
	}

	public function makepaymentAction()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('makepayment');
		}
	
		$data = $this->url->post;

		$this->load->model('commons');
		$common = $this->model_commons->getSiteInfo();

		$data['user_id'] = $this->session->data['user_id'];
		$data['month_year'] = DateTime::createFromFormat($common['date_my_format'], $data['month_year'])->format('Y-m');

		$this->load->model('managesalary');
		$data['salarytemplate'] = $this->model_managesalary->getSalaryTemplate($data['salarytemplate_id']);
		$data['salarytemplate']['allowance'] = json_decode($data['salarytemplate']['allowance'], true);
		$data['salarytemplate']['deduction'] = json_decode($data['salarytemplate']['deduction'], true);	
		$data['salarytemplate'] = json_encode($data['salarytemplate']);
		
		$this->model_managesalary->createStaffPayment($data);
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Payment added successfully.');
		$this->url->redirect('makepayment');
	}

	public function checkStaffSalary()
	{
		$data = $this->url->post;
		$data['id'] = (int)$data['id'];
		if (empty($data['id']) || !is_int($data['id'])) {
			echo json_encode(array('error' => true, 'msg' => 'User ID is not valid!'));
			exit();
		}

		if (!$validate = $this->validateDate($data['date'])) {
			echo json_encode(array('error' => true, 'msg' => 'Month is not valid!'));
			exit();
		}

		$this->load->model('managesalary');
		$check_payment = $this->model_managesalary->checkPayment($data);
		if ($check_payment > 0) {
			echo json_encode(array('error' => true, 'msg' => 'Payment already added for this month!'));
			exit();
		}
		$result['error'] = false;
		$result['msg'] = 'Payment not added.';
		echo json_encode($result);
	}

	public function validateDate($date, $format= 'Y-m')
	{
		return $date == date($format, strtotime($date));
	}
}