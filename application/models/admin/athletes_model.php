<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Athletes_Model extends CI_Model
{
    
	/*************************************************************************************/
	// FUNCTION add_athlete($data)
	// Adds a new 'athlete' to database
	/*************************************************************************************/
	function add_athlete($data)
	{
		$this->db->insert('athletes' /*tablename*/, $data);
		return $this->db->insert_id();
	}
	
	
	/*************************************************************************************/
	// FUNCTION populate_athlete($data)
	// Retrieves athlete details from database to populate the 'edit' page
	/*************************************************************************************/
	function populate_athlete()
	{
		$this->db->select('*');
		$this->db->where('athleteID', $this->uri->segment(4));
		$this->db->join('centre', 'centre.centreID = athletes.centreID');
		$this->db->join('club', 'club.clubID = athletes.clubID');
		$query = $this->db->get('athletes');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
	}
	
	
	/*************************************************************************************/
	// FUNCTION edit_athlete($data)
	// Edits an athletes details - saves them to database
	/*************************************************************************************/
	function edit_athlete($data)
	{
		$this->db->where('athleteID', $data['athleteID'] /*record id*/);
		$this->db->update('athletes' /*tablename*/, $data);
	}
	
	
	/*************************************************************************************/
	// FUNCTION delete_athlete()
	// Deletes a single result based on its 'athleteID'
	/*************************************************************************************/
	function delete_athlete($data)
	{
		$this->db->where('athleteID', $data);
		$this->db->delete('athletes' /*tablename*/);
	}

		
		
} // ENDS class Results_Model