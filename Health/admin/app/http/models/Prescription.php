<?php

/**
 * Prescription
 */
class Prescription extends Model
{
	public function getPrescriptions($period, $doctor = NULL)
	{
		if ($doctor == NULL) {
			$query = $this->database->query("SELECT p.*, CONCAT(d.firstname, ' ', d.lastname) AS doctor FROM `" . DB_PREFIX . "prescription` AS p LEFT JOIN `" . DB_PREFIX . "doctors` AS d ON d.id = p.doctor_id WHERE p.date_of_joining between '".$period['start']."' AND '".$period['end']."' ORDER BY date_of_joining DESC");
		} else {
			$query = $this->database->query("SELECT p.*, CONCAT(d.firstname, ' ', d.lastname) AS doctor FROM `" . DB_PREFIX . "prescription` AS p LEFT JOIN `" . DB_PREFIX . "doctors` AS d ON d.id = p.doctor_id WHERE p.date_of_joining between '".$period['start']."' AND '".$period['end']."' AND p.doctor_id = '".(int)$doctor."' ORDER BY date_of_joining DESC");

		}
		return $query->rows;
	}

	public function getPrescription($id, $doctor = NULL)
	{
		if ($doctor == NULL) {
			$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "prescription` WHERE id = ?", array($id));
		} else {
			$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "prescription` WHERE id = ? AND doctor_id", array($id, $doctor));
		}
		return $query->row;
	}

	public function getPrescriptionView($id, $doctor = NULL)
	{
		if ($doctor == NULL) {
			$query = $this->database->query("SELECT p.*, p.name AS patient, CONCAT(firstname, ' ', lastname) AS doctor FROM `" . DB_PREFIX . "prescription` AS p LEFT JOIN `" . DB_PREFIX . "doctors` AS d ON d.id = p.doctor_id WHERE p.id = ?", array($id));
		} else {
			$query = $this->database->query("SELECT p.*, p.name AS patient, CONCAT(firstname, ' ', lastname) AS doctor FROM `" . DB_PREFIX . "prescription` AS p LEFT JOIN `" . DB_PREFIX . "doctors` AS d ON d.id = p.doctor_id WHERE p.id = ? AND p.doctor_id = ?", array($id, $doctor));
		}
		
		return $query->row;
	}

	public function getDoctors()
	{
		$query = $this->database->query("SELECT id, CONCAT(firstname, ' ', lastname) AS name FROM `" . DB_PREFIX . "doctors` WHERE status = 1");
		return $query->rows;
	}

	public function updatePrescription($data)
	{
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "prescription` SET `name` = ?, `email` = ?, `prescription` = ?, `doctor_id` = ?, `patient_id` = ? WHERE `id` = ? " , array($this->database->escape($data['name']), $this->database->escape($data['email']), $data['medicine'], $this->database->escape($data['doctor']), $data['patient_id'], (int)$data['id']));
	}

	public function createPrescription($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "prescription` (`name`, `email`, `prescription`, `doctor_id`, `patient_id`, `user_id`, `date_of_joining`) VALUES (?, ?, ?, ?, ?, ?, ?) " , array($this->database->escape($data['name']), $this->database->escape($data['email']), $data['medicine'], $this->database->escape($data['doctor']), $data['patient_id'], $data['user_id'], $data['datetime']));
		
		if ($query->num_rows > 0) {
			return $this->database->last_id();
		} else {
			return false;
		}
	}

	public function deletePrescription($id)
	{
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "prescription` WHERE `id` = ?", array((int)$id ));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
}