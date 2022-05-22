<?php

/**
* Common Controller 
*/
class CommonController extends Controller
{
	protected $data;
	public function index() 
	{
		/*
		* Intilize Coomons model
		*/
		$this->load->model('commons');
		$result = $this->model_commons->getSettings();
		foreach ($result as $key => $value) {
			$this->data[$value['name']] = json_decode($value['data'], true);
		}
		
		if ($this->data['siteinfo']['mode'] == 2) {
			$this->url->redirect('comingsoon');
		} elseif ($this->data['siteinfo']['mode'] == 3) {
			$this->url->redirect('maintenance');
		}

		/**
		* Check if user is logged in or not
		* If logged in then get user basic info from DB
		**/
		if ($this->user_agent->isLogged()) {
			if ($user_arr = $this->model_commons->userData($this->session->data['user_id'])) {
				$user = array( 'name' => $user_arr['firstname'].' '.$user_arr['lastname'],
					'email' => $user_arr['email'],
					'mobile' => $user_arr['mobile'] );
			} else {
				unset($this->session->data['user_id']);
				unset($this->session->data['login_token']);
				$this->url->redirect('home');
			}
		} else {
			$user = array(
				'name' => '',
				'email' => '',
				'mobile' => '');
		}

		$this->data['user'] = $user;
		
		if (!empty($this->data['siteinfo']['language'])) {
			require(DIR_LANGUAGE.$this->data['siteinfo']['language'].'/language.php');
		} else {
			require(DIR_LANGUAGE.'en/language.php');
		}
		$this->data['lang'] = $lang;

		if (!empty($this->session->data['color'])) {
			$this->data['themecolor'] = $this->session->data['color'];
		} else {
			$this->data['themecolor'] = 'blue';
		}

		$this->data['whocan'] =  $this->whoCanReviewAppointmentAndComment();
		
		$this->data['logo'] = 'public/uploads/'.$this->data['siteinfo']['logo'];
		$this->data['favicon'] = 'public/uploads/'.$this->data['siteinfo']['favicon'];
		$this->data['stylesheet'] = 'public/css/style-'.$this->data['siteinfo']['color'].'.min.css';
		/**
		* Return common data array
		**/
		return $this->data;
	}

	public function whoCanReviewAppointmentAndComment()
	{
		$settings = json_decode($this->model_commons->generalSettings(), true);
		
		if (!empty($settings['appointment']) && !empty($this->data['user']['email'])) {
			$data['appointment'] = true;
		} elseif (empty($settings['appointment'])) {
			$data['appointment'] = true;
		} else {
			$data['appointment'] = false;
		}

		if (!empty($settings['review']['post']) && !empty($this->data['user']['email'])) {
			$data['review'] = true;
		} elseif (empty($settings['review']['post'])) {
			$data['review'] = true;
		} else {
			$data['review'] = false;
		}

		if (!empty($settings['comment']['post']) && !empty($this->data['user']['email'])) {
			$data['comment'] = true;
		} elseif (empty($settings['comment']['post'])) {
			$data['comment'] = true;
		} else {
			$data['comment'] = false;
		}

		return $data;
	}

	public function getLanguage()
	{
		if (!empty($this->data['siteinfo']['language'])) {
			require(DIR_LANGUAGE.$this->data['siteinfo']['language'].'/language.php');
		} else {
			require(DIR_LANGUAGE.'en/language.php');
		}
		$this->data['lang'] = $lang;
		return $lang;
	}

	public function getHeader($data, $header)
	{
		$this->data['menu'] = $this->createMenuStructure(json_decode($this->model_commons->getMenu(), true));
		$this->data = array_merge($this->data, $data);
		$this->data['meta_tag'] = $data['meta_tag'];
		$this->data['meta_description'] = $data['meta_description'];
		$this->data['customcss'] = json_decode($this->model_commons->customCss(), true);

		if (!isset($data['page_section'])) {
			if ($this->url->get('route') == "home" || empty($this->url->get('route'))) {
				$this->data['page_section'] = false;
			} else {
				$this->data['page_section'] = true;
			}
		}

		if ($header == 'header-1') {
			$this->data['page_padding'] = 'page-padding-header-1';
		} elseif ($header == 'header-2') {
			$this->data['page_padding'] = 'page-padding-header-2';
		} elseif ($header == 'header-3') {
			$this->data['page_padding'] = 'page-padding-header-3';
		} else {
			$this->data['page_padding'] = 'page-padding-header-4';
		}
		return $this->load->view('common/'.$header, $this->data);
	}

	public function getFooter($data, $footer = 'footer')
	{
		$this->data['footer'] = json_decode($this->model_commons->getFooter(), true);
		$this->data['footer']['footermenu'] = $this->createMenuStructure($this->data['footer']['footermenu']);
		if (isset($data['script'])) {
			$this->data['script'] = $data['script'];
		} else {
			$this->data['script'] = NULL;
		}
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$this->data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		return $this->load->view('common/'.$footer, $this->data);
	}

	public function getDoctors()
	{
		$doctors = $this->model_pages->doctors();
		if ($this->data['pagetheme']['doctors']['theme'] == 'doctors-1' || $this->data['pagetheme']['doctors']['theme'] == 'doctors-4' || $this->data['pagetheme']['doctors']['theme'] == 'doctors-7')
		{
			$theme = 'doctor-card-1';
		} elseif ($this->data['pagetheme']['doctors']['theme'] == 'doctors-2' || $this->data['pagetheme']['doctors']['theme'] == 'doctors-5' || $this->data['pagetheme']['doctors']['theme'] == 'doctors-8') {
			$theme = 'doctor-card-2';
		} else {
			$theme = 'doctor-card-3';
		}
		$data['lang'] = $this->data['lang'];
		$doctor = '';
		if (!empty($doctors)) {
			foreach ($doctors as $key => $value) {
				$value['about'] = json_decode($value['about'], true);
				$value['social'] = json_decode($value['social'], true);
				$doctor .= '<div class="col-md-4">';
				$data['value'] = $value;
				$doctor .= $this->load->view('doctor/'.$theme, $data);
				$doctor .= '</div>';
			}
		}

		return $doctor;
	}

	public function getSliderDoctors()
	{
		$doctors = $this->model_pages->getSliderDoctors();
		$doctor = '';
		if (!empty($doctors)) {
			$doctor .= '<div id="hm-doctor-slider" class="owl-carousel owl-theme theme-owl-dot">';
			foreach ($doctors as $key => $value) {
				$value['about'] = json_decode($value['about'], true);
				$doctor .= $this->load->view('doctor/doctor-slider', $value);
			}
			$doctor .= '</div>';
		}
		return $doctor;
	}

	public function getBlogs()
	{
		$card = $this->data['pagetheme']['blogs']['theme'];
		if ($card == 'blogs-1' || $card == 'blogs-3' || $card == 'blogs-4' || $card == 'blogs-6' || $card == 'blogs-8') {
			$theme = 'blog-card-1';
			$count = 3;
		} else {
			$theme = 'blog-card-2';
			$count = 2;
		}

		$blogs = $this->model_pages->homeBlogs($count);

		$blog = '';
		if (!empty($blogs)) {
			foreach ($blogs as $key => $value) {
				$data['value'] = $value;
				$data['lang'] = $this->data['lang'];

				if ($theme == 'blog-card-2') {
					$blog .= '<div class="col-md-6">';
				} else {
					$blog .= '<div class="col-md-4">';
				}

				$blog .= $this->load->view('blog/'.$theme, $data);
				$blog .= '</div>';
			}
		}
		
		return $blog;
	}

	public function getTestimonials()
	{
		$testimonials = $this->model_pages->testimonials();
		
		$testimonial = '';
		if (!empty($testimonials)) {
			$testimonial .= '<div id="testimonial-slider" class="owl-carousel owl-theme theme-owl-dot">';
			foreach ($testimonials as $key => $value) {
				$testimonial .= $this->load->view('common/testimonial', $value);
			}
			$testimonial .= '</div>';
		}

		return $testimonial;
	}

	public function serviceFacility($data)
	{
		$data['facilities'] = $this->model_pages->allFacilities();
		return $this->load->view('service/service-facility', $data);
	}

	public function getDepartments($data)
	{
		$data['departments'] = $this->model_pages->allDepartments();
		return $this->load->view('doctor/doctor-facility', $data);
	}

	public function createMenuStructure($elements)
	{
		$tree = array();
		// $elements = $this->model_commons->getMenu();
		// $elements = json_decode($this->model_commons->getMenu(), true);
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
		if (count($tree)) {
			foreach ($tree as $mergeelement) {
				$data = $mergeelement;
				if (isset($mergeelement['child'])) {
					$data['menu_icon'] = '<i class="fa fa-chevron-down"></i>';
				}
				$string .= $this->load->view('common/menu', $data, true);

				if(isset($mergeelement['child'])) {
					$string .= '<ul class="menu-dropdown">';
					foreach ($mergeelement['child'] as $mergeelementsec) {
						if($mergeelementsec['menu_type_id'] == 1) {
							$data = $mergeelementsec;
							$string .= $this->load->view('common/menu', $data, true);
						} elseif($mergeelementsec['menu_type_id'] == 2) {
							$data = $mergeelementsec;
							$string .= $this->load->view('common/menu', $data, true);
						}

						if(isset($mergeelementsec['child'])) {
							$string .= '<ul class="menu-dropdown menu-dropdown-left">';
							foreach ($mergeelementsec['child'] as $mergeelementthr) {
								if($mergeelementthr['menu_type_id'] == 1) {
									$data = $mergeelementthr;
									$string .= $this->load->view('common/menu', $data, true);
									$string .= '</li>';
								} elseif($mergeelementthr['menu_type_id'] == 2) {
									$data = $mergeelementthr;
									$string .= $this->load->view('common/menu', $data, true);
									$string .= '</li>';
								}
							}
							$string .= '</ul>';
						}
						$string .= '</li>';
					}
					$string .= '</ul>';
				} 
				$string .= '</li>';
			}
		}

		return $string;
	}

	public function subscriber()
	{
		if (!$this->validateEmail()) {
			$this->url->abs_redirect($_SERVER['HTTP_REFERER']);
			exit();
		}

		$this->load->model('commons');
		$data['email'] = $this->url->post('email');
		$this->model_commons->createSubscriber($data);
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'We have added your mail address in our subscriber list.');
		$this->url->abs_redirect($_SERVER['HTTP_REFERER']);
	}

	public function setColor() {
		$this->session->data['color'] = $this->url->get('colorCode');
		if (!empty($_SERVER['HTTP_REFERER'])) {
			$this->url->abs_redirect($_SERVER['HTTP_REFERER']);
		} else {
			$this->url->redirect('home');
		}	
	}

	public function shortCodes()
	{
		$data['header'] = $this->index();
		$data['meta_tag'] = 'Shortcodes -'. $data['header']['info_array']['name'];
		$data['meta_description'] = '';
		$data['active'] = 'shortcodes';
		$this->view->render('about/short-codes.tpl', $data );
	}

	public function comingSoon($data = array())
	{
		$this->load->model('commons');
		$data['common'] = json_decode($this->model_commons->siteInfo(), true);
		
		if ($data['common']['mode'] == '1') { $this->url->redirect('home'); } 
		elseif ($data['common']['mode'] == '3') { $this->url->redirect('maintenance'); }
		
		$data['social'] = json_decode($this->model_commons->getSocialLink(), true);
		/**
		* Load Launguge
		**/
		$data['lang'] = $this->getLanguage();
		$this->response->setOutput($this->load->view('common/comingsoon', $data));

	}

	public function maintenanceMode($data = array())
	{
		$this->load->model('commons');
		$data['common'] = json_decode($this->model_commons->siteInfo(), true);
		if ($data['common']['mode'] == '1') { $this->url->redirect('home'); }
		elseif ($data['common']['mode'] == '2') { $this->url->redirect('comingsoon'); }
		
		$data['social'] = json_decode($this->model_commons->getSocialLink(), true);

		$data['lang'] = $this->getLanguage();

		header("HTTP/1.0 503 Service Unavailable");
		$this->response->setOutput($this->load->view('common/maintenance', $data));
	}

	/** 
	* Validate form input field on server side
	**/
	protected function validateEmail() {
		if ((strlen($this->url->post('email')) > 96) || !filter_var($this->url->post('email'), FILTER_VALIDATE_EMAIL)) {
			/** 
			* If email is not valid
			* Return false
			**/
			return false;
		}
		else {
			/** 
			* Everthing looks good
			* Return True
			**/
			return true;
		}
	}
}