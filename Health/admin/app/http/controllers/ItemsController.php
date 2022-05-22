<?php

/**
* ItemController
*/
class ItemsController extends Controller
{
	/**
	* Item index method
	* This method will be called on Items list view
	**/
	public function index()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Get all User data from DB using User model 
		**/
		$this->load->model('items');
		$data['result'] = $this->model_items->getItems();

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = 'Items';
		$data['page_add'] = $this->user_agent->hasPermission('item/add') ? true : false;
		$data['page_edit'] = $this->user_agent->hasPermission('item/edit') ? true : false;
		$data['page_delete'] = $this->user_agent->hasPermission('item/delete') ? true : false;

		$data['action'] = URL_ADMIN.DIR_ROUTE.'item/add';
		$data['action_delete'] = URL_ADMIN.DIR_ROUTE.'item/delete';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		
		/*Render User list view*/
		$this->response->setOutput($this->load->view('items/items_list', $data));
	}
	/**
	* Item index Action method
	* This method will be called on Item Save or Update view
	**/
	public function indexAction()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) { $this->url->redirect('items'); }
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		$data = $this->url->post;
		
		$this->load->controller('common');
		if ($this->controller_common->validateToken($this->url->post('_token'))) {
			$this->url->redirect('items');
		}

		if ($validate_field = $this->validateField($data['item'])) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			$this->url->redirect('items');
		}
		$data['item']['datetime'] =  date('Y-m-d H:i:s');
		$this->load->model('items');
		if (!empty($data['item']['id'])) {
			$this->model_items->updateItem($data['item']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Item updated successfully.');
		}
		else {
			$data['item']['id'] = $this->model_items->createItem($data['item']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Item created successfully.');
		}
		$this->url->redirect('items');
	}
	/**
	* Item index Delete method
	* This method will be called on Item Delete view
	**/
	public function indexDelete()
	{
		$this->load->controller('common');
		if ($this->controller_common->validateToken($this->url->post('_token'))) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			$this->url->redirect('items');
		}
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id')) ) {
			$this->url->redirect('items');
		}
		$this->load->model('items');
		$result = $this->model_items->deleteItem($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Item deleted successfully.');
		$this->url->redirect('items');
	}

	public function indexSearch()
	{
		$data = $this->url->get;
		$this->load->model('items');
		$result = $this->model_items->getSearchedItems($data['term']);
		
		echo json_encode($result);
	}
	/**
	* Item validate method
	* This method will be called to validate input field 
	**/
	public function validateField($data)
	{
		$error = [];
		$error_flag = false;

		if ($this->controller_common->validateText($data['name'])) {
			$error_flag = true;
			$error['title'] = 'Item Name!';
		}

		if ($this->controller_common->validateNumeric($data['price'])) {
			$error_flag = true;
			$error['author'] = 'Item Rate!';
		}
		
		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}