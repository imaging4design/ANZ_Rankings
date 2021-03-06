<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Results_Model extends CI_Model
{
    
	

	/*************************************************************************************/
	// FUNCTION is_pb()
	// Determinds if the result is a 'Personal Best' for that athlete 
	/*************************************************************************************/
	public function is_pb($data)
	{
		
		if(in_array($data['eventID'], $this->config->item('seperate_performances'))) { // These are event affected by implements / hurdles
			$this->db->select_max('distHeight');
			$this->db->select_min('time');
			$this->db->where('athleteID', $data['athleteID']);
			$this->db->where('eventID', $data['eventID']);
			$this->db->where('ageGroup', $data['ageGroup']);
			$query = $this->db->get('results');
		} else {
			$this->db->select_max('distHeight');
			$this->db->select_min('time');
			$this->db->where('athleteID', $data['athleteID']);
			$this->db->where('eventID', $data['eventID']);
			$query = $this->db->get('results');
		}

		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		
		
	} // ENDS is_pb()


	/*************************************************************************************/
	// FUNCTION add_job_details($data)
	// Adds a new individual event result to database
	/*************************************************************************************/
	function add_result_ind($data)
	{
		$this->db->insert('results' /*tablename*/, $data);
		return $this->db->insert_id();
	}
	
	
	/*************************************************************************************/
	// FUNCTION update_result_ind($data)
	// Adds a new individual event result to database
	/*************************************************************************************/
	function update_result_ind($data)
	{
		$this->db->where('resultID', $data['resultID'] /*record id*/);
		$this->db->update('results' /*tablename*/, $data);
	}
	
	
	/*************************************************************************************/
	// FUNCTION populate_results($data)
	// Retrieves result from database to populate the 'edit' page
	/*************************************************************************************/
	function populate_results()
	{
		$this->db->select('*');
		$this->db->where('resultID', $this->uri->segment(4));
		$this->db->join('athletes', 'athletes.athleteID = results.athleteID');
		$this->db->join('events', 'events.eventID = results.eventID');
		$query = $this->db->get('results');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
	}
	
	
	/*************************************************************************************/
	// FUNCTION delete_result_ind()
	// Deletes a single result based on its 'resultID'
	/*************************************************************************************/
	function delete_result_ind($data)
	{
		$this->db->where('resultID', $data);
		$this->db->delete('results' /*tablename*/);
	}


	/*************************************************************************************/
	// FUNCTION statistics($data)
	// Returns the statistics (i.e., number of results in the database of each month of each year)
	/*************************************************************************************/
	function statistics($data)
	{

		$postYear = $data['year'];

		$startDate = strtotime($postYear.'-01-01');
		$endDate = strtotime($postYear.'-12-01');

		while ($startDate <= $endDate) {
		   
		   $month = date('m', $startDate);
		   $year = date('Y', $startDate);

			$results = $this->db->query("
				SELECT resultID
				FROM results
				WHERE MONTH(results.date) = $month
				AND YEAR(results.date) = $year
			");

			$resMulti = $this->db->query("
				SELECT resultID
				FROM resMulti
				WHERE MONTH(resMulti.date) = $month
				AND YEAR(resMulti.date) = $year
			");

			$resRelays = $this->db->query("
				SELECT resultID
				FROM resRelays
				WHERE MONTH(resRelays.date) = $month
				AND YEAR(resRelays.date) = $year
			");

			//echo date('M-Y', $startDate) . ': ';
			//echo $results->num_rows() + $resMulti->num_rows() + $resRelays->num_rows() . '<br>';

			$myResult[] = array(date('M Y', $startDate), $results->num_rows() + $resMulti->num_rows() + $resRelays->num_rows());

			$startDate = strtotime('+1 month', $startDate);
        	

		}

		return $myResult;
		
	}
	
		
} // ENDS class Results_Model



	