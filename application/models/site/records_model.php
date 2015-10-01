<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Records_Model extends CI_Model
{
	
	
	public function __construct()
	{
		parent::__construct();
		//stuff here
		
	} //ENDS __construct()



	
	/*************************************************************************************/
	// FUNCTION current_nz_record()
	// Get the current NZ Record of this event to display at the top of the annual lists
	/*************************************************************************************/
	public function current_nz_record()
	{

		// Need this to grab both records from M19/M18 for juniors / youths etc
		switch ($this->input->post('ageGroup')){
			case 'MS':
				$this->ageGroup = 'MS';
			break;
			case 'M19':
				$this->ageGroup = array('M19', 'M18');
			break;
			case 'M17':
				$this->ageGroup = array('M17', 'M16');
			break;
			case 'WS':
				$this->ageGroup = 'WS';
			break;
			case 'W19':
				$this->ageGroup = array('W19', 'W18');
			break;
			case 'W17':
				$this->ageGroup = array('W17', 'W16');
			break;
		}


		$this->db->select('*');
		$this->db->select("DATE_FORMAT(records.date, '%d %b %Y') AS date", FALSE);
		$this->db->where('recordType', 'NN');
		$this->db->where('in_out', 'out');
		$this->db->where_in('ageGroup', $this->ageGroup);
		$this->db->where('records.eventID', $this->input->post('eventID'));
		$this->db->join('events', 'events.eventID = records.eventID');
		$this->db->order_by('ageGroup', 'DESC');
		$this->db->order_by('date', 'DESC');
		$query = $this->db->get('records');
		
		if($query->num_rows() > 0) 
		{
			return $query->result();
		}
		
		
	} //ENDS current_nz_record()
	
	
	
	/*************************************************************************************/
	// FUNCTION get_default()
	// Retrieves the default set of 'NZ Records' (Mens Open - Allcomers)
	/*************************************************************************************/
	public function get_default()
	{
		$this->db->select('*');
		$this->db->select("DATE_FORMAT(records.date, '%d %b %Y') AS date", FALSE);
		$this->db->where('recordType', 'NN');
		$this->db->where('in_out', 'out');
		$this->db->where('ageGroup', 'MS');
		$this->db->join('events', 'events.eventID = records.eventID');
		$this->db->order_by('records.eventID', 'ASC');
		$query = $this->db->get('records');
		
		if($query->num_rows() > 0) 
		{
			return $query->result();
		}
		
		
	} //ENDS get_default()
	
	
	
	/*************************************************************************************/
	// FUNCTION get_outdoor_records()
	// Retrieves 'NZ Records' based on Allcomers, National and Resident (OUTDOORS)
	/*************************************************************************************/
	public function get_outdoor_records()
	{
		$this->db->select('*');
		$this->db->select("DATE_FORMAT(records.date, '%d %b %Y') AS date", FALSE);
		$this->db->where('recordType', $this->input->post('recordType'));
		$this->db->where('in_out', 'out');
		$this->db->where('ageGroup', $this->input->post('ageGroup'));
		$this->db->join('events', 'events.eventID = records.eventID');
		$this->db->order_by('events.eventOrder', 'ASC');
		$query = $this->db->get('records');
		
		if($query->num_rows() > 0) 
		{
			return $query->result();
		}
		
		
	} //ENDS get_outdoor_records()
	
	
	
	/*************************************************************************************/
	// FUNCTION get_indoor_records()
	// Retrieves 'NZ Records' based on Allcomers, National and Resident (INDOORS)
	/*************************************************************************************/
	public function get_indoor_records()
	{
		$this->db->select('*');
		$this->db->select("DATE_FORMAT(records.date, '%d %b %Y') AS date", FALSE);
		$this->db->where('recordType', $this->input->post('recordType'));
		$this->db->where('in_out', 'in');
		$this->db->where('ageGroup', $this->input->post('ageGroup'));
		$this->db->join('events_indoors', 'events_indoors.eventID = records.eventID');
		$this->db->order_by('records.eventID', 'ASC');
		$query = $this->db->get('records');
		
		if($query->num_rows() > 0) 
		{
			return $query->result();
		}
		
		
	} //ENDS get_indoor_records()
	
	
	
		
} // ENDS class Records_Model