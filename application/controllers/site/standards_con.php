<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Standards_con extends CI_Controller {
	
	
	function __construct()
	{
		parent::__construct();
		// AUTOLOADED FILES
		// Helpers: 	global, team
		// Models: 		global_model
		// Config: 		anz_settings
		// Libraries:	auth
		$this->load->model('site/team_model');

	}
	


	/*************************************************************************************/
	// FUNCTION index()
	// Displays TEST!
	/*************************************************************************************/
	public function index()
	{	
		
		$data['token'] = $this->auth->token();

		//$data['total_results'] = totalResults(); // from global_helper
				
		$data['main_content'] = 'site/standards';
		$this->load->view('site/includes/template', $data);
	
	} // ENDS index()



	/*************************************************************************************/
	// FUNCTION find_qualified()
	// Displays TEST!
	/*************************************************************************************/
	public function find_qualified()
	{	
		
		$this->form_validation->set_rules('token', 'Token', 'trim|required');
		$this->form_validation->set_rules('champID', 'Championship', 'trim|required');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required');


		// Create results $data array()
		$data = array(
			'champID' => $this->input->post('champID'),
			'gender' => $this->input->post('gender'),
		);

	
		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
		{
			/*
			|-----------------------------------------------------------------------------------------------------------------
			| Go get the 'Qualification Dates' for the selected Championship so we can use them in the DB->Query
			|-----------------------------------------------------------------------------------------------------------------
			*/
			$data['dates'] = find_qual_dates( $data['champID'] ); // from team_helper
			$data['standards'] = find_qual_marks( $data['champID'] ); //  from team helper

			$evt = array();
			$show_qualified = array();

			/*
			|-----------------------------------------------------------------------------------------------------------------
			| Go to database and grab ALL results between user selected 'Championship Qualification Dates'
			|-----------------------------------------------------------------------------------------------------------------
			*/
			if( $query = $this->team_model->find_qual_marks( $data ) )
			{
				
				foreach( $query as $row )
				{
					// What qualifying standard to look for? - either 'A' or 'B' standard
					$qual_standard = ( $data['gender'] == 'MS' ) ? $row->menB : $row->womenB;

					// Send through Date Range, EventID and Qualifying Standard parameters
					$show_qualified[] = $this->team_model->find_qualified( $data['dates'], $row->eventID, $qual_standard );
					
				}

				$data['show_qualified'] = $show_qualified; // Store results from database queries in $data['show_qualified'];

			}


			/*
			|-----------------------------------------------------------------------------------------------------------------
			| Go to database and grab ALL (Multi Events) results between user selected 'Championship Qualification Dates'
			|-----------------------------------------------------------------------------------------------------------------
			*/
			if( $query = $this->team_model->find_qual_marks_multis( $data ) )
			{
				
				foreach( $query as $row )
				{
					// What qualifying standard to look for? - either 'A' or 'B' standard
					$qual_standard = ( $data['gender'] == 'MS' ) ? $row->menB : $row->womenB;

					// Send through Date Range, EventID and Qualifying Standard parameters
					$show_qualified_multis[] = $this->team_model->find_qualified_multis( $data['dates'], $row->eventID, $qual_standard );
					
				}

				$data['show_qualified_multis'] = $show_qualified_multis; // Store (Multi Events) results from database queries in $data['show_qualified_multis'];

			}

			
		}

		$data['token'] = $this->auth->token();
				
		$data['main_content'] = 'site/standards';
		$this->load->view('site/includes/template', $data);
	
	} // ENDS find_qualified()




	
	
	

	
} //ENDS Team class