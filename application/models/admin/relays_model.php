<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Relays_Model extends CI_Model
{
    
	/*************************************************************************************/
	// FUNCTION add_new_relay($data)
	// Adds a new relay to the database
	/*************************************************************************************/
	function add_new_relay($data)
	{
		$this->db->insert('resRelays' /*tablename*/, $data);
		return $this->db->insert_id();
	}
	
	
	/*************************************************************************************/
	// FUNCTION update_relay($data)
	// Updates a relay to database
	/*************************************************************************************/
	function update_relay($data)
	{
		$this->db->where('resultID', $data['resultID'] /*record id*/);
		$this->db->update('resRelays' /*tablename*/, $data);
	}
	
	
	/*************************************************************************************/
	// FUNCTION populate_relays($data)
	// Retrieves record from database to populate the 'edit' page
	/*************************************************************************************/
	function populate_relays()
	{
		$this->db->select('*');
		$this->db->where('resultID', $this->uri->segment(4));
		$this->db->join('events', 'events.eventID = resRelays.eventID');
		$query = $this->db->get('resRelays');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
	}
	
	
	/*************************************************************************************/
	// FUNCTION delete_relay()
	// Deletes a single relay based on its 'resultID'
	/*************************************************************************************/
	function delete_relay($data)
	{
		$this->db->where('resultID', $data);
		$this->db->delete('resRelays' /*tablename*/);
	}
	
	
		
		
} // ENDS class Results_Model



	