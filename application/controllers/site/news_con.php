<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News_con extends CI_Controller {
	
	
	function __construct()
	{
		parent::__construct();
		// AUTOLOADED FILES
		// Helpers: 	global
		// Models: 		global_model
		// Config: 		anz_settings
		// Libraries:	auth
		$this->load->model('site/news_model');
		
	}

	
	/*************************************************************************************/
	// FUNCTION index()
	// Displays home page content including Athlete and Ranking search panels
	/*************************************************************************************/
	public function index()
	{
		// Get news data from database
		if($query = $this->news_model->archive_news())
		{
			$data['archive_news'] = $query;
		}
		
		$data['token'] = $this->auth->token();
		
		$data['main_content'] = 'site/news';
		$this->load->view('site/includes/template', $data);
	
	} // ENDS index()



	/*************************************************************************************/
	// FUNCTION news_item()
	// Displays a single news item - selected by the user from a link
	/*************************************************************************************/
	public function news_item()
	{
		// Get news data from database
		if($query = $this->news_model->news_item())
		{
			$data['news_item'] = $query;
		}
		
		$data['token'] = $this->auth->token();
		
		$data['main_content'] = 'site/newsItem';
		$this->load->view('site/includes/template', $data);
	
	} // ENDS index()
	
	
	
	
} //ENDS News_con class