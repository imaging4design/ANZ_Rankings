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
		$data['total_results'] = totalResults(); // from global_helper
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

		}
		
		$data['main_content'] = 'site/mostRecent';
		$this->load->view('site/includes/template', $data);

	
	} // ENDS contact()




	/*************************************************************************************/
	// FUNCTION find_athlete_names()
	// Used to retrieve athlete names to populate the 'Search Athletes' panel
	// Finds athletes depending on the first letter of their 'Last Name'
	/*************************************************************************************/
	// public function find_athlete_names()
	// {
	// 	$this->form_validation->set_rules('alpha', 'Alpha Letter', 'trim|required');
		
	// 	if($this->form_validation->run() == TRUE) 
	// 	{
	// 		// Get data from model
	// 		if($query = $this->profiles_model->show_athletes())
	// 		{
	// 			$athlete_names = $query;
	// 		}
			
	// 		if(isset($athlete_names))
	// 		{
			
	// 		echo '<div class="d960 drow">';
	
	// 		$results = count($athlete_names);
	// 		$per_column = ceil($results/5);
			
	// 		$i = 0;
	// 		echo '<table cellspacing="0" cellpadding="0" border="0" width="100%" >';
	// 		echo '<tr valign="top">';
	// 		echo '<td width=20%>';
			
	// 		foreach($athlete_names as $row) {
			
	// 			 if($i == $per_column)
	// 			 {
	// 					echo '</td><td width=20%>';
	// 					$i = 0;
	// 			 }
				 
	// 					echo '<h6>'.anchor('site/profiles_con/athlete/' . $row->athleteID, strtoupper($row->nameLast). ' ' . $row->nameFirst) . ' (' . $row->centreID . ')</h6>';
				 
	// 			 $i++;
				 
	// 		}
			
	// 		echo '</td>';
	// 		echo '</tr>';
	// 		echo '</table>';
			
	// 		echo '</div>';
			
	// 		}
		
	// 	}
		
	// } // ENDS find_athlete_names()
	
	
	
} //ENDS Home class