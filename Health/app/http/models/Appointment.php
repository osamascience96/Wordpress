<?php

/**
* Make an appointment model
*/
class Appointment extends Model
{
	public function getDoctors()
	{
		$query = $this->database->query("SELECT d.id, CONCAT(d.firstname, ' ', d.lastname) AS name, d.weekly, d.national, dp.name AS department, dp.id AS department_id FROM `" . DB_PREFIX . "doctors` AS d LEFT JOIN `" . DB_PREFIX . "departments` AS dp ON dp.id = d.department_id WHERE d.appointment_status = ? ORDER BY dp.id", array(1));
		return $query->rows;
	}

	public function getDepartments()
	{
		$query = $this->database->query("SELECT id, name FROM `" . DB_PREFIX . "departments` WHERE status = 1");
		return $query->rows;
	}

	public function getDoctorTime($doctor)
	{
		$query = $this->database->query("SELECT `time` FROM `" . DB_PREFIX . "doctors` WHERE `id` = ? LIMIT 1", array($this->database->escape($doctor)));
		if ($query->num_rows > 0) {
			return  $query->row['time'];
		} else {
			return false;
		}
	}
	
	public function bookedSlot($date, $doctor) 
	{
		$date = date("Y-m-d", strtotime($date));
		$query = $this->database->query("SELECT `time` FROM `" . DB_PREFIX . "appointments` WHERE `date`= ? AND `doctor_id` = ? AND `status` != ? ", array($this->database->escape($date), $this->database->escape($doctor), 1));
		$result = [];
		if ($query->num_rows > 0) {
			foreach ($query->rows as $key => $value) {
				$result[] = $value['time'];
			}
		}
		return $result;
	}

	public function isAppointmentMade($data) 
	{
		$date = date("Y-m-d", strtotime($data['date']));
		$query = $this->database->query("SELECT `time` FROM `" . DB_PREFIX . "appointments` WHERE `date` = ? AND `doctor_id` = ? AND `time` = ? AND `status` != ? ", array($this->database->escape($date), $this->database->escape($data['doctor']), $this->database->escape($data['time']), 1));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function createAppointment($data) 
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "appointments` (`name`, `email`, `mobile`, `date`, `time`, `slot`, `message`,  `department_id`, `status`, `doctor_id`, `patient_id`, `date_of_joining`, `appointment_id`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ", array($this->database->escape($data['name']), $this->database->escape($data['mail']), $this->database->escape($data['mobile']), $this->database->escape($data['date']), $this->database->escape($data['time']), $this->database->escape($data['slot']), $data['message'], $this->database->escape($data['department']), '2', $this->database->escape($data['doctor']), $this->database->escape($data['patient_id']), $data['datetime'], $data['appointment_id']));
		if ($query->num_rows > 0) {
			return $this->database->last_id();
		} else {
			return false;
		}
	}

	public function getDoctor($id)
	{
		$query = $this->database->query("SELECT CONCAT(firstname, ' ', lastname) AS name, `email` FROM `" . DB_PREFIX . "doctors` WHERE `id` = ? LIMIT 1 ", array($this->database->escape($id)));
		return $query->row;
	}
}


