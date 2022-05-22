<?php
/**
* Doctor Model 
*/
class Doctor extends Model
{
	public function allDoctors($user = NULL)
	{
		if (!empty($user)) {
			$query = $this->database->query("SELECT d.id, CONCAT(d.firstname, ' ', d.lastname) AS name, d.email, d.mobile, d.picture, d.priority, department.name As department, u.user_name, u.gender, u.status FROM `" . DB_PREFIX . "doctors` AS d LEFT JOIN `" . DB_PREFIX . "departments` AS department ON d.department_id = department.id LEFT JOIN `" . DB_PREFIX . "users` AS u ON u.user_id = d.user_id WHERE d.id = ? ORDER BY d.priority ASC, d.date_of_joining", array((int)$user));
		} else {
			$query = $this->database->query("SELECT d.id, CONCAT(d.firstname, ' ', d.lastname) AS name, d.email, d.mobile, d.picture, d.priority, department.name As department, u.user_name, u.gender, u.status FROM `" . DB_PREFIX . "doctors` AS d LEFT JOIN `" . DB_PREFIX . "departments` AS department ON d.department_id = department.id LEFT JOIN `" . DB_PREFIX . "users` AS u ON u.user_id = d.user_id ORDER BY d.priority ASC, d.date_of_joining");
		}
		return $query->rows;
	}

	public function getDoctor($id, $user = NULL)
	{
		$query = $this->database->query("SELECT d.*, u.* FROM `" . DB_PREFIX . "doctors` AS d LEFT JOIN `" . DB_PREFIX . "users` AS u ON u.user_id = d.user_id WHERE d.id = '".(int)$id."' LIMIT 1");
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function getDepartmentByName()
	{
		$query = $this->database->query("SELECT `id` , `name` FROM `" . DB_PREFIX . "departments`");
		return $query->rows;
	}

	public function updateDoctor($data)
	{
		$this->database->query("UPDATE `" . DB_PREFIX . "doctors` SET `firstname` = ?, `lastname` = ?, `email` = ?, `mobile` = ?, `picture` = ?, `about` = ?, `department_id` = ?, `social` = ?, `web_status` = ?, `status` = ?, `priority` = ?, `time` = ?, `weekly` = ?, `national` = ?, `appointment_status` = ? WHERE `id` = ? AND `user_id` = ?", array($this->database->escape($data['firstname']), $this->database->escape($data['lastname']), $this->database->escape($data['mail']), $this->database->escape($data['mobile']), $this->database->escape($data['picture']), $data['about'], (int)$data['department'], $data['social'], (int)$data['web_status'], (int)$data['status'], (int)$data['priority'], $data['time'], $data['weekly'], $data['national'], $data['appointment_status'], (int)$data['id'], (int)$data['user_id']));
		return true;
	}

	public function createDoctor($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "doctors` (`firstname`, `lastname`, `email`, `mobile`, `picture`, `about`, `department_id`, `social`, `web_status`, `status`, `priority`, `time`, `weekly`, `national`, `appointment_status`, `user_id`, `date_of_joining`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array($this->database->escape($data['firstname']), $this->database->escape($data['lastname']), $this->database->escape($data['mail']), $this->database->escape($data['mobile']), $this->database->escape($data['picture']), $data['about'], (int)$data['department'], $data['social'], (int)$data['web_status'], (int)$data['status'], (int)$data['priority'], $data['time'], $data['weekly'], $data['national'], $data['appointment_status'], (int)$data['user_id'], $data['datetime']));
		if ($query->num_rows > 0) {
			return $this->database->last_id();
		} else {
			return false;
		}
	}

	public function deleteDoctor($id)
	{
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "doctors` WHERE `id` = ?", array((int)$id));
		return true;
	}

	public function deleteUser($id)
	{
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "users` WHERE `user_id` = ?", array((int)$id));
		return true;
	}

	public function getSearchedDoctor($data)
	{
		$query = $this->database->query("SELECT id, CONCAT(firstname, ' ', lastname) AS label FROM `" . DB_PREFIX . "doctors` WHERE firstname like '%".$data."%' LIMIT 5");
		return $query->rows;
	}
}