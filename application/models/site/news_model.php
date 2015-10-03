<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class News_Model extends CI_Model
{
	
	
	public function __construct()
	{
		parent::__construct();
		//Stuff here
		
	} //ENDS __construct()
	
	
	
	/*************************************************************************************/
	// FUNCTION show_news()
	// Retrieves latest News articles to display on home page
	/*************************************************************************************/
	public function show_news()
	{
		$this->db->select('*');
		$this->db->select("DATE_FORMAT(date, '%d %b %Y') AS date", FALSE);
		$this->db->where('type', 'N'); // Is this a 'news' or 'info' item? 
		$this->db->order_by('newsID', 'DESC');
		$this->db->order_by('date', 'DESC');
		$this->db->limit(3);
		$query = $this->db->get('news_info');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
		
	} //ENDS show_news()



	/*************************************************************************************/
	// FUNCTION show_flash_news()
	// Retrieves latest 'Flash' News articles to display on home page
	/*************************************************************************************/
	public function show_flash_news()
	{
		$this->db->select('*');
		$this->db->select("DATE_FORMAT(date, '%d %b %Y') AS date", FALSE);
		$this->db->where('type', 'F'); // Is this a 'news' or 'info' item? 
		$this->db->order_by('newsID', 'DESC');
		$this->db->order_by('date', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('news_info');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
		
	} //ENDS show_flash_news()
	
	
	
	/*************************************************************************************/
	// FUNCTION archive_news()
	// Retrieves ALL news items (historical) - that don't appear on front page
	/*************************************************************************************/
	public function archive_news()
	{
		$this->db->select('*');
		$this->db->select("DATE_FORMAT(date, '%d %b %Y') AS date", FALSE);
		$this->db->where('type', 'N'); // Is this a 'news' or 'info' item? 
		$this->db->order_by('newsID', 'DESC');
		$this->db->order_by('date', 'DESC');
		$this->db->limit(12);
		$query = $this->db->get('news_info');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
		
	} //ENDS archive_news()



	/*************************************************************************************/
	// FUNCTION news_item()
	// Retrieves a single news item for display
	/*************************************************************************************/
	public function news_item()
	{
		$this->db->select('*');
		$this->db->select("DATE_FORMAT(date, '%d %b %Y') AS date", FALSE);
		$this->db->where('newsID', $this->uri->segment(4));
		$this->db->where('type', 'N'); // Is this a 'news' or 'info' item? 
		$query = $this->db->get('news_info');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
		
	} //ENDS news_item()
	
	
	
		
} // ENDS class News_Model