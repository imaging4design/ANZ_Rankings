<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Results_Model extends CI_Model
{
    
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
	
	
		
		
} // ENDS class Results_Model



	