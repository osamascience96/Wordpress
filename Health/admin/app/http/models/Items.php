<?php

/**
* Items
*/
class Items extends Model
{
	public function getItems()
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "items`");
		return $query->rows;
	}

	public function getItem($id)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "items` WHERE `id` = ? LIMIT 1", array((int)$id));
		return $query->row;
	}

	public function getSearchedItems($data)
	{
		$query = $this->database->query("SELECT id As value, name AS label, price, description FROM `" . DB_PREFIX . "items` WHERE name like '%".$data."%' LIMIT 5");
		return $query->rows;
	}
	
	public function updateItem($data)
	{
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "items` SET `name` = ?, `price` = ?, `description` = ? WHERE `id` = ? ", array($data['name'], (float)$data['price'], $data['description'], (int)$data['id']));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function createItem($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "items` (`name`, `price`, `description`, `date_of_joining`) VALUES (?, ?, ?, ?)", array($data['name'], (float)$data['price'], $data['description'], $data['datetime']));
		if ($query->num_rows > 0) {
			return $this->database->last_id();
		} else {
			return false;
		}
	}

	public function deleteItem($id)
	{
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "items` WHERE `id` = ?", array((int)$id ));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
}