<?php

/**
* Login Model
*/
class Login extends Model
{
	public function checkUser($username)
	{
		$query = $this->database->query( "SELECT `user_id`, `user_role`, `firstname`, `lastname`, `email`, `mobile`, `password`, `status` FROM `" . DB_PREFIX . "users` WHERE `user_name` = ? AND `status` = ? LIMIT 1", array($username, 1));
		if ($query->num_rows) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function checkUserId($id)
	{
		$query = $this->database->query( "SELECT `user_id`, `user_role`, `firstname`, `email`, `status` FROM `" . DB_PREFIX . "users` WHERE `user_id` = ? AND `user_role` != ? AND `status` = ? LIMIT 1", array((int)$id, 1, 1));
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function checkAdminUser($email)
	{
		$query = $this->database->query( "SELECT `user_id`, `user_role`, `firstname`, `lastname`, `email`, `mobile`, `password`, `status` FROM `" . DB_PREFIX . "users` WHERE `email` = ? AND `status` = ? LIMIT 1", array($email, 1));
		if ($query->num_rows) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function editHash($data)
	{
		$this->database->query("UPDATE `" . DB_PREFIX . "users` SET `temp_hash` = ? WHERE `email` = ? ", array($this->database->escape($data['temp_hash']), $this->database->escape($data['email'])));
	}

	public function checkAttempts($email)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "login_attempts` WHERE `email` = ?", array($email));
		if ($query->num_rows) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function checkEmailHash($data)
	{
		$query = $this->database->query( "SELECT `user_id`, `firstname`, `lastname`, `email`, `status` FROM `" . DB_PREFIX . "users` WHERE `email` = ? AND `temp_hash` = ? AND `status` = ? LIMIT 1", array($data['email'], $data['hash'], 1));

		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function resetPassword($data)
	{
		$data['password'] = password_hash($data['new'], PASSWORD_DEFAULT);
		$hash = NULL;
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "users` SET `password` = ?, `temp_hash` = ?, `emailconfirmed` = ?  WHERE `email` = ? AND `temp_hash` = ? ", array($data['password'], $hash, 1, $this->database->escape($data['email']), $this->database->escape($data['hash'])));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function addAttempt($email)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "login_attempts` WHERE `email` = ? ", array($email));
		if ($query->num_rows > 0) {
			$this->database->query("UPDATE `" . DB_PREFIX . "login_attempts` SET `count` = ?, `date_modified` = ? WHERE `email` = ?", array( $query->row['count'] + 1 , date('Y-m-d H:i:s'), $email));
		}
		else {
			$this->database->query("INSERT INTO `" . DB_PREFIX . "login_attempts` SET `email` = ?, `count` = ?, `date_added` = ?, `date_modified` = ?", array($email, 1, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')));
		}
	}

	public function deleteAttempt($email)
	{
		$this->database->query("DELETE FROM `" . DB_PREFIX . "login_attempts` WHERE `email` = ?", array($email));
	}
}