<?php

/**
* Info Model
*/

class Setting extends Model
{
	public function getSetting()
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "setting` WHERE `name` IN ('siteinfo', 'sociallink')");
		return $query->rows;
	}

	public function updateSetting($data)
	{
		$this->database->query("UPDATE `" . DB_PREFIX . "setting` SET `data` = ? WHERE `name` = ?", array($data['info'], 'siteinfo'));
		$this->database->query("UPDATE `" . DB_PREFIX . "setting` SET `data` = ? WHERE `name` = ?", array($data['sociallink'], 'sociallink'));
	}

	public function getSuppliers()
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "suppliers`");
		return $query->rows;
	}

	public function updateSupplier($data)
	{
		$this->database->query("UPDATE `" . DB_PREFIX . "suppliers` SET `name` = ?, `email` = ?, `phone` = ?, `address` = ? WHERE `id` = ? ", array($this->database->escape($data['name']), $this->database->escape($data['email']), $this->database->escape($data['phone']), $data['address'], (int)$data['id']));
	}

	public function createSupplier($data)
	{
		$this->database->query("INSERT INTO `" . DB_PREFIX . "suppliers` (`name`, `email`, `phone`, `address`, `user_id`, `date_of_joining`) VALUES (?, ?, ?, ?, ?, ?)", array($this->database->escape($data['name']), $this->database->escape($data['email']), $this->database->escape($data['phone']), $data['address'], (int)$data['user_id'], $data['datetime']));
	}

	public function deleteSupplier($id)
	{
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "suppliers` WHERE `id` = ?", array((int)$id ));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function getCustomization()
	{
		$query = $this->database->query("SELECT `data` FROM  `" . DB_PREFIX . "setting` WHERE `name` = ? LIMIT 1", array('admintheme') );
		return $query->row['data'];
	}

	public function updateCustomization($data)
	{
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "setting` SET `data` = ? WHERE `name` = ? ", array($data, 'admintheme'));
	}
}