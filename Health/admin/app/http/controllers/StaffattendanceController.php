<?php

/**
* Teacher Controller
*/
class StaffattendanceController extends Controller
{
	public function index()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Get all Teacher data from Db using Teacher Model method 
		**/
		$this->load->model('staffattendance');
		$data['result'] = $this->model_staffattendance->getStaffs();
		
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['page_title'] = 'Attendance';

		$data['page_add'] = $this->user_agent->hasPermission('staffattendance/add') ? true : false;
		$data['page_view'] = $this->user_agent->hasPermission('staffattendance/view') ? true : false;
		$data['page_delete'] = $this->user_agent->hasPermission('staffattendance/delete') ? true : false;

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		/*Render Teacher list view*/
		$this->response->setOutput($this->load->view('staffattendance/staffattendance', $data));
	}

	public function indexView()
	{
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('staffattendance');
		}

		$monthyear = $this->url->get('monthyear');

		$this->load->model('staffattendance');
		$data['staff'] = $this->model_staffattendance->getStaff($id);
		if (!empty($monthyear) && $this->validateDate($monthyear)) {
			$data['monthyear'] = $monthyear;
		} else {
			$data['monthyear'] = date('Y-m');
		}

		$month = DateTime::createFromFormat('Y-m', $data['monthyear'])->format('m');
		$year = DateTime::createFromFormat('Y-m', $data['monthyear'])->format('m');

		if (empty($data['staff'])) {
			$this->url->redirect('staffattendance');
		}

		$result = $this->model_staffattendance->getStaffAttendence($data);
		$flag = 1;
		$data['summary']['P'] = 0;
		$data['summary']['A'] = 0;
		$data['summary']['L'] = 0;
		$data['summary']['H'] = 0;
		$data['summary']['OL'] = 0;
		$daysinmonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		if (!empty($result)) {
			foreach ($result as $key => $value) {
				if ($key == 'a'.$flag && $flag <= $daysinmonth) {
					$data['result'][$data['monthyear'].'-'.str_pad($flag, 2, '0', STR_PAD_LEFT)] = $value;
					$flag++;
					if ($value == 'P') {
						$data['summary']['P']++;
					}
					if ($value == 'A') {
						$data['summary']['A']++;
					}
					if ($value == 'H') {
						$data['summary']['H']++;
					}
					if ($value == 'L') {
						$data['summary']['L']++;
					}
					if ($value == 'OL') {
						$data['summary']['OL']++;
					}
				}
			}
		} else {
			for ($i = 1; $i <= $daysinmonth; $i++) { 
				$data['result'][$data['monthyear'].'-'.str_pad($i, 2, '0', STR_PAD_LEFT)] = '';
			}
		}

		$data['summary']['p_percentage'] = ($data['summary']['P'] / $daysinmonth) * 100;
		$data['summary']['a_percentage'] = ($data['summary']['A'] / $daysinmonth) * 100;
		$data['summary']['l_percentage'] = ($data['summary']['L'] / $daysinmonth) * 100;
		$data['summary']['h_percentage'] = ($data['summary']['H'] / $daysinmonth) * 100;
		$data['summary']['ol_percentage'] = ($data['summary']['OL'] / $daysinmonth) * 100;
		

		//$data['months'] = $this->get_month_and_year_using_two_date($data['schoolyear']['startdate'], $data['schoolyear']['enddate']);
		//$data['monthArray'] = array('01' => 'jan', '02' => 'feb', '03' => 'mar', '04' => 'apr', '05' => 'may', '06' => 'jun', '07' => 'jul', '08' => 'aug', '09' => 'sep', '10' => 'oct', '11' => 'nov', '12' => 'dec,' );
		
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		$data['page_title'] = 'Attendance View';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'staffattendance/add';

		/*Render Teacher list view*/
		$this->response->setOutput($this->load->view('staffattendance/staffattendance_view', $data));
	}

	public function indexAdd()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Get all Teacher data from Db using Teacher Model method 
		**/
		$this->load->model('staffattendance');
		$data['result'] = $this->model_staffattendance->getStaffs();
		
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['page_title'] = 'Add Attendance';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'staffattendance/add';

		/*Render Teacher list view*/
		$this->response->setOutput($this->load->view('staffattendance/staffattendance_add', $data));
	}

	public function indexAction()
	{
		$data = $this->url->post;
		$this->load->controller('common');
		
		$this->load->model('commons');
		$common = $this->model_commons->getSiteInfo();
		$data['date'] = DateTime::createFromFormat($common['date_format'], $data['attendence_date'])->format('Y-m-d');
		$data['month_year'] = DateTime::createFromFormat($common['date_format'], $data['attendence_date'])->format('Y-m');
		$data['user_id'] = $this->session->data['user_id'];

		$this->load->model('staffattendance');
		if (!empty($data['attendence'])) {
			foreach ($data['attendence'] as $key => $value) {
				$data['staff_id'] = $key;
				$data['staff_attendence'] = $value;
				$checkRow = $this->model_staffattendance->createAttendence($data);
			}
		}
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Staff Attendance added successfully.');
		$this->url->redirect('staffattendance');
	}
	/** 
	* function to check Date format 
	* If matches then good else invalidate
	**/
	protected function validateDate($date, $format = 'Y-m')
	{
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}
}