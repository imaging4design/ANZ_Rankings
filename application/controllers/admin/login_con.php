<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_con extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		// AUTOLOADED FILES
		// Helpers: 	global
		// Models: 		global_model
		// Config: 		anz_settings
		// Libraries:	auth
		$this->load->model('admin/login_model');
	}
	
	/*************************************************************************************/
	// Displays the default admin login page
	/*************************************************************************************/
	public function index()
	{
		$data['main_content'] = 'admin/index';
		$this->load->view('admin/includes/template', $data);
	
	} //ENDS index()
	


	/*************************************************************************************/
	// Validates the administrators login details and provides access
	/*************************************************************************************/
	public function validate_credentials()
	{		
		$query = $this->login_model->validate();
		
		if($query) //If the admin's credentials validated...
		{
			$data = array(
				'username' => $this->input->post('username_anz'),
				'admin' => true,
				'is_logged_in' => true
			);
			
			// Unset the failed attempt session var
			$this->session->unset_userdata('login_attempt');
			
			$this->session->set_userdata($data);
			// Redirect('admin/admin_con/');
			redirect('admin/admin_con');
		}
		else // Incorrect username or password
		{
			$this->session->set_userdata('login_attempt', 'fail');
			$this->index();
		}
		
	} //ENDS validate_credentials()
	
	
	
	/*************************************************************************************/
	// Validates the administrators login details and provides access
	/*************************************************************************************/
	public function validate_franchisee()
	{		
		$query = $this->login_model->validate_franchisee();
		
		if($query) // If the franchisess's credentials validated...
		{
			$data = array(
				'username' => $this->input->post('username'),
				'is_logged_in' => true
			);
			$this->session->set_userdata($data);
			redirect('admin/content_con/');
		}
		else // Incorrect username or password
		{
			$this->index();
		}
		
	} //ENDS validate_credentials()
	
	
	
	/*************************************************************************************/
	//Logs out the administrator
	/*************************************************************************************/
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('');
		
	} //ENDS logout()
	


} //ENDS Login_con class
