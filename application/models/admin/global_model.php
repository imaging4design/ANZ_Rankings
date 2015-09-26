<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Global_Model extends CI_Model
{
    
	function __construct()
	{
		parent::__construct();
	
	} // ENDS __construct()


	/*************************************************************************************/
	// FUNCTION ratified_record()
	// Displays a NEW ratified record on the home page - as item of interest!
	/*************************************************************************************/
	function ratified_record()
	{
		$query = $this->db->query("
			SELECT *, DATE_FORMAT(date,'%d %b %Y') as newdate
			FROM records 
			WHERE date BETWEEN DATE_SUB(NOW(), INTERVAL 1 MONTH) 
			AND NOW() 
			ORDER BY date DESC
		");

		if($query->num_rows() >0) 
		{
			return $query->result();
		}

	}
	
	
	
	/********************************************************************/
	// FUNCTION totalResults()
	// Retrieves the total number of results on the site to date!
	// Add the results + resMulti + resRelays total together
	/********************************************************************/
	function totalResults()
	{
		$res1 = $this->db->count_all_results('results');
		$res2 = $this->db->count_all_results('resMulti');
		$res3 = $this->db->count_all_results('resRelays');
		$res4 = $this->db->count_all_results('records');
		
		return $res1 + $res2 + $res3 + $res4;
	
	} // ENDS totalResults()



	/********************************************************************/
	// FUNCTION totalAthletes()
	// Retrieves the total number of ranked athletes in the database!
	/********************************************************************/
	function totalAthletes()
	{
		$athletes = $this->db->count_all_results('athletes');
		
		return $athletes;
	
	} // ENDS totalAthletes()
	
	
	
	/********************************************************************/
	// FUNCTION get_auto_athletes()
	// Retrieves ALL athlete names for 'auto-populate' jQuery drop down
	/********************************************************************/
	function get_auto_athletes()
	{
		// Search term 'athletes' from jQuery
		$athletes = $this->input->post('athletes');
		
		// Search from table called clients
		$this->db->select('nameLast, nameFirst, athleteID, DOB, centreID');
		$this->db->select("DATE_FORMAT(DOB, '%d %b %Y') AS DOB", FALSE);
		$this->db->where('athleteID >', 200000); // Don't allow for searching of 'Historic Athletes'
		$this->db->like('nameLast', $athletes, 'after');
		$this->db->order_by('nameLast', 'ASC');
		$this->db->order_by('nameFirst', 'ASC');
		$query = $this->db->get('athletes');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
	
	}
	
	
	/********************************************************************/
	// FUNCTION getEvents()
	// Retrieves the full list of events (for Rankings Lists) only!!!
	// Used in the global_helper.php file!
	/********************************************************************/
	function getEvents()
	{
		$this->db->select('*');
		$this->db->where_in('eventID', $this->config->item('rankings_dropdown'));
		$this->db->order_by('eventOrder', 'ASC');
		$query = $this->db->get('events');

		//$this->config->item('rankings_dropdown'))
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}

	} // ENDS getEvents()


	/********************************************************************/
	// FUNCTION getRecordEvents()
	// Retrieves the full list of events (for Records!) only!!!
	// Used in the global_helper.php file!
	/********************************************************************/
	function getRecordEvents()
	{
		$this->db->select('*');
		$this->db->where_in('eventID', $this->config->item('records_dropdown'));
		$this->db->order_by('eventOrder', 'ASC');
		$query = $this->db->get('events');

		//$this->config->item('rankings_dropdown'))
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}

	} // ENDS getRecordEvents()
	
	
	/********************************************************************/
	// FUNCTION convertEventID()
	// Converts the eventID into an eventName
	// Used in the global_helper.php file!
	/********************************************************************/
	function convertEventID($data)
	{
		$this->db->select('eventName');
		$this->db->where('eventID', $this->session->userdata('eventID'));
		$this->db->or_where('eventID', $this->input->post('eventID'));
		$this->db->or_where('eventID', $data);
		$query = $this->db->get('events');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
	
	} // ENDS convertEventID()
	
	
	/********************************************************************/
	// FUNCTION getIndoorEvents()
	// Retrieves the full list of (Indoor) events
	// Used in the global_helper.php file!
	/********************************************************************/
	function getIndoorEvents()
	{
		$this->db->select('*');
		$query = $this->db->get('events_indoors');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
	
	} // ENDS getIndoorEvents()
	
	
	/********************************************************************/
	// FUNCTION getCentres()
	// Retrieves the full list of centres
	// Used in the global_helper.php file!
	/********************************************************************/
	function getCentres()
	{
		$this->db->select('*');
		$this->db->order_by('centreName', 'ASC');
		$query = $this->db->get('centre');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
	
	} // ENDS getCentres()
	
	
	/********************************************************************/
	// FUNCTION getClubs()
	// Retrieves the full list of clubs
	// Used in the global_helper.php file!
	/********************************************************************/
	function getClubs()
	{
		$this->db->select('*');
		$this->db->order_by('clubName', 'ASC');
		$query = $this->db->get('club');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
	
	} // ENDS getClubs()
		
		
		
} // ENDS class Global_Model