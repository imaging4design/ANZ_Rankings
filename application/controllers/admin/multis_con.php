<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Multis_con extends CI_Controller
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
		$this->load->model('admin/multis_model');
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
	// FUNCTION add_multis()
	// Displays the page (form) to add multi results
	/*************************************************************************************/
	public function add_multis()
	{
		$data['token_admin'] = $this->auth->token_admin();
		$data['main_content'] = 'admin/add_multis';
		$this->load->view('admin/includes/template', $data);
	
	} // ENDS add_multis()
	
	
	
	/*************************************************************************************/
	// FUNCTION populate_results()
	// Retrieves result details from database to populate the 'edit' page
	/*************************************************************************************/
	public function populate_results()
	{
		// // Query to retrieve ALL events
		if($query = $this->global_model->getEvents())
		{
			$data['events'] = $query;
		}

		// Query to retrieve result to populate 'edit' page
		if($query = $this->multis_model->populate_results())
		{
			$data['pop_data'] = $query;
		}
		
		$data['token_admin'] = $this->auth->token_admin();
		$data['main_content'] = 'admin/edit_multis';
		$this->load->view('admin/includes/template', $data);
	
	} // ENDS populate_results()
	
	
	
	/*************************************************************************************/
	// FUNCTION add_result_multi()
	// Adds a new multi result to the database
	/*************************************************************************************/
	public function add_result_multi()
	{
		$this->form_validation->set_rules('token_admin', 'Token Admin', 'trim|required');
		$this->form_validation->set_rules('athleteID', 'Athlete', 'trim|required');
		$this->form_validation->set_rules('points', 'Points', 'trim');
		$this->form_validation->set_rules('wind', 'Wind', 'trim');
		$this->form_validation->set_rules('placing', 'Placing', 'trim');
		$this->form_validation->set_rules('record', 'Record', 'trim');
		
		$this->form_validation->set_rules('e01', 'Event One', 'trim|required');
		$this->form_validation->set_rules('e02', 'Event Two', 'trim|required');
		$this->form_validation->set_rules('e03', 'Event Three', 'trim|required');
		$this->form_validation->set_rules('e04', 'Event Four', 'trim|required');
		$this->form_validation->set_rules('e05', 'Event Five', 'trim|required');
		$this->form_validation->set_rules('e06', 'Event Six', 'trim|required');
		$this->form_validation->set_rules('e07', 'Event Seven', 'trim|required');
		$this->form_validation->set_rules('e08', 'Event Eight', 'trim');
		$this->form_validation->set_rules('e09', 'Event Nine', 'trim');
		$this->form_validation->set_rules('e10', 'Event Ten', 'trim');
		
		$this->form_validation->set_rules('eventID', 'Event', 'trim|required');
		$this->form_validation->set_rules('ageGroup', 'Age Group', 'trim|required');
		$this->form_validation->set_rules('competition', 'Competition', 'trim|required');
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
		
		// WHAT IS THE centreID? 
		// (the centreID digits of the '$this->input->post('athleteID')' string)
		// e.g., BRAND, Daryl (06 Aug 1963) 'AKL' 527403 = (AKL)
		$centreID = substr($this->input->post('athleteID'), -10, 3);
		
		
		//Create results $data array()
		$data = array(
			'eventID' => $this->input->post('eventID'),
			'athleteID' => $athleteID,
			'centreID' => $centreID,
			'ageGroup' => $this->input->post('ageGroup'),
			'points' => $this->input->post('points'),
			'placing' => $this->input->post('placing'),
			'wind' => $this->input->post('wind'),
			'record' => $this->input->post('record'),
			'e01' => $this->input->post('e01'),
			'e02' => $this->input->post('e02'),
			'e03' => $this->input->post('e03'),
			'e04' => $this->input->post('e04'),
			'e05' => $this->input->post('e05'),
			'e06' => $this->input->post('e06'),
			'e07' => $this->input->post('e07'),
			'e08' => $this->input->post('e08'),
			'e09' => $this->input->post('e09'),
			'e10' => $this->input->post('e10'),
			'competition' => $this->input->post('competition'),
			'venue' => $venue,
			'date' => $this->input->post('date')
		);
		
		// If form post data validates and CSRF $token == session $token show lists
		if($this->form_validation->run() == TRUE && $this->input->post('token_admin') == $this->session->userdata('token_admin')) 
		{
			$this->multis_model->add_result_multi($data);
			
			echo '<div class="well well-success">';
			echo $this->update_text_message = '<div class="message_success"><i class="fa fa-check"></i> New record added!<br /></div>';
			
			// Display confirmation of uploaded result to screen
			// Example: ADDED - ABBEY, Stevens (AKL / 10 Jul 1998) 505402 | Javelin Throw | MS | 01:31.26 | | 069.69 | | Hamilton Classic | out | Hamilton | 2012-01-6
			echo '<table class="table table-condensed table-bordered">';
				echo '<tr>';
					echo '<td>Athlete</td>';
					echo '<td>Event</td>';
					echo '<td>Age Group</td>';
					echo '<td>Points</td>';
					echo '<td>Placing</td>';
					echo '<td>Wind</td>';
					echo '<td>Record</td>';
					echo '<td>Centre</td>';
					echo '<td>Competition</td>';
					echo '<td>Venue</td>';
					echo '<td>Date</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>' . $this->input->post('athleteID') . '</td>';
					echo '<td>' . $event . '</td>';
					echo '<td>' . $data['ageGroup'] . '</td>';
					echo '<td>' . $data['points'] . '</td>';
					echo '<td>' . $data['placing'] . '</td>';
					echo '<td>' . $data['wind'] . '</td>';
					echo '<td>' . $data['record'] . '</td>';
					echo '<td>' . $centreID . '</td>';
					echo '<td>' . $data['competition'] . '</td>';
					echo '<td>' . $data['venue'] . '</td>';
					echo '<td>' . $data['date'] . '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td colspan="11">'.$data['e01'].' | '.$data['e02'].' | '.$data['e03'].' | '.$data['e04'].' | '.$data['e05'].' | '.$data['e06'].' | '.$data['e07'].' | '.$data['e08'].' | '.$data['e09'].' | '.$data['e10'].'</td>';
				echo '</tr>';
			echo '</table>';

			echo '<em title="' . $this->db->insert_id() . '"></em>';

			// Show 'Edit' button so admin can edit result if incorrectly input
			echo anchor('admin/multis_con/populate_results/'.$this->db->insert_id().'', 'Edit Result', array('class'=>'btn btn-md btn-green marBot10'));

			echo '</div>';  
		} 
		else 
		{
			echo '<div class="well well-error">';
			echo validation_errors('<div class="message_error">', '</div>');
			echo '</div>'; 
		}
		
	} //ENDS add_result_multi()
	
	
	
	/*************************************************************************************/
	// FUNCTION update_result_multi()
	// Updates a new multi result to the database
	/*************************************************************************************/
	public function update_result_multi()
	{
		$this->form_validation->set_rules('token_admin', 'Token Admin', 'trim|required');
		$this->form_validation->set_rules('resultID', 'Result ID', 'trim|required');
		$this->form_validation->set_rules('athleteID', 'Athlete', 'trim|required');
		$this->form_validation->set_rules('points', 'Points', 'trim');
		$this->form_validation->set_rules('wind', 'Wind', 'trim');
		$this->form_validation->set_rules('placing', 'Placing', 'trim');
		$this->form_validation->set_rules('record', 'Record', 'trim');
		
		$this->form_validation->set_rules('e01', 'Event One', 'trim|required');
		$this->form_validation->set_rules('e02', 'Event Two', 'trim|required');
		$this->form_validation->set_rules('e03', 'Event Three', 'trim|required');
		$this->form_validation->set_rules('e04', 'Event Four', 'trim|required');
		$this->form_validation->set_rules('e05', 'Event Five', 'trim|required');
		$this->form_validation->set_rules('e06', 'Event Six', 'trim|required');
		$this->form_validation->set_rules('e07', 'Event Seven', 'trim|required');
		$this->form_validation->set_rules('e08', 'Event Eight', 'trim');
		$this->form_validation->set_rules('e09', 'Event Nine', 'trim');
		$this->form_validation->set_rules('e10', 'Event Ten', 'trim');
		
		$this->form_validation->set_rules('eventID', 'Event', 'trim|required');
		$this->form_validation->set_rules('ageGroup', 'Age Group', 'trim|required');
		$this->form_validation->set_rules('competition', 'Competition', 'trim|required');
		$this->form_validation->set_rules('venue', 'Venue', 'trim');
		$this->form_validation->set_rules('venue_other', 'Venue Other', 'trim');
		$this->form_validation->set_rules('day', 'Date (Day)', 'trim|required');
		$this->form_validation->set_rules('month', 'Date (Month)', 'trim|required');
		$this->form_validation->set_rules('year', 'Date (Year)', 'trim|required');
		
		// WHAT IS THE athleteID? 
		// (the last 6 digits of the '$this->input->post('athleteID')' string)
		$athleteID = substr($this->input->post('athleteID'), -6);
		
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
		
		// WHAT IS THE centreID? 
		// (the centreID digits of the '$this->input->post('athleteID')' string)
		// e.g., BRAND, Daryl (06 Aug 1963) 'AKL' 527403 = (AKL)
		$centreID = substr($this->input->post('athleteID'), -10, 3);
		
		
		//Create results $data array()
		$data = array(
			'resultID' => $this->input->post('resultID'),
			'eventID' => $this->input->post('eventID'),
			'athleteID' => $athleteID,
			'centreID' => $centreID,
			'ageGroup' => $this->input->post('ageGroup'),
			'points' => $this->input->post('points'),
			'placing' => $this->input->post('placing'),
			'wind' => $this->input->post('wind'),
			'record' => $this->input->post('record'),
			'e01' => $this->input->post('e01'),
			'e02' => $this->input->post('e02'),
			'e03' => $this->input->post('e03'),
			'e04' => $this->input->post('e04'),
			'e05' => $this->input->post('e05'),
			'e06' => $this->input->post('e06'),
			'e07' => $this->input->post('e07'),
			'e08' => $this->input->post('e08'),
			'e09' => $this->input->post('e09'),
			'e10' => $this->input->post('e10'),
			'competition' => $this->input->post('competition'),
			'venue' => $venue,
			'date' => $date
		);
		
		// If form post data validates and CSRF $token == session $token show lists
		if($this->form_validation->run() == TRUE && $this->input->post('token_admin') == $this->session->userdata('token_admin')) 
		{
			$this->multis_model->update_result_multi($data);
			
			echo '<div class="well well-success">';
			echo $this->update_text_message = '<div class="message_success"><i class="fa fa-check"></i> Record Updated!</div>';
			
			// Display confirmation of uploaded result to screen
			// Example: ADDED - ABBEY, Stevens (AKL / 10 Jul 1998) 505402 | Javelin Throw | MS | 01:31.26 | | 069.69 | | Hamilton Classic | out | Hamilton | 2012-01-6
			echo '<table class="table table-condensed table-bordered">';
				echo '<tr>';
					echo '<td>Athlete</td>';
					echo '<td>Event</td>';
					echo '<td>Age Group</td>';
					echo '<td>Points</td>';
					echo '<td>Placing</td>';
					echo '<td>Wind</td>';
					echo '<td>Record</td>';
					echo '<td>Centre</td>';
					echo '<td>Competition</td>';
					echo '<td>Venue</td>';
					echo '<td>Date</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>' . $this->input->post('athleteID') . '</td>';
					echo '<td>' . $event . '</td>';
					echo '<td>' . $data['ageGroup'] . '</td>';
					echo '<td>' . $data['points'] . '</td>';
					echo '<td>' . $data['placing'] . '</td>';
					echo '<td>' . $data['wind'] . '</td>';
					echo '<td>' . $data['record'] . '</td>';
					echo '<td>' . $centreID . '</td>';
					echo '<td>' . $data['competition'] . '</td>';
					echo '<td>' . $data['venue'] . '</td>';
					echo '<td>' . $data['date'] . '</td>';
					echo '</tr>';
				echo '<tr>';
					echo '<td colspan="11">'.$data['e01'].' | '.$data['e02'].' | '.$data['e03'].' | '.$data['e04'].' | '.$data['e05'].' | '.$data['e06'].' | '.$data['e07'].' | '.$data['e08'].' | '.$data['e09'].' | '.$data['e10'].'</td>';
				echo '</tr>';
			echo '</table>';
		
			echo '<em title="' . $data['resultID'] . '"></em>';
		
   			echo '</div>'; 

		} 
		else 
		{
			echo '<div class="well well-error">';
			echo validation_errors('<div class="message_error"><i class="fa fa-times"></i> ', '</div>');
			echo '</div>';
		}
		
	} //ENDS update_result_multi()
	
	
	
	/*************************************************************************************/
	// FUNCTION delete_results()
	// Deletes a single result based on its 'resultID'
	/*************************************************************************************/
	public function delete_results_multi()
	{
		$this->form_validation->set_rules('resultID', 'Result ID', 'trim');
		
		$data = $this->input->post('resultID');
		
		if($this->form_validation->run() == TRUE) 
		{
			$this->multis_model->delete_result_multi($data);

			echo '<div class="well well-error">';
			echo $this->update_text_message = '<span class="message_error">Record Deleted!</span>';
			echo '</div>';
		
		}
	
	} // ENDS delete_results_multi()
	

	


} // ENDS class Multis_con