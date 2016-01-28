<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_con extends CI_Controller
{	
	
	function __construct()
	{
		parent::__construct();
		// AUTOLOADED FILES
		// Helpers: 	global
		// Models: 		global_model
		// Config: 		anz_settings
		// Libraries:	auth
		$this->is_logged_in();
		$this->load->model('admin/results_model');
	}
	
	
	/*************************************************************************************/
	// FUNCTION is_logged_in()
	// Checks to see if the administrator is logged in - if not redirect back to login page
	/*************************************************************************************/
	public function is_logged_in()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');	
		if(!isset($is_logged_in) || $is_logged_in != true)
		{
			redirect('admin/login_con', 'refresh');
		}
		
	} // ENDS is_logged_in()
	
	
	
	/*************************************************************************************/
	// FUNCTION index()
	// Displays the default menu page
	/*************************************************************************************/
	public function index()
	{
		$data['main_content'] = 'admin/admin_menu';
		$this->load->view('admin/includes/template', $data);
		
	} // ENDS index()
	
		
	
	/*************************************************************************************/
	// FUNCTION get_auto_athletes()
	// Used to operate the 'auto complete' drop down athlete menu
	/*************************************************************************************/
	public function get_auto_athletes()
	{
		// If query returns TRUE
		if($query = $this->global_model->get_auto_athletes())
		{
			// Initiate $nameLast array()
			$nameLast = array();
			
			// Loop through results and create an array
			foreach($query as $row)
				
				// Pushes the passed variables onto the end of array ($nameLast)
				array_push($nameLast, strtoupper($row->nameLast) . ', ' . $row->nameFirst . ' (' . $row->DOB . ') ' . $row->centreID . ' ' . $row->athleteID);
			
			// Return data (json_encode)
			echo json_encode($nameLast);
		}
		
		
	} // ENDS get_auto_athletes()
	


} // ENDS class Admin_con