<?php

class Useragent {
	private $user;
	private $info;
	private $theme;
	private $user_id;
	private $login_token;
	private $role;
	private $permission = array();

	public function __construct($registry)
	{
		$this->database = $registry->get('database');
		$this->session = $registry->get('session');

		$query = $this->database->query("SELECT `data` FROM `" . DB_PREFIX . "setting` WHERE `name` in ('siteinfo', 'admintheme')");
		$this->info = json_decode($query->rows[0]['data'], true);
		$this->theme = json_decode($query->rows[1]['data'], true);

		if (isset($this->session->data['user_id']) && isset($this->session->data['login_token'])) {
			if ($this->validateLoginToken($this->session->data['login_token'])) {
				$this->logout();
			} else {
				$query = $this->database->query("SELECT u.user_id, u.firstname, u.lastname, u.picture, ur.id AS role_id, ur.name AS role, ur.permission, d.id AS doctor FROM `" . DB_PREFIX . "users` AS u LEFT JOIN `" . DB_PREFIX . "user_role` AS ur ON ur.id = u.user_role LEFT JOIN `" . DB_PREFIX . "doctors` AS d ON d.user_id = u.user_id WHERE u.user_id = ? AND u.status = ?", array((int)$this->session->data['user_id'], '1'));
				if ($query->num_rows > 0) {
					$this->user = $query->row;
					$this->user_id = $this->user['user_id'];
					$this->login_token = $this->session->data['login_token'];
					$this->role = $this->user['role_id'];
					$this->permission = json_decode($this->user['permission'], true);
					unset($this->user['permission']);
				} else {
					$this->logout();
				}
			}
		}
	}

	public function validateLoginToken($token_value)
	{
		$token_check = hash('sha512', AUTH_KEY . LOGGED_IN_SALT);
		if (hash_equals($token_check, $token_value) === false) {
			//Invalid token
			return true;
		} else {
			return false;
		}
	}

	public function validateToken($token_value)
	{
		$token_check = hash('sha512', TOKEN . TOKEN_SALT);
		if (hash_equals($token_check, $token_value) === false ) {
			//Invalid token
			return true;
		}
	}

	public function logout()
	{
		unset($this->session->data['user_id']);
		unset($this->session->data['login_token']);
		$this->user_id = '';
		$this->login_token = '';
	}

	public function hasPermission($data)
	{
		$extension = array('login',
			'forgotpassword',
			'resetpassword',
			'logout',
			'profile',
			'profile/password',
			'appointment/makeanappointment',
			'checkstaffsalary',
			'getmedicine',
			'getbatch',
			'getbatchdata',
			'notes/search',
			'records/pdf',
			'patient/search',
			'doctor/search',
			'item/search',
			'get/receiver',
			'attach/documents',
			'attach/documents/delete',
			'getmenupages',
			'getmenulink',
		);

		$this->permission = array_merge($this->permission, $extension);
		if (in_array($data, $this->permission) || $this->role == "1") {
			return true;
		} else {
			return false;
		}
	}

	public function getUserData()
	{
		return $this->user;
	}

	public function getInfo()
	{
		return $this->info;
	}

	public function getTheme()
	{
		return $this->theme;
	}

	public function isLogged()
	{
		return $this->user_id;
	}

	public function getTimezone()
	{
		return $this->info['timezone'];
	}

	public function getToken()
	{
		return $this->login_token;
	}
}