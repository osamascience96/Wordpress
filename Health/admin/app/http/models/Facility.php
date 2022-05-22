<?php

/**
* Facility Model
*/
class Facility extends Model
{
	public function allFacilities()
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "facility`");
		return $query->rows;
	}

	public function getfacility($id)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "facility` WHERE `id` = ? LIMIT 1", array($this->database->escape($id)));
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function updateFacility($data)
	{
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "facility` SET `name` = ?, `description` = ?, `icon` = ?, `status` = ? WHERE `id` = ?", array($this->database->escape($data['name']), $data['description'], $this->database->escape($data['icon']), (int)$data['status'], (int)$data['id']));
	}

	public function createFacility($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "facility` (`name`, `description`, `icon`, `status`, `date_of_joining`) VALUES (?, ?, ?, ?, ?)", array($this->database->escape($data['name']), $data['description'], $this->database->escape($data['icon']), (int)$data['status'], $data['datetime']));
		if ($query->num_rows > 0) {
			return $this->database->last_id();
		} else {
			return false;
		}
	}

	public function deleteFacility($id)
	{
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "facility` WHERE `id` = ?", array((int)$id));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
}