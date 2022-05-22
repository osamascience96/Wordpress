<?php

/**
* 
*/
class LogoutController extends Controller
{
	/**
	* For logout user this will called logout method from common class
	* That will detroy entire session and create new one 
	**/
	public function index()
	{
		$this->session->destroy();
		$this->url->redirect('login');
	}
}