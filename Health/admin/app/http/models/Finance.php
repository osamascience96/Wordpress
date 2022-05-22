<?php

/**
* Finance
*/
class Finance extends Model
{
	public function getPaymenyGateways()
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "setting` WHERE `name` = ?", array('paymentgateway'));
		return $query->row;
	}

	public function updatePaymentGateway($data)
	{
		$this->database->query("UPDATE `" . DB_PREFIX . "setting` SET `data` = ? WHERE `name` = ? ", array($data['gateways'], 'paymentgateway'));
	}

	public function getCurrency()
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "currency`");
		return $query->rows;
	}

	public function updateCurrency($data)
	{
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "currency` SET `name` = ?, `abbr` = ?, `status` = ? WHERE `id` = ? ", array($this->database->escape($data['name']), $this->database->escape($data['abbr']), (int)$data['status'], (int)$data['id']));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function createCurrency($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "currency` (`name`, `abbr`, `status`, `date_of_joining`) VALUES (?, ?, ?, ?)", array($this->database->escape($data['name']), $this->database->escape($data['abbr']), (int)$data['status'], $data['datetime']));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteCurrency($id)
	{
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "currency` WHERE `id` = ?", array((int)$id ));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function getPaymentMethod()
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "payment_method`");
		return $query->rows;
	}

	public function updatePaymentMethod($data)
	{
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "payment_method` SET `name` = ?, `status` = ? WHERE `id` = ? ", array($this->database->escape($data['name']), (int)$data['status'], (int)$data['id']));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function createPaymentMethod($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "payment_method` (`name`, `status`, `date_of_joining`) VALUES (?, ?, ?)", array($this->database->escape($data['name']), (int)$data['status'], $data['datetime']));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function deletePaymentMethod($id)
	{
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "payment_method` WHERE `id` = ?", array((int)$id ));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function getTaxes()
	{
		$query = $this->database->query("SELECT `id`, `name`, `rate` FROM `" . DB_PREFIX . "taxes`");
		return $query->rows;
	}

	public function updateTax($data)
	{
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "taxes` SET `name` = ?, `rate` = ? WHERE `id` = ? ", array($this->database->escape($data['name']), (float)$data['rate'], (int)$data['id']));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function createTax($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "taxes` (`name`, `rate`, `date_of_joining`) VALUES (?, ?, ?)", array($this->database->escape($data['name']), (float)$data['rate'], $data['datetime']));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteTax($id)
	{
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "taxes` WHERE `id` = ?", array((int)$id ));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

}