<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Multis_Model extends CI_Model
{
	
	
	public function __construct()
	{
		parent::__construct();
		
		/*****************************************************/
		// IMPORTANT!!!
		// BEFORE WE START
		/*****************************************************/
		// The $this->config->item('XXXXXXXX')
		// are config items imported from application/config/anz_settings.php
		
		
		/*****************************************************/
		// SET UP TWO KEY POST VARIABLES
		/*****************************************************/
		// $this->ageGroup will represent the value of the posted 'ageGroup'
		// $this->eventID will represent the value of the posted 'eventID'
		
		$this->ageGroup = $this->session->userdata('ageGroup');
		$this->eventID 	= $this->session->userdata('eventID');
		
		
		/*****************************************************/
		// COMBINE ALL AGE GROUPS IN OPEN LISTS
		/*****************************************************/
		// Example: Mens Decathlon
		// MS, M20 and M19 should all appear in the (MS) Mens Open list
		// as ALL implements and hurdle heights are the same in each ageGroup
		
		
		// Check the value of $this->input->post('eventID')
		// If it appears in the array $this->config->item('open_events_men')
		// && $this->ageGroup == 'MS' then ALL ageGroups in this event will appear in the Mens Open list 
		
		if(in_array($this->eventID, $this->config->item('multi_events')) && $this->ageGroup == 'MS')
		{
			$this->ageGroup = "'MS'";
		}
		
		// Womens version of above
		if(in_array($this->eventID, $this->config->item('multi_events')) && $this->ageGroup == 'WS')
		{
			$this->ageGroup = "'WS', 'W20', 'W19'";
		}
		
		
		/*************************************************************************/
		// Work out YEAR posted.
		// 0 = ALL years
		/*************************************************************************/
		if($this->session->userdata('year') == 0)
		{
			$this->year = "YEAR(resMulti.date) >=  2008";
		}
		else
		{
			$this->year = "YEAR(resMulti.date) = ". $this->session->userdata('year');
		}
		
		
		/*****************************************************/
		// EXPLAIN :: $this->group_by
		/*****************************************************/
		// This determinds if rankings are listed by
		// Athletes or Performances
		if($this->session->userdata('list_type') == 0)
		{
			$this->group_by = 'resMulti.athleteID';
		}
		else
		{
			$this->group_by = 'resMulti.resultID';
		}
		
		
		/*****************************************************/
		// EXPLAIN :: $this->limit
		/*****************************************************/
		// This determinds if rankings are listed by
		// Athletes or Performances
		
		$this->limit = $this->session->userdata('list_depth');
		
		
		/*****************************************************/
		// IMPORTANT NOTE!
		/*****************************************************/
		// If we are going to use the WHERE IN () clause
		// we must include each ageGroup in parentheses ''
		// Example: W19 = 'W19'
		
		$ages = array('MS','M20','M19','M17','WS','W20','W19','W17');
		
		if(in_array($this->ageGroup, $ages))
		{
			$this->ageGroup = "'$this->ageGroup'";
		}
		
		
		
	} //ENDS __construct()
	
	
	
	
	
	/*************************************************************************************/

	// START MYSQL ACTIVE QUERIES

	/*************************************************************************************/
	
	/*************************************************************************************/
	// FUNCTION multis()
	// Retrieves ALL results for multi events based on the above exceptions
	/*************************************************************************************/
	public function multis()
	{
		$query = $this->db->query("
															
		SELECT *, DATE_FORMAT(athletes.DOB, '%d %b %Y') AS DOB, DATE_FORMAT(resMulti.date, '%d %b %Y') AS date
			FROM (SELECT * FROM resMulti AS resMulti
			WHERE resMulti.eventID = " . $this->eventID . " 
			AND " . $this->year . " 
			AND resMulti.ageGroup IN (" . $this->ageGroup . ")
			ORDER BY resMulti.points DESC, resMulti.date ASC, resMulti.resultID ASC) AS resMulti
		INNER JOIN athletes AS athletes USING (athleteID)  
		GROUP BY " . $this->group_by . "  
		ORDER BY resMulti.points DESC, resMulti.date ASC, resMulti.resultID asc 
		LIMIT " . $this->limit . "");
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
		
	} //ENDS multis()
	
		
	
		
} // ENDS class Multis_Model