<?php

/**
 * db
 */
class Db extends Model
{
	public function checkDatabaseCredentails($data)
	{
		return $this->database->checkDb($data['db_hostname'], $data['db_username'], $data['db_password'], $data['db_name']);
	}

	public function getSettings($data)
	{
		$query = $this->database->query("SELECT * FROM `" . $data['db_prefix'] . "setting` WHERE `name` = 'siteinfo'");
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function createDatabaseTable($data, $lines)
	{
		$sql = '';
		foreach ($lines as $line) {
			if ($line && (substr($line, 0, 2) != '--') && (substr($line, 0, 1) != '#')) {
				$sql .= $line;

				if (preg_match('/;\s*$/', $line)) {
					$sql = str_replace("DROP TABLE IF EXISTS `kk_", "DROP TABLE IF EXISTS `" . $data['db_prefix'], $sql);
					$sql = str_replace("CREATE TABLE IF NOT EXISTS `kk_", "CREATE TABLE IF NOT EXISTS `" . $data['db_prefix'], $sql);
					$sql = str_replace("INSERT INTO `kk_", "INSERT INTO `" . $data['db_prefix'], $sql);
					$sql = str_replace("ALTER TABLE `kk_", "ALTER TABLE  `" . $data['db_prefix'], $sql);
					
					$this->database->createDBTable($sql);
					$sql = '';
				}
			}
		}
	}

	public function updateSettings($setting, $data)
	{
		$this->database->query("UPDATE `" . $data['db_prefix'] . "setting` SET `data` = ? WHERE `name` = ?", array($setting, 'siteinfo'));
	}

	public function updateUser($data)
	{
		$passwordhash = password_hash($data['password'], PASSWORD_DEFAULT);
		$this->database->query("UPDATE `" . $data['db_prefix'] . "users` SET `user_name` = ?, `firstname` = ?, `lastname` = ?, `email` = ?, `password` = ?, `status` = ?, `date_of_joining` = ? WHERE `user_id` = ? ",
			array($this->database->escape($data['username']), $this->database->escape($data['firstname']), $this->database->escape($data['lastname']), $this->database->escape($data['usermail']), $passwordhash, 1, $data['datetime'], 1));
	}
}










