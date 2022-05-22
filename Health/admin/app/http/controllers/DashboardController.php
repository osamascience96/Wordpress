<?php

/**
* Dashboard Controller
*/
class DashboardController extends Controller
{
	/**
	* Dashboard index method
	* This method will be called on dahsboard view
	**/
	public function index()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		if ($data['common']['user']['role_id'] == '1') {
			$this->adminDashboard($data['common']);
		} elseif ($data['common']['user']['role_id'] == '2') {
			$this->deanDashboard($data['common']);
		} elseif ($data['common']['user']['role_id'] == '3') {
			$this->doctorDashboard($data['common']);
		} elseif ($data['common']['user']['role_id'] == '5') {
			$this->accountantDashboard($data['common']);
		} elseif ($data['common']['user']['role_id'] == '6') {
			$this->pharmacistDashboard($data['common']);
		} else {
			$this->employeeDashbaord($data['common']);
		}
	}

	protected function adminDashboard($common)
	{
		$data['common'] = $common;
		$this->load->model('dashboard');
		$data['doctors'] = $this->model_dashboard->getDoctors();

		$data['title'] = 'Dashboard';
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['period']['start'] = date("Y-m-d", strtotime( date( 'Y-m-01' )." -11 months"));
		$data['period']['end'] = date("Y-m-d", strtotime( date( 'Y-m-d' )));

		$data['chart_income'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartIncome());
		$data['chart_bill'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartIncomeBill());
		$data['chart_purchase'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartPurchase());
		$data['chart_expense'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartExpense());
		$data['chart_appointment'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartAppointment());
		$data['chart_patient'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartpatient());
		$data['chart_invoice_status'] = $this->formatChartData($this->model_dashboard->getChartInvoiceStatus());
		
		$data['appointment_stats'] = $this->model_dashboard->getAppointmentStats();

		$data['income_stats'] = $this->model_dashboard->getIncomeStats();
		$data['bill_stats'] = $this->model_dashboard->getBillStats();

		$data['invoice_stats'] = $this->model_dashboard->getInvoiceStats();

		$data['clinic_stats'] = $this->model_dashboard->getClinicStats();
		$data['main_clinic_stats'] = $this->model_dashboard->getMainClinicStats();

		$data['notices'] = $this->model_dashboard->getNotices();

		$data['page_title'] = 'Dashboard';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action_new_appointment'] = URL_ADMIN.DIR_ROUTE.'appointment/add';

		/*Render dahsboard view*/
		$this->response->setOutput($this->load->view('dashboard/dashboard-admin', $data));
	}

	protected function deanDashboard($common)
	{
		$data['common'] = $common;
		$this->load->model('dashboard');
		$data['doctors'] = $this->model_dashboard->getDoctors();

		$data['title'] = 'Dashboard';
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['period']['start'] = date("Y-m-d", strtotime( date( 'Y-m-01' )." -11 months"));
		$data['period']['end'] = date("Y-m-d", strtotime( date( 'Y-m-d' )));
		
		$data['chart_appointment'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartAppointment());
		$data['chart_patient'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartpatient());
		$data['appointment_stats'] = $this->model_dashboard->getAppointmentStats();
		$data['clinic_stats'] = $this->model_dashboard->getClinicStats();
		$data['notices'] = $this->model_dashboard->getNotices();

		$data['page_title'] = 'Dashboard';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action_new_appointment'] = URL_ADMIN.DIR_ROUTE.'appointment/add';
		/*Render dahsboard view*/
		$this->response->setOutput($this->load->view('dashboard/dashboard-dean', $data));
	}

	protected function doctorDashboard($common)
	{
		$data['common'] = $common;
		$this->load->model('dashboard');
		$data['doctors'] = $this->model_dashboard->getDoctors();

		$data['title'] = 'Dashboard';
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['period']['start'] = date("Y-m-d", strtotime( date( 'Y-m-01' )." -11 months"));
		$data['period']['end'] = date("Y-m-d", strtotime( date( 'Y-m-d' )));
		
		$data['chart_patient'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartpatient($common['user']['doctor']));
		$data['chart_expense'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartExpense($common['user']['user_id']));
		$data['chart_appointment'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartAppointment($common['user']['doctor']));
		$data['appointment_stats'] = $this->model_dashboard->getAppointmentStats($common['user']['doctor']);
		$data['notices'] = $this->model_dashboard->getNotices();
		
		$data['page_title'] = 'Dashboard';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action_new_appointment'] = URL_ADMIN.DIR_ROUTE.'appointment/add';
		/*Render dahsboard view*/
		$this->response->setOutput($this->load->view('dashboard/dashboard-doctor', $data));
	}

	protected function accountantDashboard($common)
	{
		$data['common'] = $common;
		$this->load->model('dashboard');
		$data['doctors'] = $this->model_dashboard->getDoctors();

		$data['title'] = 'Dashboard';
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['period']['start'] = date("Y-m-d", strtotime( date( 'Y-m-01' )." -11 months"));
		$data['period']['end'] = date("Y-m-d", strtotime( date( 'Y-m-d' )));
		
		$data['chart_income'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartIncome());
		$data['chart_bill'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartIncomeBill());
		$data['chart_purchase'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartPurchase());
		$data['chart_expense'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartExpense());
		$data['chart_invoice_status'] = $this->formatChartData($this->model_dashboard->getChartInvoiceStatus());
		$data['income_stats'] = $this->model_dashboard->getIncomeStats();
		$data['bill_stats'] = $this->model_dashboard->getBillStats();
		$data['invoice_stats'] = $this->model_dashboard->getInvoiceStats();
		$data['notices'] = $this->model_dashboard->getNotices();

		$data['page_title'] = 'Dashboard';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'appointment/sidebar';
		/*Render dahsboard view*/
		$this->response->setOutput($this->load->view('dashboard/dashboard-accountant', $data));
	}

	protected function pharmacistDashboard($common)
	{
		$data['common'] = $common;
		$this->load->model('dashboard');
		$data['doctors'] = $this->model_dashboard->getDoctors();

		$data['title'] = 'Dashboard';
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['period']['start'] = date("Y-m-d", strtotime( date( 'Y-m-01' )." -11 months"));
		$data['period']['end'] = date("Y-m-d", strtotime( date( 'Y-m-d' )));
		
		$data['chart_bill'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartIncomeBill());
		$data['chart_purchase'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartPurchase());
		$data['bill_stats'] = $this->model_dashboard->getBillStats();
		$data['purchase'] = $this->model_dashboard->getLatestPurchase();
		
		$data['bill_stats'] = $this->model_dashboard->getBillStats();
		$data['notices'] = $this->model_dashboard->getNotices();

		$data['page_title'] = 'Dashboard';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'appointment/sidebar';
		/*Render dahsboard view*/
		$this->response->setOutput($this->load->view('dashboard/dashboard-pharmacist', $data));
	}

	protected function employeeDashbaord($common)
	{
		$data['common'] = $common;
		$this->load->model('dashboard');
		$data['notices'] = $this->model_dashboard->getNotices();
		
		$data['page_title'] = 'Dashboard';
		$data['title'] = 'Dashboard';
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		
		/*Render dahsboard view*/
		$this->response->setOutput($this->load->view('dashboard/dashboard_employee', $data));
	}

	public function formatChartDataWithMonth($data)
	{
		$months = array();
		$result['label'] = array();
		$result['value'] = array();
		for ($i = 0; $i < 12; $i++) {
			$month = date("m", strtotime( date( 'Y-m-01' )." -$i months"));
			$month_name = date("M", strtotime( date( 'Y-m-01' )." -$i months"));

			if (!empty($data)) {
				foreach ($data as $key => $value) {
					if ($value['month'] == $month) {
						$result['value'][$i] = (float)$value['amount'];
						$result['label'][$i] = $month_name;
					}
				}
			}

			if (!isset($result['value'][$i])) {
				$result['value'][$i] = 0;
				$result['label'][$i] = $month_name;
			}
		}
		
		$result['label'] = json_encode(array_reverse($result['label']));
		$result['value'] = json_encode(array_reverse($result['value']));
		return $result;
	}

	public function formatChartData($data)
	{
		$arr = array('Paid', 'Partially Paid', 'Unpaid', 'Pending', 'In Process', 'Cancelled');
		$result['label'] = array();
		$result['value'] = array();
		foreach ($arr as $key => $value) {
			if (!empty($data)) {
				foreach ($data as $k => $v) {
					if ($v['label'] == $value) {
						$result['value'][$key] = (float)$v['value'];
						$result['label'][$key] = $v['label'];
					}
				}
			}

			if (!isset($result['value'][$key])) {
				$result['value'][$key] = 0;
				$result['label'][$key] = $value;
			}
		}
		
		$result['label'] = json_encode(array_reverse($result['label']));
		$result['value'] = json_encode(array_reverse($result['value']));
		return $result;
	}
	/**
	* Method to set array for displaying in full calendar
	**/
	public function getDashbaordAppointment()
	{
		$this->load->controller('common');
		$data = $this->url->get;
		
		$data['start'] = date_format(date_create($data['start']), "Y-m-d");
		$data['end'] = date_format(date_create($data['end']), "Y-m-d");
		
		if ($validate_field = $this->validateField($data)) {
			echo json_encode(array());
			exit();
		}

		$this->load->model('commons');
		$user = $this->model_commons->getUserInfo($this->session->data['user_id']);
		
		$this->load->model('dashboard');

		if ($user['role_id'] == "3") {
			$appointments = $this->model_dashboard->getAppointments($data, $user['doctor']);
		} elseif ($user['role_id'] == "1" || $user['role_id'] == "2") {
			$appointments = $this->model_dashboard->getAppointments($data);
		} else {
			echo json_encode(array());
			exit();
		}
		
		if (!empty($appointments)) {
			foreach ($appointments as $key => $value) {
				if ($value['status'] == '1') {
					$appointments[$key]['className'] = 'fc-event-danger fc-event-solid-danger fc-event-gradient';
				} elseif ($value['status'] == '2') {
					$appointments[$key]['className'] = 'fc-event-warning fc-event-solid-warning fc-event-gradient';
				} elseif ($value['status'] == '3') {
					$appointments[$key]['className'] = 'fc-event-success fc-event-solid-success fc-event-gradient';
				} elseif ($value['status'] == '4') {
					$appointments[$key]['className'] = 'fc-event-black fc-event-solid-white fc-event-gradient';
				} else {
					$appointments[$key]['className'] = 'fc-event-primary fc-event-solid-primary fc-event-gradient';
				}
				//$appointments[$key]['url'] = URL_ADMIN.DIR_ROUTE.'appointment/view&id='.$value['id'];
				$start = new DateTime($value['date'].' '.$value['time']);
				
				$appointments[$key]['start'] = $start->format('Y-m-d H:i');
				$end = $start->modify('+'. $value['slot'] .' minute');
				$appointments[$key]['end'] = $end->format('Y-m-d H:i');
			}
		}
		echo json_encode($appointments);
	}

	public function validateField($data)
	{
		$error = [];
		$error_flag = false;
		
		if ($this->controller_common->validateDate($data['start'])) {
			$error_flag = true;
			$error['start_date'] = ' Start date';
		}

		if ($this->controller_common->validateDate($data['start'])) {
			$error_flag = true;
			$error['end_date'] = 'End date';
		}

		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}