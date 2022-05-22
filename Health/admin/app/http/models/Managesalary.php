<?php

/**
 * Makepayment
 */
class Managesalary extends Model
{
	public function getStaffs()
	{
		$query = $this->database->query("SELECT user_id, CONCAT(firstname, ' ', lastname) AS name, email, mobile, picture, dob, status, salarytemplate_id, ur.name AS role, s.grade FROM `" . DB_PREFIX . "users` AS u LEFT JOIN `" . DB_PREFIX . "user_role` AS ur ON ur.id = u.user_role LEFT JOIN `" . DB_PREFIX . "salarytemplate` AS s ON s.id = u.salarytemplate_id");
		return $query->rows;
	}

	public function getStaff($id)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "users` WHERE user_id = ? LIMIT 1", array((int)$id));
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function getSalaryTemplates()
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "salarytemplate`");
		return $query->rows;
	}

	public function getSalaryTemplate($id)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "salarytemplate` WHERE id = ?", array((int)$id));
		return $query->row;
	}

	public function getPaymentMethods()
	{
		$query = $this->database->query("SELECT id, name FROM `" . DB_PREFIX . "payment_method` WHERE status = ?", array(1));
		return $query->rows;
	}

	public function getPaymentsHistory($id)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "staff_payment` WHERE staff_id = ? ORDER BY date_of_joining", array($id));
		return $query->rows;
	}

	public function getPayments($id)
	{
		$query = $this->database->query("SELECT s.*, u.firstname, u.lastname, u.email, u.mobile, u.picture, u.bloodgroup, u.gender, u.dob, p.name AS payment_method FROM `" . DB_PREFIX . "staff_payment` s LEFT JOIN `" . DB_PREFIX . "users` AS u ON u.user_id = s.staff_id LEFT JOIN `" . DB_PREFIX . "payment_method` AS p ON p.id = s.method  WHERE s.id = ?", array($id));
		return $query->row;
	}

	public function updateStaffSalaryTemplate($data)
	{
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "users` SET `salarytemplate_id` = ? WHERE `user_id` = ?", array((int)$data['salarytemplate'], (int)$data['id']));
	}

	public function checkPayment($data)
	{
		$query = $this->database->query("SELECT COUNT(id) AS count FROM `" . DB_PREFIX . "staff_payment` WHERE month_year = ? AND staff_id = ?", array($data['date'], $data['id']));
		return $query->row['count'];
	}

	public function createStaffPayment($data)
	{
		$this->database->query("INSERT INTO `" . DB_PREFIX . "staff_payment` (`month_year`, `gross_salary`, `total_deduction`, `net_salary`, `method`, `advance`, `deduction`, `amount`, `comments`, `salarytemplate`, `salarytemplate_id`, `staff_id`, `user_id`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array($this->database->escape($data['month_year']), (float)$data['gross_salary'], (float)$data['total_deduction'], (float)$data['net_salary'], (int)$data['method'], (float)$data['advance'], (float)$data['deduction'], (float)$data['amount'], $data['comments'], $data['salarytemplate'], (int)$data['salarytemplate_id'], (int)$data['staff_id'], (int)$data['user_id']));
	}

	public function deleteStaffPayment($id)
	{
		$this->database->query("DELETE FROM `" . DB_PREFIX . "staff_payment` WHERE `id` = ?", array((int)$id));
	}























}