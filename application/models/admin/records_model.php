<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Records_Model extends CI_Model
{
    
	/*************************************************************************************/
	// FUNCTION add_new_record($data)
	// Adds a new record to the database
	/*************************************************************************************/
	function add_new_record($data)
	{
		$this->db->insert('records' /*tablename*/, $data);
		return $this->db->insert_id();
	}
	
	
	/*************************************************************************************/
	// FUNCTION update_record($data)
	// Updates a record to database
	/*************************************************************************************/
	function update_record($data)
	{
		$this->db->where('recordID', $data['recordID'] /*record id*/);
		$this->db->update('records' /*tablename*/, $data);
	}
	
	
	/*************************************************************************************/
	// FUNCTION populate_records($data)
	// Retrieves record from database to populate the 'edit' page
	/*************************************************************************************/
	function populate_records()
	{
		$this->db->select('*');
		$this->db->where('recordID', $this->uri->segment(4));
		$this->db->join('events', 'events.eventID = records.eventID');
		$query = $this->db->get('records');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
	}

	// Use this for 'indoor records' - because of the two different event dropdowns ...
	function populate_records_in()
	{
		$this->db->select('*');
		$this->db->where('recordID', $this->uri->segment(4));
		$this->db->join('events_indoors', 'events_indoors.eventID = records.eventID');
		$query = $this->db->get('records');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
	}
	
	
	/*************************************************************************************/
	// FUNCTION delete_record()
	// Deletes a single record based on its 'recordID'
	/*************************************************************************************/
	function delete_record($data)
	{
		$this->db->where('recordID', $data);
		$this->db->delete('records' /*tablename*/);
	}
	
	
		
		
} // ENDS class Results_Model



	