<?php

/**
 * Sender
 */
class Sender extends Model
{
	public function getRole()
	{
		$query = $this->database->query("SELECT `id` , `name` FROM `" . DB_PREFIX . "user_role` WHERE `id` != 1 ");
		return $query->rows;
	}

	public function getPatients()
	{
		$query = $this->database->query("SELECT `id` , CONCAT(`firstname`, ' ', `lastname`) AS name, 'patient' AS type FROM `" . DB_PREFIX . "patients` WHERE status = ?", array('1'));
		return $query->rows;
	}

	public function getUsers($role)
	{
		$query = $this->database->query("SELECT u.user_id AS id , CONCAT(u.firstname, ' ', u.lastname) AS name, ur.name AS type FROM `" . DB_PREFIX . "users` AS u LEFT JOIN `" . DB_PREFIX . "user_role` AS ur ON ur.id = u.user_role WHERE user_role = ? AND status = ?", array((int)$role, '1'));
		return $query->rows;
	}

	public function getUserReceiver($data)
	{
		$query = $this->database->query("SELECT CONCAT(firstname, ' ', lastname) AS name, email FROM `" . DB_PREFIX . "users` WHERE user_role = '".$data['user_type']."' AND user_id IN (".implode(',',$data['user']).") ");
		return $query->rows;
	}

	public function getPatientReceiver($data)
	{
		$query = $this->database->query("SELECT CONCAT(firstname, ' ', lastname) AS name, email FROM `" . DB_PREFIX . "patients` WHERE id IN (".implode(',',$data['user']).") AND status = '1' ");
		return $query->rows;
	}

	public function createMailLog($data)
	{
		$data['datetime'] = date('Y-m-d H:i:s');
		$this->database->query("INSERT INTO `" . DB_PREFIX . "email_logs` (`email_to`, `subject`, `message`, `type`, `type_id`, `user_id`, `date_of_joining`) VALUES (?, ?, ?, ?, ?, ?, ?)", array($this->database->escape($data['email']), $this->database->escape($data['subject']), $data['message'], $this->database->escape($data['type']), (int)$data['type_id'], (int)$data['user_id'], $data['datetime']));
	}

	public function getEmailLog($period)
	{
		$query = $this->database->query("SELECT el.*, CONCAT(u.firstname, ' ', u.lastname) AS user FROM `" . DB_PREFIX . "email_logs` AS el LEFT JOIN `" . DB_PREFIX . "users` AS u ON u.user_id = el.user_id WHERE el.date_of_joining between '".$period['start']."' AND '".$period['end']."' ORDER BY el.date_of_joining DESC");
		return $query->rows;
	}
}