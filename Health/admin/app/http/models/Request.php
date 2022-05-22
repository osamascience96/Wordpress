<?php

/**
* Request Model
*/
class Request extends Model
{
	public function allRequests()
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "request` ORDER BY `date_of_joining` DESC");
		if ($query->num_rows > 0) {
			return $query->rows;
		} else {
			return false;
		}
	}

	public function getRequest($id)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "request` WHERE `id` = ? LIMIT 1", array($this->database->escape($id)));
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function updateRequest($data)
	{
		$this->database->query("UPDATE `" . DB_PREFIX . "request` SET `name` = ?, `email` = ?, `mobile` = ?, `subject` = ?, `message` = ?, `remark` = ?, `status` = ?, `user_id` = ? WHERE `id` = ?", array($this->database->escape($data['name']), $this->database->escape($data['mail']), $this->database->escape($data['mobile']), $data['subject'], $data['message'], $data['remark'], (int)$data['status'], (int)$data['user_id'], (int)$data['id']));
		return true;
	}

	public function createRequest($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "request` (`name`, `email`, `mobile`, `subject`, `message`, `remark`) VALUES (?, ?, ?, ?, ?, ?)", array($this->database->escape($data['name']), $this->database->escape($data['email']), $this->database->escape($data['mobile']), $data['subject'], $data['message'], $data['remark']));
		if ($query->num_rows > 0) {
			return $this->database->last_id();
		} else {
			return false;
		}
	}

	public function deleteRequest($id)
	{
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "request` WHERE `id` = ?", array((int)$id));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
}