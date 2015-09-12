<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Results_con extends CI_Controller
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
	// FUNCTION add_results()
	// Displays the page (form) to add individual results
	/*************************************************************************************/
	public function add_results()
	{
		$data['token_admin'] = $this->auth->token_admin();
		$data['main_content'] = 'admin/add_results';
		$this->load->view('admin/includes/template', $data);
	
	} // ENDS add_results()
	
	
	
	/*************************************************************************************/
	// FUNCTION populate_results()
	// Retrieves result details from database to populate the 'edit' page
	/*************************************************************************************/
	public function populate_results()
	{
		// Query to retrieve ALL events
		if($query = $this->global_model->getEvents())
		{
			$data['events'] = $query;
		}
		
		// Query to retrieve result to populate 'edit' page
		if($query = $this->results_model->populate_results())
		{
			$data['pop_data'] = $query;
		}
		
		$data['token_admin'] = $this->auth->token_admin();
		$data['main_content'] = 'admin/edit_results';
		$this->load->view('admin/includes/template', $data);
	
	} // ENDS populate_results()
	
	
	
	/*************************************************************************************/
	// FUNCTION add_result_ind()
	// Adds a new individual result to the database
	// or
	// Edits an existing result
	/*************************************************************************************/
	public function add_result_ind()
	{
		$this->form_validation->set_rules('token_admin', 'Token Admin', 'trim|required');
		$this->form_validation->set_rules('athleteID', 'Athlete', 'trim|required');
		$this->form_validation->set_rules('eventID', 'Event', 'trim|required');
		$this->form_validation->set_rules('ageGroup', 'Age Group', 'trim|required');
		$this->form_validation->set_rules('time', 'Time', 'trim');
		$this->form_validation->set_rules('wind', 'Wind', 'trim');
		$this->form_validation->set_rules('distHeight', 'Distance / Height', 'trim');
		$this->form_validation->set_rules('record', 'Record', 'trim');
		$this->form_validation->set_rules('placing', 'Placing', 'trim');
		$this->form_validation->set_rules('competition', 'Competition', 'trim');
		$this->form_validation->set_rules('in_out', 'Indoors / Outdoors', 'trim|required');
		$this->form_validation->set_rules('venue', 'Venue', 'trim');
		$this->form_validation->set_rules('venue_other', 'Venue Other', 'trim');
		$this->form_validation->set_rules('date', 'Date', 'trim|required');
		
		// WHAT IS THE athleteID? 
		// (the last 6 digits of the '$this->input->post('athleteID')' string)
		$athleteID = substr($this->input->post('athleteID'), -6);
		
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
		
		// WHAT IS THE time
		//Adds leading zeros to time (i.e., 10.87 = 00010.87)
		$time = '';
		if($this->input->post('time'))
		{
			$time = sprintf("%08.10s", $this->input->post('time')); 
		}
		
		// WHAT IS THE distHeight
		//Adds a leading zero to distHeight (i.e., 75.55 = 075.55)
		$distHeight = '';
		if($this->input->post('distHeight'))
		{
			$distHeight = sprintf("%06.10s", $this->input->post('distHeight')); 
		}
		
		// WHAT IS THE centreID? 
		// (the centreID digits of the '$this->input->post('athleteID')' string)
		// e.g., BRAND, Daryl (06 Aug 1963) 'AKL' 527403 = (AKL)
		$centreID = substr($this->input->post('athleteID'), -10, 3);
		
		// WHAT IS THE implement?
		// Find out if the eventID is an implement affected event
		// Then assign an appropriate implement tag to it
		$implement = '';
		
		if(in_array($this->input->post('eventID'), $this->config->item('seperate_performances')))
		{
			foreach($this->config->item($config_item) as $key => $value): // Get $config_item from above
			
				if($this->input->post('ageGroup') == $key)
				{
					$implement = $value;
				}
				
			endforeach;
		}

	
		//Create results $data array()
		$data = array(
			'athleteID' => $athleteID,
			'eventID' => $this->input->post('eventID'),
			'ageGroup' => $this->input->post('ageGroup'),
			'time' => $time,
			'wind' => $this->input->post('wind'),
			'distHeight' => $distHeight,
			'implement' => $implement,
			'record' => $this->input->post('record'),
			'centreID' => $centreID,
			'placing' => $this->input->post('placing'),
			'competition' => $this->input->post('competition'),
			'in_out' => $this->input->post('in_out'),
			'venue' => $venue,
			'date' => $this->input->post('date')
		);

		
		// If form post data validates and CSRF $token == session $token add new results
		if($this->form_validation->run() == TRUE && $this->input->post('token_admin') == $this->session->userdata('token_admin')) 
		{
			// Insert new results
			$this->results_model->add_result_ind($data);
			
			echo '<div class="well well-success">';
			echo $this->update_text_message = '<div class="message_success"><i class="fa fa-check"></i> New record added!<br /></div>';
			
			// Display confirmation of uploaded result to screen
			// Example: ADDED - ABBEY, Stevens (AKL / 10 Jul 1998) 505402 | Javelin Throw | MS | 01:31.26 | | 069.69 | | Hamilton Classic | out | Hamilton | 2012-01-6

			echo '<table class="table table-condensed table-bordered">';
				echo '<tr>';
					echo '<td>Athlete</td>';
					echo '<td>Event</td>';
					echo '<td>Age Group</td>';
					echo '<td>Time</td>';
					echo '<td>Wind</td>';
					echo '<td>Dist/Height</td>';
					echo '<td>Implement</td>';
					echo '<td>Record</td>';
					echo '<td>Centre</td>';
					echo '<td>Placing</td>';
					echo '<td>In/Out</td>';
					echo '<td>Venue</td>';
					echo '<td>Date</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>' . $this->input->post('athleteID') . '</td>';
					echo '<td>' . $event . '</td>';
					echo '<td>' . $data['ageGroup'] . '</td>';
					echo '<td>' . $data['time'] . '</td>';
					echo '<td>' . $data['wind'] . '</td>';
					echo '<td>' . $data['distHeight'] . '</td>';
					echo '<td>' . $implement . '</td>';
					echo '<td>' . $data['record'] . '</td>';
					echo '<td>' . $centreID . '</td>';
					echo '<td>' . $data['placing'] . '</td>';
					echo '<td>' . $data['in_out'] . '</td>';
					echo '<td>' . $data['venue'] . '</td>';
					echo '<td>' . $data['date'] . '</td>';
				echo '</tr>';
			echo '</table>';


			// Set up an attribute '<em>'
			// Why?
			// Because jQuery needs it to identify what the current 'resultID' is
			// Then if admin wishes to delete the record - jQuery knows which one to delete
			// See this line in the results form page (var resultID = $("em").attr("title");)
			echo '<em title="' . $this->db->insert_id() . '"></em>';

			// Show 'Edit' button so admin can edit result if incorrectly input
			echo anchor('admin/results_con/populate_results/'.$this->db->insert_id().'', 'Edit Result', array('class'=>'btn btn-md btn-red marBot10'));
			echo '</div>';

		} 
		else 
		{
			echo '<div class="well well-error">';
			echo validation_errors('<div class="message_error"><i class="fa fa-times"></i> ', '</div>');
			echo '</div>';
		}
		
	} //ENDS add_result_ind()
	
	
	
	/*************************************************************************************/
	// FUNCTION update_result_ind()
	// Adds a new individual result to the database
	// or
	// Edits an existing result
	/*************************************************************************************/
	public function update_result_ind()
	{
		$this->form_validation->set_rules('token_admin', 'Token Admin', 'trim|required');
		$this->form_validation->set_rules('resultID', 'Result ID', 'trim|required');
		$this->form_validation->set_rules('athleteID', 'Athlete', 'trim|required');
		$this->form_validation->set_rules('eventID', 'Event', 'trim|required');
		$this->form_validation->set_rules('ageGroup', 'Age Group', 'trim|required');
		$this->form_validation->set_rules('time', 'Time', 'trim');
		$this->form_validation->set_rules('wind', 'Wind', 'trim');
		$this->form_validation->set_rules('distHeight', 'Distance / Height', 'trim');
		$this->form_validation->set_rules('record', 'Record', 'trim');
		$this->form_validation->set_rules('placing', 'Placing', 'trim');
		$this->form_validation->set_rules('competition', 'Competition', 'trim');
		$this->form_validation->set_rules('in_out', 'Indoors / Outdoors', 'trim|required');
		$this->form_validation->set_rules('venue', 'Venue', 'trim');
		$this->form_validation->set_rules('venue_other', 'Venue Other', 'trim');
		$this->form_validation->set_rules('day', 'Date (Day)', 'trim|required');
		$this->form_validation->set_rules('month', 'Date (Month)', 'trim|required');
		$this->form_validation->set_rules('year', 'Date (Year)', 'trim|required');
		
		// WHAT IS THE athleteID?
		// If not changing the athlete use their existing athleteID
		// Otherwise we will need to grab the 'athleteID' portion of the $this->input->post('athleteID')
		if(strlen($this->input->post('athleteID')) >6)
		{
			// (the last 6 digits of the '$this->input->post('athleteID')' string)
			$athleteID = substr($this->input->post('athleteID'), -6);
		}
		else
		{
			$athleteID = $this->input->post('athleteID');
		}
		
		// WHAT IS THE date?
		// Combine $day, $month and $year into variable '$date'
		$day 	= $this->input->post('day');
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
		
		// WHAT IS THE venue?
		// If no default venue selection (from dropdown), use the manual entry from textbox
		$venue = '';
		if($this->input->post('venue_other') !='')
		{
			$venue = $this->input->post('venue_other');
		}
		else
		{
			$venue = $this->input->post('venue');
		}
		
		// WHAT IS THE time
		//Adds leading zeros to time (i.e., 10.87 = 00010.87)
		$time = '';
		if($this->input->post('time'))
		{
			$time = sprintf("%08.10s", $this->input->post('time')); 
		}
		
		// WHAT IS THE distHeight
		//Adds a leading zero to distHeight (i.e., 75.55 = 075.55)
		$distHeight = '';
		if($this->input->post('distHeight'))
		{
			$distHeight = sprintf("%06.10s", $this->input->post('distHeight')); 
		}
		
		// WHAT IS THE centreID? 
		// (the centreID digits of the '$this->input->post('athleteID')' string)
		// e.g., BRAND, Daryl (06 Aug 1963) 'AKL' 527403 = (AKL)
		$centreID = substr($this->input->post('athleteID'), -10, 3);
		
		// WHAT IS THE implement?
		// Find out if the eventID is an implement affected event
		// Then assign an appropriate implement tag to it
		$implement = '';
		
		if(in_array($this->input->post('eventID'), $this->config->item('seperate_performances')))
		{
			foreach($this->config->item($config_item) as $key => $value): // Get $config_item from above

				if($this->input->post('ageGroup') == $key)
				{
					$implement = $value;
				}

			endforeach;
		}
		
		
		//Create results $data array()
		$data = array(
			'resultID' => $this->input->post('resultID'),
			'athleteID' => $athleteID,
			'eventID' => $this->input->post('eventID'),
			'ageGroup' => $this->input->post('ageGroup'),
			'time' => $time,
			'wind' => $this->input->post('wind'),
			'distHeight' => $distHeight,
			'implement' => $implement,
			'record' => $this->input->post('record'),
			'centreID' => $centreID,
			'placing' => $this->input->post('placing'),
			'competition' => $this->input->post('competition'),
			'in_out' => $this->input->post('in_out'),
			'venue' => $venue,
			'date' => $date
		);
		
		
		// If form post data validates and CSRF $token == session $token update result
		if($this->form_validation->run() == TRUE && $this->input->post('token_admin') == $this->session->userdata('token_admin')) 
		{
			// Insert new results
			$this->results_model->update_result_ind($data);
			
			echo $this->update_text_message = '<span class="message_success">Record Updated!</span>';
			
			// Display confirmation of uploaded result to screen
			// Example: ADDED - ABBEY, Stevens (AKL / 10 Jul 1998) 505402 | Javelin Throw | MS | 01:31.26 | | 069.69 | | Hamilton Classic | out | Hamilton | 2012-01-6
			echo '<table class="table table-condensed table-bordered">';
				echo '<tr>';
					echo '<td>Athlete</td>';
					echo '<td>Event</td>';
					echo '<td>Age Group</td>';
					echo '<td>Time</td>';
					echo '<td>Wind</td>';
					echo '<td>Dist/Height</td>';
					echo '<td>Record</td>';
					echo '<td>Centre</td>';
					echo '<td>Placing</td>';
					echo '<td>In/Out</td>';
					echo '<td>Venue</td>';
					echo '<td>Date</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>' . $this->input->post('athleteID') . '</td>';
					echo '<td>' . $event . '</td>';
					echo '<td>' . $data['ageGroup'] . '</td>';
					echo '<td>' . $data['time'] . '</td>';
					echo '<td>' . $data['wind'] . '</td>';
					echo '<td>' . $data['distHeight'] . '</td>';
					echo '<td>' . $data['record'] . '</td>';
					echo '<td>' . $centreID . '</td>';
					echo '<td>' . $data['placing'] . '</td>';
					echo '<td>' . $data['in_out'] . '</td>';
					echo '<td>' . $data['venue'] . '</td>';
					echo '<td>' . $data['date'] . '</td>';
				echo '</tr>';
			echo '</table>';

			// Set up an attribute '<em>'
			// Why?
			// Because jQuery needs it to identify what the current resultID is
			// Then if admin wishes to delete the record - jQuery knows which one to delete
			// See this line in the results form page (var resultID = $("em").attr("title");)
			echo '<em title="' . $data['resultID'] . '"></em>';

			echo '<div class="dotted"></div>';  
		} 
		else 
		{
			echo validation_errors('<div class="message_error">', '</div>') . '<br />';
		}
		
	} //ENDS update_result_ind()
	
	
	
	/*************************************************************************************/
	// FUNCTION delete_results()
	// Deletes a single result based on its 'resultID'
	/*************************************************************************************/
	public function delete_results()
	{
		$this->form_validation->set_rules('resultID', 'Result ID', 'trim');
		
		$data = $this->input->post('resultID');
		
		if($this->form_validation->run() == TRUE) 
		{
			$this->results_model->delete_result_ind($data);
			echo $this->update_text_message = '<span class="message_success">Record Deleted!</span>';
		
		}
	
	} // ENDS delete_results()
	

	


} // ENDS class Results_con