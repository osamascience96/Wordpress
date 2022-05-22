<?php

/**
* Invoice Model
*/
class Invoice extends Model
{
	public function allInvoices($period, $user = NULL)
	{
		if ($user != NULL) {
			$query = $this->database->query("SELECT i.*, a.appointment_id AS appointment_unique, CONCAT(d.firstname, ' ', d.lastname) AS doctor FROM `" . DB_PREFIX . "invoice` AS i LEFT JOIN `" . DB_PREFIX . "appointments` AS a ON a.id = i.appointment_id LEFT JOIN `" . DB_PREFIX . "doctors` AS d ON d.id = i.doctor_id WHERE i.invoicedate between '".$period['start']."' AND '".$period['end']."' AND i.doctor_id = '".$user['doctor']."' ORDER BY i.invoicedate DESC");
		} else {
			$query = $this->database->query("SELECT i.*, CONCAT(d.firstname, ' ', d.lastname) AS doctor FROM `" . DB_PREFIX . "invoice` AS i LEFT JOIN `" . DB_PREFIX . "appointments` AS a ON a.id = i.appointment_id LEFT JOIN `" . DB_PREFIX . "doctors` AS d ON d.id = i.doctor_id WHERE i.invoicedate between '".$period['start']."' AND '".$period['end']."' ORDER BY i.invoicedate DESC");
		}
		return $query->rows;
	}

	public function getInvoiceView($id, $user = NULL)
	{
		if ($user != NULL) {
			$query = $this->database->query("SELECT i.*, CONCAT(d.firstname, ' ', d.lastname) AS doctor, p.name AS method FROM `" . DB_PREFIX . "invoice` AS i LEFT JOIN `" . DB_PREFIX . "payment_method` AS p ON p.id = i.method LEFT JOIN `" . DB_PREFIX . "doctors` AS d ON d.id = i.doctor_id WHERE i.id = '".(int)$id."' AND i.doctor_id = '".$user['doctor']."' LIMIT 1");
		} else {
			$query = $this->database->query("SELECT i.*, CONCAT(d.firstname, ' ', d.lastname) AS doctor, p.name AS method FROM `" . DB_PREFIX . "invoice` AS i LEFT JOIN `" . DB_PREFIX . "payment_method` AS p ON p.id = i.method LEFT JOIN `" . DB_PREFIX . "doctors` AS d ON d.id = i.doctor_id WHERE i.id = '".(int)$id."' LIMIT 1");
		}
		return $query->row;
	}

	public function getInvoice($id, $user = NULL)
	{
		if ($user != NULL) {
			$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "invoice` WHERE `id` = ? AND doctor_id = ? LIMIT 1", array((int)$id, (int)$user['doctor']));
		} else {
			$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "invoice` WHERE `id` = ? LIMIT 1", array((int)$id));
		}
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function getDoctors()
	{
		$query = $this->database->query("SELECT `id`, CONCAT(firstname, ' ',lastname) AS name FROM `" . DB_PREFIX . "doctors`");
		return $query->rows;
	}

	public function getPaymentMethod()
	{
		$query = $this->database->query("SELECT `id`, `name` FROM `" . DB_PREFIX . "payment_method` WHERE status = ?", array(1));
		return $query->rows;
	}

	public function getTaxes()
	{
		$query = $this->database->query("SELECT `id`, `name`, `rate` FROM `" . DB_PREFIX . "taxes`");
		return $query->rows;
	}

	public function checkInvoiceMailStatus($id)
	{
		$query = $this->database->query("SELECT `mail_sent` FROM `" . DB_PREFIX . "invoice` WHERE `id` = ?", array($id));
		return $query->row['mail_sent'];
	}

	public function getAttachments($id)
	{
		$query = $this->database->query("SELECT `id`, `file` FROM `" . DB_PREFIX . "attached_files` WHERE `type` = ? AND `type_id` = ?", array('invoice', $id));
		return $query->rows;
	}

	public function getAppointmentData($id)
	{
		$query = $this->database->query("SELECT a.id AS appointment_id, a.name, a.email, a.mobile, a.doctor_id, CONCAT(d.firstname, ' ', d.lastname) AS doctor, pt.id AS patient_id FROM `" . DB_PREFIX . "appointments` AS a LEFT JOIN `" . DB_PREFIX . "doctors` AS d ON d.id = a.doctor_id LEFT JOIN `" . DB_PREFIX . "patients` AS pt ON pt.id = a.patient_id WHERE a.id = ? LIMIT 1", array((int)$id));
		
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function updateInvoice($data)
	{
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "invoice` SET `name` = ?, `email` = ?, `mobile` = ?, `duedate` = ?, `invoicedate` = ?, `method` = ?, `status` = ?, `inv_status` = ?, `items` = ?, `subtotal` = ?, `tax` = ?, `discounttype` = ?, `discount` = ?, `discount_value` = ?, `amount` = ?, `paid` = ?, `due` = ?, `note` = ?, `tc` = ?, `doctor` = ?, `doctor_id` = ?, `patient_id` = ?, `appointment_id` = ? WHERE `id` = ?", array($this->database->escape($data['name']), $this->database->escape($data['email']), $this->database->escape($data['mobile']), $data['duedate'], $data['invoicedate'], (int)$data['method'], $data['status'], (int)$data['inv_status'], $data['item'], $data['subtotal'], $data['tax'], $data['discounttype'], $data['discount'], $data['discount_value'], $data['amount'], $data['paid'], $data['due'], $data['note'], $data['tc'], $data['doctor'], (int)$data['doctor_id'], (int)$data['patient_id'], (int)$data['appointment_id'], (int)$data['id']));

		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function updateInvoiceMailStatus($id)
	{
		$this->database->query("UPDATE `" . DB_PREFIX . "invoice` SET `mail_sent` = ? WHERE `id` = ?", array(1, (int)$id));
	}

	public function createInvoice($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "invoice` (`name`, `email`, `mobile`, `duedate`, `invoicedate`, `method`, `status`, `inv_status`, `items`, `subtotal`, `tax`, `discounttype`, `discount`, `discount_value`, `amount`, `paid`, `due`, `note`, `tc`, `doctor`, `doctor_id`, `patient_id`, `appointment_id`, `user_id`, `date_of_joining`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array($this->database->escape($data['name']), $this->database->escape($data['email']), $this->database->escape($data['mobile']), $data['duedate'], $data['invoicedate'], (int)$data['method'], $data['status'], (int)$data['inv_status'], $data['item'], $data['subtotal'], $data['tax'], $data['discounttype'], $data['discount'], $data['discount_value'], $data['amount'], $data['paid'], $data['due'], $data['note'], $data['tc'], $data['doctor'], (int)$data['doctor_id'], (int)$data['patient_id'], (int)$data['appointment_id'], (int)$data['user_id'], $data['datetime']));

		if ($query->num_rows > 0) {
			return $this->database->last_id();
		} else {
			return false;
		}
	}

	public function updateInvoiceIdAppointment($id, $appointment_id)
	{
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "appointments` SET `invoice_id` = ? WHERE `id` = ?", array((int)$id, (int)$appointment_id));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteInvoice($id)
	{
		$this->database->query("DELETE FROM `" . DB_PREFIX . "payments` WHERE `invoice` = ?", array((int)$id ));
		$this->database->query("DELETE FROM `" . DB_PREFIX . "attached_files` WHERE `type` = ? AND type_id = ?", array('invoice', (int)$id ));
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "invoice` WHERE `id` = ?", array((int)$id ));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function getPayments($id)
	{
		$query = $this->database->query("SELECT p.id, p.amount, p.payment_date, pm.name AS method_name FROM `" . DB_PREFIX . "payments` AS p LEFT JOIN `" . DB_PREFIX . "payment_method` AS pm ON pm.id = p.payment_method WHERE p.invoice = ?", array((int)$id));
		return $query->rows;
	}
	
	public function addInvoicePayment($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "payments` (`email`, `amount`, `payment_date`, `payment_method`, `invoice`) VALUES (?, ?, ?, ?, ?)", array($data['email'], $data['amount'], $data['date'], $data['method'], $data['invoice']));
		if ($query->num_rows > 0) {
			return $this->database->last_id();
		} else {
			return false;
		}
	}

	public function invoiceTotal($data)
	{
		$query = $this->database->query("SELECT `amount`, `paid`, `due` FROM `" . DB_PREFIX . "invoice` WHERE `id` = ? LIMIT 1", array((int)$data['invoice']));
		if ($query->num_rows > 0) {
			$total = $query->row;
			$total['paid'] = number_format((float)$total['paid'] + (float)$data['amount'], 2, '.', '');
			$total['due'] = number_format((float)$total['due'] - (float)$data['amount'], 2, '.', '');
			if ($total['due'] <= 0) { $status = "Paid"; }
			else { $status = "Partially Paid"; }
			$this->database->query("UPDATE `" . DB_PREFIX . "invoice` SET `paid` = ?, `due` = ?, `status` = ? WHERE `id` = ?", array($total['paid'], $total['due'], $status, (int)$data['invoice']));

			return true;
		} else {
			return false;
		}
	}
}