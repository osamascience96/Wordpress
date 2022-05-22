<?php
/**
* Blog Controller
*/
class BlogController extends Controller
{
	/**
	* Blog controller index method
	* It will call getPage method of this controller
	**/
	public function index() {
		$this->load->model('pages');
		$data['page'] = $this->model_pages->pageData('blogs');
		$data['page']['page_data'] = json_decode($data['page']['page_data'], true);

		$this->load->controller('common');
		$data = array_merge($data, $this->controller_common->index());
		$data['page']['breadcrumbs'] = array();
		$data['page']['breadcrumbs'][] = array(
			'label' => $data['lang']['text_home'],
			'link' => URL.DIR_ROUTE.'home',
		);
		$data['page']['breadcrumbs'][] = array(
			'label' => $data['page']['page_title'],
			'link' => '#',
		);

		$data['header'] = $this->controller_common->getHeader($data['page'], $data['pagetheme']['blogs']['header']);
		$data['footer'] = $this->controller_common->getFooter(NULL, 'footer');

		$data['blogs'] = $this->model_pages->blogs();

		$data['recentblog'] = $this->model_pages->recentBlog();
		$data['trendingblog'] = $this->model_pages->trendingBlog();
		$data['categories'] = $this->model_pages->getCategories();
		$data['active'] = 'blog';

		/**
		* Load home view according to theme selected
		* Pass data to view
		**/
		$this->response->setOutput($this->load->view('blog/'.$data['pagetheme']['blogs']['theme'], $data));
	}

	public function singleBlog() 
	{
		if (empty($this->url->get('name'))) {
			$this->url->redirect('blog');
		}
		
		$this->load->model('pages');
		$data['blog'] = $this->model_pages->getSingleBlog($this->url->get('name'));
		if (empty($data['blog'])) {
			$this->url->redirect('blogs');
		}

		$this->load->controller('common');
		$data = array_merge($data, $this->controller_common->index());
		
		$data['page']['page_title'] = $data['blog']['title'];
		$data['page']['breadcrumbs'] = array();
		$data['page']['breadcrumbs'][] = array(
			'label' => $data['lang']['text_home'],
			'link' => URL.DIR_ROUTE.'home',
		);
		$data['page']['breadcrumbs'][] = array(
			'label' => $data['lang']['text_blogs'],
			'link' => URL.DIR_ROUTE.'blogs',
		);
		$data['page']['breadcrumbs'][] = array(
			'label' => $data['page']['page_title'],
			'link' => '#',
		);

		$data['page']['meta_tag'] = $data['blog']['title']. ' | ' .$data['siteinfo']['name'];
		$data['page']['meta_description'] = $data['blog']['title'].', '.$data['siteinfo']['name'];

		$data['header'] = $this->controller_common->getHeader($data['page'], $data['pagetheme']['blogs']['header']);
		$data['footer'] = $this->controller_common->getFooter(NULL, 'footer');

		if (isset($this->session->data['error'])) {
			$data['error'] = $this->session->data['error'];
			unset($this->session->data['error']);
		}
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		}
		$data['comments'] = $this->model_pages->getComments($data['blog']['id']);
		$data['recentblog'] = $this->model_pages->recentBlog();
		$data['trendingblog'] = $this->model_pages->trendingBlog();
		$data['categories'] = $this->model_pages->getCategories();
		
		$data['share_url'] = urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
		$data['active'] = 'blog';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		//$this->view->render('blog/blog.tpl', $data );
		$this->response->setOutput($this->load->view('blog/blog', $data));
	}

	public function commentAction()
	{
		$this->load->controller('common');
		$lang = $this->controller_common->getLanguage();
		if (isset($_POST['submit']) && !$this->validateField()) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => $lang['text_please_enter_valid_data_in_input_box']);
			$this->url->abs_redirect($_SERVER['HTTP_REFERER']);
			exit();
		}

		$token = $this->url->post('_token');
		$token_check = hash('sha512', TOKEN . TOKEN_SALT);
		if (hash_equals($token_check, $token) === false ) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => $lang['text_security_token_is_missing']);
			$this->url->abs_redirect($_SERVER['HTTP_REFERER']);
			exit();
		}

		$this->load->model('forms');
		$result = $this->model_forms->createComment($this->url->post, $_SERVER['REMOTE_ADDR']);
		$this->session->data['message'] = array('alert' => 'success', 'value' => $lang['text_comment_created_successfully']);
		$this->url->abs_redirect($_SERVER['HTTP_REFERER']);
	}

	protected function validateField()
	{
		if (filter_var($this->url->post('blog_id'), FILTER_VALIDATE_INT) === false) {
			/**
			* If Blog id is not valid or integer 
			* Return false
			**/
			return false;
		} elseif ((strlen(trim($this->url->post('name'))) < 2) || (strlen(trim($this->url->post('name'))) > 52)) {
			/**
			* If Name is not valid ( min 3 character or max 52 ) 
			* Return false
			**/
			return false;
		} elseif ((strlen($this->url->post('email')) > 96) || !filter_var($this->url->post('email'), FILTER_VALIDATE_EMAIL)) {
			/** 
			* If email is not valid
			* Return false
			**/
			return false;
		} elseif ((strlen($this->url->post('content')) < 5)) {
			/** 
			* If Comment content is not valid
			* Return false
			**/
			return false;
		} else {
			/** 
			* Everthing looks good
			* Return True
			**/
			return true;
		}
	}

	public function categoryBlog()
	{
		if (!is_numeric((int)$this->url->get('id'))) {
			$this->url->redirect('blogs');
		}
		$id = (int)$this->url->get('id');

		$this->load->model('pages');
		$data['category'] = $this->model_pages->getCategory($id);

		if (empty($data['category'])) {
			$this->url->redirect('blogs');
		}

		$data['page'] = $this->model_pages->pageData('blogs');
		$data['page']['page_data'] = json_decode($data['page']['page_data'], true);

		$this->load->controller('common');
		$data = array_merge($data, $this->controller_common->index());
		$data['page']['breadcrumbs'] = array();
		$data['page']['breadcrumbs'][] = array(
			'label' => $data['lang']['text_home'],
			'link' => URL.DIR_ROUTE.'home',
		);
		$data['page']['breadcrumbs'][] = array(
			'label' => $data['page']['page_title'],
			'link' => URL.DIR_ROUTE.'blogs',
		);
		$data['page']['breadcrumbs'][] = array(
			'label' => $data['category']['name'],
			'link' => '#',
		);


		$data['page']['meta_tag'] = $data['category']['name']. ' | ' .$data['page']['meta_tag'];
		$data['page']['meta_description'] = $data['category']['name'].', '.$data['page']['meta_description'];

		$data['header'] = $this->controller_common->getHeader($data['page'], $data['pagetheme']['blogs']['header']);
		$data['footer'] = $this->controller_common->getFooter(NULL, 'footer');

		$data['blogs'] = $this->model_pages->blogs();
		$data['categories'] = $this->model_pages->allCategoryWithChild($id);
		
		if (!empty($data['categories'])) {
			$data['categories'] = array_filter(array_map(function($current){
				return $current['id'];
			},$data['categories']));

			array_push($data['categories'], $id);
			$data['blogs'] = $this->model_pages->getBlogByCategory($data['categories']);
		} else {
			$data['blogs'] = array();
		}
		
		$data['recentblog'] = $this->model_pages->recentBlog();
		$data['trendingblog'] = $this->model_pages->trendingBlog();
		$data['categories'] = $this->model_pages->getCategories();
		$data['active'] = 'blog';

		$this->response->setOutput($this->load->view('blog/'.$data['pagetheme']['blogs']['theme'], $data));
	}
}