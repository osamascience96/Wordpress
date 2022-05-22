<?php

/**
* Pages Controller
*/
class PagesController extends Controller
{
	/**
	* Page index edit method
	* This method will be called on page view
	**/
	public function index()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		$this->load->model('pages');
		$data['result'] = $this->model_pages->getPages();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['page_title'] = 'Pages';
		$data['page_add'] = $this->user_agent->hasPermission('page/add') ? true : false;
		$data['page_edit'] = $this->user_agent->hasPermission('page/edit') ? true : false;
		$data['page_delete'] = $this->user_agent->hasPermission('page/delete') ? true : false;

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action_delete'] = URL_ADMIN.DIR_ROUTE.'page/delete';

		/*call appointment list view*/
		$this->response->setOutput($this->load->view('pages/pages_list', $data));
	}

	public function indexAdd()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		$this->load->model('pages');
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['result'] = NULL;	

		$data['page_title'] = 'Add Page';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'page/add';

		/*call appointment list view*/
		$this->response->setOutput($this->load->view('pages/page_form', $data));
	}

	public function indexEdit()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Get page data from DB using Page model's method
		**/
		$id = $this->url->get('id');

		$this->load->model('pages');
		$data['result'] = $this->model_pages->getPage($id);

		if (empty($data['result'])) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Page does not exist in database!');
			$this->url->redirect('pages');
		}
		$data['result']['page_data'] = json_decode($data['result']['page_data'], true);
		
		if ($data['result']['page_name'] == 'gallery') {
			$data['gallery'] = $this->model_pages->getGalleries();
		}

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		
		$data['page_title'] = $data['result']['page_title'];
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'page/edit';
		
		/*Render page view according to page*/
		if ($data['result']['predefined'] == '0') {
			$this->response->setOutput($this->load->view('pages/page_form', $data));
		} else {
			$this->response->setOutput($this->load->view('pages/page_'.$data['result']['page_name'], $data));
		}
	}

	public function indexAction()
	{
		$data = $this->url->post;
		
		$this->load->controller('common');

		$this->load->model('pages');
		$data['page']['datetime'] = date('Y-m-d H:i:s');
		if (!empty($data['page']['content'])) {
			$data['page']['content'] = json_encode($data['page']['content']);	
		} else {
			$data['page']['content'] = json_encode(array());
		}
		
		if (!empty($data['page']['id'])) {
			$result = $this->model_pages->updatePage($data['page']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Page updated successfully.');
		} else {
			$data['page']['url'] = $this->controller_common->url_slug($data['page']['title']);
			$data['page']['id'] = $this->model_pages->createPage($data['page']);
			$count = $this->model_pages->checkUrlinDb($data['page']);
			if ($count) {
				$data['page']['url'] = $data['page']['url'].'-'.$data['page']['id'];
				$this->model_pages->updatePageUrl($data['page']);
			} else {
				$this->model_pages->updatePageUrl($data['page']);
			}
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Page created successfully.');	
		}
		$this->url->redirect('page/edit&id='.$data['page']['id']);
	}

	public function indexDelete()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id')) ) {
			$this->url->redirect('pages');
		}
		/**
		* Call delete method
		**/
		$this->load->model('pages');

		$result = $this->model_pages->deletePage($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Page deleted successfully.');
		$this->url->redirect('pages');
	}

	public function indexMenu()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Get page data from DB using Page model's method
		**/
		$id = $this->url->get('id');

		$this->load->model('pages');
		$data['result'] = $this->model_pages->getMenu();
		
		$data['result']['data'] = json_decode($data['result']['data'], true);
		$data['pages'] = $this->model_pages->getPages();
		
		$data['result']['data'] = $this->createMenuStructure($data['result']['data']);
		//exit();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		
		$data['page_title'] = 'Web Menu';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'page/menu';
		
		/*Render page view according to page*/
		$this->response->setOutput($this->load->view('pages/page_header', $data));
	}

	public function indexMenuAction()
	{
		$data = $this->url->post;
		$this->load->controller('common');

		if ($this->controller_common->validateToken($this->url->post('_token'))) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security Token is missing.');
			$this->url->redirect('page/menu');
		}

		$this->load->model('pages');
		$data['page']['last_modified'] = date("Y-m-d H:i:s");
		$data['page']['page_data'] = html_entity_decode($data['page']['page_data']);
		$result = $this->model_pages->updateMenu($data['page']);

		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Menu updated successfully.');		
		$this->url->redirect('page/menu');
	}

	public function indexFooter()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Get page data from DB using Page model's method
		**/
		$id = $this->url->get('id');

		$this->load->model('pages');
		$data['result'] = $this->model_pages->getFooter();
		
		$data['result']['data'] = json_decode($data['result']['data'], true);
		$data['result']['data']['footermenu'] = $this->createMenuStructure($data['result']['data']['footermenu']);
		
		$data['pages'] = $this->model_pages->getPages();

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		
		$data['page_title'] = 'Web Footer';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'page/footer';
		
		/*Render page view according to page*/
		$this->response->setOutput($this->load->view('pages/page_footer', $data));
	}

	public function indexFooterAction()
	{
		$data = $this->url->post;
		$data['page']['footermenu'] = json_decode(html_entity_decode($data['page']['footermenu']), true);
		
		$this->load->controller('common');

		if ($this->controller_common->validateToken($this->url->post('_token'))) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security Token is missing.');
			$this->url->redirect('pages');
		}

		$this->load->model('pages');
		$data['datetime'] = date('Y-m-d H:i:s');
		$data['page'] = json_encode($data['page']);

		$result = $this->model_pages->updateFooter($data['page']);
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Page updated successfully.');
		$this->url->redirect('page/footer');
	}

	public function getPageHeaderPages()
	{
		$pages = $this->url->post('pages');
		$this->load->model('pages');
		$result = '';
		if (!empty($pages)) {
			foreach ($pages as $key => $value) {
				$data = $this->model_pages->getPageforLink($value);
				$data['menu_id'] = uniqid();
				$data['menu_type_id'] = '1';
				$data['menu_page_id'] = $data['id'];
				$data['menu_custom'] = 1;
				$data['menu_label'] = $data['page_title'];
				$data['menu_link'] = $data['page_name'];
				$result .= $this->load->view('pages/generatepage', $data).'</li>';
			}
		}
		echo $result;
	}

	public function getPageHeaderLink()
	{
		$data = $this->url->post;
		$data['menu_id'] = uniqid();
		$data['menu_type_id'] = '2';
		$data['menu_page_id'] = '';
		$data['menu_custom'] = 0;
		$data['menu_label'] = $data['custom_text'];
		$data['menu_link'] = $data['custom_url'];

		$result = $this->load->view('pages/generatelink', $data).'</li>';
		echo $result;
	}

	public function createMenuStructure($elements)
	{
		$tree = array();
		if (!empty($elements)) {
			foreach ($elements as $key => $value) {
				if($value['menu_parent'] == 0) {
					$tree[] = $value;
					unset($elements[$key]);
				}
			}

			foreach ($elements as $key => $value) {
				if(count($tree)) {
					foreach ($tree as $s_key =>  $s_value) {
						if($value['menu_parent'] == $s_value['menu_id']) {
							$tree[$s_key]['child'][] = $value;
							unset($elements[$key]);
						}
					}
				}
			}

			foreach ($elements as $key => $value) {
				if(count($tree)) {
					foreach ($tree as $s_key =>  $s_value) {
						if(!empty($s_value['child'])) {
							foreach ($s_value['child'] as $ss_key => $ss_value) {
								if($ss_value['menu_id'] == $value['menu_parent']) {
									$tree[$s_key]['child'][$ss_key]['child'][] = $value;
								}
							}
						}
					}
				}
			}
		}

		$string = '';
		if(count($tree)) {
			foreach ($tree as $mergeelement) {
				if($mergeelement['menu_type_id'] == 1) {
					$data = $mergeelement;
					$string .= $this->load->view('pages/generatepage', $data, true);
				} elseif($mergeelement['menu_type_id'] == 2) {
					$data = $mergeelement;
					$string .= $this->load->view('pages/generatelink', $data, true);
				}

				if(isset($mergeelement['child'])) {
					$string .= '<ol>';
					foreach ($mergeelement['child'] as $mergeelementsec) {
						if($mergeelementsec['menu_type_id'] == 1) {
							$data = $mergeelementsec;
							$string .= $this->load->view('pages/generatepage', $data, true);
						} elseif($mergeelementsec['menu_type_id'] == 2) {
							$data = $mergeelementsec;
							$string .= $this->load->view('pages/generatelink', $data, true);
						}

						if(isset($mergeelementsec['child'])) {
							$string .= '<ol>';
							foreach ($mergeelementsec['child'] as $mergeelementthr) {
								if($mergeelementthr['menu_type_id'] == 1) {
									$data = $mergeelementthr;
									$string .= $this->load->view('pages/generatepage', $data, true);
									$string .= '</li>';
								} elseif($mergeelementthr['menu_type_id'] == 2) {
									$data = $mergeelementthr;
									$string .= $this->load->view('pages/generatelink', $data, true);
									$string .= '</li>';
								}
							}
							$string .= '</ol>';
						}
						$string .= '</li>';
					}
					$string .= '</ol>';
				} 
				$string .= '</li>';
			}
		}

		return $string;
	}

	public function createMenuTheme($page_name, $selected_value)
	{
		$data['home'] = array(
			'home-1' => 'Home 1',
			'home-2' => 'home 2',
			'home-3' => 'Home 3',
			'home-4' => 'Home 4'
		);
		$data['services'] = array(
			'services-1' => 'Services 1',
			'services-2' => 'Services 2',
			'services-3' => 'Services 3',
			'services-4' => 'Services 4',
			'services-5' => 'Services 5',
			'services-6' => 'Services 6',
			'services-7' => 'Services 7'
		);
		$data['doctors'] = array(
			'doctors-1' => 'Doctors 1',
			'doctors-2' => 'Doctors 2',
			'doctors-3' => 'Doctors 3',
			'doctors-4' => 'Doctors 4',
			'doctors-5' => 'Doctors 5',
			'doctors-6' => 'Doctors 6',
			'doctors-7' => 'Doctors 7',
			'doctors-8' => 'Doctors 8',
			'doctors-9' => 'Doctors 9'
		);
		$data['blogs'] = array(
			'blogs-1' => 'Blogs 1',
			'blogs-2' => 'Blogs 2',
			'blogs-3' => 'Blogs 3',
			'blogs-4' => 'Blogs 4',
			'blogs-5' => 'Blogs 5',
			'blogs-6' => 'Blogs 6',
			'blogs-7' => 'Blogs 7',
			'blogs-8' => 'Blogs 8'
		);
		$themelist = '';
		if (isset($data[$page_name])) {
			$themelist .= '<div class="form-group"><label>Theme</label><select class="custom-select form-control-sm menu-theme">';
			foreach ($data[$page_name] as $key => $value) {
				if ($key === $selected_value) {
					$themelist .= '<option value="'.$key.'" selected>'.$value.'</option>';
				} else {
					$themelist .= '<option value="'.$key.'">'.$value.'</option>';
				}
			}
			$themelist .= '</select></div>';
		}

		return $themelist;
	}

	public function indexTheme()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		$this->load->model('pages');
		$data['result'] = $this->model_pages->getPageThemes();
		$data['result'] = json_decode($data['result'], true);
		
		$data['page_title'] = 'Web Page Theme';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'page/theme';
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/*call appointment list view*/
		$this->response->setOutput($this->load->view('pages/pages_theme', $data));
	}

	public function indexThemeAction()
	{
		$data = $this->url->post;

		$this->load->controller('common');

		if ($this->controller_common->validateToken($data['_token'])) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security Token is missing.');
			$this->url->redirect('pages');
		}

		$this->load->model('pages');
		$data['page'] = json_encode($data['page']);

		$result = $this->model_pages->updatePageTheme($data['page']);
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Page updated successfully.');
		$this->url->redirect('page/theme');
	}

	public function indexSettings()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		/**
		* Get all info data from DB using info model's method
		**/
		$this->load->model('pages');
		$result = $this->model_pages->getWebSetting();
		foreach ($result as $key => $value) {
			$data[$value['name']] = json_decode($value['data'], true);
		}
		
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		
		$data['page_title'] = 'Web Settings';
		/*Set action method for form submit call*/
		$data['action'] = URL_ADMIN.DIR_ROUTE.'page/settings';
		/*Render Info view*/
		$this->response->setOutput($this->load->view('pages/page_settings', $data));
	}

	public function indexSettingsAction()
	{
		$data = $this->url->post;
		$this->load->controller('common');
		
		$data['generalsettings'] = json_encode($data['generalsettings']);
		$data['customcss'] = json_encode($data['customcss']);

		$this->load->model('pages');
		$result = $this->model_pages->updateWebSetting($data);
		
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Site Info updated successfully.');
		$this->url->redirect('page/settings');
	}

	public function iconsPage()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		$data['page_title'] = 'Icons';
		/*call appointment list view*/
		$this->response->setOutput($this->load->view('pages/page_icon', $data));
	}
}