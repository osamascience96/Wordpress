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
		$data['common'] = $this->model_commons->getSiteInfo();
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

			if (!empty($data['mail_info']['reply'])) {
				$mail->addReplyTo($data['mail_info']['reply'], $data['mail_info']['fromname']);
			}

			$mail->addAddress($data['email'], $data['name']);

			if (!empty($data['cc'])) {
				$mail->addCC($data['cc']);
			}
			if (!empty($data['bcc'])) {
				$mail->addBCC($data['bcc']);
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

	public function sendBulkMail($data)
	{
		
		$error = array();
		if ($validate_field = $this->validateBulkMailField($data)) {
			return 'Please enter valid '.implode(", ",$validate_field).'!';
		}

		$this->load->model('commons');
		$data['common'] = $this->model_commons->getSiteInfo();
		$data['mail_info'] = $this->model_commons->getMailInfo();
		
		$mail = new Mail();

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

		if (!empty($data['mail_info']['reply'])) {
			$mail->addReplyTo($data['mail_info']['reply'], $data['mail_info']['fromname']);
		}

		if (!empty($data['cc'])) {
			$mail->addCC($data['cc']);
		}

		if (!empty($data['bcc'])) {
			$mail->addBCC($data['bcc']);
		}
		
		if (!empty($data['attachments'])) {
			$mail->addAttachment($data['attachments']['file'], $data['attachments']['name']);
		}
		
		$mail->isHTML();
		if (!empty($data['is_html'])) {}

		$mail->setSubject($data['subject']);
		$mail->setMessage($data['message']);

		foreach ($data['addresses'] as $key => $value) {
			if (!empty($value['email'])) {
				$mail->addAddress($value['email'], $value['name']);
				$mail->sendMail();
			}
			$mail->clearAddresses();
		}
		return true;
	}

	public function createMailLog($data)
	{
		$this->load->model('sender');
		$this->model_sender->createMailLog($data);
		return true;
	}

	public function createBulkMailLog($data)
	{
		$data['datetime'] = date('Y-m-d H:i:s');
		$this->load->model('sender');
		foreach ($data['addresses'] as $key => $value) {
			$data['email'] = $value['email'];
			$this->model_sender->createMailLog($data);
		}
		return true;
	}

	public function getTemplate($name)
	{
		$this->load->model('emailtemplate');
		return $this->model_emailtemplate->getTemplateAndInfo($name);
	}

	public function validateMailField($data)
	{
		$error = [];
		$error_flag = false;
		$this->load->controller('common');
		if ($this->controller_common->validateText($data['subject'])) {
			$error_flag = true;
			$error['subject'] = 'subject';
		}

		if ($this->controller_common->validateEmail($data['email'])) {
			$error_flag = true;
			$error['email'] = 'email address';
		}

		if ($this->controller_common->validateText($data['message'])) {
			$error_flag = true;
			$error['message'] = 'mobile number';
		}

		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}

	public function validateBulkMailField($data)
	{
		$error = [];
		$error_flag = false;
		$this->load->controller('common');
		if ($this->controller_common->validateText($data['subject'])) {
			$error_flag = true;
			$error['subject'] = 'subject';
		}

		if ($this->controller_common->validateText($data['message'])) {
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