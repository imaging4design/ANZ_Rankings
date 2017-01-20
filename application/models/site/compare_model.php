<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Compare_Model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();

		// WHAT IS $this->athleteID?

		// It is the posted 'athleteID' field from the 'auto-populate' input box in the 'Search Section'
		// This returns the athlete 'firstname', 'lastName' and 'id' (as the posted result)
		// Do a PHP string function to get the last 6 characters/digits
		// This will be the athlete(ID)

		// OR it might be the '$this->uri->segment(4)' if clicking the athletes 'name link' in the lists
		// OR it might be the user clicking on the 'Quick Profile' icon on the main lists

		// Get and configure $athleteID
		if( $_POST['athlete'][0] ) 
		{
			$this->athleteID = substr($_POST['athlete'][0], -6);
		}
		
		if( $_POST['athlete'][1] ) 
		{
			$this->athleteID2 = substr($_POST['athlete'][1], -6);
		}




		/*****************************************************/
		// SET UP TWO KEY POST VARIABLES
		/*****************************************************/
		// $this->ageGroup will represent the value of the posted 'ageGroup'
		// $this->eventID will represent the value of the posted 'eventID'
		
		$this->ageGroup = $this->input->post('ageGroup');
		$this->eventID 	= $this->input->post('eventID');

		
		
		/*************************************************************************/
		// Work out how to order athlete profile results (by date or performance)
		// Create exceptions for 'individual' events as well as 'multi' events
		/*************************************************************************/
		
		// If in_array $this->config->item('multi_events') = Multi Event
		if(in_array($this->input->post('eventID'), $this->config->item('multi_events'))) {
			$this->order_by = "resMulti.points DESC";
		} else {
			$this->order_by = "results.time ASC, results.distHeight DESC, results.date ASC";
		}


	
		/*****************************************************/
		// COMBINE ALL AGE GROUPS IN OPEN LISTS
		/*****************************************************/
		// Example: Mens 100m
		// MS, M20, M19 and M17 should all appear in the (MS) Mens Open list
		// There are no implements or hurdle heights affecting these events
		
		
		// Check the value of $this->input->post('eventID')
		// If it appears in the array $this->config->item('open_events_men')
		// && $this->ageGroup == 'MS' then ALL ageGroups in this event will appear in the Mens Open list 
		
		if(in_array($this->eventID, $this->config->item('open_events_men')) && $this->ageGroup == 'MS')
		{
			$this->ageGroup = "'MS', 'M20', 'M19', 'M17', 'M16'";
		}
		
		// Womens version of above
		if(in_array($this->eventID, $this->config->item('open_events_women')) && $this->ageGroup == 'WS')
		{
			$this->ageGroup = "'WS', 'W20', 'W19', 'W17', 'W16'";
		}

		
		/*****************************************************/
		// COMBINE LIMITED AGE GROUPS IN OPEN LISTS
		/*****************************************************/
		// In certain cases we only need to combine SOME of the younger 
		// ageGroups into the (MS/WS) open lists where they use the 
		// same implement weights/heights as the seniors
		
		// Example: Mens Javelin Throw
		// M20 and M19 use 800gm javelin, so these rankings
		// need to be included in the Mens Senior (MS) lists.
		/*****************************************************/
		
		/*****************************************************/
		// MENS HURDLES / STEEPLECHASE
		/*****************************************************/
		// 400m Hurdles (Combine MS / M20 / M19)
		if($this->eventID == 25 && $this->ageGroup == 'MS')
		{
			$this->ageGroup = "'MS', 'M20', 'M19'";
		}
		
		// 3000m Steeplechase (Combine MS / M20 / M19)
		if($this->eventID == 21 && $this->ageGroup == 'MS')
		{
			$this->ageGroup = "'MS', 'M20', 'M19'";
		}
		
		/*****************************************************/
		// MENS THROWS
		/*****************************************************/
		// Mens Javelin (Combine MS / M20 / M19)
		if($this->eventID == 33 && $this->ageGroup == 'MS')
		{
			$this->ageGroup = "'MS', 'M20', 'M19'";
		}
		
		/*****************************************************/
		// WOMENS HURDLES / STEEPLECHASE
		/*****************************************************/
		// 100m Hurdles (Combine WS / W20 / W19)
		if($this->eventID == 22 && $this->ageGroup == 'WS')
		{
			$this->ageGroup = "'WS', 'W20', 'W19'";
		}
		
		if($this->eventID == 25 && $this->ageGroup == 'WS')
		{
			$this->ageGroup = "'WS', 'W20', 'W19'";
		}
		
		// 3000m Steeplechase (Combine WS / W20 / W19)
		if($this->eventID == 21 && $this->ageGroup == 'WS')
		{
			$this->ageGroup = "'WS', 'W20', 'W19'";
		}
		
		/*****************************************************/
		// WOMENS THROWS
		/*****************************************************/
		// Shot Put (Combine WS / W20 / W19)
		if($this->eventID == 30 && $this->ageGroup == 'WS')
		{
			$this->ageGroup = "'WS', 'W20', 'W19'";
		}
		
		// Hammer (Combine WS / W20 / W19)
		if($this->eventID == 32 && $this->ageGroup == 'WS')
		{
			$this->ageGroup = "'WS', 'W20', 'W19'";
		}
		
		// Javelin (Combine WS / W20 / W19)
		if($this->eventID == 33 && $this->ageGroup == 'WS')
		{
			$this->ageGroup = "'WS', 'W20', 'W19'";
		}


		/*****************************************************/
		// EXPLAIN :: $this->track_or_field
		// EXPLAIN :: $this->order_by
		/*****************************************************/
		// $this->track_or_field will tell the query to either
		// search by time (track events) or distHeight (field events)
		// $this->order_by will order the results correctly
		
		if(in_array($this->eventID, $this->config->item('track_events')))
		{
			$this->track_or_field = "MIN(time) AS time";
		}
		else
		{
			$this->track_or_field = "MAX(distHeight) AS distHeight";
		}


		/*****************************************************/
		// IMPORTANT NOTE!
		/*****************************************************/
		// If we are going to use the WHERE IN () clause
		// we must include each ageGroup in parentheses ''
		// Example: W20 = 'W20' and  W19 = 'W19' etc ...
		
		$ages = array('MS','M20','M19','M17','M16','WS','W20','W19','W17','W16');
		
		if(in_array($this->ageGroup, $ages))
		{
			$this->ageGroup = "'$this->ageGroup'";
		}
		
		
			
	} // ENDS __construct()



	/*************************************************************************************/
	// FUNCTION athlete_data_a()
	// Display an athletes 'individual' event results
	/*************************************************************************************/

	public function athlete_data_a()
	{	

		$query = $this->db->query("
			SELECT *, " . $this->track_or_field . ", DATE_FORMAT(athletes.DOB, '%d %b %Y') AS DOB, DATE_FORMAT(results.date, '%d %b %Y') AS date
			FROM athletes

			INNER JOIN results ON results.athleteID = athletes.athleteID
			INNER JOIN events ON events.eventID = results.eventID

			WHERE athletes.athleteID = " . $this->athleteID . " 
			AND results.eventID = " . $this->eventID . " 
			AND results.ageGroup IN (" . $this->ageGroup . ")
			ORDER BY " . $this->order_by . ", results.date ASC, results.resultID asc
		");

		
		if($query->num_rows() > 0) 
		{
			return $query->row();
		}
		
		
	} //ENDS athlete_data_a()


	/*************************************************************************************/
	// FUNCTION athlete_data_b()
	// Display an athletes 'individual' event results
	/*************************************************************************************/

	public function athlete_data_b()
	{	

		$query = $this->db->query("
			SELECT *, " . $this->track_or_field . ", DATE_FORMAT(athletes.DOB, '%d %b %Y') AS DOB, DATE_FORMAT(results.date, '%d %b %Y') AS date
			FROM athletes

			INNER JOIN results ON results.athleteID = athletes.athleteID
			INNER JOIN events ON events.eventID = results.eventID

			WHERE athletes.athleteID = " . $this->athleteID2 . " 
			AND results.eventID = " . $this->eventID . " 
			AND results.ageGroup IN (" . $this->ageGroup . ")
			ORDER BY " . $this->order_by . ", results.date ASC, results.resultID asc
		");


		if($query->num_rows() > 0) 
		{
			return $query->row();
		}
		
		
	} //ENDS athlete_data_b()



	/*************************************************************************************/
	// FUNCTION athlete_perfs_a()
	// Display an athletes 'individual' event results
	/*************************************************************************************/

	public function athlete_perfs_a()
	{	

		$query = $this->db->query("
			SELECT *, DATE_FORMAT(athletes.DOB, '%d %b %Y') AS DOB, DATE_FORMAT(results.date, '%d %b %Y') AS date
			FROM results

			INNER JOIN athletes ON athletes.athleteID = results.athleteID 
			INNER JOIN events ON events.eventID = results.eventID  

			WHERE athletes.athleteID = " . $this->athleteID . " 
			AND results.eventID = " . $this->eventID . " 
			AND results.ageGroup IN (" . $this->ageGroup . ")
			ORDER BY " . $this->order_by . ", results.date ASC, results.resultID asc
		");

		
		if($query->num_rows() > 0) 
		{
			return $query->result();
		}
		
		
	} //ENDS athlete_perfs_a()


	/*************************************************************************************/
	// FUNCTION athlete_perfs_b()
	// Display an athletes 'individual' event results
	/*************************************************************************************/

	public function athlete_perfs_b()
	{

		$query = $this->db->query("
			SELECT *, DATE_FORMAT(athletes.DOB, '%d %b %Y') AS DOB, DATE_FORMAT(results.date, '%d %b %Y') AS date
			FROM results

			INNER JOIN athletes ON athletes.athleteID = results.athleteID 
			INNER JOIN events ON events.eventID = results.eventID  

			WHERE athletes.athleteID = " . $this->athleteID2 . " 
			AND results.eventID = " . $this->eventID . " 
			AND results.ageGroup IN (" . $this->ageGroup . ")
			ORDER BY " . $this->order_by . ", results.date ASC, results.resultID asc
		");
		
		
		if($query->num_rows() > 0) 
		{
			return $query->result();
		}
		
		
	} //ENDS athlete_perfs_b()



	/*************************************************************************************/
	// FUNCTION athlete_rep_a()
	// Display an athletes 'Representational' honors
	/*************************************************************************************/

	public function athlete_rep_a()
	{	

		$query = $this->db->query("
			SELECT * FROM representations
			INNER JOIN events ON events.eventID = representations.eventID
			WHERE athleteID = " . $this->athleteID . "
			AND representations.eventID = " . $this->eventID . "
			ORDER BY year ASC
		");

		
		if($query->num_rows() > 0) 
		{
			return $query->result();
		}
		
		
	} //ENDS athlete_rep_a()



	/*************************************************************************************/
	// FUNCTION athlete_rep_b()
	// Display an athletes 'Representational' honors
	/*************************************************************************************/

	public function athlete_rep_b()
	{	

		$query = $this->db->query("
			SELECT * FROM representations
			INNER JOIN events ON events.eventID = representations.eventID
			WHERE athleteID = " . $this->athleteID2 . "
			AND representations.eventID = " . $this->eventID . "
			ORDER BY year ASC
		");

		
		if($query->num_rows() > 0) 
		{
			return $query->result();
		}
		
		
	} //ENDS athlete_rep_b()



	/*************************************************************************************/
	// FUNCTION athlete_medals_a()
	// Display an athletes 'NZ Champs' medals
	/*************************************************************************************/

	public function athlete_medals_a()
	{	

		$query = $this->db->query("
			SELECT * FROM nzchamps
			INNER JOIN events ON events.eventID = nzchamps.eventID
			WHERE athleteID = " . $this->athleteID . "
			AND nzchamps.eventID = " . $this->eventID . "
			ORDER BY year ASC
		");

		
		if($query->num_rows() > 0) 
		{
			return $query->result();
		}
		
		
	} //ENDS athlete_medals_a()



	/*************************************************************************************/
	// FUNCTION athlete_medals_b()
	// Display an athletes 'NZ Champs' medals
	/*************************************************************************************/

	public function athlete_medals_b()
	{	

		$query = $this->db->query("
			SELECT * FROM nzchamps
			INNER JOIN events ON events.eventID = nzchamps.eventID
			WHERE athleteID = " . $this->athleteID2 . "
			AND nzchamps.eventID = " . $this->eventID . "
			ORDER BY year ASC
		");

		
		if($query->num_rows() > 0) 
		{
			return $query->result();
		}
		
		
	} //ENDS athlete_medals_b()



	/*************************************************************************************/
	// FUNCTION athlete_progressions_a()
	// Displays the Personal Best Performances of an athletes individual events 
	/*************************************************************************************/
	public function athlete_progressions_a()
	{
		$query = $this->db->query("
															
			SELECT *, MIN(r.time) AS MIN_time, MAX(r.distHeight) AS MAX_distHeight, DATE_FORMAT(r.date, '%Y') AS year
			FROM
						
			(SELECT *
				FROM results
				WHERE athleteID = ".$this->athleteID."
				# AND ageGroup IN (" . $this->ageGroup . ")
				AND eventID = ".$this->eventID."
				AND record != 'ht'
				GROUP BY eventID, implement, resultID
				ORDER BY time ASC, distHeight DESC
			) AS rr
						
			JOIN results AS r
				ON r.time = rr.time
				AND r.distHeight = rr.distHeight
				AND r.resultID = rr.resultID
			
			INNER JOIN events AS e ON e.eventID = r.eventID
			INNER JOIN athletes AS a ON a.athleteID = r.athleteID
					
			GROUP BY YEAR(r.date), r.athleteID, r.eventID, r.implement
			ORDER BY YEAR(r.date), e.eventID ASC, r.implement ASC
					
		");
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
		
	} // ENDS athlete_progressions_a($eventID)



	/*************************************************************************************/
	// FUNCTION athlete_progressions_b()
	// Displays the Personal Best Performances of an athletes individual events 
	/*************************************************************************************/
	public function athlete_progressions_b($eventID)
	{
		$query = $this->db->query("
															
			SELECT *, MIN(r.time) AS MIN_time, MAX(r.distHeight) AS MAX_distHeight, DATE_FORMAT(r.date, '%Y') AS year
			FROM
						
			(SELECT *
				FROM results
				WHERE athleteID = ".$this->athleteID2."
				# AND ageGroup IN (" . $this->ageGroup . ")
				AND eventID = ".$this->eventID."
				AND record != 'ht'
				GROUP BY eventID, implement, resultID
				ORDER BY time ASC, distHeight DESC
			) AS rr
						
			JOIN results AS r
				ON r.time = rr.time
				AND r.distHeight = rr.distHeight
				AND r.resultID = rr.resultID
			
			INNER JOIN events AS e ON e.eventID = r.eventID
			INNER JOIN athletes AS a ON a.athleteID = r.athleteID
					
			GROUP BY YEAR(r.date), r.athleteID, r.eventID, r.implement
			ORDER BY YEAR(r.date), e.eventID ASC, r.implement ASC
					
		");
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
		
	} // ENDS athlete_progressions_b($eventID)
	
		
	
		
} // ENDS class Profiles_Model