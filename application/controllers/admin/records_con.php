<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Records_con extends CI_Controller
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
		$this->load->model('admin/records_model');
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
	// FUNCTION add_records()
	// Displays the page (form) to add new records
	/*************************************************************************************/
	public function add_records()
	{
		$data['token_admin'] = $this->auth->token_admin();
		$data['main_content'] = 'admin/add_records';
		$this->load->view('admin/includes/template', $data);
	
	} // ENDS add_records()
	
	
	
	/*************************************************************************************/
	// FUNCTION populate_records()
	// Retrieves record details from database to populate the 'edit' page
	/*************************************************************************************/
	public function populate_records()
	{
		// Query to retrieve ALL events
		if($query = $this->global_model->getEvents())
		{
			$data['events'] = $query;
		}
		
		// Query to retrieve result to populate 'edit' page
		if($query = $this->records_model->populate_records())
		{
			$data['pop_data'] = $query;
		}
		
		$data['token_admin'] = $this->auth->token_admin();
		$data['main_content'] = 'admin/edit_records';
		$this->load->view('admin/includes/template', $data);
	
	} // ENDS populate_records()
	
	
	
	/*************************************************************************************/
	// FUNCTION add_new_record()
	// Adds a new record to the database
	/*************************************************************************************/
	public function add_new_record()
	{
		$this->form_validation->set_rules('token_admin', 'Token Admin', 'trim|required');
		$this->form_validation->set_rules('recordType', 'Record Type', 'trim|required');
		$this->form_validation->set_rules('ageGroup', 'Age Group', 'trim|required');
		$this->form_validation->set_rules('in_out', 'Indoors / Outdoors', 'trim|required');
		$this->form_validation->set_rules('eventID', 'Event', 'trim');
		$this->form_validation->set_rules('indoorEventID', 'Event', 'trim');
		$this->form_validation->set_rules('result', 'Result', 'trim|required');
		$this->form_validation->set_rules('nameFirst', 'First Name', 'trim|required');
		$this->form_validation->set_rules('nameLast', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('country', 'Country', 'trim|required');
		$this->form_validation->set_rules('venue', 'Venue', 'trim|required');
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
		
		
		if($this->input->post('eventID'))
		{
			$eventID = $this->input->post('eventID');
			
			$events = getEvents(); // From global helper
			
			foreach($events as $row):
			
				if($this->input->post('eventID') == $row->eventID)
				{
					$event = $row->eventName;
				}
				
			endforeach;
		}
		
		
		// FOR OUTDOORS EVENTS
		// Run this to get the eventID and the event label
		
		
		if($this->input->post('indoorEventID'))
		{
			$eventID = $this->input->post('indoorEventID');
				
			$events = getIndoorEvents(); // From global helper
			
			foreach($events as $row):
			
				if($this->input->post('indoorEventID') == $row->eventID)
				{
					$event = $row->eventName;
				}
				
			endforeach;
		}


		

		// WHAT IS THE $event?'
		// Run the posted $eventID through the convertEventID() function to return the 'event name'
		$events = convertEventID(); // From global helper
		$config_item = str_replace(' ','_', $events->eventName);

		// WHAT IS THE implement?
		// Find out if the eventID is an implement affected event
		// Then assign an appropriate implement tag to it
		$implement = '';
		
		if( in_array( $this->input->post('eventID'), $this->config->item('seperate_performances') ) )
		{

			foreach($this->config->item( $config_item ) as $key => $value): // Get $config_item from above
			
				if($this->input->post( 'ageGroup' ) == $key)
				{
					$implement = $value;
				}

			endforeach;
		}
		
		
		//Create results $data array()
		$data = array(
			'in_out' => $this->input->post('in_out'),
			'eventID' => $eventID,
			'ageGroup' => $this->input->post('ageGroup'),
			'result' => $this->input->post('result'),
			'implement' => $implement,
			'recordType' => $this->input->post('recordType'),
			'nameFirst' => $this->input->post('nameFirst'),
			'nameLast' => $this->input->post('nameLast'),
			'country' => $this->input->post('country'),
			'venue' => $this->input->post('venue'),
			'date' => $date
		);
		
		// If form post data validates and CSRF $token == session $token add new results
		if($this->form_validation->run() == TRUE && $this->input->post('token_admin') == $this->session->userdata('token_admin')) 
		{
			// Insert new results
			$this->records_model->add_new_record($data);
			
			echo $this->update_text_message = '<span class="message_success">New record added!</span>';
			
			// Display confirmation of uploaded result to screen
			// Example: ADDED - ABBEY, Stevens (AKL / 10 Jul 1998) 505402 | Javelin Throw | MS | 01:31.26 | | 069.69 | | Hamilton Classic | out | Hamilton | 2012-01-6
      echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:1.1em;">';
      echo '<tr style="font-weight:700; text-align:right;">';
        echo '<td><div align="left">Indoors / Outdoors</div></td>';
        echo '<td>Record Type</td>';
				echo '<td>Age Group</td>';
        echo '<td>Event</td>';
        echo '<td>Result</td>';
        echo '<td>Athlete</td>';
        echo '<td>Country</td>';
				echo '<td>Venue</td>';
        echo '<td>Date</td>';
      echo '</tr>';
      echo '<tr style="text-align:right;">';
        echo '<td><div align="left">' . $data['in_out'] . '</div></td>';
        echo '<td>' . $data['recordType'] . '</td>';
				echo '<td>' . $data['ageGroup'] . '</td>';
        echo '<td>' . $event . '</td>';
        echo '<td>' . $data['result'] . '</td>';
        echo '<td>' . $data['nameFirst'] . ' ' . $data['nameLast'] . '</td>';
        echo '<td>' . $data['country'] . '</td>';
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
		
	} //ENDS add_new_record()
	
	
	
	/*************************************************************************************/
	// FUNCTION update_record()
	// Updates a record to the database
	/*************************************************************************************/
	public function update_record()
	{
		$this->form_validation->set_rules('token_admin', 'Token Admin', 'trim|required');
		$this->form_validation->set_rules('recordID', 'Record ID', 'trim|required');
		$this->form_validation->set_rules('recordType', 'Record Type', 'trim|required');
		$this->form_validation->set_rules('ageGroup', 'Age Group', 'trim|required');
		$this->form_validation->set_rules('eventID', 'Event', 'trim|required');
		$this->form_validation->set_rules('result', 'Result', 'trim|required');
		$this->form_validation->set_rules('nameFirst', 'First Name', 'trim|required');
		$this->form_validation->set_rules('nameLast', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('country', 'Country', 'trim|required');
		$this->form_validation->set_rules('venue', 'Venue', 'trim|required');
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
		$events = getEvents(); // From global helper
		
		foreach($events as $row):
		
			if($this->input->post('eventID') == $row->eventID)
			{
				$event = $row->eventName;
				// Get the appropriate $this->config->item(xxxxx) in anz_settings.php
				// to use in the WHAT IS THE implement section below
				$config_item = str_replace(' ','_', $row->eventName);
			}
			
		endforeach;


		// WHAT IS THE $event?'
		// Run the posted $eventID through the convertEventID() function to return the 'event name'
		$events = convertEventID(); // From global helper
		$config_item = str_replace(' ','_', $events->eventName);

		// WHAT IS THE implement?
		// Find out if the eventID is an implement affected event
		// Then assign an appropriate implement tag to it
		$implement = '';
		
		if( in_array( $this->input->post('eventID'), $this->config->item('seperate_performances') ) )
		{

			foreach($this->config->item( $config_item ) as $key => $value): // Get $config_item from above
			
				if($this->input->post( 'ageGroup' ) == $key)
				{
					$implement = $value;
				}

			endforeach;
		}

		
		//Create results $data array()
		$data = array(
			'recordID' => $this->input->post('recordID'),
			'eventID' => $this->input->post('eventID'),
			'ageGroup' => $this->input->post('ageGroup'),
			'result' => $this->input->post('result'),
			'implement' => $implement,
			'recordType' => $this->input->post('recordType'),
			'nameFirst' => $this->input->post('nameFirst'),
			'nameLast' => $this->input->post('nameLast'),
			'country' => $this->input->post('country'),
			'venue' => $this->input->post('venue'),
			'date' => $date
		);
		
		// If form post data validates and CSRF $token == session $token add new results
		if($this->form_validation->run() == TRUE && $this->input->post('token_admin') == $this->session->userdata('token_admin')) 
		{
			// Insert new results
			$this->records_model->update_record($data);
			
			echo $this->update_text_message = '<span class="message_success">Record updated!</span>';
			
			// Display confirmation of uploaded result to screen
			// Example: ADDED - ABBEY, Stevens (AKL / 10 Jul 1998) 505402 | Javelin Throw | MS | 01:31.26 | | 069.69 | | Hamilton Classic | out | Hamilton | 2012-01-6
      echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:1.1em;">';
      echo '<tr style="font-weight:700; text-align:right;">';
        echo '<td><div align="left">Record Type</div></td>';
        echo '<td>Age Group</td>';
        echo '<td>Event</td>';
        echo '<td>Result</td>';
        echo '<td>Athlete</td>';
        echo '<td>Country</td>';
				echo '<td>Venue</td>';
        echo '<td>Date</td>';
      echo '</tr>';
      echo '<tr style="text-align:right;">';
        echo '<td><div align="left">' . $data['recordType'] . '</div></td>';
        echo '<td>' . $data['ageGroup'] . '</td>';
        echo '<td>' . $event . '</td>';
        echo '<td>' . $data['result'] . '</td>';
        echo '<td>' . $data['nameFirst'] . ' ' . $data['nameLast'] . '</td>';
        echo '<td>' . $data['country'] . '</td>';
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
		
	} //ENDS update_record()
	
	
	
	/*************************************************************************************/
	// FUNCTION delete_record()
	// Deletes a single record based on its 'resultID'
	/*************************************************************************************/
	public function delete_record()
	{
		$this->form_validation->set_rules('recordID', 'Record ID', 'trim|required');
		
		$data = $this->input->post('recordID');
		
		if($this->form_validation->run() == TRUE) 
		{
			$this->records_model->delete_record($data);
			echo $this->update_text_message = '<span class="message_success">Record Deleted!</span>';
		
		}
	
	} // ENDS delete_record()
	

	


} // ENDS class Results_con