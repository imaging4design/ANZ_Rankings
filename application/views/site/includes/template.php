<?php
$this->css_path_url = base_url().'css/css_images/'; //CSS image path
$this->archive_path_url = base_url().'files/archives/'; //Archived lists path
$this->recordApp_path_url = base_url().'files/record_apps/'; //Archived lists path

/************************************************************/
//START IMPORTING WEBSITE SECTIONS
/************************************************************/
$this->load->view('site/includes/header'); // Header and meta info

$this->load->view('site/includes/menu'); // Top Nav Menu
	
	// Only show masthead on opening 'index.php' page
	if( ! $this->uri->segment(1) )
	{
		$data['show_news'] = show_news(); // Inject ($show_news) data into all pages via 'masthead' via global_helper
		$this->load->view('site/includes/masthead', $data); // Masthead
	}
	


	/*****************************************************************************************************************************/
	// DO NOT SHOW 'Search Bar' in these uri's !!!
	
	$hide_search = array('news_con', 'archive_lists', 'publications', 'records_con', 'standards_con', 'info_con', 'contact'); 

	if( ! in_array( $this->uri->segment(2), $hide_search ) && ! in_array( $this->uri->segment(3), $hide_search ) )
	{
		$this->load->view('site/includes/abbreviations'); // Abbreviations

		$this->load->view('site/includes/search'); // 'Search Bar'
		
	}
	/*****************************************************************************************************************************/


$this->load->view($main_content); // Main content

$this->load->view('site/includes/footer'); // Footer

?>