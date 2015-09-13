<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Athlete_con extends CI_Controller
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
		$this->load->model('admin/athletes_model');
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
	// Displays the page (form) to add individual results
	/*************************************************************************************/
	public function index()
	{
		$data['token_admin'] = $this->auth->token_admin();
		$data['main_content'] = 'admin/add_athlete';
		$this->load->view('admin/includes/template', $data);
	
	} // ENDS index()
	
	
	
	/*************************************************************************************/
	// FUNCTION populate_athlete()
	// Retrieves athlete details from database to populate the 'edit' page
	/*************************************************************************************/
	public function populate_athlete()
	{
		// Query to retrieve result to populate 'edit' page
		if($query = $this->athletes_model->populate_athlete())
		{
			$data['pop_data'] = $query;
		}
		
		$data['token_admin'] = $this->auth->token_admin();
		$data['main_content'] = 'admin/edit_athlete';
		$this->load->view('admin/includes/template', $data);
	
	} // ENDS populate_results()
	
	
	
	/*************************************************************************************/
	// FUNCTION add_athlete()
	// Adds a new 'athlete' to the database
	/*************************************************************************************/
	public function add_athlete()
	{
		$this->form_validation->set_rules('token_admin', 'Token Admin', 'trim|required');
		$this->form_validation->set_rules('athleteID', 'Athlete ID', 'trim|required|exact_length[6]|is_unique[athletes.athleteID]');
		$this->form_validation->set_rules('nameFirst', 'First Name', 'trim|required');
		$this->form_validation->set_rules('nameLast', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('day', 'Day (DOB)', 'trim|required');
		$this->form_validation->set_rules('month', 'Month (DOB)', 'trim|required');
		$this->form_validation->set_rules('year', 'Year (DOB)', 'trim|required');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
		$this->form_validation->set_rules('centreID', 'Centre', 'trim|required');
		$this->form_validation->set_rules('clubID', 'Club', 'trim|required');
		$this->form_validation->set_rules('coach', 'Coach', 'trim');
		$this->form_validation->set_rules('coach_former', 'Former Coach', 'trim');
		
		// Create a session for the 'athleteID'
		// Why? .. so we can use the 'athleteID' value in the following
		// echo '<em title="' . $this->session->userdata('athleteID') . '"></em>';
		// Therefore we can use jQuery to 'delete' the new record if we want
		if($this->input->post('athleteID'))
		{
			$this->session->set_userdata('athleteID', $this->input->post('athleteID'));
		}
		
		
		/*****************************************************************************/
		// WHAT IS THE date?
		// Combine $day, $month and $year into variable '$date'
		/*****************************************************************************/
		$day 		= $this->input->post('day');
		$month 	= $this->input->post('month');
		$year 	= $this->input->post('year');
		$DOB 		= $year . '-' . $month . '-' . $day;
		
		
		/*****************************************************************************/
		// WHAT IS THE event?
		// The event is posted as an integer ($this->input->post('eventID'))
		// Match this integer with its corresponding 'eventName' using the getEvents() function
		/*****************************************************************************/
		$events = getEvents(); // From global helper
		
		foreach($events as $row):
		
			if($this->input->post('eventID') == $row->eventID)
			{
				$event = $row->eventName;
			}
			
		endforeach;
		
		
		/*****************************************************************************/
		// WHAT IS THE Centre?
		// The centre is posted as an integer ($this->input->post('centreID'))
		// Match this integer with its corresponding 'centreName' using the getCentre() function
		/*****************************************************************************/
		$centres = getCentres(); // From global helper
		
		foreach($centres as $row):
		
			if($this->input->post('centreID') == $row->centreID)
			{
				$centre = $row->centreName;
			}
			
		endforeach;
		
		
		/*****************************************************************************/
		// WHAT IS THE club?
		// The club is posted as an integer ($this->input->post('clubID'))
		// Match this integer with its corresponding 'clubName' using the getClub() function
		/*****************************************************************************/
		$clubs = getClubs(); // From global helper
		
		foreach($clubs as $row):
		
			if($this->input->post('clubID') == $row->clubID)
			{
				$club = $row->clubName;
			}
			
		endforeach;
		
		
		//Create results $data array()
		$data = array(
			'athleteID' => $this->input->post('athleteID'),
			'nameFirst' => $this->input->post('nameFirst'),
			'nameLast' => $this->input->post('nameLast'),
			'DOB' => $DOB,
			'gender' => $this->input->post('gender'),
			'centreID' => $this->input->post('centreID'),
			'clubID' => $this->input->post('clubID'),
			'coach' => $this->input->post('coach'),
			'coach_former' => $this->input->post('coach_former')
		);
		
		// If form post data validates and CSRF $token == session $token update result
		if($this->form_validation->run() == TRUE && $this->input->post('token_admin') == $this->session->userdata('token_admin')) 
		{
		// Insert new athlete
		$this->athletes_model->add_athlete($data);
		
			echo '<div class="well well-success">';
			echo $this->update_text_message = '<div class="message_success"><i class="fa fa-check"></i> New record added!<br /></div>';

		
			// Display confirmation of uploaded result to screen
			// Example: ADDED - ABBEY, Stevens (AKL / 10 Jul 1998) 505402 | Javelin Throw | MS | 01:31.26 | | 069.69 | | Hamilton Classic | out | Hamilton | 2012-01-6
			echo '<table class="table table-condensed table-bordered">';
				echo '<tr>';
					echo '<td>Athlete ID</td>';
					echo '<td>First Name</td>';
					echo '<td>Last Name</td>';
					echo '<td>DOB</td>';
					echo '<td>Gender</td>';
					echo '<td>Centre</td>';
					echo '<td>Club</td>';
					echo '<td>Coach</td>';
				echo '</tr>';
					echo '<tr>';
					echo '<td><div align="left">' . $data['athleteID'] . '</div></td>';
					echo '<td>' . $data['nameFirst'] . '</td>';
					echo '<td>' . $data['nameLast'] . '</td>';
					echo '<td>' . $data['DOB'] . '</td>';
					echo '<td>' . $data['gender'] . '</td>';
					echo '<td>' . $centre . '</td>';
					echo '<td>' . $club . '</td>';
					echo '<td>' . $data['coach'] . '</td>';
				echo '</tr>';
			echo '</table>';

		
			// Set up an attribute '<em>'
			// Why?
			// Because jQuery needs it to identify what the current resultID is
			// Then if admin wishes to delete the record - jQuery knows which one to delete
			// See this line in the results form page (var resultID = $("em").attr("title");)
			echo '<em title="' . $this->session->userdata('athleteID') . '"></em>';
			
	    	// Show 'Edit' button so admin can edit result if incorrectly input
			echo anchor('admin/athlete_con/populate_athlete/'.$this->db->insert_id().'', 'Edit Result', array('class'=>'btn btn-md btn-green marBot10'));
			echo '</div>';
			
		} 
		else 
		{
			echo '<div class="well well-error">';
			echo validation_errors('<div class="message_error"><i class="fa fa-times"></i> ', '</div>');
			echo '</div>';
		}
		
	} //ENDS add_athlete()
	
	
	
	
	/*************************************************************************************/
	// FUNCTION edit_athlete()
	// Edits an existing 'athletes' details to the database
	/*************************************************************************************/
	public function edit_athlete()
	{
		$this->form_validation->set_rules('token_admin', 'Token Admin', 'trim|required');
		$this->form_validation->set_rules('athleteID', 'Athlete ID', 'trim|required|exact_length[6]');
		$this->form_validation->set_rules('nameFirst', 'First Name', 'trim|required');
		$this->form_validation->set_rules('nameLast', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('day', 'Day (DOB)', 'trim|required');
		$this->form_validation->set_rules('month', 'Month (DOB)', 'trim|required');
		$this->form_validation->set_rules('year', 'Year (DOB)', 'trim|required');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
		$this->form_validation->set_rules('centreID', 'Centre', 'trim|required');
		$this->form_validation->set_rules('clubID', 'Club', 'trim|required');
		$this->form_validation->set_rules('coach', 'Coach', 'trim');
		$this->form_validation->set_rules('coach_former', 'Former Coach', 'trim');
		
				
		/*****************************************************************************/
		// WHAT IS THE date?
		// Combine $day, $month and $year into variable '$date'
		/*****************************************************************************/
		$day 		= $this->input->post('day');
		$month 	= $this->input->post('month');
		$year 	= $this->input->post('year');
		$DOB 		= $year . '-' . $month . '-' . $day;
		
		
		/*****************************************************************************/
		// WHAT IS THE event?
		// The event is posted as an integer ($this->input->post('eventID'))
		// Match this integer with its corresponding 'eventName' using the getEvents() function
		/*****************************************************************************/
		$events = getEvents(); // From global helper
		
		foreach($events as $row):
		
			if($this->input->post('eventID') == $row->eventID)
			{
				$event = $row->eventName;
			}
			
		endforeach;
		
		
		/*****************************************************************************/
		// WHAT IS THE Centre?
		// The centre is posted as an integer ($this->input->post('centreID'))
		// Match this integer with its corresponding 'centreName' using the getCentre() function
		/*****************************************************************************/
		$centres = getCentres(); // From global helper
		
		foreach($centres as $row):
		
			if($this->input->post('centreID') == $row->centreID)
			{
				$centre = $row->centreName;
			}
			
		endforeach;
		
		
		/*****************************************************************************/
		// WHAT IS THE club?
		// The club is posted as an integer ($this->input->post('clubID'))
		// Match this integer with its corresponding 'clubName' using the getClub() function
		/*****************************************************************************/
		$clubs = getClubs(); // From global helper
		
		foreach($clubs as $row):
		
			if($this->input->post('clubID') == $row->clubID)
			{
				$club = $row->clubName;
			}
			
		endforeach;
		
		
		//Create results $data array()
		$data = array(
			'athleteID' => $this->input->post('athleteID'),
			'nameFirst' => $this->input->post('nameFirst'),
			'nameLast' => $this->input->post('nameLast'),
			'DOB' => $DOB,
			'gender' => $this->input->post('gender'),
			'centreID' => $this->input->post('centreID'),
			'clubID' => $this->input->post('clubID'),
			'coach' => $this->input->post('coach'),
			'coach_former' => $this->input->post('coach_former')
		);
		
		// If form post data validates and CSRF $token == session $token update result
		if($this->form_validation->run() == TRUE && $this->input->post('token_admin') == $this->session->userdata('token_admin')) 
		{
			// Insert new athlete
			$this->athletes_model->edit_athlete($data);

			echo '<div class="well well-success">';
			echo $this->update_text_message = '<div class="message_success"><i class="fa fa-check"></i> Athlete Updated!</div>';
			
			// Display confirmation of uploaded result to screen
			// Example: ADDED - ABBEY, Stevens (AKL / 10 Jul 1998) 505402 | Javelin Throw | MS | 01:31.26 | | 069.69 | | Hamilton Classic | out | Hamilton | 2012-01-6
			echo '<table class="table table-condensed table-bordered">';
				echo '<tr>';
					echo '<td>Athlete ID</td>';
					echo '<td>First Name</td>';
					echo '<td>Last Name</td>';
					echo '<td>DOB</td>';
					echo '<td>Gender</td>';
					echo '<td>Centre</td>';
					echo '<td>Club</td>';
					echo '<td>Coach</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>' . $data['athleteID'] . '</td>';
					echo '<td>' . $data['nameFirst'] . '</td>';
					echo '<td>' . $data['nameLast'] . '</td>';
					echo '<td>' . $data['DOB'] . '</td>';
					echo '<td>' . $data['gender'] . '</td>';
					echo '<td>' . $centre . '</td>';
					echo '<td>' . $club . '</td>';
					echo '<td>' . $data['coach'] . '</td>';
				echo '</tr>';
			echo '</table>';

			echo '</div>';
			
		} 
		else 
		{
			echo '<div class="well well-error">';
			echo validation_errors('<div class="message_error"><i class="fa fa-times"></i> ', '</div>');
			echo '</div>';
		}
		
	} //ENDS edit_athlete()
	
	
	
	/*************************************************************************************/
	// FUNCTION delete_athlete()
	// Deletes a single result based on its 'athleteID'
	/*************************************************************************************/
	public function delete_athlete()
	{
		$this->form_validation->set_rules('athleteID', 'Athlete ID', 'trim');
		
		$data = $this->input->post('athleteID');
		
		if($this->form_validation->run() == TRUE) 
		{
			$this->athletes_model->delete_athlete($data);
			$this->session->unset_userdata('athleteID');

			echo '<div class="well well-error">';
			echo $this->update_text_message = '<span class="message_error">Athlete Deleted!</span>';
			echo '</div>';
		}
	
	} // ENDS delete_athlete()
	
	
	


} // ENDS class Athlete_con