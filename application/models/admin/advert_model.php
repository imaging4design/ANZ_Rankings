<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Advert_Model extends CI_Model
{
    
	/*************************************************************************************/
	// FUNCTION add_advert($data)
	// Adds a new 'advert' to database
	/*************************************************************************************/
	function add_advert($data)
	{
		$this->db->insert('advert' /*tablename*/, $data);
		return $this->db->insert_id();
	}
	
	
	/*************************************************************************************/
	// FUNCTION show_advert($data)
	// Displays the advert on the page
	/*************************************************************************************/
	function show_advert()
	{
		$this->db->select('*');
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('advert');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
	}
	
	
	/*************************************************************************************/
	// FUNCTION delete_news()
	// Deletes a news article - by newsID
	/*************************************************************************************/
	function delete_news($data)
	{
		$this->db->where('newsID', $data);
		$this->db->delete('news_info' /*tablename*/);
	}
	
	
	/*************************************************************************************/
	// FUNCTION populate_news($data)
	// Retrieves result form database to populate the 'edit' page
	/*************************************************************************************/
	function populate_news()
	{
		$this->db->select('*');
		$this->db->where('newsID', $this->uri->segment(4));
		$query = $this->db->get('news_info');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
	} // ENDS populate_news()
	
	
		
		
} // ENDS class News_Model



	