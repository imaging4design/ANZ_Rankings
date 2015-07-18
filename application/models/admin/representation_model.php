<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Representation_Model extends CI_Model
{
    
	/*************************************************************************************/
	// FUNCTION add_new_record($data)
	// Adds a new record to the database
	/*************************************************************************************/
	function add_new_representation($data)
	{
		$this->db->insert('representations' /*tablename*/, $data);
		return $this->db->insert_id();
	}
	
	
	/*************************************************************************************/
	// FUNCTION update_record($data)
	// Updates a record to database
	/*************************************************************************************/
	function update_representation($data)
	{
		$this->db->where('id', $data['id'] /*record id*/);
		$this->db->update('representations' /*tablename*/, $data);
	}
	
	
	/*************************************************************************************/
	// FUNCTION populate_records($data)
	// Retrieves record from database to populate the 'edit' page
	/*************************************************************************************/
	function populate_representations()
	{
		$this->db->select('*');
		$this->db->where('id', $this->uri->segment(4));
		$this->db->join('events', 'events.eventID = representations.eventID');
		$query = $this->db->get('representations');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
	}
	
	
	/*************************************************************************************/
	// FUNCTION delete_record()
	// Deletes a single record based on its 'recordID'
	/*************************************************************************************/
	function delete_representation($data)
	{
		$this->db->where('id', $data);
		$this->db->delete('representations' /*tablename*/);
	}
	
	
		
		
} // ENDS class Representation_Model



	