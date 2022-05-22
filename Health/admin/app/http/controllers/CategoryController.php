<?php

/**
 * Category Controller
 */
class CategoryController extends Controller
{
	public function index()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Get all blogs data from DB using blog model 
		**/
		$this->load->model('category');
		$data['result'] = $this->model_category->allCategories();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['page_title'] = 'Category';
		$data['page_add'] = $this->user_agent->hasPermission('category/add') ? true : false;
		$data['page_edit'] = $this->user_agent->hasPermission('category/edit') ? true : false;
		$data['page_delete'] = $this->user_agent->hasPermission('category/delete') ? true : false;

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'category/add';
		$data['action_delete'] = URL_ADMIN.DIR_ROUTE.'category/delete';
		/*Render Blog view*/
		$this->response->setOutput($this->load->view('blog/category', $data));
	}

	/**
	* Blog index edit method
	* This method will be called on Blog edit view
	**/
	public function indexEdit()
	{
		/**
		* Check if id exist in url if not exist then redirect to blog list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('category');
		}
		/**
		* Call getBlog method from Blog model to get data from DB for single blog
		* If blog does not exist then redirect it to blog list view
		**/
		$this->load->model('category');
		$category = $this->model_category->getCategory($id);
		if (!$category) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Category does not exist in database!');
			$this->url->redirect('category');
		}
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		
		/* Set Blog data to array */
		$data['result'] =  $category;
		$data['categories'] = $this->model_category->allCategories();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		/* Set Edit blog page title */
		$data['page_title'] = 'Edit Category';

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'category/edit';
		/*Render Blog edit view*/
		$this->response->setOutput($this->load->view('blog/category_form', $data));
	}
	/**
	* Category index action method
	* This method will be called on Category submit/save view
	**/
	public function indexAction()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('category');
		}
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		$data = $this->url->post;
		$this->load->controller('common');

		if ($this->controller_common->validateToken($data['_token'])) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			$this->url->redirect('category');
		}

		if ($validate_field = $this->validateField($data['category'])) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			if (!empty($data['category']['id'])) {
				$this->url->redirect('category/edit&id='.$data['category']['id']);
			} else {
				$this->url->redirect('category');
			}
		}
		$data['category']['parent'] = isset($data['category']['parent']) ? $data['category']['parent'] : NULL;
		$data['category']['datetime'] = date('Y-m-d H:i:s');
		$this->load->model('category');
		if (!empty($data['category']['id'])) {
			$result = $this->model_category->updateCategory($data['category']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Category updated successfully.');
			$this->url->redirect('category/edit&id='.$data['category']['id']);
		}
		else {
			$result = $this->model_category->createCategory($data['category']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Category created successfully.');
			$this->url->redirect('category');
		}
	}

	/**
	* Category index delete method
	* This method will be called on Category delete action
	**/
	public function indexDelete()
	{
		$this->load->controller('common');
		if ($this->controller_common->validateToken($this->url->post('_token'))) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			$this->url->redirect('category');
		}
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id')) ) {
			$this->url->redirect('category');
		}
		/**
		* Call delete method
		**/
		$this->load->model('category');
		$result = $this->model_category->deleteCategory($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Category deleted successfully.');
		$this->url->redirect('category');
	}

	protected function validateField($data)
	{
		$error = [];
		$error_flag = false;
		if ($this->controller_common->validateText($data['name'])) {
			$error_flag = true;
			$error['title'] = 'Category Name!';
		}

		if ($this->controller_common->validateText($data['slug'])) {
			$error_flag = true;
			$error['author'] = 'Slug!';
		}

		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}