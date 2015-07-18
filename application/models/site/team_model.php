<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Team_Model extends CI_Model
{
	
	
	public function __construct()
	{
		parent::__construct();
		//Stuff here


	} //ENDS __construct()
	
	
	
	/*************************************************************************************/
	// FUNCTION champsDropdown()
	// Displays the list of Championships in a dropdown
	/*************************************************************************************/
	public function champsDropdown()
	{
		$this->db->select('*');
		$this->db->select("DATE_FORMAT(qualStart, '%d %b %Y') AS qualStart", FALSE);
		$this->db->select("DATE_FORMAT(qualEnd, '%d %b %Y') AS qualStart", FALSE);
		$this->db->select("DATE_FORMAT(qualStartExt, '%d %b %Y') AS qualStartExt", FALSE);
		$this->db->select("DATE_FORMAT(qualEndExt, '%d %b %Y') AS qualEndExt", FALSE);
		$query = $this->db->get('champDetails');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
		
	} //ENDS champsDropdown()



	/*************************************************************************************/
	// FUNCTION find_qual_dates()
	// Returns the 'Qualification Dates' of the selected Championship
	/*************************************************************************************/
	public function find_qual_dates( $data )
	{
		$this->db->select('champName, year, qualStart, qualEnd, qualStartExt, qualEndExt');
		$this->db->select("DATE_FORMAT(qualStart, '%d/%b/%Y') AS qualStartFormat", FALSE);
		$this->db->select("DATE_FORMAT(qualEnd, '%d/%b/%Y') AS qualEndFormat", FALSE);
		$this->db->select("DATE_FORMAT(qualStartExt, '%d/%b/%Y') AS qualStartExtFormat", FALSE);
		$this->db->select("DATE_FORMAT(qualEndExt, '%d/%b/%Y') AS qualEndExtFormat", FALSE);
		$this->db->where('id', $data);
		$query = $this->db->get('champDetails');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
		
	} //ENDS find_qual_dates()



	/*************************************************************************************/
	// FUNCTION find_qual_marks()
	// Returns the 'Qualification Marks' for each event
	/*************************************************************************************/
	public function find_qual_marks( $data )
	{
		$this->db->select('*');
		$this->db->where('champID', $data['champID']);
		$this->db->join('events', 'events.eventID = champStandards.eventID');
		$this->db->order_by('events.eventID', 'ASC');
		$query = $this->db->get('champStandards');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
		
	} //ENDS find_qual_marks()



	/*************************************************************************************/
	// FUNCTION find_qual_marks_multis()
	// Returns the 'Qualification Marks' for each event
	/*************************************************************************************/
	public function find_qual_marks_multis( $data )
	{
		// Only search against Multi Event ID's
		$multis = array('34', '35', '36');

		$this->db->select('*');
		$this->db->where('champID', $data['champID']);
		$this->db->where_in('events.eventID', $multis); //Multi Event ID's
		$this->db->join('events', 'events.eventID = champStandards.eventID');
		$this->db->order_by('events.eventID', 'ASC');
		$query = $this->db->get('champStandards');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
		
	} //ENDS find_qual_marks_multis()



	/*************************************************************************************/
	// FUNCTION find_qualified()
	// Select ALL results from both Men and Women during the selected Championship Qualification Dates
	/*************************************************************************************/
	public function find_qualified( $dates, $eventID, $qual_standard )
	{
		// Set up Qualification Date Vars
		// ------------------------------------
		// [qualStart] => 2012-10-01
		// [qualEnd] => 2013-06-30
		// [qualStartExt] => 2012-01-01
		// [qualEndExt] => 2013-05-26
		// ------------------------------------

		$qualStart = $dates->qualStart;
		$qualEnd = $dates->qualEnd;
		$qualStartExt = $dates->qualStartExt;
		$qualEndExt = $dates->qualEndExt;


		// List of config items we are using - can remove later!
		//$config['track_events'] = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '37', '38', '39', '40');
		//$config['field_events'] = array('25', '26', '27', '28', '29', '30', '31', '32', '33');

		// Open events (not affected by implements)
		//$config['open_events_men'] = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '26', '27', '28', '29', '37', '38', '41', '42', '43', '44', '45');
		//$config['open_events_women'] = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '26', '27', '28', '29', '31', '37', '38', '41', '42', '43', '44', '45');

		/*
		|-----------------------------------------------------------------------------------------------------------------
		| What is the gender that was selected?
		|-----------------------------------------------------------------------------------------------------------------
		*/
		$post_gender = $this->input->post('gender');


		/*
		|-----------------------------------------------------------------------------------------------------------------
		| If a men's event - is this event (during this loop) an open event?
		| If so, combine ALL ageGroups (e.g., a 16 year old CAN qualify for the World Senior Champs in the 100m)
		| But if its NOT an open event - only search Senior ageGroup (e.g., a 16 year old CANNOT qualify for the World Senior Champs in the javelin - wrong implement weights)
		|-----------------------------------------------------------------------------------------------------------------
		*/
		if( $post_gender == 'MS' ) {
			$gender = ( in_array( $eventID, $this->config->item('open_events_men') ) ) ? array('MS', 'M20', 'M19', 'M17', 'M16') : array('MS');
		}

		// As above - but with women's events
		if( $post_gender == 'WS' ) {
			$gender = ( in_array( $eventID, $this->config->item('open_events_women') ) ) ? array('WS', 'W20', 'W19', 'W17', 'W16') : array('WS');
		}


		/*
		|-----------------------------------------------------------------------------------------------------------------
		| EXTENDED Qualification Dates
		| We have to extend the qualification dates for these events:
		| 10,000m (11), Marathon (19), 20km Race Walk (39) & 50km Race Walk (40)
		|-----------------------------------------------------------------------------------------------------------------
		*/
		$special_events = array('19', '39', '40'); // Event ID's

		$qDateStart = ( in_array( $eventID, $special_events ) ) ? $qualStartExt : $qualStart; // Extended START qualifying period if in above event
		$qDateEnd = ( in_array( $eventID, $special_events ) ) ? $qualEndExt : $qualEnd; // Extended END qualifying period if in above event


		/*
		|-----------------------------------------------------------------------------------------------------------------
		| What is the event type?
		| Track events get queried on time <=
		| Field events get queried on distHeight >=
		|-----------------------------------------------------------------------------------------------------------------
		*/
		$event = ( in_array( $eventID, $this->config->item('track_events') ) ) ? 'time <=' : 'distHeight >=';


			$this->db->select('*, results.eventID, events.eventID');
			$this->db->select("DATE_FORMAT(results.date, '%d %b %Y') AS date", FALSE);
			$this->db->where('date >=', $qDateStart);
			$this->db->where('date <=', $qDateEnd);

			$this->db->where_in('ageGroup', $gender);

			$this->db->where('results.eventID', $eventID);
			$this->db->where($event, $qual_standard);

				$this->db->where('wind <=', '2.0');
				$this->db->where('wind !=', 'nwr');

			$this->db->join('athletes', 'athletes.athleteID = results.athleteID');
			$this->db->join('events', 'events.eventID = results.eventID');
			$this->db->join('champStandards', 'champStandards.eventID = events.eventID');
			$this->db->order_by('results.time', 'ASC');
			$this->db->order_by('results.distHeight', 'DESC');
			$this->db->group_by('results.resultID');
			$query = $this->db->get('results');

		
		if($query->num_rows() >0) 
		{
			return $query->result();
			$query->free_result();
		}
		
		
	} //ENDS find_qualified()




	/*************************************************************************************/
	// FUNCTION find_qualified_multis()
	// Select ALL results from both Men and Women (Multi Events) during the selected Championship Qualification Dates
	/*************************************************************************************/
	public function find_qualified_multis( $dates, $eventID, $qual_standard )
	{
		
		/*
		|-----------------------------------------------------------------------------------------------------------------
		| Qual Date -> Same as per above
		|-----------------------------------------------------------------------------------------------------------------
		*/

		$qualStart = $dates->qualStart;
		$qualEnd = $dates->qualEnd;
		$qualStartExt = $dates->qualStartExt;
		$qualEndExt = $dates->qualEndExt;


		// Config Items -> Same as per above
		// $config['multi_events'] = array('34', '35', '36');


		/*
		|-----------------------------------------------------------------------------------------------------------------
		| What is the gender that was selected?
		|-----------------------------------------------------------------------------------------------------------------
		*/
		$gender = $this->input->post('gender');


			$this->db->select('*, resMulti.eventID, events.eventID');
			$this->db->select("DATE_FORMAT(resMulti.date, '%d %b %Y') AS date", FALSE);
			$this->db->where('date >=', $qualStartExt);
			$this->db->where('date <=', $qualEndExt);

			$this->db->where_in('ageGroup', $gender);

			$this->db->where('resMulti.eventID', $eventID);
			$this->db->where('points >=', $qual_standard);

				$this->db->where('wind <=', '2.0');
				$this->db->where('wind !=', 'nwr');

			$this->db->join('athletes', 'athletes.athleteID = resMulti.athleteID');
			$this->db->join('events', 'events.eventID = resMulti.eventID');
			$this->db->join('champStandards', 'champStandards.eventID = events.eventID');
			$this->db->order_by('resMulti.points', 'DESC');
			$this->db->group_by('resMulti.resultID');
			$query = $this->db->get('resMulti');

		
		if($query->num_rows() >0) 
		{
			return $query->result();
			$query->free_result();
		}
		
		
	} //ENDS find_qualified_multis()
	
	
		
} // ENDS class Team_Model