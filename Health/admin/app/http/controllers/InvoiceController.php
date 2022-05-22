<?php
/**
* Invoice Controller
*/
class InvoiceController extends Controller
{
	/**
	* Invoice index edit method
	* This method will be called on Invoice list view
	**/
	public function index()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		
		$this->load->model('invoice');
		$this->load->controller('common');
		$data['period']['start'] = $this->url->get('start');
		$data['period']['end'] = $this->url->get('end');

		if (!empty($data['period']['start']) && !empty($data['period']['end']) && !$this->controller_common->validateDate($data['period']['start']) && !$this->controller_common->validateDate($data['period']['end'])) {
			$data['period']['start'] = date_format(date_create($data['period']['start'].'00:00:00'), "Y-m-d H:i:s");
			$data['period']['end'] = date_format(date_create($data['period']['end'].'23:59:59'), "Y-m-d H:i:s");
		} else {
			$data['period']['start'] = date('Y-m-d '.'00:00:00');
			$data['period']['end'] = date('Y-m-d '.'23:59:59');
		}

		if ($data['common']['user']['role_id'] == '3' && $data['common']['info']['doctor_access'] == '1') {
			$data['result'] = $this->model_invoice->allInvoices($data['period'], $data['common']['user']);
		} else {
			$data['result'] = $this->model_invoice->allInvoices($data['period']);
		}

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		/* Set page title */
		$data['page_title'] = 'Invoices';
		$data['page_view'] = $this->user_agent->hasPermission('invoice/view') ? true : false;
		$data['page_pdf'] = $this->user_agent->hasPermission('invoice/pdf') ? true : false;
		$data['page_add'] = $this->user_agent->hasPermission('invoice/add') ? true : false;
		$data['page_edit'] = $this->user_agent->hasPermission('invoice/edit') ? true : false;
		$data['page_delete'] = $this->user_agent->hasPermission('invoice/delete') ? true : false;

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action_delete'] = URL_ADMIN.DIR_ROUTE.'invoice/delete';

		/*Render Invoice list view*/
		$this->response->setOutput($this->load->view('invoice/invoice_list', $data));
	}

	public function indexView()
	{
		/**
		* Check if id exist in url if not exist then redirect to blog list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('invoices');
		}
		
		/**
		* Call getInvoice method from invoice model to get data from DB for single blog
		* If blog does not exist then redirect it to invoice list view
		**/

		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		$this->load->model('invoice');
		if ($data['common']['user']['role_id'] == '3' && $data['common']['info']['doctor_access'] == '1') {
			$data['result'] = $this->model_invoice->getInvoiceView($id, $data['common']['user']);
		} else {
			$data['result'] = $this->model_invoice->getInvoiceView($id);
		}

		if (!$data['result']) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Invoice does not exist in database!');
			$this->url->redirect('invoices');
		}
		$data['result']['items'] = json_decode($data['result']['items'], true);
		$data['method'] = $this->model_invoice->getPaymentMethod();
		$data['payments'] = $this->model_invoice->getPayments($id);
		$data['attachments'] = $this->model_invoice->getAttachments($id);

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		
		$data['page_title'] = 'Invoice View';
		$data['page_edit'] = $this->user_agent->hasPermission('invoice/edit') ? true : false;
		$data['page_pdf'] = $this->user_agent->hasPermission('invoice/pdf') ? true : false;
		$data['page_send_mail'] = $this->user_agent->hasPermission('invoice/sentmail') ? true : false;
		$data['page_addpayment'] = $this->user_agent->hasPermission('addpayment') ? true : false;

		$data['action'] = URL_ADMIN.DIR_ROUTE.'addpayment';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);

		/*Render Invoice list view*/
		$this->response->setOutput($this->load->view('invoice/invoice_view', $data));
	}

	public function indexAdd()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		$this->load->model('invoice');
		$data['payment_method'] = $this->model_invoice->getPaymentMethod();
		$data['taxes'] = $this->model_invoice->getTaxes();

		if ($this->url->get('appointment')) {
			$data['result'] = NULL;
			$data['result'] = $this->model_invoice->getAppointmentData($this->url->get('appointment'));
			$data['result']['duedate'] = NULL;
			$data['result']['invoicedate'] = NULL;
			$data['result']['currency'] = NULL;
			$data['result']['method'] = NULL;
			$data['result']['status'] = NULL;
			$data['result']['inv_status'] = NULL;
			$data['result']['items'] = NULL;
			$data['result']['subtotal'] = NULL;
			$data['result']['tax'] = NULL;
			$data['result']['discounttype'] = NULL;
			$data['result']['discount'] = NULL;
			$data['result']['discount_value'] = NULL;
			$data['result']['amount'] = NULL;
			$data['result']['paid'] = NULL;
			$data['result']['due'] = NULL;
			$data['result']['note'] = NULL;
			$data['result']['tc'] = NULL;
			$data['result']['id'] = NULL;
		} else {
			$data['result'] =  NULL;
		}

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['page_title'] = 'Invoice Add';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'invoice/add';
		$this->response->setOutput($this->load->view('invoice/invoice_form', $data));
	}
	/**
	* Invoice index edit method
	* This method will be called on invoice edit view
	**/
	public function indexEdit()
	{
		/**
		* Check if id exist in url if not exist then redirect to blog list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('invoices');
		}

		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Call getInvoice method from invoice model to get data from DB for single blog
		* If blog does not exist then redirect it to invoice list view
		**/
		$this->load->model('invoice');
		if ($data['common']['user']['role_id'] == '3' && $data['common']['info']['doctor_access'] == '1') {
			$data['result'] = $this->model_invoice->getInvoice($id, $data['common']['user']);
		} else {
			$data['result'] = $this->model_invoice->getInvoice($id);
		}
		
		if (!$data['result']) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Invoice does not exist in database!');
			$this->url->redirect('invoices');
		}
		
		$data['payment_method'] = $this->model_invoice->getPaymentMethod();
		$data['taxes'] = $this->model_invoice->getTaxes();

		/* Set Blog data to array */
		$data['result']['items'] = json_decode($data['result']['items'], true);

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['page_title'] = 'Invoice Edit';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'invoice/edit&id='.$data['result']['id'];
		/*Render invoice edit view*/
		$this->response->setOutput($this->load->view('invoice/invoice_form', $data));
	}

	public function indexMail()
	{
		if (!isset($_POST['submit'])) {
			$this->url->redirect('invoices');
		}
		$data = $this->url->post;
		$this->load->controller('common');
		
		$this->load->model('invoice');
		$result = $this->model_invoice->getInvoice($data['mail']['id']);
		if (empty($result)) {
			$this->url->redirect('invoices');
		}
		
		$data['mail']['email'] = $result['email'];
		$data['mail']['name'] = $result['name'];
		$data['mail']['redirect'] = 'invoice/view&id='.$result['id'];
		if ($data['mail']['attachPdf'] == '1' && file_exists(DIR.'public/uploads/invoice/invoice-'.$data['mail']['id'].'.pdf')) {
			$data['mail']['attachments'] = array('file' => DIR.'public/uploads/invoice/invoice-'.$data['mail']['id'].'.pdf', 'name' => 'Invoice');
		}
		
		$this->load->controller('Mail');
		$mail_result = $this->controller_mail->sendmail($data['mail']);
		
		if ($mail_result == 1) {
			$data['mail']['type'] = 'invoice';
			$data['mail']['type_id'] = $data['mail']['id'];
			$data['mail']['user_id'] = $this->session->data['user_id'];
			
			$this->controller_mail->createMailLog($data['mail']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Success: Message sent successfully.');
			$this->url->redirect('invoice/view&id='.$result['id']);
		} else {
			$this->session->data['message'] = array('alert' => 'error', 'value' => $mail_result);
			$this->url->redirect('invoice/view&id='.$result['id']);
		}
	}

	public function indexPdf()
	{
		/**
		* Check if id exist in url if not exist then redirect to Invoice list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) { $this->url->redirect('invoices'); }

		$data = $this->createPDFHTML($id);

		$pdf = new PDF();
		$pdf->createPDF($data);
	}

	public function indexPrint()
	{
		/**
		* Check if id exist in url if not exist then redirect to Invoice list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) { $this->url->redirect('invoices'); }

		$data = $this->createPDFHTML($id, 1);
		$pdf = new PDF();
		$pdf->createPDF($data);
	}

	public function indexAction()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) { $this->url->redirect('invoices'); }
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		$data = $this->url->post;
		$this->load->model('commons');
		$this->load->controller('common');
		$data['info'] = $this->model_commons->getSiteInfo($this->session->data['user_id']);

		$this->load->controller('common');
		if ($validate_field = $this->validateField($data)) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter/select valid '.implode(", ",$validate_field).'!');
			exit();
			if (!empty($data['invoice']['user_id'])) {
				$this->url->redirect('invoice/edit&id='.$data['invoice']['id']);
			} else {
				$this->url->redirect('invoice/add');
			}
		}

		$data['invoice']['item'] = json_encode($data['invoice']['item']);
		$data['invoice']['duedate'] = DateTime::createFromFormat($data['info']['date_format'], $data['invoice']['duedate'])->format('Y-m-d');
		$data['invoice']['invoicedate'] = DateTime::createFromFormat($data['info']['date_format'], $data['invoice']['invoicedate'])->format('Y-m-d');
		$data['invoice']['datetime'] = date('Y-m-d H:i:s');

		$this->load->model('invoice');
		if (!empty($data['invoice']['id'])) {
			$this->model_invoice->updateInvoice($data['invoice']);
			$this->createPDF($data['invoice']['id']);
			if ($data['invoice']['inv_status'] == "1") {
				$checkMailStatus = $this->model_invoice->checkInvoiceMailStatus($data['invoice']['id']);
				if ($checkMailStatus == '0') {
					$this->invoiceMail($data['invoice']['id']);
					$this->model_invoice->updateInvoiceMailStatus($data['invoice']['id']);
				}
			}
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Invoice updated successfully.');
			$this->url->redirect('invoice/view&id='.$data['invoice']['id']);
		} else {
			$data['invoice']['user_id'] = $this->session->data['user_id'];
			$result = $this->model_invoice->createInvoice($data['invoice']);
			if ((int)$result) {
				$this->createPDF($result);
				if ($data['invoice']['inv_status'] == "1") {
					$checkMailStatus = $this->model_invoice->checkInvoiceMailStatus($result);
					if ($checkMailStatus == '0') {
						$this->invoiceMail($result);
						$this->model_invoice->updateInvoiceMailStatus($result);
					}
				}

				if ((int)$result && $data['invoice']['appointment_id']) {
					$this->model_invoice->updateInvoiceIdAppointment($result, $data['invoice']['appointment_id']);
				}

				$this->session->data['message'] = array('alert' => 'success', 'value' => 'Invoice created successfully.');
				$this->url->redirect('invoice/view&id='.$result);
			} else {
				$this->session->data['message'] = array('alert' => 'error', 'value' => 'Invoice does not created (Server Error).');
				$this->url->redirect('invoice/add');
			}
		}
	}

	public function createPDF($id)
	{
		$html_array = $this->createPDFHTML($id);

		$pdf = new Pdf();
		$pdf->saveInvoicePDF($html_array);
	}

	public function invoicePayment()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {$this->url->redirect('invoices');}
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		$data = $this->url->post;
		
		$this->load->controller('common');
		if ($validate_field = $this->validateInvoicePaymentField($data['payment'])) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			$this->url->redirect('invoice/view&id='.$data['payment']['invoice']);
		}
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getInvoiceData($this->session->data['user_id']);
		$data['payment']['date'] = DateTime::createFromFormat($data['common']['date_format'], $data['payment']['date'])->format('Y-m-d');
		
		$this->load->model('invoice');
		$result = $this->model_invoice->addInvoicePayment($data['payment']);
		$this->model_invoice->invoiceTotal($data['payment']);

		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Payment added successfully');
		$this->url->redirect('invoice/view&id='.$data['payment']['invoice']);
	}

	protected function validateInvoicePaymentField($data)
	{
		$error = [];
		$error_flag = false;

		if ($this->controller_common->validateNumeric($data['method'])) {
			$error_flag = true;
			$error['method'] = 'Payment Method';
		}

		if ($this->controller_common->validateNumeric($data['amount'])) {
			$error_flag = true;
			$error['method'] = 'Amount';
		}

		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
	/**
	* invoice index delete method
	* This method will be called on blog delete action
	**/
	public function indexDelete()
	{
		$this->load->controller('common');
		if ($this->controller_common->validateToken($this->url->post('_token'))) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			$this->url->redirect('invoices');
		}
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id')) ) {
			$this->url->redirect('invoices');
		}
		$this->load->model('invoice');
		$result = $this->model_invoice->deleteInvoice($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Invoice deleted successfully.');
		$this->url->redirect('invoices');
	}

	private function invoiceMail($id)
	{
		$this->load->controller('mail');
		$result = $this->controller_mail->getTemplate('newinvoice');
		if (empty($result['template']) || $result['template']['status'] == '0') {
			return false;
		}
		
		$invoice = $this->model_invoice->getInvoiceView($id);
		
		$data['id'] = $result['common']['invoice_prefix'].str_pad($invoice['id'], 4, '0', STR_PAD_LEFT);
		$site_link = '<a href="'.URL.'">Click Here</a>';
		$invoice['duedate'] = date_format(date_create($invoice['duedate']), $result['common']['date_format']);

		$result['template']['message'] = str_replace('{name}', $invoice['name'], $result['template']['message']);
		$result['template']['message'] = str_replace('{inv_id}', $data['id'], $result['template']['message']);
		$result['template']['message'] = str_replace('{amount}', $result['common']['currency_abbr'].$invoice['amount'], $result['template']['message']);
		$result['template']['message'] = str_replace('{paid}', $result['common']['currency_abbr'].$invoice['paid'], $result['template']['message']);
		$result['template']['message'] = str_replace('{due}', $result['common']['currency_abbr'].$invoice['due'], $result['template']['message']);
		$result['template']['message'] = str_replace('{due_date}', $invoice['duedate'], $result['template']['message']);
		$result['template']['message'] = str_replace('{clinic_name}', $result['common']['name'], $result['template']['message']);
		$result['template']['message'] = str_replace('{inv_url}', $site_link, $result['template']['message']);

		$data['name'] = $invoice['name'];
		$data['email'] = $invoice['email'];
		$data['subject'] = $result['template']['subject'];
		$data['message'] = $result['template']['message'];
		
		if (file_exists(DIR.'public/uploads/invoice/invoice-'.$invoice['id'].'.pdf')) {
			$data['attachments'] = array('file' => DIR.'public/uploads/invoice/invoice-'.$invoice['id'].'.pdf', 'name' => 'Invoice');
		}
		
		return $this->controller_mail->sendMail($data);
	}

	/**
	* Validate user field from server side
	**/
	protected function validateField($data)
	{
		$error = [];
		$error_flag = false;
		if ($this->controller_common->validateText($data['invoice']['name'])) {
			$error_flag = true;
			$error['name'] = 'Name';
		}
		if (!empty($data['invoice']['invoicedate'])) {
			if ($this->controller_common->validateDate( $data['invoice']['invoicedate'], $data['info']['date_format'] )) {
				$error_flag = true;
				$error['invoicedate'] = 'Date';
			}
		}
		if (!empty($data['invoice']['duedate'])) {
			if ($this->controller_common->validateDate( $data['invoice']['duedate'], $data['info']['date_format'] )) {
				$error_flag = true;
				$error['invoicedate'] = 'Date';
			}
		}
		if ($this->controller_common->validateEmail($data['invoice']['email'])) {
			$error_flag = true;
			$error['email'] = 'Email Address';
		}
		if ($this->controller_common->validatePhoneNumber($data['invoice']['mobile'])) {
			$error_flag = true;
			$error['mobile'] = 'Mobile Number';
		}
		
		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
	/**
	* Validate Field Method
	* This method will be called on to validate invoice field
	**/
	private function vaildateMailField($data)
	{
		$error = [];
		$error_flag = false;

		if ($this->controller_common->validateText($data['to'])) {
			$error_flag = true;
			$error['to'] = 'Email!';
		}

		if ($this->controller_common->validateText($data['subject'])) {
			$error_flag = true;
			$error['subject'] = 'Subject!';
		}

		if ($this->controller_common->validateText($data['message'])) {
			$error_flag = true;
			$error['message'] = 'Message!';
		}
		
		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}

	private function createPDFHTML($id, $printInvoice = NULL)
	{
		$this->load->model('commons');
		$this->load->model('invoice');
		$user = $this->model_commons->getUserInfo($this->session->data['user_id']);
		$info = $this->model_commons->getSiteInfo();
		if ($user['role_id'] == '3' && $info['doctor_access'] == '1') {
			$result = $this->model_invoice->getInvoiceView($id, $user);
		} else {
			$result = $this->model_invoice->getInvoiceView($id);
		}
		//$result = $this->model_invoice->getInvoiceView($id);
		
		if (empty($result)) { $this->url->redirect('invoices'); }

		$result['items'] = json_decode($result['items'], true);
		$result['info'] = $info;
		
		ob_start();
		if (!empty($result['info']['invoice_template'])) {
			include DIR_APP.'views/invoice/invoice_pdf_'.(int)$result['info']['invoice_template'].'.tpl.php';
		} else {
			include DIR_APP.'views/invoice/invoice_pdf_1.tpl.php';
		}
		
		$html = ob_get_clean();
		
		if(ob_get_length() > 0) {
			ob_end_flush();
		}
		return array('html' => $html, 'result' => $result);
	}
}