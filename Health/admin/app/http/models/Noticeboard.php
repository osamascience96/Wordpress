<?php

/**
 * Noticeboard
 */
class Noticeboard extends Controller
{
	public function getNotices()
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "noticeboard` ORDER BY date_of_joining DESC");
		return $query->rows;
	}

	public function getNotice($id)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "noticeboard` WHERE `id` = ? LIMIT 1", array($this->database->escape($id)));
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function updateNotice($data)
	{
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "noticeboard` SET `title` = ?, `description` = ?, `start_date` = ?, `end_date` = ?, `status` = ? WHERE `id` = ?", array($this->database->escape($data['title']), $data['description'], $data['start_date'], $data['end_date'], (int)$data['status'], (int)$data['id']));
	}

	public function createNotice($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "noticeboard` (`title`, `description`, `start_date`, `end_date`, `status`, `user_id`, `date_of_joining`) VALUES (?, ?, ?, ?, ?, ?, ?)", array($this->database->escape($data['title']), $data['description'], $data['start_date'], $data['end_date'], (int)$data['status'], (int)$data['user_id'], $data['datetime']));
		if ($query->num_rows > 0) {
			return $this->database->last_id();
		} else {
			return false;
		}
	}

	public function deleteNotice($id)
	{
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "noticeboard` WHERE `id` = ?", array((int)$id));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
}