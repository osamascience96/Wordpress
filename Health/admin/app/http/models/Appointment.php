<?php

/**
* Appointment Model
*/
class Appointment extends Model
{
	public function getAppointments($period, $doctor = NULL)
	{
		if ($doctor == NULL) {
			$query = $this->database->query("SELECT a.*, d.id AS doctor_id, CONCAT(d.firstname, ' ', d.lastname) AS doctor, d.picture AS picture, d.email AS doctor_email, dep.name AS department, user.id AS patient_id FROM `" . DB_PREFIX . "appointments` AS a LEFT JOIN `" . DB_PREFIX . "doctors` AS d ON d.id = a.doctor_id LEFT JOIN `" . DB_PREFIX . "departments` AS dep ON dep.id = a.department_id LEFT JOIN `" . DB_PREFIX . "patients` AS user ON user.email = a.email WHERE a.date between '".$period['start']."' AND '".$period['end']."' ORDER BY date DESC");
		} else {
			$query = $this->database->query("SELECT a.*, d.id AS doctor_id, CONCAT(d.firstname, ' ', d.lastname) AS doctor, d.picture AS picture, d.email AS doctor_email, dep.name AS department, user.id AS patient_id FROM `" . DB_PREFIX . "appointments` AS a LEFT JOIN `" . DB_PREFIX . "doctors` AS d ON d.id = a.doctor_id LEFT JOIN `" . DB_PREFIX . "departments` AS dep ON dep.id = a.department_id LEFT JOIN `" . DB_PREFIX . "patients` AS user ON user.email = a.email WHERE a.date between '".$period['start']."' AND '".$period['end']."' AND a.doctor_id = '".(int)$doctor."' ORDER BY date DESC");
		}
		return $query->rows;
	}

	public function getAppointment($id, $doctor = NULL)
	{
		if ($doctor == NULL) {
			$query = $this->database->query("SELECT a.*, CONCAT(dr.firstname, ' ', dr.lastname) AS doctor_name, dr.email AS doctor_email, dr.mobile AS doctor_mobile, dr.picture AS doctor_picture, d.name AS department, p.id AS prescription_id, p.prescription AS prescription, pt.id AS patient_id, pt.bloodgroup, pt.gender, TIMESTAMPDIFF (YEAR, pt.dob, CURDATE()) AS age_year, TIMESTAMPDIFF(MONTH, pt.dob, now()) % 12 AS age_month, pt.history FROM `" . DB_PREFIX . "appointments` AS a LEFT JOIN `" . DB_PREFIX . "doctors` AS dr ON dr.id = a.doctor_id LEFT JOIN `" . DB_PREFIX . "departments` AS d ON d.id = a.department_id LEFT JOIN `" . DB_PREFIX . "prescription` AS p ON p.appointment_id = a.id LEFT JOIN `" . DB_PREFIX . "patients` AS pt ON pt.email = a.email WHERE a.id = '".(int)$id."' LIMIT 1");
		} else {
			$query = $this->database->query("SELECT a.*, CONCAT(dr.firstname, ' ', dr.lastname) AS doctor_name, dr.email AS doctor_email, dr.mobile AS doctor_mobile, dr.picture AS doctor_picture, d.name AS department, p.id AS prescription_id, p.prescription AS prescription, pt.id AS patient_id, pt.bloodgroup, pt.gender, TIMESTAMPDIFF (YEAR, pt.dob, CURDATE()) AS age_year, TIMESTAMPDIFF(MONTH, pt.dob, now()) % 12 AS age_month, pt.history FROM `" . DB_PREFIX . "appointments` AS a LEFT JOIN `" . DB_PREFIX . "doctors` AS dr ON dr.id = a.doctor_id LEFT JOIN `" . DB_PREFIX . "departments` AS d ON d.id = a.department_id LEFT JOIN `" . DB_PREFIX . "prescription` AS p ON p.appointment_id = a.id LEFT JOIN `" . DB_PREFIX . "patients` AS pt ON pt.email = a.email WHERE a.id = '".(int)$id."' AND a.doctor_id = '".(int)$doctor."' LIMIT 1");
		}
		
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function getAppointmentView($id, $doctor = NULL)
	{
		if ($doctor == NULL) {
			$query = $this->database->query("SELECT a.*, CONCAT(dr.firstname, ' ', dr.lastname) AS doctor_name, dr.email AS doctor_email, dr.mobile AS doctor_mobile, dr.picture AS doctor_picture, d.name AS department, p.id AS prescription_id, p.prescription AS prescription, pt.id AS patient_id, pt.bloodgroup, pt.gender, TIMESTAMPDIFF (YEAR, pt.dob, CURDATE()) AS age_year, TIMESTAMPDIFF(MONTH, pt.dob, now()) % 12 AS age_month, pt.history FROM `" . DB_PREFIX . "appointments` AS a LEFT JOIN `" . DB_PREFIX . "doctors` AS dr ON dr.id = a.doctor_id LEFT JOIN `" . DB_PREFIX . "departments` AS d ON d.id = a.department_id LEFT JOIN `" . DB_PREFIX . "prescription` AS p ON p.appointment_id = a.id LEFT JOIN `" . DB_PREFIX . "patients` AS pt ON pt.email = a.email WHERE a.id = '".(int)$id."' LIMIT 1");
		} else {
			$query = $this->database->query("SELECT a.*, CONCAT(dr.firstname, ' ', dr.lastname) AS doctor_name, dr.email AS doctor_email, dr.mobile AS doctor_mobile, dr.picture AS doctor_picture, d.name AS department, p.id AS prescription_id, p.prescription AS prescription, pt.id AS patient_id, pt.bloodgroup, pt.gender, TIMESTAMPDIFF (YEAR, pt.dob, CURDATE()) AS age_year, TIMESTAMPDIFF(MONTH, pt.dob, now()) % 12 AS age_month, pt.history FROM `" . DB_PREFIX . "appointments` AS a LEFT JOIN `" . DB_PREFIX . "doctors` AS dr ON dr.id = a.doctor_id LEFT JOIN `" . DB_PREFIX . "departments` AS d ON d.id = a.department_id LEFT JOIN `" . DB_PREFIX . "prescription` AS p ON p.appointment_id = a.id LEFT JOIN `" . DB_PREFIX . "patients` AS pt ON pt.email = a.email WHERE a.id = '".(int)$id."' AND a.doctor_id = '".(int)$doctor."' LIMIT 1");
		}
		
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function getPrescription($id)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "prescription` WHERE appointment_id = ? LIMIT 1", array((int)$id));
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function getClinicalNotes($id)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "appointment_notes` WHERE appointment_id = ? LIMIT 1", array((int)$id));
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function clinicalNotesPDF($id)
	{
		$query = $this->database->query("SELECT an.*, CONCAT(d.firstname, ' ', d.lastname) AS doctor  FROM `" . DB_PREFIX . "appointment_notes` AS an LEFT JOIN `" . DB_PREFIX . "doctors` AS d ON d.id = an.doctor_id WHERE an.id = ? LIMIT 1", array((int)$id));
		
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}


	public function getSingleRecords($id)
	{
		$query = $this->database->query("SELECT a.id, a.name, a.notes, a.date, CONCAT(d.firstname, ' ', d.lastname) AS doctor FROM `" . DB_PREFIX . "appointments` AS a LEFT JOIN `" . DB_PREFIX . "doctors` AS d ON d.id = a.doctor_id WHERE a.id = ? LIMIT 1", array($this->database->escape($id)));
		return $query->row;
	}

	public function createPatientDoctor($data)
	{
		$this->database->query("INSERT INTO `" . DB_PREFIX . "patient_doctor` (`patient_id`, `doctor_id`, `user_id`, `appointment_id`) VALUES (?, ?, ?, ?)",array($data['appointment']['patient_id'], $data['user']['doctor'], $data['user']['user_id'], $data['appointment']['id']));
	}

	public function updateAppointment($data)
	{
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "appointments` SET `name` = ?, `email` = ?, `mobile` = ?,  `date` = ?, `time` = ?, `message` = ?, `slot` = ?, `department_id` = ?, `status` = ?, `doctor_id` = ?, `patient_id` = ? WHERE `id` = ? " , array($this->database->escape($data['name']), $this->database->escape($data['mail']), $this->database->escape($data['mobile']), $this->database->escape($data['date']), $this->database->escape($data['time']), $data['message'], $data['slot'], (int)$data['department'], (int)$data['status'], (int)$data['doctor'], (int)$data['patient_id'], (int)$data['id']));
		
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function updateSideBarAppointment($data)
	{
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "appointments` SET `name` = ?, `email` = ?, `mobile` = ?,  `date` = ?, `time` = ?, `slot` = ?, `department_id` = ?, `status` = ?, `doctor_id` = ?, `patient_id` = ? WHERE `id` = ? " , array($this->database->escape($data['name']), $this->database->escape($data['mail']), $this->database->escape($data['mobile']), $this->database->escape($data['date']), $this->database->escape($data['time']), $data['slot'], (int)$data['department'], (int)$data['status'], (int)$data['doctor'], (int)$data['patient_id'], (int)$data['id']));

		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function updatePrescription($data)
	{
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "prescription` SET `name` = ?, `email` = ?, `prescription` = ?, `doctor_id` = ?, `patient_id` = ? WHERE `id` = ? " , array($this->database->escape($data['appointment']['name']), $this->database->escape($data['appointment']['mail']), $data['prescription']['medicine'], (int)$data['appointment']['doctor'], (int)$data['appointment']['patient_id'], (int)$data['prescription']['id']));
		
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function createPrescription($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "prescription` (`name`, `email`, `prescription`, `doctor_id`, `appointment_id`, `patient_id`, `user_id`, `date_of_joining`) VALUES (?, ?, ?, ?, ?, ?, ?, ?) " , array($this->database->escape($data['appointment']['name']), $this->database->escape($data['appointment']['mail']), $data['prescription']['medicine'], (int)$data['appointment']['doctor'], (int)$data['appointment']['id'], (int)$data['appointment']['patient_id'], (int)$data['appointment']['user_id'], $data['appointment']['datetime']));
		
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function createAppointment($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "appointments` (`name`, `email`, `mobile`, `date`, `time`, `slot`, `department_id`, `status`, `doctor_id`, `patient_id`, `date_of_joining`, `appointment_id`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ", array($this->database->escape($data['name']), $this->database->escape($data['mail']), $this->database->escape($data['mobile']), $this->database->escape($data['date']), $this->database->escape($data['time']), $data['slot'], (int)$data['department'], (int)$data['status'], (int)$data['doctor'], (int)$data['patient_id'], $data['datetime'], $data['appointment_id']));

		if ($query->num_rows > 0) {
			return $this->database->last_id();
		} else {
			return false;
		}
	}

	public function updateNotes($data)
	{
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "appointment_notes` SET `name` = ?, `email` = ?, `notes` = ?, `appointment_id` = ?, `doctor_id` = ?, `patient_id` = ? WHERE `id` = ? " , array($this->database->escape($data['appointment']['name']), $this->database->escape($data['appointment']['mail']), $data['notes']['notes'], (int)$data['appointment']['id'], (int)$data['appointment']['doctor'], (int)$data['appointment']['patient_id'], (int)$data['notes']['id']));
		
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function createNotes($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "appointment_notes` (`name`, `email`, `notes`, `appointment_id`, `doctor_id`, `patient_id`, `user_id`, `date_of_joining`) VALUES (?, ?, ?, ?, ?, ?, ?, ?) " , array($this->database->escape($data['appointment']['name']), $this->database->escape($data['appointment']['mail']), $data['notes']['notes'], (int)$data['appointment']['id'], (int)$data['appointment']['doctor'], (int)$data['appointment']['patient_id'], (int)$data['appointment']['user_id'], $data['appointment']['datetime']));
		
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function getDoctors()
	{
		$query = $this->database->query("SELECT d.id, CONCAT(d.firstname, ' ', d.lastname) AS name, d.weekly, d.national, dep.name AS department, dep.id AS department_id FROM `" . DB_PREFIX . "doctors` AS d LEFT JOIN `" . DB_PREFIX . "departments` AS dep ON dep.id = d.department_id WHERE d.appointment_status = ? ORDER BY d.department_id ASC", array(1));
		return $query->rows;
	}

	public function getDoctorData($id)
	{
		$query = $this->database->query("SELECT CONCAT(firstname, ' ', lastname) AS name, `email` FROM `" . DB_PREFIX . "doctors` WHERE id = ? LIMIT 1", array($id));
		return $query->row;
	}

	public function getPatientInfo($id)
	{
		$query = $this->database->query("SELECT `id`, CONCAT(`firstname`, ' ', `lastname`) AS name, `email`, `mobile` FROM `" . DB_PREFIX . "patients` WHERE id = ? LIMIT 1", array($id));
		return $query->row;
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

	public function deleteAppointment($id)
	{
		$this->database->query("DELETE FROM `" . DB_PREFIX . "appointment_notes` WHERE `appointment_id` = ?", array((int)$id));
		$this->database->query("DELETE FROM `" . DB_PREFIX . "prescription` WHERE `appointment_id` = ?", array((int)$id));
		$this->database->query("DELETE FROM `" . DB_PREFIX . "reports` WHERE `appointment_id` = ?", array((int)$id));
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "appointments` WHERE `id` = ?", array((int)$id));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function getReports($id)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "reports` WHERE `appointment_id` = ?", array((int)$id));
		if ($query->num_rows > 0) {
			return  $query->rows;
		} else {
			return false;
		}
	}

	public function createReport($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "reports` (`name`, `report`, `email`, `appointment_id`, `patient_id`, `user_id`) VALUES (?, ?, ?, ?, ?, ?) ", array($data['report_name'], $this->database->escape($data['report']), $this->database->escape($data['email']), (int)$data['id'], (int)$data['patient'], (int)$data['user_id']));
	}

	public function deleteReport($data)
	{
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "reports` WHERE `report` = ? AND `appointment_id` = ?" , array($this->database->escape($data['report']), (int)$data['appointment_id']));

	}

	public function getSearchedMedicine($data)
	{
		$query = $this->database->query("SELECT id, name AS label, generic FROM `" . DB_PREFIX . "medicines` WHERE name like '%".$data."%' LIMIT 5");
		return $query->rows;
	}
}