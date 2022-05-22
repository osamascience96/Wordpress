<?php

/**
* Teacher Model 
*/
class Staffattendance extends Model
{
	public function getStaffs()
	{
		$query = $this->database->query("SELECT u.user_id, CONCAT(u.firstname, ' ', u.lastname) AS name, u.email, u.picture, ur.name AS role, status FROM `" . DB_PREFIX . "users` AS u LEFT JOIN `" . DB_PREFIX . "user_role` AS ur ON ur.id = u.user_role");
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

	public function getStaffAttendence($data)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "staff_attendance` WHERE staff_id = '".$data['staff']['user_id']."' AND monthyear = '".$data['monthyear']."' ");
		return $query->row;
	}

	public function createAttendence($data)
	{
		$query = $this->database->query("SELECT `id` FROM `" . DB_PREFIX . "staff_attendance` WHERE `staff_id` = ? AND `monthyear` = ?", 
			array((int)$data['staff_id'], $data['month_year']));

		if (!empty($query->row)) {
			$this->database->query("UPDATE `" . DB_PREFIX . "staff_attendance` SET a".$data['day']." = ? WHERE `id` = ?", array($data['staff_attendence'], (int)$query->row['id']));
		} else {
			$this->database->query("INSERT INTO `" . DB_PREFIX . "staff_attendance` (`staff_id`, `user_id`, `monthyear`, a".$data['day'].") VALUES (?, ?, ?, ?)", array((int)$data['staff_id'], (int)$data['user_id'], $data['month_year'], $data['staff_attendence']));
		}
	}
}













