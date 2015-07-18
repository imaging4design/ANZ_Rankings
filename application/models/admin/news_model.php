<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class News_Model extends CI_Model
{
    
	/*************************************************************************************/
	// FUNCTION add_news($data)
	// Adds a new 'news article' to database
	/*************************************************************************************/
	function add_news($data)
	{
		$this->db->insert('news_info' /*tablename*/, $data);
		return $this->db->insert_id();
	}
	
	
	/*************************************************************************************/
	// FUNCTION update_news($data)
	// Adds a new 'news article' to database
	/*************************************************************************************/
	function update_news($data)
	{
		$this->db->where('newsID', $data['newsID'] /*record id*/);
		$this->db->update('news_info' /*tablename*/, $data);
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



	