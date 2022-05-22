<?php
/**
* Phpmailer Class
*/
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail
{
	public $mail;
	public function __construct()
	{
		require BUILDER.'library/mailer/src/Exception.php';
		require BUILDER.'library/mailer/src/PHPMailer.php';
		require BUILDER.'library/mailer/src/SMTP.php';
		$this->mail = new PHPMailer;
		$this->mail->CharSet = 'UTF-8';
		//$this->mail->SMTPDebug = 2;
	}

	public function setSmtp($data)
	{
		$this->mail->isSMTP();
		$this->mail->Host = $data['host'];
		if ($data['authentication'] == '1') {
		    $this->mail->SMTPAuth = $data['authentication'];
		}
		$this->mail->Username = $data['username'];
		$this->mail->Password = $data['password'];
		$this->mail->Port = $data['port'];	
		$this->mail->SMTPSecure = $data['encryption'];

		//For Godaddy Server
		// $this->mail->SMTPOptions = array(
		// 	'ssl' => array(
		// 		'verify_peer' => false,
		// 		'verify_peer_name' => false,
		// 		'allow_self_signed' => true
		// 	)
		// );
	}
	
	public function setFrom($set_mail, $set_name) {
		$this->mail->setFrom($set_mail, $set_name);
	}

	public function addAddress($add_mail, $add_name) {
		$this->mail->addAddress($add_mail, $add_name);
	}

	public function addCC($cc_mail) {
		$this->mail->addCC($cc_mail, '');
	}

	public function addBCC($bcc_mail) {
		$this->mail->addBCC($bcc_mail, '');
	}
	
	public function addReplyTo($reply_to, $reply_name) {
		$this->mail->addReplyTo($reply_to, $reply_name);
	}
	
	public function isHTML()
	{
		$this->mail->isHTML(true);
	}
	
	public function setSubject($subject) {
		$this->mail->Subject = $subject;
	}
	
	public function setMessage($message) {
		$this->mail->Body = $message;
	}
	
	public function addAttachment($file, $file_name) {
		$this->mail->addAttachment($file, $file_name);
	}

	public function clearAddresses()
	{
		$this->mail->ClearAddresses();
	}

	public function sendMail()
	{
		$this->mail->send();
	}
}