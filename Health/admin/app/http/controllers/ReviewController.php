<?php

/**
* Review Controller
*/
class ReviewController extends Controller
{
	public function index()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Get all blogs data from DB using blog model 
		**/
		$this->load->model('review');
		$data['result'] = $this->model_review->allReviews();
		
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		/* Set page title */
		$data['page_title'] = 'Reviews';
		$data['page_edit'] = $this->user_agent->hasPermission('review/edit') ? true : false;
		$data['page_delete'] = $this->user_agent->hasPermission('review/delete') ? true : false;

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action_delete'] = URL_ADMIN.DIR_ROUTE.'review/delete';

		/*Render Blog view*/
		$this->response->setOutput($this->load->view('review/review_list', $data));
	}

	/**
	* Review index edit method
	* This method will be called on Review edit view
	**/
	public function indexEdit()
	{
		/**
		* Check if id exist in url if not exist then redirect to Review list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('blog');
		}
		/**
		* Call getReview method from Blog model to get data from DB for single Review
		* If Review does not exist then redirect it to Review list view
		**/
		$this->load->model('review');
		$review = $this->model_review->getReview($id);
		if (empty($review)) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Review does not exist in database!');
			$this->url->redirect('reviews');
		}
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']); 
		/* Set Edit blog page title */
		$data['page_title'] = 'Edit Review';
		/* Set Blog data to array */
		$data['result'] =  $review;
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'review/edit';
		/*Render Blog edit view*/
		$this->response->setOutput($this->load->view('review/review_form', $data));
	}
	/**
	* Review index action method
	* This method will be called on review submit/save view
	**/
	public function indexAction()
	{
		/**
		* Check if from is submitted or not 
		**/
		$data = $this->url->post;
		
		if (!isset($_POST['submit']) && !empty($data['review']['id'])) {
			$this->url->redirect('reviews');
			exit();
		}
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		$this->load->controller('common');

		if ($this->controller_common->validateToken($data['_token'])){
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			$this->url->redirect('review/edit&id='.$data['review']['id']);
		}
		if ($validate_field = $this->validateField($data['review'])) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			$this->url->redirect('review/edit&id='.$data['review']['id']);
		}

		$this->load->model('review');
		$this->model_review->updateReview($data['review']);
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Review updated successfully.');
		$this->url->redirect('review/edit&id='.$data['review']['id']);
	}
	/**
	* Review index delete method
	* This method will be called on Review delete action
	**/
	public function indexDelete()
	{
		$this->load->controller('common');
		if ($this->controller_common->validateToken($this->url->post('_token'))) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			$this->url->redirect('reviews');
		}
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id')) ) {
			$this->url->redirect('reviews');
		}
		$this->load->model('review');
		$result = $this->model_review->deleteReview($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Review deleted successfully.');
		$this->url->redirect('reviews');
	}

	protected function validateField($data)
	{
		$error = [];
		$error_flag = false;

		if ($this->controller_common->validateText($data['content'])) {
			$error_flag = true;
			$error['content'] = 'Review!';
		}
		
		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}