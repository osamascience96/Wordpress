<?php

/**
* Register Model
*/
class Register extends Model
{
	public function checkUser($email) 
	{
		$query = $this->database->query("SELECT `id`, `firstname`, `lastname`, `email`, `status` FROM `" . DB_PREFIX . "patients` WHERE `email` = ? LIMIT 1 ", array($this->database->escape($email)));
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}
	
	public function createAccount($data) 
	{
		$passwordhash = password_hash($data['password'], PASSWORD_DEFAULT);
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "patients` (`firstname`, `lastname`, `email`, `mobile`, `password`, `temp_hash`, `status`, `date_of_joining`) VALUES (?, ?, ?, ?, ?, ?, ?, ?) ", array($this->database->escape($data['firstname']), $this->database->escape($data['lastname']), $this->database->escape($data['email']), $this->database->escape($data['mobile']), $this->database->escape($passwordhash), $this->database->escape($data['temp_hash']), 1, $data['datetime']));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function editHash($email, $code)
	{
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "patients` SET `temp_hash` = ? WHERE `email` = ? ", array($this->database->escape($code), $this->database->escape($email)));
	}

	public function checkEmailHash($data)
	{
		$query = $this->database->query("SELECT `email` FROM `" . DB_PREFIX . "patients` WHERE `email` = ? and `temp_hash` = ? LIMIT 1", array($this->database->escape($data['email']), $this->database->escape($data['hash'])));
		
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function changepassword($data)
	{
		$passwordhash = password_hash($data['password'], PASSWORD_DEFAULT);
		$hash = NULL;
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "patients` SET `password` = ?, `temp_hash` = ?, `emailconfirmed` = ?  WHERE `email` = ? AND `temp_hash` = ? ", array($passwordhash, $hash, 1, $this->database->escape($data['email']), $this->database->escape($data['hash'])));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function confirmAccount($data)
	{
		$hash = NULL;
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "patients` SET `temp_hash` = ?, `emailconfirmed` = ? WHERE `email` = ? AND `temp_hash` = ? ", array($hash, 1, $this->database->escape($data['email']), $this->database->escape($data['hash'])));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
}

