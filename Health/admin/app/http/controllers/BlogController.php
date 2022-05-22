<?php

/**
* Blog Controller
*/
class BlogController extends Controller
{
	/**
	* Blog index method
	* This method will be called on blog list view
	**/
	public function index()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Get all blogs data from DB using blog model 
		**/
		$this->load->model('blog');
		$data['result'] = $this->model_blog->allBlogs();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['page_title'] = 'Blogs';
		$data['page_add'] = $this->user_agent->hasPermission('blog/add') ? true:false;
		$data['page_edit'] = $this->user_agent->hasPermission('blog/edit') ? true:false;
		$data['page_delete'] = $this->user_agent->hasPermission('blog/delete') ? true:false;

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action_delete'] = URL_ADMIN.DIR_ROUTE.'blog/delete';

		/*Render Blog view*/
		$this->response->setOutput($this->load->view('blog/blog_list', $data));
	}
	/**
	* Blog index add method
	* This method will be called on Blog add
	**/
	public function indexAdd()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		/* Set empty data to array */
		$data['result'] =  NULL;
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$this->load->model('blog');
		$data['categories'] = $this->model_blog->allCategory();
		$categories = array();
		if (!empty($data['categories'])) {
			foreach ($data['categories'] as $value){
				$categories[$value['parent']][] = $value;
			}

			$data['categories'] = $this->createCategoryArray($categories, $categories[0]);
			$data['categories'] = $this->createCategoryHTML($data['categories']);
		} else {
			$data['categories'] = "";
		}
		
		/* Set page title */
		$data['page_title'] = 'New Blog';

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'blog/add';
		/*Render Blog add view*/
		$this->response->setOutput($this->load->view('blog/blog_form', $data));
	}
	/**
	* Blog index edit method
	* This method will be called on Blog Edit view
	**/
	public function indexEdit()
	{
		/**
		* Check if id exist in url if not exist then redirect to blog list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('blogs');
		}
		/**
		* Call getBlog method from Blog model to get data from DB for single blog
		* If blog does not exist then redirect it to blog list view
		**/
		$this->load->model('blog');
		$data['result']  = $this->model_blog->getBlog($id);
		if (empty($data['result'])) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Blog does not exist in database!');
			$this->url->redirect('blogs');
		}

		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		$data['categories'] = $this->model_blog->allCategoryWithCheck($id);

		$categories = array();
		if (!empty($data['categories'])) {
			foreach ($data['categories'] as $value){
				$categories[$value['parent']][] = $value;
			}

			$data['categories'] = $this->createCategoryArray($categories, $categories[0]);
			$data['categories'] = $this->createCategoryHTML($data['categories']);
		} else {
			$data['categories'] = "";
		}
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['page_title'] = 'Edit Blog';
		$data['comment_edit'] = $this->user_agent->hasPermission('comment/edit') ? true:false;
		$data['comment_list'] = $this->user_agent->hasPermission('comment') ? true:false;
		if ($data['comment_list']) {
			$data['comments'] = $this->model_blog->getComments($id);
		}
		
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'blog/edit';
		/*Render Blog edit view*/
		$this->response->setOutput($this->load->view('blog/blog_form', $data));
	}

	protected function createCategoryHTML($categories)
	{
		$data = '<ul class="category-list list-style-none">';
		foreach($categories as $value){
			if(isset($value['sub'])) {
				$data .= '<div class="custom-control custom-checkbox mb-3">
				<input type="checkbox" name="blog[category][]" class="custom-control-input" value="'.$value['id'].'" id="category-'.$value['id'].'" '.$value['status'].'>
				<label class="custom-control-label" for="category-'.$value['id'].'"><p>'.$value['name'].'</p></label>
				</div>' .$this->createCategoryHTML($value['sub']);
			}else{
				$data .= '<li><div class="custom-control custom-checkbox mb-3">
				<input type="checkbox" name="blog[category][]" class="custom-control-input" value="'.$value['id'].'" id="category-'.$value['id'].'" '.$value['status'].'>
				<label class="custom-control-label" for="category-'.$value['id'].'"><p>'.$value['name'].'</p></label>
				</div>';
			}
		}
		return $data.'</ul>';
	}

	protected function createCategoryArray(&$list, $parent)
	{
		$tree = array();
		foreach ($parent as $k=>$l){
			if(isset($list[$l['id']])){
				$l['sub'] = $this->createCategoryArray($list, $list[$l['id']]);
			}
			$tree[] = $l;
		}
		return $tree;
	}
	/**
	 * Blog index action method
	 * This method will be called on blog submit/save view
	**/
	public function indexAction()
	{
		/**
		 * Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('blogs');
		}
		
		$data = $this->url->post;
		$this->load->controller('common');
		if ($this->controller_common->validateToken($data['_token'])){
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			$this->url->redirect('blogs');
		}

		if ($validate_field = $this->validateField($data['blog'])) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			if (!empty($data['blog']['id'])) {
				$this->url->redirect('blog/edit&id='.$data['blog']['id']);
			} else {
				$this->url->redirect('blog/add');
			}
		}

		$data['blog']['datetime'] = date('Y-m-d H:i:s');
		$this->load->model('blog');
		if (!empty($data['blog']['id'])) {
			$this->model_blog->updateBlog($data['blog']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Blog updated successfully.');
		}
		else {
			$data['blog']['user_id'] = $this->session->data['user_id'];
			$data['blog']['id'] = $this->model_blog->createBlog($data['blog']);
			$data['blog']['url'] = $this->controller_common->url_slug($data['blog']['title']);
			$count = $this->model_blog->checkUrlinDb($data['blog']);
			if ($count) {
				$data['blog']['url'] = $data['blog']['url'].'-'.$data['blog']['id'];
				$this->model_blog->updateBlogUrl($data['blog']);
			} else {
				$this->model_blog->updateBlogUrl($data['blog']);
			}
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Blog created successfully.');
		}
		$this->url->redirect('blog/edit&id='.$data['blog']['id']);
	}
	/**
	* Blog index delete method
	* This method will be called on blog delete action
	**/
	public function indexDelete()
	{
		$this->load->controller('common');
		if ($this->controller_common->validateToken($this->url->post('_token'))) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			$this->url->redirect('blogs');
		}

		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id')) ) {
			$this->url->redirect('blogs');
		}
		/**
		* Call delete method
		**/
		$this->load->model('blog');
		$result = $this->model_blog->deleteBlog($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Blog deleted successfully.');
		$this->url->redirect('blogs');
	}

	protected function validateField($data)
	{
		$error = [];
		$error_flag = false;
		if ($this->controller_common->validateText($data['title'])) {
			$error_flag = true;
			$error['title'] = 'Blog Title!';
		}

		if ($this->controller_common->validateText($data['author'])) {
			$error_flag = true;
			$error['author'] = 'Author Name!';
		}

		if ($this->controller_common->validateText($data['short_post'])) {
			$error_flag = true;
			$error['short_post'] = 'Short Description!';
		}

		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}