<?php

/**
 * MailController
 */
class MailController extends Controller
{
	public function sendMail($data)
	{
		$error = array();
		if ($validate_field = $this->validateMailField($data)) {
			return 'Please enter valid '.implode(", ",$validate_field).'!';
		}

		$this->load->model('commons');
		$data['common'] = $this->model_commons->siteInfo();
		$data['mail_info'] = $this->model_commons->getMailInfo();
		if ($data['mail_info']['status'] == '0') {
			return "Mail service is disabled. Please emable it to send mails.";
		}

		$mail = new Mail();
		try {
			if ($data['mail_info']['status'] == '2') {
				$mail->setSmtp($data['mail_info']);
			}

			if (!empty($data['mail_info']['fromemail'])) {
				$mail->setFrom($data['mail_info']['fromemail'], $data['mail_info']['fromname']);
			} elseif (!empty($data['common']['mail'])) {
				$mail->setFrom($data['common']['mail'], $data['common']['name']);
			} else {
				return 'Please enter valid From Email Address in Email setting field!';
			}

			$mail->addAddress($data['email'], $data['name']);

			if (!empty($data['cc'])) {
				$mail->addCC($data['cc']);
			}

			if (!empty($data['bcc'])) {
				$mail->addBCC($data['bcc']);
			}

			if (!empty($data['mail_info']['reply'])) {
				$mail->addReplyTo($data['mail_info']['reply'], $data['mail_info']['fromname']);
			}

			if (!empty($data['attachments'])) {
				$mail->addAttachment($data['attachments']['file'], $data['attachments']['name']);
			}

			$mail->isHTML();
			if (!empty($data['is_html'])) {}

			$mail->setSubject($data['subject']);
			$mail->setMessage(html_entity_decode($data['message']));
			$mail->sendMail();
			return true;

		} catch (Exception $e) {
			return "Message could not be sent. Mailer Error: {$mail->mail->ErrorInfo}";
		}
	}


	public function getTemplate($name)
	{
		
	}

	public function validateMailField($data)
	{
		$error = [];
		$error_flag = false;
		if ((strlen($data['subject']) < 2) || !is_string($data['subject'])) {
			$error_flag = true;
			$error['subject'] = 'subject';
		}

		if ((strlen($data['email']) > 96) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			$error_flag = true;
			$error['email'] = 'email address';
		}

		if ((strlen($data['subject']) < 2) || !is_string($data['message'])) {
			$error_flag = true;
			$error['message'] = 'mobile number';
		}

		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}