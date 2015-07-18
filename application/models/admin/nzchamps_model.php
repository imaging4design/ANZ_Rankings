<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Nzchamps_Model extends CI_Model
{
    
	/*************************************************************************************/
	// FUNCTION add_new_nzchamps($data)
	// Adds a new NZ Championship Medalist performance to the database
	/*************************************************************************************/
	function add_new_nzchamps($data)
	{
		$this->db->insert('nzchamps' /*tablename*/, $data);
		return $this->db->insert_id();
	}
	
	
	/*************************************************************************************/
	// FUNCTION update_nzchamps($data)
	// Updates a record to database
	/*************************************************************************************/
	function update_nzchamps($data)
	{
		$this->db->where('id', $data['id'] /*record id*/);
		$this->db->update('nzchamps' /*tablename*/, $data);
	}
	
	
	/*************************************************************************************/
	// FUNCTION populate_nzchamps()
	// Retrieves record from database to populate the 'edit' page
	/*************************************************************************************/
	function populate_nzchamps()
	{
		$this->db->select('*');
		$this->db->where('id', $this->uri->segment(4));
		$this->db->join('events', 'events.eventID = nzchamps.eventID');
		$query = $this->db->get('nzchamps');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
	}
	
	
	/*************************************************************************************/
	// FUNCTION delete_nzchamps()
	// Deletes a single record based on its 'recordID'
	/*************************************************************************************/
	function delete_nzchamps($data)
	{
		$this->db->where('id', $data);
		$this->db->delete('nzchamps' /*tablename*/);
	}
	
	
		
		
} // ENDS class Nzchamps_Model



	