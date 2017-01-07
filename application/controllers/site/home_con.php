<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_con extends CI_Controller {
	
	
	function __construct()
	{
		parent::__construct();
		// AUTOLOADED FILES
		// Helpers: 	global
		// Models: 		global_model
		// Config: 		anz_settings
		// Libraries:	auth
		$this->load->model('site/profiles_model');
		$this->load->model('site/news_model');
		$this->load->model('site/toplist_model');

		date_default_timezone_set('Pacific/Auckland'); // Set defaut timezone .... otherwise 1 day out on localhost!
	}


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
				array_push($nameLast, strtoupper($row->nameLast) . ', ' . $row->nameFirst . ' ' . $row->athleteID);
			
			// Return data (json_encode)
			echo json_encode( $nameLast );
		}
		
		
	} // ENDS get_auto_athletes()


	
	/*************************************************************************************/
	// FUNCTION index()
	// Displays home page content including Athlete and Ranking search panels
	/*************************************************************************************/
	public function index()
	{	
		if($this->input->post('ageGroup'))
		{
			$this->session->set_userdata('ageGroup', $this->input->post('ageGroup'));
			$data['show_target'] = '<div class="top_home"></div>';
		}
		
		$data['token'] = $this->auth->token();

		$data['born_this_day'] = born_this_day(); // from global_helper
		$data['records_this_day'] = records_this_day(); // from global_helper
		$data['show_news'] = show_news(); // from global_helper
		$data['show_flash_news'] = show_flash_news(); // from global_helper
		$data['ratified_record'] = ratified_record(); // from global_helper

		//$data['rankings_added_month'] = rankings_added_month(); // from global_helper
		//$data['rankings_seven_days'] = rankings_seven_days(); // from global_helper
		//$data['total_results'] = totalResults(); // from global_helper
		
		$data['top_performers'] = topPerformers(); // from global_helper
		$data['topPerformers_Multis'] = topPerformers_Multis(); // from global_helper
		$data['topPerformers_Relays'] = topPerformers_Relays(); // from global_helper
				
		$data['main_content'] = 'site/index';
		$this->load->view('site/includes/template', $data);
	
	} // ENDS index()
	
	
	
	
	/*************************************************************************************/
	// FUNCTION archive_lists()
	// Page containing ALL archived lists from previous website
	/*************************************************************************************/
	public function archive_lists()
	{
		$data['token'] = $this->auth->token();
		
		$data['main_content'] = 'site/archive_lists';
		$this->load->view('site/includes/template', $data);
	
	} // ENDS archive_lists()



	/*************************************************************************************/
	// FUNCTION publications()
	// Page containing ALL archived lists from previous website
	/*************************************************************************************/
	public function publications()
	{
		$data['token'] = $this->auth->token();
		
		$data['main_content'] = 'site/publications';
		$this->load->view('site/includes/template', $data);
	
	} // ENDS archive_lists()
	
	
	
	
	/*************************************************************************************/
	// FUNCTION contact()
	// Page containing 'Contact' details to get on touch with admin
	/*************************************************************************************/
	public function contact()
	{
		$data['token'] = $this->auth->token();
		
		$data['main_content'] = 'site/contact';
		$this->load->view('site/includes/template', $data);
	
	} // ENDS contact()



	/*************************************************************************************/
	// FUNCTION most_recent()
	// Retrieves the most recent entries into the rankings database for display
	// Options are either past week or past month
	/*************************************************************************************/
	public function most_recent()
	{
		// Set this to activate the 'Scroll To' function
		if($this->input->post('gender'))
		{
			$data['show_target'] = '<div class="top_home"></div>';
		}

		$this->form_validation->set_rules('time_frame', 'Time Frame', 'trim|required');

		if($this->form_validation->run() == TRUE ) 
		{
			$data['token'] = $this->auth->token();

			$data['most_recent'] = mostRecent(); // from global_helper
			$data['most_recent_multis'] = most_recent_multis(); // from global_helper

			$data['main_content'] = 'site/mostRecent';
			$this->load->view('site/includes/template', $data);
		
		} else {

			$this->error_message = validation_errors('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>');
			
			$data['token'] = $this->auth->token();
			$data['main_content'] = 'site/mostRecent';
			$this->load->view('site/includes/template', $data);
		}

	
	} // ENDS contact()
	
	
	
} //ENDS Home class