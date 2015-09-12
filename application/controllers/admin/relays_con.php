<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Relays_con extends CI_Controller
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
		$this->load->model('admin/relays_model');
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
	// FUNCTION add_relays()
	// Displays the page (form) to add new records
	/*************************************************************************************/
	public function add_relays()
	{
		$data['token_admin'] = $this->auth->token_admin();
		$data['main_content'] = 'admin/add_relays';
		$this->load->view('admin/includes/template', $data);
	
	} // ENDS add_relays()
	
	
	
	/*************************************************************************************/
	// FUNCTION populate_relays()
	// Retrieves record details from database to populate the 'edit' page
	/*************************************************************************************/
	public function populate_relays()
	{
		// Query to retrieve ALL events
		if($query = $this->global_model->getEvents())
		{
			$data['events'] = $query;
		}
		
		// Query to retrieve result to populate 'edit' page
		if($query = $this->relays_model->populate_relays())
		{
			$data['pop_data'] = $query;
		}
		
		$data['token_admin'] = $this->auth->token_admin();
		$data['main_content'] = 'admin/edit_relays';
		$this->load->view('admin/includes/template', $data);
	
	} // ENDS populate_relays()
	
	
	
	/*************************************************************************************/
	// FUNCTION add_new_relay()
	// Adds a new record to the database
	/*************************************************************************************/
	public function add_new_relay()
	{
		$this->form_validation->set_rules('token_admin', 'Token Admin', 'trim|required');
		$this->form_validation->set_rules('eventID', 'Event', 'trim|required');
		$this->form_validation->set_rules('ageGroup', 'Age Group', 'trim|required');
		$this->form_validation->set_rules('time', 'Time', 'trim|required');
		$this->form_validation->set_rules('record', 'Record', 'trim');
		$this->form_validation->set_rules('placing', 'Placing', 'trim');
		$this->form_validation->set_rules('athlete01', 'Athlete 1', 'trim|required');
		$this->form_validation->set_rules('athlete02', 'Athlete 2', 'trim|required');
		$this->form_validation->set_rules('athlete03', 'Athlete 3', 'trim|required');
		$this->form_validation->set_rules('athlete04', 'Athlete 4', 'trim|required');
		$this->form_validation->set_rules('team', 'Team', 'trim|required');
		$this->form_validation->set_rules('competition', 'Competition', 'trim|required');
		$this->form_validation->set_rules('in_out', 'Indoors / Outdoors', 'trim|required');
		$this->form_validation->set_rules('venue', 'Venue', 'trim');
		$this->form_validation->set_rules('venue_other', 'Venue Other', 'trim');
		$this->form_validation->set_rules('date', 'Date', 'trim|required');
		
		// WHAT IS THE event?
		// The event is posted as an integer ($this->input->post('eventID'))
		// Match this integer with its corresponding 'eventName' using the getEvents() function
		
		// FOR OUTDOORS EVENTS
		// Run this to get the eventID and the event label
		$eventID = $this->input->post('eventID');
		
		if($this->input->post('eventID'))
		{
		$events = getEvents(); // From global helper
		
		foreach($events as $row):
		
			if($this->input->post('eventID') == $row->eventID)
			{
				$event = $row->eventName;
			}
			
		endforeach;
		}
		
		// WHAT IS THE venue?
		// If no default venue selection (from dropdown), use the manual entry from textbox
		$venue = '';
		if($this->input->post('venue') !='')
		{
			$venue = $this->input->post('venue');
		}
		else
		{
			$venue = $this->input->post('venue_other');
		}
		
		
		//Create results $data array()
		$data = array(
			'eventID' => $this->input->post('eventID'),
			'ageGroup' => $this->input->post('ageGroup'),
			'time' => $this->input->post('time'),
			'record' => $this->input->post('record'),
			'placing' => $this->input->post('placing'),
			'athlete01' => $this->input->post('athlete01'),
			'athlete02' => $this->input->post('athlete02'),
			'athlete03' => $this->input->post('athlete03'),
			'athlete04' => $this->input->post('athlete04'),
			'team' => $this->input->post('team'),
			'competition' => $this->input->post('competition'),
			'in_out' => $this->input->post('in_out'),
			'venue' => $venue,
			'date' => $this->input->post('date')
		);
		
		
		// If form post data validates and CSRF $token == session $token add new results
		if($this->form_validation->run() == TRUE && $this->input->post('token_admin') == $this->session->userdata('token_admin')) 
		{
			// Insert new results
			$this->relays_model->add_new_relay($data);
			
			echo '<div class="well well-success">';
			echo $this->update_text_message = '<div class="message_success"><i class="fa fa-check"></i> New record added!<br /></div>';

			
			// Display confirmation of uploaded result to screen
			// Example: ADDED - ABBEY, Stevens (AKL / 10 Jul 1998) 505402 | Javelin Throw | MS | 01:31.26 | | 069.69 | | Hamilton Classic | out | Hamilton | 2012-01-6
			echo '<table class="table table-condensed table-bordered">';
				echo '<tr>';
					echo '<td>Event</td>';
					echo '<td>Age Group</td>';
					echo '<td>Time</td>';
					echo '<td>Record</td>';
					echo '<td>Placing</td>';
					echo '<td>Athletes</td>';
					echo '<td>Team</td>';
					echo '<td>Competition</td>';
					echo '<td>In/Out</td>';
					echo '<td>Venue</td>';
					echo '<td>Date</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>' . $event . '</td>';
					echo '<td>' . $data['ageGroup'] . '</td>';
					echo '<td>' . $data['time'] . '</td>';
					echo '<td>' . $data['record'] . '</td>';
					echo '<td>' . $data['placing'] . '</td>';
					echo '<td>' . $data['athlete01'] . ', ' . $data['athlete02'] . ', ' . $data['athlete03'] . ', ' . $data['athlete04'] . '</td>';
					echo '<td>' . $data['team'] . '</td>';
					echo '<td>' . $data['competition'] . '</td>';
					echo '<td>' . $data['in_out'] . '</td>';
					echo '<td>' . $data['venue'] . '</td>';
					echo '<td>' . $data['date'] . '</td>';
				echo '</tr>';
			echo '</table>';
		
		// Set up an attribute '<em>'
		// Why?
		// Because jQuery needs it to identify what the current recordID is
		// Then if admin wishes to delete the record - jQuery knows which one to delete
		// See this line in the records form page ( var recordID = $("em").attr("title"); )
		echo '<em title="' . $this->db->insert_id() . '"></em>';

		// Show 'Edit' button so admin can edit result if incorrectly input		
		echo anchor('admin/relays_con/populate_relays/'.$this->db->insert_id().'', 'Edit Result', array('class'=>'btn btn-md btn-red marBot10'));
		echo '</div>';
		
		} 
		else 
		{
			echo '<div class="well well-error">';
			echo validation_errors('<div class="message_error"><i class="fa fa-times"></i> ', '</div>');
			echo '</div>';
		}
		
	} //ENDS add_new_relay()
	
	
	
	/*************************************************************************************/
	// FUNCTION edit_relay()
	// Adds a new record to the database
	/*************************************************************************************/
	public function edit_relay()
	{
		$this->form_validation->set_rules('token_admin', 'Token Admin', 'trim|required');
		$this->form_validation->set_rules('resultID', 'Result ID', 'trim|required');
		$this->form_validation->set_rules('eventID', 'Event', 'trim|required');
		$this->form_validation->set_rules('ageGroup', 'Age Group', 'trim|required');
		$this->form_validation->set_rules('time', 'Time', 'trim|required');
		$this->form_validation->set_rules('record', 'Record', 'trim');
		$this->form_validation->set_rules('placing', 'Placing', 'trim');
		$this->form_validation->set_rules('athlete01', 'Athlete 1', 'trim|required');
		$this->form_validation->set_rules('athlete02', 'Athlete 2', 'trim|required');
		$this->form_validation->set_rules('athlete03', 'Athlete 3', 'trim|required');
		$this->form_validation->set_rules('athlete04', 'Athlete 4', 'trim|required');
		$this->form_validation->set_rules('team', 'Team', 'trim|required');
		$this->form_validation->set_rules('competition', 'Competition', 'trim|required');
		$this->form_validation->set_rules('in_out', 'Indoors / Outdoors', 'trim|required');
		$this->form_validation->set_rules('venue', 'Venue', 'trim');
		$this->form_validation->set_rules('venue_other', 'Venue Other', 'trim');
		$this->form_validation->set_rules('day', 'Date (Day)', 'trim|required');
		$this->form_validation->set_rules('month', 'Date (Month)', 'trim|required');
		$this->form_validation->set_rules('year', 'Date (Year)', 'trim|required');
		
		// WHAT IS THE date?
		// Combine $day, $month and $year into variable '$date'
		$day 		= $this->input->post('day');
		$month 	= $this->input->post('month');
		$year 	= $this->input->post('year');
		$date 	= $year . '-' . $month . '-' .$day;
		
		// WHAT IS THE event?
		// The event is posted as an integer ($this->input->post('eventID'))
		// Match this integer with its corresponding 'eventName' using the getEvents() function
		
		// FOR OUTDOORS EVENTS
		// Run this to get the eventID and the event label
		$eventID = $this->input->post('eventID');
		
		if($this->input->post('eventID'))
		{
		$events = getEvents(); // From global helper
		
		foreach($events as $row):
		
			if($this->input->post('eventID') == $row->eventID)
			{
				$event = $row->eventName;
			}
			
		endforeach;
		}
		
		// WHAT IS THE venue?
		// If no default venue selection (from dropdown), use the manual entry from textbox
		$venue = '';
		if($this->input->post('venue_other'))
		{
			$venue = $this->input->post('venue_other');
		}
		else
		{
			$venue = $this->input->post('venue');
		}
		
		
		
		
		//Create results $data array()
		$data = array(
			'resultID' => $this->input->post('resultID'),
			'eventID' => $this->input->post('eventID'),
			'ageGroup' => $this->input->post('ageGroup'),
			'time' => $this->input->post('time'),
			'record' => $this->input->post('record'),
			'placing' => $this->input->post('placing'),
			'athlete01' => $this->input->post('athlete01'),
			'athlete02' => $this->input->post('athlete02'),
			'athlete03' => $this->input->post('athlete03'),
			'athlete04' => $this->input->post('athlete04'),
			'team' => $this->input->post('team'),
			'competition' => $this->input->post('competition'),
			'in_out' => $this->input->post('in_out'),
			'venue' => $venue,
			'date' => $date
		);
		
		
		// If form post data validates and CSRF $token == session $token add new results
		if($this->form_validation->run() == TRUE && $this->input->post('token_admin') == $this->session->userdata('token_admin')) 
		{
			// Insert new results
			$this->relays_model->update_relay($data);
			
			echo $this->update_text_message = '<span class="message_success">Relay updated added!</span>';
			
			// Display confirmation of uploaded result to screen
			// Example: ADDED - ABBEY, Stevens (AKL / 10 Jul 1998) 505402 | Javelin Throw | MS | 01:31.26 | | 069.69 | | Hamilton Classic | out | Hamilton | 2012-01-6
      echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:1.1em;">';
      echo '<tr style="font-weight:700; text-align:right;">';
        echo '<td><div align="left">Event</div></td>';
        echo '<td>Age Group</td>';
				echo '<td>Time</td>';
        echo '<td>Record</td>';
        echo '<td>Placing</td>';
        echo '<td>Athletes</td>';
        echo '<td>Team</td>';
				echo '<td>Competition</td>';
        echo '<td>In/Out</td>';
				echo '<td>Venue</td>';
				echo '<td>Date</td>';
      echo '</tr>';
      echo '<tr style="text-align:right;">';
        echo '<td><div align="left">' . $event . '</div></td>';
        echo '<td>' . $data['ageGroup'] . '</td>';
				echo '<td>' . $data['time'] . '</td>';
				echo '<td>' . $data['record'] . '</td>';
        echo '<td>' . $data['placing'] . '</td>';
        echo '<td>' . $data['athlete01'] . ', ' . $data['athlete02'] . ', ' . $data['athlete03'] . ', ' . $data['athlete04'] . '</td>';
        echo '<td>' . $data['team'] . '</td>';
        echo '<td>' . $data['competition'] . '</td>';
        echo '<td>' . $data['in_out'] . '</td>';
				echo '<td>' . $data['venue'] . '</td>';
				echo '<td>' . $date . '</td>';
      echo '</tr>';
    echo '</table>';
		
		// Set up an attribute '<em>'
		// Why?
		// Because jQuery needs it to identify what the current recordID is
		// Then if admin wishes to delete the record - jQuery knows which one to delete
		// See this line in the records form page ( var recordID = $("em").attr("title"); )
		echo '<em title="' . $this->db->insert_id() . '"></em>';
		
    echo '<div class="dotted"></div>';  
		} 
		else 
		{
			echo validation_errors('<div class="message_error">', '</div>') . '<br />';
		}
		
	} //ENDS edit_relay()
	
	
	
	
	/*************************************************************************************/
	// FUNCTION delete_relay()
	// Deletes a single record based on its 'resultID'
	/*************************************************************************************/
	public function delete_relay()
	{
		$this->form_validation->set_rules('resultID', 'Result ID', 'trim|required');
		
		$data = $this->input->post('resultID');
		
		if($this->form_validation->run() == TRUE) 
		{
			$this->relays_model->delete_relay($data);
			echo $this->update_text_message = '<span class="message_success">Relay Deleted!</span>';
		
		}
	
	} // ENDS delete_relay()
	

	


} // ENDS class Results_con