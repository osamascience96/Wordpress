<?php

/**
* Types Model
*/
class Types extends Model
{
	public function getExpenseTypes()
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "expense_type`");
		return $query->rows;
	}

	public function updateExpenseType($data)
	{
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "expense_type` SET `name` = ?, `description` = ?, `status` = ? WHERE `id` = ? ", array($this->database->escape($data['name']), $data['description'], (int)$data['status'], (int)$data['id']));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function createExpenseType($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "expense_type` (`name`, `description`, `status`) VALUES (?, ?, ?)", array($this->database->escape($data['name']), $data['description'], (int)$data['status']));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteExpenseType($id)
	{
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "expense_type` WHERE `id` = ?", array((int)$id ));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
}