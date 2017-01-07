<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Abbrev_con extends CI_Controller {
	
	
	function __construct()
	{
		parent::__construct();
		// AUTOLOADED FILES
		// Helpers: 	global
		// Models: 		global_model
		// Config: 		anz_settings
		// Libraries:	auth		
	}

	
	/*************************************************************************************/
	// FUNCTION index()
	// Displays info content for the 'Abbreviations' page
	/*************************************************************************************/
	public function index()
	{
		$data['main_content'] = 'site/includes/abbreviations';
		$this->load->view('site/includes/template', $data);
	
	} // ENDS index()
	

} //ENDS Abbrev_con class