<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profiles_con extends CI_Controller {
	
	
	public function __construct()
	{
		parent::__construct();
		// AUTOLOADED FILES
		// Helpers: 	global
		// Models: 		global_model
		// Config: 		anz_settings
		// Libraries:	auth
		$this->load->model('site/profiles_model');
	}

	
	/*************************************************************************************/
	// FUNCTION show_athletes()
	// Display ALL athletes who's lastname starts with $this->uri->segment(2)
	/*************************************************************************************/
	public function index()
	{
		$data['token'] = $this->auth->token();
		$data['main_content'] = 'site/profiles';
		$this->load->view('site/includes/template', $data);
		
	} // ENDS index()
	
	
	/*************************************************************************************/
	// FUNCTION search_proxy()
	// WHAT IS THIS?
	// This function calls the athlete() function directly below it
	// WHY?
	// So we can capture the $this->input->post('athleteID') from the form and append it to the url
	// This will allow people to copy this link as a reference to the athlete profile
	/*************************************************************************************/

	public function search_proxy() 
	{
		$athleteID = substr($this->input->post('athleteID'), -6);

		if( strlen($athleteID) == 6 ) {
			// if needed urlencode or other search query manipulation
			redirect('site/profiles_con/athlete/' . $athleteID);
		}
		else {
			show_my_404();
			echo 'we know an athlete by the name of <strong>' . $this->input->post('athleteID') . '</strong> but we didn\'t get their athlete ID<br>';
			echo 'Click here and try entering their name again ... slowly big guy';
		}
		
	}


	/*************************************************************************************/
	// FUNCTION athleteFly()
	// Gets information about the athlete to display on the 'Quick View' flyout panel
	// i.e., Name, club, centre etc
	/*************************************************************************************/

	public function athleteFlyout() {

		echo '<div class="flyout-styles">';

			// Display athlete personal details ...
			$data['athlete'] = athlete(); // see profiles_helper

			$gender = ( $data['athlete']->gender == 'M') ? 'Male' : 'Female'; // format gender

			echo '<h3>' . $data['athlete']->nameFirst . ' ' . $data['athlete']->nameLast . ' (' . age_from_dob($data['athlete']->birthDate) . ')</h3>';

			echo '<ul>';
				echo '<li>Gender: ' . $gender . '</li>';
				echo '<li>DOB: ' . $data['athlete']->birthDate . '</li>';
				echo '<li>Age: ' . age_from_dob($data['athlete']->birthDate) . ' Years / ' . daysLeftForBirthday($data['athlete']->DOB) . ' Days</li>';
				echo '<li>Centre: ' . $data['athlete']->centreID . '</li>';
				echo '<li>Club: ' . $data['athlete']->clubName . '</li>';
				echo '<li>Coach: ' . $data['athlete']->coach . '</li>';
				echo '<li>Former Coach(s): ' . $data['athlete']->coach_former . '</li>';
			echo '</ul>';



			// Display athlete personal bests ...
			if($query = $this->profiles_model->personal_bests())
			{
				$data['personal_bests'] = $query;
			}

			echo '<h4>Personal Bests:</h4>';

			echo '<ul>';

				foreach ($data['personal_bests'] as $row) {

					$implement = ( $row->implement ) ? '('.ltrim($row->implement, 0).')' : ''; // format implement
					$performance = ( $row->time ) ? ltrim($row->time, 0) : ltrim($row->distHeight, 0); // format performance

					echo '<li>' . $row->eventName . ' '. $implement . ' ' . $performance . '</li>';
				}

			echo '</ul>';



			// Display athlete (Multis) personal bests ...
			if($query = $this->profiles_model->personal_bests_multis())
			{
				$data['personal_bests_multis'] = $query;
			}

			echo '<ul>';

				foreach ($data['personal_bests_multis'] as $row) {

					echo '<li>' . $row->eventName . ' - '. $row->points . '</li>';
				}

			echo '</ul>';



			// New Zealand Representation ...
			$rep = get_representations($this->input->post('athleteID'));
			if( $rep ) {
				echo '<h4>NZ Representation:</h4>';
			}

			echo '<ul>';

				foreach ($rep as $row) {
					//echo '<li>' . $row->year . ' ' . $row->competition . '</br>' . $row->eventName . ' ' . $row->position . '</li>';
					echo '<li>' . $row->year . ' ' . $row->competition . ' - ' . $row->eventName . '</li>';
				}

			echo '</ul>';

			//echo anchor('#', 'Full Profile', array('class'=>'btn btn-red center-block'));
			echo anchor('site/profiles_con/athlete/' . $this->input->post('athleteID'), 'View Full Profile', array('class'=>'flyout-btn-full'));

		echo '</div>';
		
	}




	/*************************************************************************************/
	// FUNCTION athlete()
	// Gets information about the athlete
	// i.e., Name, club, centre etc
	/*************************************************************************************/
	public function athlete()
	{
		$data['token'] = $this->auth->token();

			// WHAT IS THIS?
			// If user does NOT include the FULL 'auto populate' value (i.e., GILL, Jacko 527325) -> throw an error!
			// It STOPS searches like 'GILL' without passing the athleteID number
			// But ALLOWS clicking the 'athlete name' ( $this->uri->segment(4) ) link in the lists to get to their profile page
			if( ! $this->uri->segment(4) )
			{
				if( $this->input->post('athleteID') && ! is_numeric( substr($this->input->post('athleteID'), -6) ) || $this->input->post('athleteID') =='' )
				{
					$this->session->set_flashdata('bad_search', 'Search must include athleteID');
					redirect('');
				}
			}
			

		$data['athlete'] = athlete(); // see profiles_helper
		
		// 1) Get ALL events athlete has results against
		// Required to populate dropdown menu of their events
		$data['get_athlete_events'] = get_athlete_events(); // see profiles_helper
		
		// 2) Get the athletes Personal Best Perfomances (Individual) events
		if($query = $this->profiles_model->personal_bests())
		{
			$data['personal_bests'] = $query;
		}
		
		// 3) Get the athletes Personal Best Perfomances (Multi) events
		if($query = $this->profiles_model->personal_bests_multis())
		{
			$data['personal_bests_multis'] = $query;
		}
		
		$data['main_content'] = 'site/profiles';
		$this->load->view('site/includes/template', $data);
		
	} // ENDS athlete()
	
	
	/*************************************************************************************/
	// FUNCTION athlete_data()
	// Display athletes results data
	// i.e., Rank | Time | Wind | Competition | Venue | Date 
	/*************************************************************************************/
	public function athlete_data()
	{
		$this->form_validation->set_rules('token', 'Token', 'trim|required');
		$this->form_validation->set_rules('athleteID', 'Athlete ID', 'trim|required');
		$this->form_validation->set_rules('eventID', 'Select Event', 'trim|required');
		$this->form_validation->set_rules('year', 'Year', 'trim|required');
		$this->form_validation->set_rules('order_by', 'Order By', 'trim|required');
		
		// Create results $data array()
		$data = array(
			'athleteID' => $this->input->post('athleteID'),
			'eventID' => $this->input->post('eventID'),
			'year' => $this->input->post('year'),
			'order_by' => $this->input->post('order_by')
		);
				
		// If form post data validates and CSRF $token == session $token show lists
		if($this->form_validation->run() == TRUE /* && $this->input->post('token') == $this->session->userdata('token') */) 
		{
			// $data['token'] = $this->auth->token();
			$data['athlete'] = athlete(); // see profiles_helper
			
			// If an individual event use athlete_data()
			// If a multi-event use athlete_multi_data()
			if(in_array($this->input->post('eventID'), $this->config->item('multi_events')))
			{
				$data['athlete_multi_data'] = athlete_multi_data(); // see profiles_helper
				$data['event_info'] = getEvents();  // see global_helper
			}
			else
			{
				$data['athlete_data'] = athlete_data(); // see profiles_helper
				$data['event_info'] = getEvents(); // see global_helper
			}
			
			$data['token'] = $this->auth->token();
			$data['main_content'] = 'site/profiles';
			$this->load->view('site/includes/template', $data);
		}
		else
		{
			$this->error_message = validation_errors('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>');
			
			
			$data['athlete'] = athlete(); // see profiles_helper
			
			$data['token'] = $this->auth->token();
			$data['main_content'] = 'site/profiles';
			$this->load->view('site/includes/template', $data);
		}
		
		
		
	} // ENDS athlete_data()
	
	
	
	
} //ENDS Profiles_con class