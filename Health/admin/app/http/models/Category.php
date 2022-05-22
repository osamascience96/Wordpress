<?php

/**
* Category Model
*/
class Category extends Model
{
	public function allCategories()
	{
		$query = $this->database->query("SELECT c1.id, c1.name, c2.name as `parent` FROM `" . DB_PREFIX . "category` c1 LEFT OUTER JOIN `" . DB_PREFIX . "category` c2 on c1.parent = c2.id ORDER BY c1.parent, c1.id");
		return $query->rows;
	}

	public function getCategory($id)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "category` WHERE `id` = ? LIMIT 1", array($this->database->escape($id)));
		
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function updateCategory($data)
	{
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "category` SET `name` = ?, `slug` = ?, `icon` = ?, `parent` = ? WHERE `id` = ?", array($this->database->escape($data['name']), $this->database->escape($data['slug']), $this->database->escape($data['icon']), (int)$data['parent'], (int)$data['id']));
	}

	public function createCategory($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "category` (`name`, `slug`, `icon`, `parent`) VALUES (?, ?, ?, ?)", array($this->database->escape($data['name']), $this->database->escape($data['slug']), $this->database->escape($data['icon']), (int)$data['parent']));
	}

	public function deleteCategory($id)
	{
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "category` WHERE `id` = ?", array((int)$id));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
}