<?php

/**
* Info Controller
*/
class SettingController extends Controller
{
	/**
	* Info index edit method
	* This method will be called on Info edit view
	**/
	public function index()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		$this->load->controller('common');
		$data['timezone'] = $this->controller_common->getTimezones();
		/**
		* Get all info data from DB using info model's method
		**/
		$this->load->model('setting');
		$result = $this->model_setting->getSetting();
		foreach ($result as $key => $value) {
			$data[$value['name']] = json_decode($value['data'], true);
		}
		
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['page_title'] = 'System Info';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		/*Set action method for form submit call*/
		$data['action'] = URL_ADMIN.DIR_ROUTE.'info';
		/*Render Info view*/
		$this->response->setOutput($this->load->view('setting/info', $data));
	}
	/**
	* Info index action method
	* This method will be called on Info submit/save view
	**/
	public function indexAction()
	{
		$data = $this->url->post;
		$this->load->controller('common');
		if ($validate_field = $this->validateField($data['info'])) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			$this->url->redirect('info');
		}
		
		if (empty($data['info']['doctor_access'])) {
			$data['info']['doctor_access'] = 0;
		}

		$data['info'] = json_encode($data['info']);
		$data['sociallink'] = json_encode($data['sociallink']);
		$this->load->model('setting');
		$result = $this->model_setting->updateSetting($data);
		
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Site Info updated successfully.');
		$this->url->redirect('info');
	}

	protected function validateField($data)
	{
		$error = [];
		$error_flag = false;
		
		if ($this->controller_common->validateText($data['name'])) {
			$error_flag = true;
			$error['name'] = 'Name';
		}

		if ($this->controller_common->validateText($data['legal_name'])) {
			$error_flag = true;
			$error['legal_name'] = 'Legal Name';
		}

		if ($this->controller_common->validateEmail($data['mail'])) {
			$error_flag = true;
			$error['email'] = 'Email Address';
		}

		if ($this->controller_common->validateText($data['phone'])) {
			$error_flag = true;
			$error['phone'] = 'Phone number';
		}

		if ($this->controller_common->validateText($data['emergency'])) {
			$error_flag = true;
			$error['emergency'] = 'Emergency Number';
		}

		if (!empty($data['facebook'])) {
			if ($this->controller_common->validateUrl($data['social']['facebook'])) {
				$error_flag = true;
				$error['facebook'] = 'Facebook address!';
			}
		}

		if (!empty($this->url->post('twitter'))) {
			if ($this->controller_common->validateUrl($data['social']['twitter'])) {
				$error_flag = true;
				$error['twitter'] = 'Twitter address!';
			}
		}
		if (!empty($this->url->post('google'))) {
			if ($this->controller_common->validateUrl($data['social']['google'])) {
				$error_flag = true;
				$error['google'] = 'Google address!';
			}
		}
		if (!empty($this->url->post('instagram'))) {
			if ($this->controller_common->validateUrl($data['social']['instagram'])) {
				$error_flag = true;
				$error['instagram'] = 'Instagram address!';
			}
		}

		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}

	public function suppliers()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Get all info data from DB using info model's method
		**/
		$this->load->model('setting');
		$data['result'] = $this->model_setting->getSuppliers();
		
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['page_title'] = 'Suppliers';
		$data['page_add'] = $this->user_agent->hasPermission('supplier/add') ? true : false;
		$data['page_edit'] = $this->user_agent->hasPermission('supplier/edit') ? true : false;
		$data['page_delete'] = $this->user_agent->hasPermission('supplier/delete') ? true : false;
		/*Set action method for form submit call*/
		$data['action'] = URL_ADMIN.DIR_ROUTE.'supplier/add';
		$data['action_delete'] = URL_ADMIN.DIR_ROUTE.'supplier/delete';
		/*Render Info view*/
		$this->response->setOutput($this->load->view('setting/suppliers_list', $data));
	}

	public function supplierAction()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('suppliers');
			exit();
		}
		
		$data = $this->url->post;

		$this->load->controller('common');
		if ($validate_field = $this->validateSupplier($data)) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			$this->url->redirect('suppliers');
		}
		
		$data = $this->url->post;
		$data['datetime'] =  date('Y-m-d H:i:s');
		$data['user_id'] =  $this->session->data['user_id'];
	
		$this->load->model('setting');
		if (!empty($data['id'])) {
			$result = $this->model_setting->updateSupplier($data);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Supplier updated successfully.');
		} else {
			$result = $this->model_setting->createSupplier($data);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Supplier created successfully.');
		}
		$this->url->redirect('suppliers');
	}

	public function supplierDelete()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id')) ) {
			$this->url->redirect('suppliers');
		}
		$this->load->model('setting');
		$this->model_setting->deleteSupplier($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Supplier deleted successfully.');
		$this->url->redirect('suppliers');
	}

	public function validateSupplier($data)
	{
		$error = [];
		$error_flag = false;
		if (!empty($data['name']) && $this->controller_common->validateText($data['name'])) {
			$error_flag = true;
			$error['name'] = 'Name';
		}
		if (!empty($data['mobile']) && $this->controller_common->validateEmail($data['mobile'])) {
			$error_flag = true;
			$error['mobile'] = 'Phone Number';
		}

		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}

	public function customization()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		$this->load->model('setting');
		/**
		* Get all info data from DB using info model's method
		**/
		$data['result'] = json_decode($this->model_setting->getCustomization(), true);

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['page_title'] = 'Theme Customization';
		/*Set action method for form submit call*/
		$data['action'] = URL_ADMIN.DIR_ROUTE.'customization';
		/*Render Info view*/
		$this->response->setOutput($this->load->view('setting/customization', $data));
	}

	public function customizationAction()
	{
		$temp = $this->url->post;
		$temp['layout_menu'] = isset($temp['layout_menu']) ? $temp['layout_menu'] : false;
		$data = array('layout' => $temp['layout'],
			'layout_fixed' => $temp['layout_fixed'],
			'layout_menu' => $temp['layout_menu'],
			'side_menu' => $temp['side-menu'], 
			'header_color' => $temp['header-color'],
			'logo' => $temp['logo'],
			'logo_icon' => $temp['logo_icon'],
			'favicon' => $temp['favicon'],
			'lg_background' => $temp['lg_background']
		);
		
		$this->load->model('setting');
		$result = $this->model_setting->updateCustomization(json_encode($data));
		
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Customization updated successfully.');
		$this->url->redirect('customization');
	}
}