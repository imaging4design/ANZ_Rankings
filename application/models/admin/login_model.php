<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {

	/*************************************************************************************/
	//Validates the user upon login
	/*************************************************************************************/
	public function validate()
	{
		$this->db->where('username', $this->input->post('username_anz'));
		$this->db->where('password', md5($this->input->post('password_anz')));
		$query = $this->db->get('admin');
		
		if($query->num_rows == 1)
		{
			return true;
		}
		
	} //ENDS validate()
	
	
	
} //ENDS class Login_model