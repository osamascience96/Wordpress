<?php

class Useragent {
	private $user_id;
	private $login_token;
	private $role;
	private $timezone;
	private $permission = array();

	public function __construct($registry) {
		$this->database = $registry->get('database');
		$this->session = $registry->get('session');

		$query = $this->database->query("SELECT `data` FROM `" . DB_PREFIX . "setting` WHERE `name` = ?", array('siteinfo'));
		$this->timezone = json_decode($query->row['data'], true)['timezone'];

		if (isset($this->session->data['user_id']) && isset($this->session->data['login_token'])) {
			if ($this->validateToken($this->session->data['login_token'])) {
				$this->logout();
			} else {
				$query = $this->database->query("SELECT id FROM `" . DB_PREFIX . "patients` WHERE id = ? AND status = ?", array((int)$this->session->data['user_id'], '1'));
				if ($query->num_rows > 0) {
					$this->user_id = $query->row['id'];
					$this->login_token = $this->session->data['login_token'];
				} else {
					$this->logout();
				}
			}
		}
	}

	public function isRoutePage($page)
	{
		$query = $this->database->query("SELECT id FROM `" . DB_PREFIX . "page` WHERE `page_name` = ?", array($page));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function validateToken($token)
	{
		$token_check = hash('sha512', AUTH_KEY . LOGGED_IN_SALT);
		if ( hash_equals($token_check, $token) === false ) {
			return true;
		} else {
			return false;
		}
	}

	public function logout() {
		unset($this->session->data['user_id']);
		unset($this->session->data['login_token']);
		$this->user_id = '';
		$this->login_token = '';
	}

	public function isLogged() {
		return $this->user_id;
	}

	public function getTimezone() {
		return $this->timezone;
	}

	public function getToken() {
		return $this->login_token;
	}
}