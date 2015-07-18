<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Results_con extends CI_Controller {
	
	
	function __construct()
	{
		parent::__construct();
		// AUTOLOADED FILES
		// Helpers: 	global
		// Models: 		global_model
		// Config: 		anz_settings
		// Libraries:	auth
		$this->load->model('site/results_model');
		$this->load->model('site/multis_model');
		$this->load->model('site/relays_model');

	}


	/*************************************************************************************/
	// FUNCTION index()
	// Displays results of ALL events
	/*************************************************************************************/
	public function index()
	{
		$this->form_validation->set_rules('eventID', 'Event', 'trim|required');
		$this->form_validation->set_rules('ageGroup', 'Age Group', 'trim|required');
		$this->form_validation->set_rules('year', 'Date (Year)', 'trim|required');
		$this->form_validation->set_rules('list_depth', 'List Depth', 'trim|required');
		$this->form_validation->set_rules('list_type', 'List Type', 'trim|required');
		
		// Create results $data array()
		$data = array(
			'eventID' => $this->input->post('eventID'),
			'ageGroup' => $this->input->post('ageGroup'),
			'date' => $this->input->post('year'),
			'list_depth' => $this->input->post('list_depth'),
			'list_type' => $this->input->post('list_type')
		);
		
		// Set up $this->config->item('xxxxxxx') vars
		$eventID = $this->input->post('eventID');
		$track_events = $this->config->item('track_events');
		$track_events_wind = $this->config->item('track_events_wind');
		$field_events = $this->config->item('field_events');
		$field_events_wind = $this->config->item('field_events_wind');
		$multi_events = $this->config->item('multi_events');
		$relay_events = $this->config->item('relay_events');
		
		
		// Create session vars of posted (search rankings) parameters
		$searchData = array(
			'eventID'  	=> $this->input->post('eventID'),
			'ageGroup' 	=> $this->input->post('ageGroup'),
			'year'     	=> $this->input->post('year'),
			'list_depth' => $this->input->post('list_depth'),
			'list_type'  => $this->input->post('list_type')
		);

		$this->session->set_userdata($searchData);
		
		
		// If form post data validates and CSRF $token == session $token show lists
		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
		{
			
			/*********************************************************************
			| TRACK EVENTS 
			**********************************************************************
			| OUTPUT LIST TRACK ONE - Displays 3 x lists:
			| Wind Legal 	(<= 2.0)
			| Wind Illegal 	(>2.0)
			| Hand Timed 	(ht)
			*/
			
			if( in_array( $eventID, $track_events ) && in_array( $eventID, $track_events_wind ) ) // START OUTPUT LIST TRACK ONE
			{
				// Select ALL non-wind affected track events
				if($query = $this->results_model->results_legal_wind())
				{
					$data['legal_wind'] = $query;
				}
				
				// Select ALL wind affected track events
				if($query = $this->results_model->results_illegal_wind())
				{
					$data['illegal_wind'] = $query;
				}
				
				// Select ALL hand-timed track events
				// if($query = $this->results_model->results_hand_timed())
				// {
				// 	$data['results_hand_timed'] = $query;
				// }
			
			} // ENDS OUTPUT LIST TRACK ONE

			
			
			/*********************************************************************
			| TRACK EVENTS 
			**********************************************************************
			| OUTPUT LIST TRACK TWO - Displays 2 x lists:
			| Wind (Irrelevant)
			| Hand Timed 	(ht)
			*/
			
			if( in_array( $eventID, $track_events ) && ! in_array( $eventID, $track_events_wind ) ) // START OUTPUT LIST TRACK TWO
			{
				// Select ALL wind-irrelevant track events
				if($query = $this->results_model->results())
				{
					$data['results'] = $query;
				}
				
				// Select ALL hand-timed track events
				// if($query = $this->results_model->results_hand_timed())
				// {
				// 	$data['results_hand_timed'] = $query;
				// }
				
			} // ENDS OUTPUT LIST TRACK TWO
			
			
			/*********************************************************************
			| FIELD EVENTS 
			**********************************************************************
			| OUTPUT LIST FIELD ONE - Displays 3 x lists:
			| Wind legal 	(>2.1)
			| Wind Illegal (>2.0)
			*/
			
			if( in_array( $eventID, $field_events ) && in_array( $eventID, $field_events_wind ) ) // START OUTPUT LIST FIELD ONE
			{
				// Select ALL legal wind affected field events
				if($query = $this->results_model->results_legal_wind())
				{
					$data['legal_wind'] = $query;
				}
				
				// Select ALL illegal wind affected field events
				if($query = $this->results_model->results_illegal_wind())
				{
					$data['illegal_wind'] = $query;
				}
				
			} // ENDS OUTPUT LIST FIELD ONE
			
			
			/*********************************************************************
			| FIELD EVENTS 
			**********************************************************************
			| OUTPUT LIST FIELD TWO - Displays 2 x lists:
			| Wind (Irrelevant)
			*/
			
			if(in_array($eventID, $field_events) &&
				 !in_array($eventID, $field_events_wind)) // START OUTPUT LIST FIELD TWO
			{
				// Select ALL wind-irrelevant field events
				if($query = $this->results_model->results())
				{
					$data['results'] = $query;
				}
	
				
			} // ENDS OUTPUT LIST FIELD TWO
			
			
			/*********************************************************************
			| MULTI EVENTS 
			**********************************************************************
			| OUTPUT LIST MULTIS - Displays 1 x lists:
			*/
			
			if(in_array($eventID, $multi_events)) // START OUTPUT LIST MULTIS
			{
				// Select ALL multi events
				if($query = $this->multis_model->multis())
				{
					$data['multis'] = $query;
				}
	
				
			} // ENDS OUTPUT LIST MULTIS
			
			
			/*********************************************************************
			| RELAY EVENTS 
			**********************************************************************
			| OUTPUT LIST RELAYS - Displays 1 x lists:
			*/
			
			if(in_array($eventID, $relay_events)) // START OUTPUT LIST RELAYS
			{
				// Select ALL relay events
				if($query = $this->relays_model->relays())
				{
					$data['relays'] = $query;
				}
	
				
			} // ENDS OUTPUT LIST MULTIS
			
			
			$data['token'] = $this->auth->token();
			$data['event_info'] = getEvents(); // global_helper
			$data['main_content'] = 'site/results';
			$this->load->view('site/includes/template', $data);
			
		} 
		else 
		{
			//$this->error_message = validation_errors('<div class="message_error">', '</div>') . '<br />';
			$this->error_message = validation_errors('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>');
			
			$data['token'] = $this->auth->token();
			$data['main_content'] = 'site/results';
			$this->load->view('site/includes/template', $data);
		}
		
	} //ENDS index()
	
	
	
	
} //ENDS Results class