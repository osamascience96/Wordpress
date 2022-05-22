<?php

/**
* Dashboard Model
*/

class Dashboard extends Model
{
	public function getAppointments($data, $doctor = NULL)
	{
		if ($doctor) {
			$query = $this->database->query("SELECT a.id, a.name AS title, a.email, a.mobile, a.date, a.time, a.slot, a.status, a.doctor_id, a.department_id, CONCAT(d.firstname,' ', d.lastname) AS doctor FROM `" . DB_PREFIX . "appointments` AS a LEFT JOIN `" . DB_PREFIX . "doctors` AS d ON d.id = a.doctor_id WHERE a.date BETWEEN '" . $data['start'] . "' AND  '" . $data['end'] . "' AND a.doctor_id = '".$doctor."' ORDER BY a.date DESC");
		} else {
			$query = $this->database->query("SELECT a.id, a.name AS title, a.email, a.mobile, a.date, a.time, a.slot, a.status, a.doctor_id, a.department_id, CONCAT(d.firstname,' ', d.lastname) AS doctor FROM `" . DB_PREFIX . "appointments` AS a LEFT JOIN `" . DB_PREFIX . "doctors` AS d ON d.id = a.doctor_id WHERE a.date BETWEEN '" . $data['start'] . "' AND  '" . $data['end'] . "' ORDER BY a.date DESC");
		}
		return $query->rows;
	}

	public function getNotices()
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "noticeboard` WHERE end_date >= '".date('Y-m-d')."' ");
		return $query->rows;
	}

	public function getDoctors()
	{
		$query = $this->database->query("SELECT d.id, CONCAT(d.firstname, ' ', d.lastname) AS name, d.weekly, d.national, dep.name AS department, dep.id AS department_id FROM `" . DB_PREFIX . "doctors` AS d LEFT JOIN `" . DB_PREFIX . "departments` AS dep ON dep.id = d.department_id WHERE d.appointment_status = ? ORDER BY d.department_id ASC", array(1));
		return $query->rows;
	}

	public function getDoctorTime($id)
	{
		$query = $this->database->query("SELECT `time` FROM `" . DB_PREFIX . "doctors` WHERE `id` = ? LIMIT 1", array($this->database->escape($id)));
		if ($query->num_rows > 0) {
			return  $query->row['time'];
		} else {
			return false;
		}
	}

	public function bookedSlot($data)
	{
		$data['date'] = date("Y-m-d", strtotime($data['date']));

		$query = $this->database->query("SELECT `time` FROM `" . DB_PREFIX . "appointments` WHERE `date`= ? AND `doctor_id` = ? AND `status` != ? ", array($this->database->escape($data['date']), $this->database->escape($data['doctor']), 1));

		$result = [];
		if ($query->num_rows > 0) {
			foreach ($query->rows as $key => $value) {
				$result[] = $value['time'];
			}
		}
		return $result;
	}

	public function getClinicStats($doctor = NULL)
	{
		$query = $this->database->query("SELECT COUNT(id) AS total FROM `" . DB_PREFIX . "subscribe`");
		$data['subscribe'] = $query->row['total'];
		$query = $this->database->query("SELECT COUNT(id) AS total FROM `" . DB_PREFIX . "doctors`");
		$data['doctors'] = $query->row['total'];
		$query = $this->database->query("SELECT COUNT(id) AS total FROM `" . DB_PREFIX . "blog`");
		$data['blog'] = $query->row['total'];
		$query = $this->database->query("SELECT COUNT(id) AS total FROM `" . DB_PREFIX . "comment`");
		$data['comment'] = $query->row['total'];
		$query = $this->database->query("SELECT COUNT(id) AS total FROM `" . DB_PREFIX . "review`");
		$data['review'] = $query->row['total'];
		$query = $this->database->query("SELECT COUNT(user_id) AS total FROM `" . DB_PREFIX . "users`");
		$data['users'] = $query->row['total'];

		return $data;
	}

	public function getMainClinicStats()
	{
		$query = $this->database->query("SELECT COUNT(id) AS total FROM `" . DB_PREFIX . "patients`");
		$data['patients'] = $query->row['total'];
		$query = $this->database->query("SELECT COUNT(id) AS total FROM `" . DB_PREFIX . "appointments`");
		$data['appointments'] = $query->row['total'];
		$query = $this->database->query("SELECT COUNT(id) AS total FROM `" . DB_PREFIX . "invoice`");
		$data['invoices'] = $query->row['total'];
		$query = $this->database->query("SELECT COUNT(id) AS total FROM `" . DB_PREFIX . "request`");
		$data['request'] = $query->row['total'];
		return $data;
	}

	public function getAppointmentStats($doctor = NULL)
	{
		if ($doctor) {
			$query = $this->database->query("SELECT COUNT(id) AS appointment FROM `" . DB_PREFIX . "appointments` WHERE date > DATE_SUB(now(), INTERVAL 12 MONTH) AND doctor_id = '".$doctor."' ");
			$data['last_12'] = $query->row['appointment'];

			$query = $this->database->query("SELECT COUNT(id) AS appointment FROM `" . DB_PREFIX . "appointments` WHERE date >= DATE_SUB(now(), INTERVAL 1 MONTH) AND date <= '".date('Y-m-d')."' AND doctor_id = '".$doctor."' ");
			$data['last_1'] = $query->row['appointment'];

			$query = $this->database->query("SELECT COUNT(id) AS appointment FROM `" . DB_PREFIX . "appointments` WHERE date > DATE_SUB(now(), INTERVAL 12 MONTH) AND doctor_id = '".$doctor."' AND status = '4' ");
			$data['completed_last_12'] = $query->row['appointment'];

			$query = $this->database->query("SELECT COUNT(id) AS appointment FROM `" . DB_PREFIX . "appointments` WHERE date >= DATE_SUB(now(), INTERVAL 1 MONTH) AND date <= '".date('Y-m-d')."' AND doctor_id = '".$doctor."' AND status = '4'");
			$data['completed_last_1'] = $query->row['appointment'];
		} else {
			$query = $this->database->query("SELECT COUNT(id) AS appointment FROM `" . DB_PREFIX . "appointments` WHERE date >= DATE_SUB(now(), INTERVAL 12 MONTH) AND date <= '".date('Y-m-d')."'");
			$data['last_12'] = $query->row['appointment'];

			$query = $this->database->query("SELECT COUNT(id) AS appointment FROM `" . DB_PREFIX . "appointments` WHERE date >= DATE_SUB(now(), INTERVAL 1 MONTH) AND date <= '".date('Y-m-d')."' ");
			$data['last_1'] = $query->row['appointment'];

			$query = $this->database->query("SELECT COUNT(id) AS appointment FROM `" . DB_PREFIX . "appointments` WHERE date >= DATE_SUB(now(), INTERVAL 12 MONTH) AND date <= '".date('Y-m-d')."' AND status = '4' ");
			$data['completed_last_12'] = $query->row['appointment'];

			$query = $this->database->query("SELECT COUNT(id) AS appointment FROM `" . DB_PREFIX . "appointments` WHERE date >= DATE_SUB(now(), INTERVAL 1 MONTH) AND date <= '".date('Y-m-d')."' AND status = '4'");
			$data['completed_last_1'] = $query->row['appointment'];
		}

		return $data;
	}

	public function getIncomeStats($doctor = NULL)
	{
		$query = $this->database->query("SELECT SUM(amount) AS invoice FROM `" . DB_PREFIX . "invoice` WHERE invoicedate > DATE_SUB(now(), INTERVAL 12 MONTH)");
		$data['income_12'] = $query->row['invoice'];

		$query = $this->database->query("SELECT SUM(amount) AS invoice FROM `" . DB_PREFIX . "invoice` WHERE invoicedate > DATE_SUB(now(), INTERVAL 1 MONTH)");
		$data['income_1'] = $query->row['invoice'];

		$query = $this->database->query("SELECT SUM(amount) AS expense FROM `" . DB_PREFIX . "expenses` WHERE date > DATE_SUB(now(), INTERVAL 12 MONTH)");
		$data['expense_12'] = $query->row['expense'];

		$query = $this->database->query("SELECT SUM(amount) AS expense FROM `" . DB_PREFIX . "expenses` WHERE date > DATE_SUB(now(), INTERVAL 1 MONTH) AND date <= '".date('Y-m-d')."'");
		$data['expense_1'] = $query->row['expense'];

		return $data;
	}

	public function getBillStats($doctor = NULL)
	{
		$query = $this->database->query("SELECT SUM(amount) AS amount FROM `" . DB_PREFIX . "medicine_bill` WHERE date_of_joining > DATE_SUB(now(), INTERVAL 12 MONTH)");
		$data['income_12'] = $query->row['amount'];

		$query = $this->database->query("SELECT SUM(amount) AS amount FROM `" . DB_PREFIX . "medicine_bill` WHERE date_of_joining > DATE_SUB(now(), INTERVAL 1 MONTH)");
		$data['income_1'] = $query->row['amount'];

		$query = $this->database->query("SELECT SUM(amount) AS amount FROM `" . DB_PREFIX . "medicine_purchase` WHERE date > DATE_SUB(now(), INTERVAL 12 MONTH)");
		$data['purchase_12'] = $query->row['amount'];

		$query = $this->database->query("SELECT SUM(amount) AS amount FROM `" . DB_PREFIX . "medicine_purchase` WHERE date > DATE_SUB(now(), INTERVAL 1 MONTH) AND date <= '".date('Y-m-d')."'");
		$data['purchase_1'] = $query->row['amount'];

		return $data;
	}

	public function getInvoiceStats($doctor = NULL)
	{
		$query = $this->database->query("SELECT SUM(amount) AS amount, SUM(tax) AS tax, SUM(discount_value) AS discount, SUM(paid) AS paid, SUM(due) AS due FROM `" . DB_PREFIX . "invoice`");
		$data = $query->row;
		$query = $this->database->query("SELECT SUM(amount) AS amount, SUM(tax) AS tax, SUM(discount_value) AS discount, SUM(amount) AS paid FROM `" . DB_PREFIX . "medicine_bill`");
		$data['amount'] = (float)$data['amount'] + (float)$query->row['amount'];
		$data['tax'] = (float)$data['tax'] + (float)$query->row['tax'];
		$data['discount'] = (float)$data['discount'] + (float)$query->row['discount'];
		$data['paid'] = (float)$data['paid'] + (float)$query->row['paid'];
		return $data;
	}

	public function getChartIncome($doctor = NULL)
	{
		$query = $this->database->query("SELECT SUM(amount) AS amount, MONTH(invoicedate) AS month FROM `" . DB_PREFIX . "invoice` WHERE invoicedate > DATE_SUB(now(), INTERVAL 12 MONTH) GROUP BY MONTH(invoicedate)");
		return $query->rows;
	}

	public function getChartIncomeBill()
	{
		$query = $this->database->query("SELECT SUM(amount) AS amount, MONTH(date_of_joining) AS month FROM `" . DB_PREFIX . "medicine_bill` WHERE date_of_joining > DATE_SUB(now(), INTERVAL 12 MONTH) GROUP BY MONTH(date_of_joining)");
		return $query->rows;
	}

	public function getChartPurchase()
	{
		$query = $this->database->query("SELECT SUM(amount) AS amount, MONTH(date) AS month FROM `" . DB_PREFIX . "medicine_purchase` WHERE date > DATE_SUB(now(), INTERVAL 12 MONTH) GROUP BY MONTH(date)");
		return $query->rows;
	}

	public function getChartExpense($user_id = NULL)
	{
		$query = $this->database->query("SELECT SUM(amount) AS amount, MONTH(date) AS month FROM `" . DB_PREFIX . "expenses` WHERE date > DATE_SUB(now(), INTERVAL 12 MONTH) GROUP BY MONTH(date)");
		return $query->rows;
	}

	public function getChartExpensebyType()
	{
		$query = $this->database->query("SELECT SUM(e.amount) AS value, et.name AS label FROM `" . DB_PREFIX . "expenses` AS e LEFT JOIN `" . DB_PREFIX . "expense_type` AS et ON et.id = e.expense_type GROUP BY expense_type");
		return $query->rows;
	}

	public function getChartAppointment($doctor = NULL)
	{
		if ($doctor) {
			$query = $this->database->query("SELECT COUNT(id) AS amount, MONTH(date) AS month FROM `" . DB_PREFIX . "appointments` WHERE date > DATE_SUB(now(), INTERVAL 12 MONTH) AND doctor_id = '".$doctor."' GROUP BY MONTH(date)");
		} else {
			$query = $this->database->query("SELECT COUNT(id) AS amount, MONTH(date) AS month FROM `" . DB_PREFIX . "appointments` WHERE date > DATE_SUB(now(), INTERVAL 12 MONTH) GROUP BY MONTH(date)");
		}
		return $query->rows;
	}

	public function getChartpatient($doctor = NULL)
	{
		if ($doctor) {
			$data = $this->getPatientDoctorIDs($doctor);
			if (!empty($data)) {
				$query = $this->database->query("SELECT COUNT(id) AS amount, MONTH(date_of_joining) AS month FROM `" . DB_PREFIX . "patients` WHERE id IN(".implode(",", $data).") AND date_of_joining > DATE_SUB(now(), INTERVAL 12 MONTH) GROUP BY MONTH(date_of_joining)");
				return $query->rows;
			} else {
				return false;
			}
		} else {
			$query = $this->database->query("SELECT COUNT(id) AS amount, MONTH(date_of_joining) AS month FROM `" . DB_PREFIX . "patients` WHERE date_of_joining > DATE_SUB(now(), INTERVAL 12 MONTH) GROUP BY MONTH(date_of_joining)");
		}
		return $query->rows;
	}

	public function getChartInvoiceStatus($doctor = NULL)
	{
		$query = $this->database->query("SELECT COUNT(status) AS value, status AS label FROM `" . DB_PREFIX . "invoice` WHERE invoicedate > DATE_SUB(now(), INTERVAL 12 MONTH) GROUP BY status");
		return $query->rows;
	}

	public function getPatientDoctorIDs($doctor)
	{
		$ids1 = array();
		$ids2 = array();
		$query = $this->database->query("SELECT `patient_id` FROM `" . DB_PREFIX . "appointments` WHERE doctor_id = ?", array($doctor));
		if ($query->num_rows > 0) { $ids1 = array_column($query->rows, 'patient_id'); }

		$query = $this->database->query("SELECT `patient_id` FROM `" . DB_PREFIX . "patient_doctor` WHERE doctor_id = ?", array($doctor));
		if ($query->num_rows > 0) { $ids2 = array_column($query->rows, 'patient_id'); }

		$data = array_unique(array_merge($ids1, $ids2));
		return $data;
	}

	public function getLatestPurchase()
	{
		$query = $this->database->query("SELECT mp.*, s.name AS supplier FROM `" . DB_PREFIX . "medicine_purchase` AS mp LEFT JOIN `" . DB_PREFIX . "suppliers` AS s ON s.id = mp.supplier ORDER BY date_of_joining DESC LIMIT 5");
		return $query->rows;
	}
}