<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Representation_con extends CI_Controller
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
		$this->load->model('admin/representation_model');
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
	// FUNCTION add_representation()
	// Displays the page (form) to add new representations
	/*************************************************************************************/
	public function add_representation()
	{
		$data['token_admin'] = $this->auth->token_admin();
		$data['main_content'] = 'admin/add_representation';
		$this->load->view('admin/includes/template', $data);
	
	} // ENDS add_representation()
	
	
	
	/*************************************************************************************/
	// FUNCTION populate_representation()
	// Retrieves representation details from database to populate the 'edit' page
	/*************************************************************************************/
	public function populate_representation()
	{
		// Query to retrieve ALL events
		if($query = $this->global_model->getEvents())
		{
			$data['events'] = $query;
		}

		// Query to retrieve result to populate 'edit' page
		if( $query = $this->representation_model->populate_representations())
		{
			$data['pop_data'] = $query;
		}

		$data['token_admin'] = $this->auth->token_admin();
		$data['main_content'] = 'admin/edit_representations';
		$this->load->view('admin/includes/template', $data);
	
	} // ENDS populate_representation()
	
	
	
	/*************************************************************************************/
	// FUNCTION add_new_representation()
	// Adds a new representation to the database
	/*************************************************************************************/
	public function add_new_representation()
	{
		
		$this->form_validation->set_rules('token_admin', 'Token Admin', 'trim|required');
		$this->form_validation->set_rules('athleteID', 'Athlete ID', 'trim|required');
		$this->form_validation->set_rules('year', 'Year', 'trim|required');
		$this->form_validation->set_rules('competition', 'Competition', 'trim|required');
		$this->form_validation->set_rules('eventID', 'Event', 'trim');
		$this->form_validation->set_rules('performance', 'Performance', 'trim');
		$this->form_validation->set_rules('position', 'Position', 'trim|required');
		
		//Create results $data array()
		$data = array(
			'athleteID' => $this->input->post('athleteID'),
			'year' => $this->input->post('year'),
			'competition' => $this->input->post('competition'),
			'eventID' => $this->input->post('eventID'),
			'performance' => $this->input->post('performance'),
			'position' => $this->input->post('position')
		);

	
		// If form post data validates and CSRF $token == session $token add new results
		if($this->form_validation->run() == TRUE && $this->input->post('token_admin') == $this->session->userdata('token_admin')) 
		{
			// Insert new results
			$this->representation_model->add_new_representation($data);
			
			echo '<div class="well well-success">';
			echo $this->update_text_message = '<div class="message_success"><i class="fa fa-check"></i> New record added!<br /></div>';

			
				// Display confirmation of uploaded result to screen
				// Example: ADDED - ABBEY, Stevens (AKL / 10 Jul 1998) 505402 | Javelin Throw | MS | 01:31.26 | | 069.69 | | Hamilton Classic | out | Hamilton | 2012-01-6
			echo '<table class="table table-condensed table-bordered">';
				echo '<tr>';
					echo '<td>Year</td>';
					echo '<td>Competition</td>';
					echo '<td>Event</td>';
					echo '<td>Performance</td>';
					echo '<td>Position</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>' . $data['year'] . '</td>';
					echo '<td>' . $data['competition'] . '</td>';
					echo '<td>' . $data['eventID'] . '</td>';
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
			echo anchor('admin/representation_con/populate_representation/'.$this->db->insert_id().'/'.$data['athleteID'].'', 'Edit Result', array('class'=>'btn btn-md btn-green marBot10'));
			echo '</div>';  

		} 
		else 
		{
			echo '<div class="well well-error">';
			echo validation_errors('<div class="message_error"><i class="fa fa-times"></i> ', '</div>');
			echo '</div>';
		}
		
	} //ENDS add_new_representation()
	
	
	
	/*************************************************************************************/
	// FUNCTION update_representation()
	// Updates a representation to the database
	/*************************************************************************************/
	public function update_representation()
	{
		$this->form_validation->set_rules('token_admin', 'Token Admin', 'trim|required');
		$this->form_validation->set_rules('repID', 'Rep ID', 'trim|required');
		$this->form_validation->set_rules('year', 'Year', 'trim|required');
		$this->form_validation->set_rules('competition', 'Competition', 'trim|required');
		$this->form_validation->set_rules('eventID', 'Event', 'trim|required');
		$this->form_validation->set_rules('performance', 'Performance', 'trim|required');
		$this->form_validation->set_rules('position', 'Position', 'trim|required');
		
		//Create results $data array()
		$data = array(
			'id' => $this->input->post('repID'),
			'year' => $this->input->post('year'),
			'competition' => $this->input->post('competition'),
			'eventID' => $this->input->post('eventID'),
			'performance' => $this->input->post('performance'),
			'position' => $this->input->post('position')
		);
		
		// If form post data validates and CSRF $token == session $token add new results
		if($this->form_validation->run() == TRUE && $this->input->post('token_admin') == $this->session->userdata('token_admin')) 
		{
			// Insert new results
			$this->representation_model->update_representation($data);

			echo '<div class="well well-success">';
			echo $this->update_text_message = '<div class="message_success"><i class="fa fa-check"></i> Representation Updated!</div>';
			
			// Display confirmation of uploaded result to screen
			// Example: ADDED - ABBEY, Stevens (AKL / 10 Jul 1998) 505402 | Javelin Throw | MS | 01:31.26 | | 069.69 | | Hamilton Classic | out | Hamilton | 2012-01-6
			echo '<table class="table table-condensed table-bordered">';
				echo '<tr>';
					echo '<td>Year</td>';
					echo '<td>Competition</td>';
					echo '<td>Event</td>';
					echo '<td>Performance</td>';
					echo '<td>Position</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>' . $data['year'] . '</td>';
					echo '<td>' . $data['competition'] . '</td>';
					echo '<td>' . $data['eventID'] . '</td>';
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
		
    		echo '</div>';  
		} 
		else 
		{
			echo '<div class="well well-error">';
			echo validation_errors('<div class="message_error"><i class="fa fa-times"></i> ', '</div>');
			echo '</div>';
		}
		
	} //ENDS update_representation()
	
	
	
	/*************************************************************************************/
	// FUNCTION delete_representation()
	// Deletes a single representation based on its 'resultID'
	/*************************************************************************************/
	public function delete_representation()
	{
		$this->form_validation->set_rules('repID', 'Rep ID', 'trim|required');
		
		$data = $this->input->post('repID');
		
		if($this->form_validation->run() == TRUE) 
		{
			$this->representation_model->delete_representation($data);

			echo '<div class="well well-error">';
			echo $this->update_text_message = '<span class="message_error">Representation Deleted!</span>';
			echo '</div>';
		
		}
	
	} // ENDS delete_representation()
	

	


} // ENDS class Representation_con