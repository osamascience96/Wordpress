<?php

/**
* Comment Controller
*/
class CommentController extends Controller
{	/**
	* Comment index method
	* This method will be called on Comment list view
	**/
	public function index()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Get all Comments data from DB using Comment model 
		**/
		$this->load->model('comment');
		$data['result'] = $this->model_comment->allComments();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['meta_title'] = 'Comments';
		$data['page_title'] = 'Comments';
		$data['page_edit'] = $this->user_agent->hasPermission('comment/edit') ? true:false;
		$data['page_delete'] = $this->user_agent->hasPermission('comment/delete') ? true:false;

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action_delete'] = URL_ADMIN.DIR_ROUTE.'comment/delete';

		/*Render Comments view*/
		$this->response->setOutput($this->load->view('blog/comment_list', $data));
	}
	/**
	* Comment index edit method
	* This method will be called on Comment edit view
	**/
	public function indexEdit()
	{
		/**
		* Check if id exist in url if not exist then redirect to Comment list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('comment');
		}
		/**
		* Call getComment method from Comment model to get data from DB for single Comment
		* If Comment does not exist then redirect it to Comment list view
		**/
		$this->load->model('comment');
		$comment = $this->model_comment->getComment($id);
		if (!$comment) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Comment does not exist in database!');
			$this->url->redirect('comment');
		}
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/* Set Edit Comment page title */
		$data['page_title'] = 'Edit Comment';
		/* Set Comment data to array */
		$data['result'] =  $comment;
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'comment/edit';
		/*Render Comment edit view*/
		$this->response->setOutput($this->load->view('blog/comment_form', $data));
	}

	/**
	* Comment index action method
	* This method will be called on Comment submit/save view
	**/
	public function indexAction()
	{
		/**
		* Check if from is submitted or not 
		**/
		$data = $this->url->post;
		if (!isset($_POST['submit']) && !empty($data['comment']['id'])) {
			$this->url->redirect('comment');
		}
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		$this->load->controller('common');
		if ($this->controller_common->validateToken($this->url->post('_token'))){
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security Token is missing!');
			$this->url->redirect('comment/edit&id='.$data['comment']['id']);
		}
		if ($validate_field = $this->validateField($data['comment'])) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			$this->url->redirect('comment/edit&id='.$data['comment']['id']);
		}

		$data['comment']['datetime'] = date('Y-m-d H:i:s');
		$this->load->model('comment');
		$this->model_comment->updateComment($data['comment']);
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Comment updated successfully.');
		$this->url->redirect('comment/edit&id='.$data['comment']['id']);
	}
	/**
	* Comment index delete method
	* This method will be called on Comment delete action
	**/
	public function indexDelete()
	{
		$this->load->controller('common');
		if ($this->controller_common->validateToken($this->url->post('_token'))) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			$this->url->redirect('comment');
		}

		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id')) ) {
			$this->url->redirect('comment');
		}
		/**
		* Call delete method
		**/
		$this->load->model('comment');
		$result = $this->model_comment->deleteComment($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Comment deleted successfully.');
		$this->url->redirect('comment');
	}

	protected function validateField($data)
	{
		$error = [];
		$error_flag = false;

		if ($this->controller_common->validateText($data['content'])) {
			$error_flag = true;
			$error['content'] = 'Comment!';
		}
		
		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}