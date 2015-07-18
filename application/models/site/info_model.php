<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Info_Model extends CI_Model
{
	
	
	public function __construct()
	{
		parent::__construct();
		//Stuff here
		
	} //ENDS __construct()
	
	
	
	/*************************************************************************************/
	// FUNCTION show_info()
	// Retrieves 'Info' articles to display on home page
	/*************************************************************************************/
	public function show_info()
	{
		$this->db->select('*');
		$this->db->select("DATE_FORMAT(date, '%d %b %Y') AS date", FALSE);
		$this->db->where('type', 'I'); // Is this a 'news' or 'info' item? 
		$this->db->order_by('newsID', 'DESC');
		$query = $this->db->get('news_info');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
		
	} //ENDS show_info()
	
	
		
} // ENDS class Info_Model