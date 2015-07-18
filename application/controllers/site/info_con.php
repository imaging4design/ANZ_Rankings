<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Info_con extends CI_Controller {
	
	
	function __construct()
	{
		parent::__construct();
		// AUTOLOADED FILES
		// Helpers: 	global
		// Models: 		global_model
		// Config: 		anz_settings
		// Libraries:	auth
		$this->load->model('site/info_model');
		
	}

	
	/*************************************************************************************/
	// FUNCTION index()
	// Displays info content for the 'General Information' page
	/*************************************************************************************/
	public function index()
	{
		// Get news data from database
		if($query = $this->info_model->show_info())
		{
			$data['info'] = $query;
		}
		
		$data['token'] = $this->auth->token();
		
		$data['main_content'] = 'site/info';
		$this->load->view('site/includes/template', $data);
	
	} // ENDS index()
	
	
	
	
} //ENDS Info_con class