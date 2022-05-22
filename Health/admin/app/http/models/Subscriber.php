<?php

/**
* Subscriber Model
*/
class Subscriber extends Model
{
	public function allSubscribers()
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "subscribe` ORDER BY `date_of_joining` DESC");
		return $query->rows;
	}

	public function getSubscriber($id)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "subscribe` WHERE `id` = ? LIMIT 1", array($this->database->escape($id)));
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function updateSubscriber($data)
	{
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "subscribe` SET `email` = ?, `status` = ? WHERE `id` = ?" , array($this->database->escape($data['mail']), (int)$data['status'], (int)$data['id']));
		return true;
	}

	public function createSubscriber($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "subscribe` (`email`, `status`, `date_of_joining`) VALUES (?, ?, ?)", array($this->database->escape($data['mail']), 1, $data['datetime']));
		if ($query->num_rows > 0) {
			return $this->database->last_id();
		} else {
			return false;
		}
	}

	public function deleteSubscriber($id)
	{
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "subscribe` WHERE `id` = ?", array((int)$id));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
}