<?php
/**
* User Model
*/
class User extends Model
{
	public function allUsers()
	{
		$query = $this->database->query("SELECT u.*, u.user_id AS id, ur.name AS role FROM `" . DB_PREFIX . "users` As u LEFT JOIN `" . DB_PREFIX . "user_role` As ur ON u.user_role = ur.id WHERE user_role != 3 ORDER BY `date_of_joining` DESC");
		return $query->rows;
	}

	public function getUser($id)
	{
		$query = $this->database->query("SELECT u.*, d.time, d.weekly, d.national, d.appointment_status, d.department_id FROM `" . DB_PREFIX . "users` AS u LEFT JOIN `" . DB_PREFIX . "doctors` AS d ON d.user_id = u.user_id WHERE u.user_id = ? LIMIT 1", array($this->database->escape($id)));
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function getDepartments()
	{
		$query = $this->database->query("SELECT `id` , `name` FROM `" . DB_PREFIX . "departments`");
		return $query->rows;
	}

	public function getUserRoles()
	{
		$query = $this->database->query("SELECT `id` , `name` FROM `" . DB_PREFIX . "user_role` WHERE id != 1 AND id != 3");
		return $query->rows;
	}

	public function userInvoicetList($email)
	{
		$query = $this->database->query("SELECT i.id, i.name, i.email, i.mobile, i.amount, i.due, d.name AS `doctor`, i.date_of_joining AS `date`, c.abbr FROM `" . DB_PREFIX . "invoice` AS i LEFT JOIN `" . DB_PREFIX . "doctor` AS d ON d.id = i.doctor_id LEFT JOIN `" . DB_PREFIX . "currency` AS c ON c.id = i.currency WHERE i.email = ? ORDER BY i.date_of_joining DESC", array($this->database->escape($email)));
		return $query->rows;
	}

	public function checkUserName($username, $id)
	{
		if (!empty($id)) {
			$query = $this->database->query("SELECT count(*) AS total FROM `" . DB_PREFIX . "users` WHERE `user_name` = ? AND `user_id` != ?", array($this->database->escape($username), (int)$id));
		} else {
			$query = $this->database->query("SELECT count(*) AS total FROM `" . DB_PREFIX . "users` WHERE `user_name` = ?", array($this->database->escape($username)));
		}
		if ( $query->num_rows > 0 ) {
			return $query->row['total'];
		} else {
			return false;
		}
	}

	public function checkUserEmail($email, $id)
	{
		if (!empty($id)) {
			$query = $this->database->query("SELECT count(*) AS total FROM `" . DB_PREFIX . "users` WHERE `email` = ? AND `user_id` != ?", array($this->database->escape($email), (int)$id));
		} else {
			$query = $this->database->query("SELECT count(*) AS total FROM `" . DB_PREFIX . "users` WHERE `email` = ?", array($this->database->escape($email)));
		}
		if ($query->num_rows > 0) {
			return $query->row['total'];
		} else{
			return false;
		}
	}

	public function updateUser($data)
	{
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "users` SET `user_role` = ?, `user_name` = ?, `firstname` = ?, `lastname` = ?, `email` = ?, `mobile` = ?, `picture` = ?, `address` = ?, `bloodgroup` = ?, `gender` = ?, `dob` = ?, `status` = ? WHERE `user_id` = ? " , array((int)$data['user_role'], $this->database->escape($data['user_name']), $this->database->escape($data['firstname']), $this->database->escape($data['lastname']), $this->database->escape($data['mail']), $this->database->escape($data['mobile']), $data['picture'], $data['address'], $this->database->escape($data['bloodgroup']), $data['gender'], $this->database->escape($data['dob']), (int)$data['status'], (int)$data['user_id']));

		if ($query->num_rows > 0) { 
			return true;
		} else { 
			return false;
		}
	}

	public function createUser($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "users` (`user_role`, `user_name`, `firstname`, `lastname`, `email`, `mobile`, `picture`, `address`, `bloodgroup`, `gender`, `dob`, `password`, `temp_hash`, `date_of_joining`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array($this->database->escape($data['user_role']), $this->database->escape($data['user_name']), $this->database->escape($data['firstname']), $this->database->escape($data['lastname']), $this->database->escape($data['mail']), $this->database->escape($data['mobile']), $data['picture'], $data['address'], $data['bloodgroup'], $data['gender'], $data['dob'], $data['password'], $data['hash'], $data['datetime']));
		if ($query->num_rows > 0) {
			return $this->database->last_id();
		} else {
		    return false;	
		}
	}

	public function deleteUser($id)
	{
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "users` WHERE `user_id` = ?", array((int)$id));
		if ($query->num_rows > 0) { 
			return true;
		} else {
			return false;
		}
	}

	public function getUserReports($email)
	{
		$query = $this->database->query("SELECT `report`, `appointment_id` FROM `" . DB_PREFIX . "reports` WHERE `email` = ?", array($this->database->escape($email)));
		if ($query->num_rows > 0) {
			return $query->rows;
		} else {
			return false;
		}
	}

	
	public function userRole()
	{
		$query = $this->database->query("SELECT `id`, `name` FROM `" . DB_PREFIX . "user_role`");
		return $query->rows;
	}

	public function getRoles()
	{
		$query = $this->database->query("SELECT `id`, `name`, `description`, `date_of_joining` FROM `" . DB_PREFIX . "user_role`");
		return $query->rows;
	}

	public function getRole($id)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "user_role` WHERE `id` = ?", array((int)$id));
		return $query->row;
	}

	public function addUserRole($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "user_role` (`name`, `description` ,`permission`) VALUES (?, ?, ?)", 
			array($this->database->escape($data['name']), $data['description'], $data['role']));
		return $this->database->last_id();
	}

	public function updateUserRole($data)
	{
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "user_role` SET `name` = ?, `description` = ?, `permission` = ? WHERE `id` = ?", array($this->database->escape($data['name']), $data['description'], $data['role'], (int)$data['id']));
		return true;
	}

	public function deleteRole($id)
	{
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "user_role` WHERE `id` = ?", array((int)$id));
		if ($query->num_rows > 0) { 
			return true;
		} else {
			return false;
		}
	}
}