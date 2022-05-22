<?php

/**
* Gallery Controller
*/
class GalleryController extends Controller
{
	/**
	* Gallery Controller index method
	* It will call getPage method
	**/
	public function index() 
	{
		$this->load->model('pages');
		$data['page'] = $this->model_pages->pageData('gallery');
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
		$data['header'] = $this->controller_common->getHeader($data['page'], $data['pagetheme']['gallery']['header']);
		$data['footer'] = $this->controller_common->getFooter(NULL, 'footer');

		$data['galleries'] = $this->model_pages->getGalleries();

		$data['active'] = 'gallery';
		/**
		* Load gallery view
		* Pass data to view
		**/
		$this->response->setOutput($this->load->view('gallery/'.$data['pagetheme']['gallery']['theme'], $data));
	}
}