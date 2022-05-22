<?php

/**
* Profile Model
*/
class Profile extends Model
{
	public function getProfile($id)
	{
		$query = $this->database->query("SELECT `user_id`, `user_name`, `firstname`, `lastname`, `email`, `mobile`, `bloodgroup`, `gender`, `dob` FROM `" . DB_PREFIX . "users` WHERE `user_id` = ? LIMIT 1", array($this->database->escape($id)));
		
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function updateProfile($data)
	{
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "users` SET `user_name` = ?, `firstname` = ?, `lastname` = ?, `mobile` = ? WHERE `user_id` = ? AND `email` = ?", array($this->database->escape($data['username']), $this->database->escape($data['firstname']), $this->database->escape($data['lastname']), $this->database->escape($data['mobile']), (int)$data['user_id'], $this->database->escape($data['email'])));
		if ($this->database->error()) {
			return $this->database->error();
		} else {
			return true;
		}
	}

	public function checkUserName($username, $email)
	{
		$query = $this->database->query("SELECT count(*) AS total FROM `" . DB_PREFIX . "users` WHERE `user_name` = ? AND `email` != ?", array($this->database->escape($username), $this->database->escape($email)));
		if ($query->num_rows > 0) {
			return $query->row['total'];
		} else {
			return false;
		}
	}

	public function updatePassword($data)
	{
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "users` SET `password` = ? WHERE `user_id` = ? " , array($this->database->escape($data['password']), (int)$data['user_id']));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function getUserData($id)
	{
		 $query = $this->database->query("SELECT `password` FROM `" . DB_PREFIX . "users` WHERE `user_id` = ? LIMIT 1", array($this->database->escape($id)));
		if ($query->num_rows > 0) {
			return  $query->row['password'];
		} else {
			return false;
		}
	}
}