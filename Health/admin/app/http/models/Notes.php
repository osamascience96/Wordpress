<?php

/**
* Items
*/
class Notes extends Model
{
	public function getNotes()
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "notes`");
		return $query->rows;
	}

	public function getSearchedNotes($data)
	{
		$query = $this->database->query("SELECT note AS label, type FROM `" . DB_PREFIX . "notes` WHERE note like '%".$data['term']."%' AND type = '".$data['type']."' LIMIT 5");
		return $query->rows;
	}

	public function updateNote($data)
	{
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "notes` SET `type` = ?, `note` = ? WHERE `id` = ? ", array($data['type'], $data['note'], (int)$data['id']));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function createNote($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "notes` (`type`, `note`) VALUES (?, ?)", array($data['type'], $data['note']));
		if ($query->num_rows > 0) {
			return $this->database->last_id();
		} else {
			return false;
		}
	}

	public function deleteNote($id)
	{
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "notes` WHERE `id` = ?", array((int)$id ));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
}