<?php 

/**
* Report
*/
class Report extends Model
{
	public function createReport($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "reports` (`report`, `email`, `appointment_id`) VALUES (?, ?, ?) ", array($this->database->escape($data['report']), $this->database->escape($data['email']), (int)$data['appointment_id']));
		return $query->row;
	}


	public function deleteReport($data)
	{
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "reports` WHERE `report` = ? AND `appointment_id` = ?" , array($this->database->escape($data['report']), (int)$data['appointment_id']));

	}
}