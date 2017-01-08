<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Compare_con extends CI_Controller {
	
	
	function __construct()
	{
		parent::__construct();
		// AUTOLOADED FILES
		// Helpers: 	global
		// Models: 		global_model
		// Config: 		anz_settings
		// Libraries:	auth
		$this->load->model('site/compare_model');		
	}

	
	/*************************************************************************************/
	// FUNCTION index()
	// Displays info content for the 'Compare' page
	/*************************************************************************************/
	public function index()
	{
		$data['token'] = $this->auth->token();

		$data['main_content'] = 'site/compare';
		$this->load->view('site/includes/template', $data);
	
	} // ENDS index()






	/*************************************************************************************/
	// FUNCTION compare_athlete_data()
	// Display athletes results data
	// i.e., Rank | Time | Wind | Competition | Venue | Date 
	/*************************************************************************************/
	public function compare_athlete_data()
	{
		$this->form_validation->set_rules('token', 'Token', 'trim|required');
		$this->form_validation->set_rules('athlete[0]', 'Athlete One', 'trim|required');
		$this->form_validation->set_rules('athlete[1]', 'Athlete Two', 'trim|required');
		$this->form_validation->set_rules('eventID', 'Event', 'trim|required');

		$this->session->set_userdata('athlete[0]', $_POST['athlete'][0]);
		$this->session->set_userdata('athlete[1]', $_POST['athlete'][1]);

		// Create results $data array()
		$data = array(
			'athleteID' => $_POST['athlete'][0],
			'athleteID2' => $_POST['athlete'][1],
			'eventID' => $this->input->post('eventID'),
			'year' => $this->input->post('year')
		);

		$data['eventName'] = convertEventID($this->input->post('eventID'));

		
				
		// If form post data validates and CSRF $token == session $token show lists
		if($this->form_validation->run() == TRUE /* && $this->input->post('token') == $this->session->userdata('token') */) 
		{

			// ATHLETE A
			if($query = $this->compare_model->athlete_rep_a())
			{
				$data['athlete_rep_a'] = $query;
			}
			if($query = $this->compare_model->athlete_medals_a())
			{
				$data['athlete_medals_a'] = $query;
			}
			if($query = $this->compare_model->athlete_data_a())
			{
				$data['athlete_data_a'] = $query;
			}

			if($query = $this->compare_model->athlete_perfs_a())
			{
				$data['athlete_perfs_a'] = $query;
			}

			// ATHLETE B
			if($query = $this->compare_model->athlete_rep_b())
			{
				$data['athlete_rep_b'] = $query;
			}
			if($query = $this->compare_model->athlete_medals_b())
			{
				$data['athlete_medals_b'] = $query;
			}
			if($query = $this->compare_model->athlete_data_b())
			{
				$data['athlete_data_b'] = $query;
			}

			if($query = $this->compare_model->athlete_perfs_b())
			{
				$data['athlete_perfs_b'] = $query;
			}

			$data['eventName'] = convertEventID( $this->input->post('eventID') );
			
			$data['token'] = $this->auth->token();
			$data['main_content'] = 'site/compare';
			$this->load->view('site/includes/template', $data);
		}
		
		
		
		
	} // ENDS compare_athlete_data()
	

} //ENDS Compare_con class