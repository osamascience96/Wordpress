<?php

/**
 * 
 */
class Upload extends Model
{
	public function createAttachments($data)
	{
		$this->database->query("INSERT INTO `" . DB_PREFIX . "attached_files` (`file`, `type`, `type_id`, `user_id`, `date_of_joining`) VALUES (?, ?, ?, ?, ?) ", array($data['file'], $this->database->escape($data['type']), (int)$data['id'], (int)$data['user_id'], $data['datetime']));
	}

	public function getMedia()
	{
		$query = $this->database->query("SELECT `id`, `media` FROM `" . DB_PREFIX . "media`");
		if ($query->num_rows > 0) {
			return $query->rows;
		} else {
			return false;
		}
	}

	public function isMedia($data)
	{
		$query = $this->database->query("SELECT id FROM `" . DB_PREFIX . "media` WHERE id = ? AND media = ?", array((int)$data['id'], $data['name']));
		if ($query->row > 0) { return true; }
		else { return false; }
	}

	public function createMedia($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "media` (`media`, `ext`, `user_id`, `date_of_joining`) VALUES (?, ?, ?, ?) ", array($this->database->escape($data['file']), $data['ext'], (int)$data['user_id'], $data['datetime']));
		if ($query->row > 0) {
			return $this->database->last_id(); 
		} else {
			return false;
		}
	}

	public function deleteMedia($data)
	{
		$this->database->query("DELETE FROM `" . DB_PREFIX . "media` WHERE `media` = ? AND `id` = ?" , array($this->database->escape($data['name']), (int)$data['id']));
	}

	public function createGallery($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "gallery` (`media`, `ext`, `user_id`, `date_of_joining`) VALUES (?, ?, ?, ?) ", array($this->database->escape($data['file']), $data['ext'], (int)$data['user_id'], $data['datetime']));
		if ($query->row > 0) {
			return $this->database->last_id(); 
		} else {
			return false;
		}
	}

	public function isGallery($data)
	{
		$query = $this->database->query("SELECT id FROM `" . DB_PREFIX . "gallery` WHERE id = ? AND media = ?", array((int)$data['id'], $data['name']));
		if ($query->row > 0) { return true; }
		else { return false; }
	}

	public function deleteGallery($data)
	{
		$this->database->query("DELETE FROM `" . DB_PREFIX . "gallery` WHERE `media` = ? AND `id` = ?" , array($this->database->escape($data['name']), (int)$data['id']));
	}

	public function deleteAttachments($data)
	{
		$this->database->query("DELETE FROM `" . DB_PREFIX . "attached_files` WHERE `file` = ? AND `type` = ? AND `type_id` = ?" , array($this->database->escape($data['name']), $data['type'], (int)$data['type_id']));
	}
}