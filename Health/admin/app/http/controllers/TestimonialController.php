<?php

/**
* Testimonial Controller
*/
class TestimonialController extends Controller
{
	/**
	* Testimonial index edit method
	* This method will be called on blog Testimonial view
	**/
	public function index()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Get all Testimonial data from DB using Testimonial model 
		**/
		$this->load->model('testimonial');
		$data['result'] = $this->model_testimonial->allTestimonials();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = 'Testimonials';
		$data['page_add'] = $this->user_agent->hasPermission('testimonial/add') ? true : false;
		$data['page_edit'] = $this->user_agent->hasPermission('testimonial/edit') ? true : false;
		$data['page_delete'] = $this->user_agent->hasPermission('testimonial/delete') ? true : false;

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action_delete'] = URL_ADMIN.DIR_ROUTE.'testimonial/delete';
		/*Render testimonial list view*/
		$this->response->setOutput($this->load->view('themeoption/testimonial_list', $data));
	}
	/**
	* Testimonial index add method
	* This method will be called on Testimonial add
	**/
	public function indexAdd()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/* Set page title */
		$data['page_title'] = 'Add Testimonial';
		/* Set empty data to array */
		$data['result'] =  NULL;
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'testimonial/add';
		/*Render Testimonial add view*/
		$this->response->setOutput($this->load->view('themeoption/testimonial_form', $data));
	}
	/**
	* Testimonial index edit method
	* This method will be called on Testimonial edit view
	**/
	public function indexEdit()
	{	
		/**
		* Check if id exist in url if not exist then redirect to Testimonial list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('testimonials');
		}
		/**
		* Check Testimonial exist or not 
		* If not than redirect to testimonial list view
		**/
		$this->load->model('testimonial');
		$testimonial = $this->model_testimonial->getTestimonial($id);
		if (!$testimonial) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Testimonial does not exist in database!');
			$this->url->redirect('testimonials');
		}
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/*Create array to pass to view*/
		$data['page_title'] = 'Edit Testimonial';
		$data['result'] = $testimonial;

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'testimonial/edit';
		/*Render Testimonial edit view*/
		$this->response->setOutput($this->load->view('themeoption/testimonial_form', $data));
	}/**
	* Info index action method
	* This method will be called on Info submit/save view
	**/
	public function indexAction()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('testimonials');
			exit();
		}
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		$data = $this->url->post;
		$this->load->controller('common');
		if ($validate_field = $this->validateField($data['testimonial'])) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			if (!empty($data['testimonial']['id'])) {
				$this->url->redirect('testimonial/edit&id='.$data['testimonial']['id']);
			} else {
				$this->url->redirect('testimonial/add');
			}
		}

		if ($this->controller_common->validateToken($data['_token'])) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Security token is missing!');
			if (!empty($data['testimonial']['id'])) {
				$this->url->redirect('testimonial/edit&id='.$data['testimonial']['id']);
			} else {
				$this->url->redirect('testimonial/add');
			}
		}

		$data['testimonial']['datetime'] =  date('Y-m-d H:i:s');
		$this->load->model('testimonial');
		if (!empty($data['testimonial']['id'])) {
			$this->model_testimonial->updateTestimonial($data['testimonial']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Testimonial updated successfully.');
			$this->url->redirect('testimonial/edit&id='.$data['testimonial']['id']);
		}
		else {
			$result = $this->model_testimonial->createTestimonial($data['testimonial']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Testimonial created successfully.');
			$this->url->redirect('testimonial/edit&id='.$result);
		}
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
			$this->url->redirect('testimonials');
		}
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id')) ) {
			$this->url->redirect('testimonials');
		}
		$this->load->model('testimonial');
		$result = $this->model_testimonial->deleteTestimonial($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Testimonial deleted successfully.');
		$this->url->redirect('testimonials');
	}

	protected function validateField($data)
	{
		$error = [];
		$error_flag = false;
		if ($this->controller_common->validateText($data['name'])) {
			$error_flag = true;
			$error['name'] = 'Name';
		}

		if ($this->controller_common->validateText($data['testimonial'])) {
			$error_flag = true;
			$error['testimonial'] = 'Person Testimonial';
		}

		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}