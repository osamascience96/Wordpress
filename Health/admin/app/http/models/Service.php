<?php

/**
* Service Model
*/
class Service extends Model
{
	public function allServices()
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "service` ORDER BY priority ASC, date_of_joining");
		return $query->rows;
	}

	public function getService($id)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "service` WHERE `id` = ? LIMIT 1", array($this->database->escape($id)));

		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function checkUrlinDb($data)
	{
		$query = $this->database->query( "SELECT COUNT(id) AS count FROM `" . DB_PREFIX . "service` WHERE service_url = ?", array($data['url']));
		if ($query->row['count'] > 0) {
			return true;
		} else {
			return false;
		}

	}

	public function updateServiceUrl($data)
	{
		$this->database->query("UPDATE `" . DB_PREFIX . "service` SET `service_url` = ? WHERE `id` = ?" , array($data['url'], (int)$data['id']));
	}

	public function updateService($data)
	{
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "service` SET `name` = ?, `short_post` = ?, `long_post` = ?, `icon` = ?, `picture` = ?, `status` = ?, `priority` = ? WHERE `id` = ?", array($this->database->escape($data['name']), $data['short_post'], $data['long_post'], $this->database->escape($data['icon']), $this->database->escape($data['picture']), (int)$data['status'], (int)$data['priority'], (int)$data['id']));
		return true;
	}

	public function createService($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "service` (`name`, `short_post`, `long_post`, `icon`, `picture`, `status`, `priority`, `date_of_joining`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", array($this->database->escape($data['name']), $data['short_post'], $data['long_post'], $this->database->escape($data['icon']), $this->database->escape($data['picture']), (int)$data['status'], (int)$data['priority'], $data['datetime']));
		if ($query->num_rows > 0) {
			return $this->database->last_id();
		} else {
			return false;
		}
	}

	public function deleteService($id)
	{
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "service` WHERE `id` = ?", array((int)$id));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
}