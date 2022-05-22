<?php
/**
* Session Class
*/

class Session extends SessionHandler
{
	protected $cookieParams;
	public $data = array();
	protected $repository;
	public function __construct($repository = '')
	{
		$this->repository = $repository;
		if (!session_id()) {
			ini_set('session.use_only_cookies', 1);
			ini_set('session.use_cookies', 1);
			ini_set('session.use_trans_sid', 0);
			ini_set('session.cookie_httponly', 1);

			if (!empty($_COOKIE[session_name()]) && !preg_match('/^[a-zA-Z0-9,\-]{22,52}$/', $_COOKIE[session_name()])) {
				exit('Error: Session Id is not valid, please clear your cookies!!!');
			}
			
			session_set_cookie_params(0, '/');
			session_start();
		}
	}

	public function start($name = 'KWSESSID') 
	{
		if (isset($_COOKIE[$name])) {
			$this->key = $_COOKIE[$name];
		} else {
			$this->key = $this->createSessionId();
		}

		if (!$this->isValid()) {
			$this->destroy($name);
		}

		if (!isset($_SESSION[$this->key])) {
			$_SESSION[$this->key] = array();
		}

		$this->data = &$_SESSION[$this->key];
		setcookie($name, $this->key, ini_get('session.cookie_lifetime'), ini_get('session.cookie_path'), ini_get('session.cookie_domain'), ini_get('session.cookie_secure'), ini_get('session.cookie_httponly'));
		return $this->key;
	}

	public function createSessionId() {
		if (function_exists('random_bytes')) {
			return substr(bin2hex(random_bytes(26)), 0, 26);
		} else {
			return substr(bin2hex(openssl_random_pseudo_bytes(26)), 0, 26);
		}
	}

	public function isExpired($ttl = 120)
	{
		$last = isset($_SESSION['_last_activity']) ? $_SESSION['_last_activity'] : false;
		if ($last !== false && time() - $last > $ttl * 60) {
			return true;
		}
		$_SESSION['_last_activity'] = time();
		return false;
	}

	public function isFingerprint()
	{
		$hash = md5($_SERVER['HTTP_USER_AGENT']);
		if (isset($_SESSION['_fingerprint'])) {
			return $_SESSION['_fingerprint'] === $hash;
		}
		$_SESSION['_fingerprint'] = $hash;
		return true;
	}

	public function isValid()
	{
		return !$this->isExpired() && $this->isFingerprint();
	}

	public function destroy($name = 'default')
	{
		if (isset($_SESSION[$this->key])) {
			unset($_SESSION[$this->key]);
		}
		setcookie($name, '', time() - 42000, ini_get('session.cookie_path'), ini_get('session.cookie_domain'));
		//session_destroy();
	}

	public function read($id)
	{
		return mcrypt_decrypt(MCRYPT_3DES, $this->key, parent::read($id), MCRYPT_MODE_ECB);
	}

	public function write($id, $data)
	{
		return parent::write($id, mcrypt_encrypt(MCRYPT_3DES, $this->key, $data, MCRYPT_MODE_ECB));
	}
}