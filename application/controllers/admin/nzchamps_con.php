<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nzchamps_con extends CI_Controller
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
		$this->load->model('admin/nzchamps_model');
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
	// FUNCTION add_nzchamps()
	// Displays the page (form) to add a 'NEW' NZ Championships Medal Performance
	/*************************************************************************************/
	public function add_nzchamps()
	{
		
		$data['token_admin'] = $this->auth->token_admin();
		$data['main_content'] = 'admin/add_nzchamps';
		$this->load->view('admin/includes/template', $data);
	
	} // ENDS add_nzchamps()
	
	
	
	/*************************************************************************************/
	// FUNCTION populate_nzchamps()
	// Retrieves NZ Championships Medal details from database to populate the 'edit' page
	/*************************************************************************************/
	public function populate_nzchamps()
	{
		// Query to retrieve ALL events
		if($query = $this->global_model->getEvents())
		{
			$data['events'] = $query;
		}

		// Query to retrieve result to populate 'edit' page
		if( $query = $this->nzchamps_model->populate_nzchamps())
		{
			$data['pop_data'] = $query;
		}

		$data['token_admin'] = $this->auth->token_admin();
		$data['main_content'] = 'admin/edit_nzchamps';
		$this->load->view('admin/includes/template', $data);
	
	} // ENDS populate_nzchamps()
	
	
	
	/*************************************************************************************/
	// FUNCTION add_new_nzchamps()
	// Adds a new NZ Championships Medal Performance to the database
	/*************************************************************************************/
	public function add_new_nzchamps()
	{
		
		$this->form_validation->set_rules('token_admin', 'Token Admin', 'trim|required');
		$this->form_validation->set_rules('athleteID', 'Athlete ID', 'trim|required');
		$this->form_validation->set_rules('year', 'Year', 'trim|required');
		$this->form_validation->set_rules('eventID', 'Event', 'trim');
		$this->form_validation->set_rules('ageGroup', 'Age Group', 'trim|required');
		$this->form_validation->set_rules('performance', 'Performance', 'trim');
		$this->form_validation->set_rules('position', 'Position', 'trim|required');
		
		//Create results $data array()
		$data = array(
			'athleteID' => $this->input->post('athleteID'),
			'year' => $this->input->post('year'),
			'eventID' => $this->input->post('eventID'),
			'ageGroup' => $this->input->post('ageGroup'),
			'performance' => $this->input->post('performance'),
			'position' => $this->input->post('position')
		);

	
		// If form post data validates and CSRF $token == session $token add new results
		if($this->form_validation->run() == TRUE && $this->input->post('token_admin') == $this->session->userdata('token_admin')) 
		{
			// Insert new results
			$this->nzchamps_model->add_new_nzchamps($data);
			
			echo '<div class="well well-success">';
			echo $this->update_text_message = '<div class="message_success"><i class="fa fa-check"></i> New record added!<br /></div>';
			
			// Display confirmation of uploaded result to screen
			// Example: ADDED - ABBEY, Stevens (AKL / 10 Jul 1998) 505402 | Javelin Throw | MS | 01:31.26 | | 069.69 | | Hamilton Classic | out | Hamilton | 2012-01-6
			echo '<table class="table table-condensed table-bordered">';
				echo '<tr>';
					echo '<td>Year</td>';
					echo '<td>Event</td>';
					echo '<td>Age Group</td>';
					echo '<td>Performance</td>';
					echo '<td>Position</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>' . $data['year'] . '</td>';
					echo '<td>' . $data['eventID'] . '</td>';
					echo '<td>' . $data['ageGroup'] . '</td>';
					echo '<td>' . $data['performance'] . '</td>';
					echo '<td>' . $data['position'] . '</td>';
				echo '</tr>';
			echo '</table>';
		
			// Set up an attribute '<em>'
			// Why?
			// Because jQuery needs it to identify what the current recordID is
			// Then if admin wishes to delete the record - jQuery knows which one to delete
			// See this line in the records form page ( var recordID = $("em").attr("title"); )
			echo '<em title="' . $this->db->insert_id() . '"></em>';
		
    		// Show 'Edit' button so admin can edit result if incorrectly input
			echo anchor('admin/nzchamps_con/populate_nzchamps/'.$this->db->insert_id().'/'.$data['athleteID'].'', 'Edit Result', array('class'=>'btn btn-md btn-green marBot10'));
			echo '</div>';

		} 
		else 
		{
			echo '<div class="well well-error">';
			echo validation_errors('<div class="message_error"><i class="fa fa-times"></i> ', '</div>');
			echo '</div>';
		}
		
	} //ENDS add_new_nzchamps()
	
	
	
	/*************************************************************************************/
	// FUNCTION update_nzchamps()
	// Updates NZ Championship Medal performance to the database
	/*************************************************************************************/
	public function update_nzchamps()
	{
		$this->form_validation->set_rules('token_admin', 'Token Admin', 'trim|required');
		$this->form_validation->set_rules('repID', 'Rep ID', 'trim|required');
		$this->form_validation->set_rules('year', 'Year', 'trim|required');
		$this->form_validation->set_rules('eventID', 'Event', 'trim|required');
		$this->form_validation->set_rules('ageGroup', 'Age Group', 'trim|required');
		$this->form_validation->set_rules('performance', 'Performance', 'trim|required');
		$this->form_validation->set_rules('position', 'Position', 'trim|required');
		
		//Create results $data array()
		$data = array(
			'id' => $this->input->post('repID'),
			'year' => $this->input->post('year'),
			'eventID' => $this->input->post('eventID'),
			'ageGroup' => $this->input->post('ageGroup'),
			'performance' => $this->input->post('performance'),
			'position' => $this->input->post('position')
		);
		
		// If form post data validates and CSRF $token == session $token add new results
		if($this->form_validation->run() == TRUE && $this->input->post('token_admin') == $this->session->userdata('token_admin')) 
		{
			// Insert new results
			$this->nzchamps_model->update_nzchamps($data);
			
			echo $this->update_text_message = '<span class="message_success">Representation updated!</span>';
			
			// Display confirmation of uploaded result to screen
			// Example: ADDED - ABBEY, Stevens (AKL / 10 Jul 1998) 505402 | Javelin Throw | MS | 01:31.26 | | 069.69 | | Hamilton Classic | out | Hamilton | 2012-01-6
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:1.1em;">';
				echo '<tr style="font-weight:700; text-align:right;">';
					echo '<td>Year</td>';
					echo '<td>Event</td>';
					echo '<td>Age Group</td>';
					echo '<td>Performance</td>';
					echo '<td>Position</td>';
				echo '</tr>';
				echo '<tr style="text-align:right;">';
					echo '<td>' . $data['year'] . '</td>';
					echo '<td>' . $data['eventID'] . '</td>';
					echo '<td>' . $data['ageGroup'] . '</td>';
					echo '<td>' . $data['performance'] . '</td>';
					echo '<td>' . $data['position'] . '</td>';
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
		
	} //ENDS update_nzchamps()
	
	
	
	/*************************************************************************************/
	// FUNCTION delete_nzchamps()
	// Deletes a single representation based on its 'resultID'
	/*************************************************************************************/
	public function delete_nzchamps()
	{
		$this->form_validation->set_rules('repID', 'Rep ID', 'trim|required');
		
		$data = $this->input->post('repID');
		
		if($this->form_validation->run() == TRUE) 
		{
			$this->nzchamps_model->delete_nzchamps($data);
			echo $this->update_text_message = '<span class="message_success">Performance Deleted!</span>';
		
		}
	
	} // ENDS delete_nzchamps()
	

	


} // ENDS class Representation_con