<?php

/**
* Template
*/
class Emailtemplate extends Model
{
	public function getTemplate($id)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "email_template` WHERE `template` = ? LIMIT 1", array($id));
		return $query->row;
	}
	
	public function getTemplateAndInfo($id)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "email_template` WHERE `template` = ? LIMIT 1", array($id));
		$data['template'] = $query->row;
		$query = $this->database->query("SELECT * FROM  `" . DB_PREFIX . "setting` WHERE `name` = ? LIMIT 1", array('siteinfo'));
		$data['common'] = json_decode($query->row['data'], true);
		return $data;
	}

	public function getTemplateMenu()
	{
		$query = $this->database->query("SELECT `id`, `template`, `name` FROM `" . DB_PREFIX . "email_template`");
		return $query->rows;
	}

	public function getEmailSetting()
	{
		$query = $this->database->query("SELECT * FROM  `" . DB_PREFIX . "setting` WHERE `name` = ? LIMIT 1", array('emailsetting'));
		return $query->row['data'];
	}

	public function updateTemplate($data)
	{
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "email_template` SET `name` = ?, `subject` = ?, `message` = ?, `status` = ? WHERE `template` = ? ", array($data['name'], $data['subject'], $data['message'], $data['status'], $data['template']));
		
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function updateEmailSetting($data)
	{
		$this->database->query("UPDATE `" . DB_PREFIX . "setting` SET `data` = ? WHERE `name` = ?", array($data, 'emailsetting'));
	}
}