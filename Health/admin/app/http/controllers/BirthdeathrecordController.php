<?php

/**
 * BirthrecordController
 */
class BirthdeathrecordController extends Controller
{
	public function birthList()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Get all blogs data from DB using blog model 
		**/
		$this->load->model('birthdeath');
		$data['result'] = $this->model_birthdeath->birthRecords();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['page_title'] = 'Birth Records';
		$data['page_view'] = $this->user_agent->hasPermission('birthrecord/view') ? true:false;
		$data['page_add'] = $this->user_agent->hasPermission('birthrecord/add') ? true:false;
		$data['page_edit'] = $this->user_agent->hasPermission('birthrecord/edit') ? true:false;
		$data['page_delete'] = $this->user_agent->hasPermission('birthrecord/delete') ? true:false;
		$data['action_delete'] = URL_ADMIN.DIR_ROUTE.'birthrecord/delete';

		/*Render Blog view*/
		$this->response->setOutput($this->load->view('birthdeath/birthrecord_list', $data));
	}

	public function birthView()
	{
		/**
		* Check if id exist in url if not exist then redirect to blog list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('birthrecords');
		}
		
		$this->load->model('birthdeath');
		$data['result'] = $this->model_birthdeath->birthRecord($id);
		if (empty($data['result'])) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Birth Records does not exist in database!');
			$this->url->redirect('birthrecords');
		}

		$data['documents'] = $this->model_birthdeath->birthDeathDocuments($id, 'birth');
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['page_title'] = 'View Birth Records';
		$data['page_edit'] = $this->user_agent->hasPermission('birthrecord/edit') ? true:false;
		/*Render Blog view*/
		$this->response->setOutput($this->load->view('birthdeath/birthrecord_view', $data));
	}

	public function birthPdf()
	{
		/**
		* Check if id exist in url if not exist then redirect to blog list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('deathrecords');
		}
		
		$this->load->model('commons');
		$common = $this->model_commons->getSiteInfo();

		$this->load->model('birthdeath');
		$result = $this->model_birthdeath->birthRecord($id);
		if (empty($result)) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Birth Records does not exist in database!');
			$this->url->redirect('deathrecords');
		}
		$meta_title = 'Birth Records';

		ob_start();
		include DIR_APP.'views/birthdeath/birthrecord_pdf.tpl.php';
		
		$data['html'] = ob_get_clean();
		
		if(ob_get_length() > 0) {
			ob_end_flush();
		}

		$pdf = new PDF();
		$pdf->createPDF($data);
	}

	public function birthAdd()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Get all blogs data from DB using blog model 
		**/
		$this->load->model('birthdeath');
		$data['result'] = NULL;
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['doctors'] = $this->model_birthdeath->getDoctors();

		$data['page_title'] = 'Add Birth Records';
		$data['action'] = URL_ADMIN.DIR_ROUTE.'birthrecord/add';

		/*Render Blog view*/
		$this->response->setOutput($this->load->view('birthdeath/birthrecord_form', $data));
	}

	public function birthEdit()
	{
		/**
		* Check if id exist in url if not exist then redirect to blog list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('birthrecords');
		}
		
		$this->load->model('birthdeath');
		$data['result'] = $this->model_birthdeath->birthRecord($id);
		if (empty($data['result'])) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Birth Records does not exist in database!');
			$this->url->redirect('birthrecords');
		}
		$data['doctors'] = $this->model_birthdeath->getDoctors();

		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['page_title'] = 'Edit Birth Records';
		$data['action'] = URL_ADMIN.DIR_ROUTE.'birthrecord/edit';

		/*Render Blog view*/
		$this->response->setOutput($this->load->view('birthdeath/birthrecord_form', $data));
	}

	public function birthAction()
	{
		$data = $this->url->post;
		$this->load->controller('common');
		$this->load->model('commons');
		$data['info'] = $this->model_commons->getSiteInfo();

		if ($validate_field = $this->validateBirthField($data)) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			if (!empty($data['birth']['id'])) {
				$this->url->redirect('birthrecord/edit&id='.$data['birth']['id']);
			} else {
				$this->url->redirect('birthrecord/add');
			}
		}

		$data['birth']['date'] = DateTime::createFromFormat($data['info']['date_format'], $data['birth']['date'])->format('Y-m-d');
		$data['birth']['user_id'] = $this->session->data['user_id'];
		$data['birth']['datetime'] = date('Y-m-d H:i:s');
		
		$this->load->model('birthdeath');
		if (!empty($data['birth']['id'])) {
			$this->model_birthdeath->updateBirthRecord($data['birth']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Birth Records updated successfully.');
		} else {
			$data['birth']['id'] = $this->model_birthdeath->createBirthRecord($data['birth']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Birth Records created successfully.');
		}
		$this->url->redirect('birthrecord/view&id='.$data['birth']['id']);
	}

	public function birthDelete()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id')) ) {
			$this->url->redirect('birthrecords');
		}
		/**
		* Call delete method
		**/
		$this->load->model('birthdeath');
		$result = $this->model_birthdeath->deleteBirthRecord((int)$this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Birth Records deleted successfully.');
		$this->url->redirect('birthrecords');
	}

	protected function validateBirthField($data)
	{
		$error = [];
		$error_flag = false;
		if ($this->controller_common->validateText($data['birth']['child'])) {
			$error_flag = true;
			$error['child'] = 'Child Name';
		}
		if ($this->controller_common->validateText($data['birth']['gender'])) {
			$error_flag = true;
			$error['gender'] = 'Gender';
		}
		if ($this->controller_common->validateText($data['birth']['weight'])) {
			$error_flag = true;
			$error['weight'] = 'Weight';
		}
		if ($this->controller_common->validateDate( $data['birth']['date'], $data['info']['date_format'] )) {
			$error_flag = true;
			$error['birth_date'] = 'Date of Birth';
		}
		if ($this->controller_common->validateText($data['birth']['time'])) {
			$error_flag = true;
			$error['time'] = 'Time';
		}
		if ($this->controller_common->validateText($data['birth']['mother_name'])) {
			$error_flag = true;
			$error['mother'] = 'Mother Name';
		}
		
		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}

	public function deathList()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Get all blogs data from DB using blog model 
		**/
		$this->load->model('birthdeath');
		$data['result'] = $this->model_birthdeath->deathRecords();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['page_title'] = 'Death Records';
		$data['page_view'] = $this->user_agent->hasPermission('deathrecord/view') ? true:false;
		$data['page_add'] = $this->user_agent->hasPermission('deathrecord/add') ? true:false;
		$data['page_edit'] = $this->user_agent->hasPermission('deathrecord/edit') ? true:false;
		$data['page_delete'] = $this->user_agent->hasPermission('deathrecord/delete') ? true:false;
		$data['action_delete'] = URL_ADMIN.DIR_ROUTE.'deathrecord/delete';

		/*Render Blog view*/
		$this->response->setOutput($this->load->view('birthdeath/deathrecord_list', $data));
	}

	public function deathView()
	{
		/**
		* Check if id exist in url if not exist then redirect to blog list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('deathrecords');
		}
		
		$this->load->model('birthdeath');
		$data['result'] = $this->model_birthdeath->deathRecord($id);
		if (empty($data['result'])) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Birth Records does not exist in database!');
			$this->url->redirect('deathrecords');
		}
		$data['documents'] = $this->model_birthdeath->birthDeathDocuments($id, 'death');

		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['page_title'] = 'View Death Records';
		$data['page_edit'] = $this->user_agent->hasPermission('deathrecord/edit') ? true:false;
		/*Render Blog view*/
		$this->response->setOutput($this->load->view('birthdeath/deathrecord_view', $data));
	}

	public function deathPdf()
	{
		/**
		* Check if id exist in url if not exist then redirect to blog list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('deathrecords');
		}
		
		$this->load->model('commons');
		$common = $this->model_commons->getSiteInfo();

		$this->load->model('birthdeath');
		$result = $this->model_birthdeath->deathRecord($id);
		if (empty($result)) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Birth Records does not exist in database!');
			$this->url->redirect('deathrecords');
		}
		$meta_title = 'Death Records';

		ob_start();
		include DIR_APP.'views/birthdeath/deathrecord_pdf.tpl.php';
		
		$data['html'] = ob_get_clean();
		
		if(ob_get_length() > 0) {
			ob_end_flush();
		}

		$pdf = new PDF();
		$pdf->createPDF($data);
	}

	public function deathAdd()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Get all blogs data from DB using blog model 
		**/
		$this->load->model('birthdeath');
		$data['result'] = NULL;
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['doctors'] = $this->model_birthdeath->getDoctors();

		$data['page_title'] = 'Add Death Records';
		$data['action'] = URL_ADMIN.DIR_ROUTE.'deathrecord/add';

		/*Render Blog view*/
		$this->response->setOutput($this->load->view('birthdeath/deathrecord_form', $data));
	}

	public function deathEdit()
	{
		/**
		* Check if id exist in url if not exist then redirect to blog list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('deathrecord');
		}
		
		$this->load->model('birthdeath');
		$data['result'] = $this->model_birthdeath->deathRecord($id);
		if (empty($data['result'])) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Birth Records does not exist in database!');
			$this->url->redirect('deathrecord');
		}
		$data['doctors'] = $this->model_birthdeath->getDoctors();

		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['page_title'] = 'Edit Death Records';
		$data['action'] = URL_ADMIN.DIR_ROUTE.'deathrecord/edit';

		/*Render Blog view*/
		$this->response->setOutput($this->load->view('birthdeath/deathrecord_form', $data));
	}

	public function deathAction()
	{
		$data = $this->url->post;
		$this->load->controller('common');
		$this->load->model('commons');
		$data['info'] = $this->model_commons->getSiteInfo();

		if ($validate_field = $this->validateDeathField($data)) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			if (!empty($data['death']['id'])) {
				$this->url->redirect('deathrecord/edit&id='.$data['death']['id']);
			} else {
				$this->url->redirect('deathrecord/add');
			}
		}

		$data['death']['date'] = DateTime::createFromFormat($data['info']['date_format'], $data['death']['date'])->format('Y-m-d');
		$data['death']['user_id'] = $this->session->data['user_id'];
		$data['death']['datetime'] = date('Y-m-d H:i:s');

		$this->load->model('birthdeath');
		if (!empty($data['death']['id'])) {
			$this->model_birthdeath->updateDeathRecord($data['death']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Death Records updated successfully.');
		} else {
			$data['death']['id'] = $this->model_birthdeath->createDeathRecord($data['death']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Death Records created successfully.');
		}
		$this->url->redirect('deathrecord/view&id='.$data['death']['id']);
	}

	public function deathDelete()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id')) ) {
			$this->url->redirect('deathrecords');
		}
		/**
		* Call delete method
		**/
		$this->load->model('birthdeath');
		$result = $this->model_birthdeath->deleteDeathRecord((int)$this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Death records deleted successfully.');
		$this->url->redirect('deathrecords');
	}

	protected function validateDeathField($data)
	{
		$error = [];
		$error_flag = false;
		if ($this->controller_common->validateText($data['death']['name'])) {
			$error_flag = true;
			$error['child'] = 'Patient Name';
		}
		if ($this->controller_common->validateText($data['death']['gender'])) {
			$error_flag = true;
			$error['gender'] = 'Gender';
		}
		if ($this->controller_common->validateDate( $data['death']['date'], $data['info']['date_format'] )) {
			$error_flag = true;
			$error['birth_date'] = 'Date of Birth';
		}
		if ($this->controller_common->validateText($data['death']['time'])) {
			$error_flag = true;
			$error['time'] = 'Time';
		}
		if ($this->controller_common->validateText($data['death']['guardian_name'])) {
			$error_flag = true;
			$error['mother'] = 'Guardian';
		}
		
		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}