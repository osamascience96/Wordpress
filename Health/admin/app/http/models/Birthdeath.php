<?php

/**
 * Birthdeath
 */
class Birthdeath extends Model
{
	public function birthRecords()
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "birth_records` ORDER BY `date_of_joining`");
		return $query->rows;
	}

	public function getDoctors()
	{
		$query = $this->database->query("SELECT id, CONCAT(firstname, ' ', lastname) AS name FROM `" . DB_PREFIX . "doctors` ORDER BY `date_of_joining`");
		return $query->rows;
	}

	public function birthRecord($id)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "birth_records` WHERE `id` = ? LIMIT 1", array((int)$id));
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function birthDeathDocuments($id, $name)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "attached_files` WHERE type_id = ? AND type = ?", array($id, $name));
		return $query->rows;
	}

	public function updateBirthRecord($data)
	{
		$this->database->query("UPDATE `" . DB_PREFIX . "birth_records` SET `child` = ?, `date` = ?, `time` = ?, `gender` = ?, `weight` = ?, `height` = ?, `mother_name` = ?, `mother_email` = ?, `mother_mobile` = ?, `mother_id` = ?, `father_name` = ?, `father_email` = ?, `father_mobile` = ?, `father_id` = ?, `remark` = ?, `doctor_name` = ?, `doctor_id` = ?  WHERE `id` = ?", array($this->database->escape($data['child']), $data['date'], $this->database->escape($data['time']), $data['gender'], $data['weight'], $data['height'], $data['mother_name'], $data['mother_email'], $data['mother_mobile'], $data['mother_id'], $data['father_name'], $data['father_email'], $data['father_mobile'], $data['father_id'], $data['remark'], $data['doctor_name'], $data['doctor_id'], (int)$data['id']));
	}

	public function createBirthRecord($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "birth_records` (`child`, `date`, `time`, `gender`, `weight`, `height`, `mother_name`, `mother_email`, `mother_mobile`, `mother_id`, `father_name`, `father_email`, `father_mobile`, `father_id`, `remark`, `doctor_name`, `doctor_id`, `user_id`, `date_of_joining`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array($this->database->escape($data['child']), $data['date'], $this->database->escape($data['time']), $data['gender'], $data['weight'], $data['height'], $data['mother_name'], $data['mother_email'], $data['mother_mobile'], $data['mother_id'], $data['father_name'], $data['father_email'], $data['father_mobile'], $data['father_id'], $data['remark'], $data['doctor_name'], $data['doctor_id'], $data['user_id'], $data['datetime']));
		
		if ($query->num_rows > 0) {
			return $this->database->last_id();
		} else {
			return false;
		}
	}

	public function deleteBirthRecord($id)
	{
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "birth_records` WHERE `id` = ?", array((int)$id));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function deathRecords()
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "death_records` ORDER BY `date_of_joining`");
		return $query->rows;
	}

	public function deathRecord($id)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "death_records` WHERE `id` = ? LIMIT 1", array((int)$id));
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function updateDeathRecord($data)
	{
		$this->database->query("UPDATE `" . DB_PREFIX . "death_records` SET `name` = ?, `date` = ?, `time` = ?, `gender` = ?, `guardian_name` = ?, `guardian_email` = ?, `guardian_mobile` = ?, `remark` = ?, `doctor_name` = ?, `doctor_id` = ? WHERE `id` = ?", array($this->database->escape($data['name']), $data['date'], $this->database->escape($data['time']), $data['gender'], $data['guardian_name'], $data['guardian_email'], $data['guardian_mobile'], $data['remark'], $data['doctor_name'], $data['doctor_id'], (int)$data['id']));
	}

	public function createDeathRecord($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "death_records` (`name`, `date`, `time`, `gender`, `guardian_name`, `guardian_email`, `guardian_mobile`, `remark`, `doctor_name`, `doctor_id`, `user_id`, `date_of_joining`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array($this->database->escape($data['name']), $data['date'], $this->database->escape($data['time']), $data['gender'], $data['guardian_name'], $data['guardian_email'], $data['guardian_mobile'], $data['remark'], $data['doctor_name'], $data['doctor_id'], $data['user_id'], $data['datetime']));

		if ($query->num_rows > 0) {
			return $this->database->last_id();
		} else {
			return false;
		}
	}

	public function deleteDeathRecord($id)
	{
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "death_records` WHERE `id` = ?", array((int)$id));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
}