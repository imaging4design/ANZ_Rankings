<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Multis_Model extends CI_Model
{
    
	/*************************************************************************************/
	// FUNCTION add_result_multi($data)
	// Adds a new multi event result to database
	/*************************************************************************************/
	function add_result_multi($data)
	{
		$this->db->insert('resMulti' /*tablename*/, $data);
		return $this->db->insert_id();
	}
	
	
	/*************************************************************************************/
	// FUNCTION update_result_multi($data)
	// Updates an existing multi result to database
	/*************************************************************************************/
	function update_result_multi($data)
	{
		$this->db->where('resultID', $data['resultID'] /*record id*/);
		$this->db->update('resMulti' /*tablename*/, $data);
	}
	
	
	/*************************************************************************************/
	// FUNCTION populate_results($data)
	// Retrieves result form database to populate the 'edit' page
	/*************************************************************************************/
	function populate_results()
	{
		$this->db->select('*');
		$this->db->where('resultID', $this->uri->segment(4));
		$this->db->join('athletes', 'athletes.athleteID = resMulti.athleteID');
		$this->db->join('events', 'events.eventID = resMulti.eventID');
		$query = $this->db->get('resMulti');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
	}
	
	
	/*************************************************************************************/
	// FUNCTION delete_result_multi()
	// Deletes a single multi result based on its 'resultID'
	/*************************************************************************************/
	function delete_result_multi($data)
	{
		$this->db->where('resultID', $data);
		$this->db->delete('resMulti' /*tablename*/);
	}
	
	
		
		
} // ENDS class Multis_Model