<?php

/**
* Payment
*/
class Payment extends Model
{
	public function checkTransaction($param, $transaction_id)
	{
		$query = $this->database->query("SELECT `id`, `txn_id` FROM `" . DB_PREFIX . "payments` WHERE `txn_id` = ?", array($transaction_id));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function getInvoice($id)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "invoice` WHERE id = ? LIMIT 1", array((int)$id));
		return $query->row;
	}

	public function getPaymentGateway()
	{
		$query = $this->database->query("SELECT data FROM `" . DB_PREFIX . "setting` WHERE name = ? LIMIT 1", array('paymentgateway'));
		return $query->row['data'];
	}

	public function createPayment($data)
	{
		$this->database->query("INSERT INTO `" . DB_PREFIX . "payments` (`payer_id`, `email`, `txn_id`, `currency`, `amount`, `payment_date`, `is_online`, `invoice`, `patient_id`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", array($data['payer_id'], $data['invoice']['email'], $data['txn_id'], $data['params']['currency'], $data['amount'], $data['datetime'], 1, $data['invoice']['id'], $data['patient_id']));
	}

	public function updateInvoice($data)
	{
		$this->database->query("UPDATE `" . DB_PREFIX . "invoice` SET `status` = ?, `paid` = ?, `due` = ? WHERE `id` = ?", array($data['status'], $data['paid'], $data['due'], (int)$data['id']));
	}

	public function getTemplate()
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "email_template` WHERE `template` = ? LIMIT 1", array('paymentconfirmation'));
		return $query->row;
	}

	public function getSiteInfo()
	{
		$query = $this->database->query("SELECT data FROM `" . DB_PREFIX . "setting` WHERE `name` = ? LIMIT 1", array('siteinfo'));
		if ($query->num_rows > 0) {
			return $query->row['data'];
		} else {
			return false;
		}
	}
}