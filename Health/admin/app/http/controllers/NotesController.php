<?php

/**
* ItemController
*/
class NotesController extends Controller
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
		$this->load->model('notes');
		$data['result'] = $this->model_notes->getNotes();

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = 'Notes';
		$data['page_add'] = $this->user_agent->hasPermission('note/add') ? true : false;
		$data['page_edit'] = $this->user_agent->hasPermission('note/edit') ? true : false;
		$data['page_delete'] = $this->user_agent->hasPermission('note/delete') ? true : false;

		$data['action'] = URL_ADMIN.DIR_ROUTE.'note/add';
		$data['action_delete'] = URL_ADMIN.DIR_ROUTE.'note/delete';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		
		/*Render User list view*/
		$this->response->setOutput($this->load->view('notes/notes_list', $data));
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
		if (!isset($_POST['submit'])) { $this->url->redirect('notes'); }
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		$data = $this->url->post;
		
		$this->load->controller('common');
		if ($this->controller_common->validateToken($data['_token'])) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			$this->url->redirect('notes');
		}

		if ($validate_field = $this->validateField($data['note'])) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			$this->url->redirect('notes');
		}


		$this->load->model('notes');
		if (!empty($data['note']['id'])) {
			$this->model_notes->updateNote($data['note']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Note updated successfully.');
		}
		else {
			$data['note']['id'] = $this->model_notes->createNote($data['note']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Note created successfully.');
		}
		$this->url->redirect('notes');
	}

	public function indexSearch()
	{
		$data = $this->url->get;

		$this->load->model('notes');
		$result = $this->model_notes->getSearchedNotes($data);
		
		echo json_encode($result);
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
			$this->url->redirect('notes');
		}
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id')) ) {
			$this->url->redirect('notes');
		}
		$this->load->model('notes');
		$result = $this->model_notes->deleteNote($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Note deleted successfully.');
		$this->url->redirect('notes');
	}
	/**
	* Item validate method
	* This method will be called to validate input field 
	**/
	public function validateField($data)
	{
		$error = [];
		$error_flag = false;

		if ($this->controller_common->validateText($data['type'])) {
			$error_flag = true;
			$error['title'] = 'Note Type!';
		}

		if ($this->controller_common->validateText($data['note'])) {
			$error_flag = true;
			$error['author'] = 'Note Paragraph!';
		}
		
		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}