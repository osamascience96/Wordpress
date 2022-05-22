<?php

/**
 * PageController
 */
class PageController extends Controller
{
	public function index()
	{
		/**
		* Intilize common controller
		* Get common data from DB
		* We used header variable to represent common data
		**/
		$page = $this->url->get('route');

		$this->load->model('pages');
		$data['page'] = $this->model_pages->pageData($page);
		if (empty($data['page'])) {
			$this->url->redirect('home');
		}
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

		$data['header'] = $this->controller_common->getHeader($data['page'], $data['pagetheme']['other']['header']);
		$data['footer'] = $this->controller_common->getFooter(NULL, 'footer');

		$data['page_sidebar'] = $this->getPageSidebar();
		
		$data['active'] = '';
		
		$this->response->setOutput($this->load->view('page/'.$data['pagetheme']['other']['theme'], $data));
	}

	public function getPageSidebar()
	{
		$data['lang'] = $this->controller_common->getLanguage();
		$data['recentblog'] = $this->model_pages->recentBlog();
		$data['slider_services'] = $this->model_pages->getSliderServices();
		$data['slider_doctor'] = $this->model_pages->getSliderDoctors();
		return $this->load->view('page/page-sidebar', $data);
	}
}