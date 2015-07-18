<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News_con extends CI_Controller
{	
	
	function __construct()
	{
		parent::__construct();
		// AUTOLOADED FILES
		// Helpers: 	global
		// Models: 		global_model
		// Config: 		anz_settings
		// Libraries:	auth
		$this->is_logged_in();
		$this->load->model('admin/news_model');
	}
	
	
	/*************************************************************************************/
	// FUNCTION is_logged_in()
	// Checks to see if the administrator is logged in - if not redirect back to login page
	/*************************************************************************************/
	public function is_logged_in()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');	
		if(!isset($is_logged_in) || $is_logged_in != true)
		{
			redirect('admin/login_con', 'refresh');
		}
		
	} // ENDS is_logged_in()
	
	
	
	/*************************************************************************************/
	// FUNCTION index()
	// Displays the page (form) to add individual results
	/*************************************************************************************/
	public function index()
	{
		$data['token_admin'] = $this->auth->token_admin();
		$data['main_content'] = 'admin/add_news';
		$this->load->view('admin/ckedit'); //load ckeditor function
		$this->load->view('admin/includes/template', $data);
	
	} // ENDS index()
	
	
	
	/*************************************************************************************/
	// FUNCTION add_news()
	// Adds a new 'news article' to the database
	/*************************************************************************************/
	public function add_news()
	{
		$this->form_validation->set_rules('token_admin', 'Token Admin', 'trim|required');
		$this->form_validation->set_rules('type', 'Article Type', 'trim|required');
		$this->form_validation->set_rules('heading', 'Heading', 'trim|required');
		$this->form_validation->set_rules('bodyContent', 'Body', 'trim|required');
		
		//Create results $data array()
		$data = array(
			'type' => $this->input->post('type'),
			'heading' => $this->input->post('heading'),
			'bodyContent' => auto_link($this->input->post('bodyContent'), 'both', TRUE),
			'date' => date('Y-m-d')
		);
		
		// If form post data validates and CSRF $token == session $token update result
		if($this->form_validation->run() == TRUE && $this->input->post('token_admin') == $this->session->userdata('token_admin')) 
		{
		// Insert new athlete
		$this->news_model->add_news($data);
		
		echo $this->update_text_message = '<span class="message_success">New Article Added!</span>';
		
		echo '<p>' . $data['date'] . '</p>';
		echo '<p>' . $data['type'] . '</p>';
		echo '<p>' . $data['heading'] . '</p>';
		echo '<p>' . $data['bodyContent'] . '</p>';
		
		// Set up an attribute '<em>'
		// Why?
		// Because jQuery needs it to identify what the current resultID is
		// Then if admin wishes to delete the record - jQuery knows which one to delete
		// See this line in the results form page (var resultID = $("em").attr("title");)
		echo '<em title="' . $this->db->insert_id() . '"></em>';
		
    echo '<div class="dotted"></div>';
			
		} 
		else 
		{
			echo validation_errors('<div class="message_error">', '</div>') . '<br />';
		}
		
	} //ENDS add_news()
	
	
	
	/*************************************************************************************/
	// FUNCTION populate_news()
	// Retrieves news article details from database to populate the 'edit' page
	/*************************************************************************************/
	public function populate_news()
	{
		// Query to retrieve article to populate 'edit' page
		if($query = $this->news_model->populate_news())
		{
			$data['pop_news'] = $query;
		}
		
		$data['token_admin'] = $this->auth->token_admin();
		$data['main_content'] = 'admin/edit_news';
		$this->load->view('admin/ckedit'); //load ckeditor function
		$this->load->view('admin/includes/template', $data);
	
	} // ENDS populate_news()
	
	
	
	/*************************************************************************************/
	// FUNCTION update_news()
	// Edits a 'news article' to the database
	/*************************************************************************************/
	public function update_news()
	{
		$this->form_validation->set_rules('token_admin', 'Token Admin', 'trim|required');
		$this->form_validation->set_rules('newsID', 'News ID', 'trim|required');
		$this->form_validation->set_rules('type', 'Article Type', 'trim|required');
		$this->form_validation->set_rules('heading', 'Heading', 'trim|required');
		$this->form_validation->set_rules('bodyContent', 'Body', 'trim|required');
		
		//Create results $data array()
		$data = array(
			'newsID' => $this->input->post('newsID'),
			'type' => $this->input->post('type'),
			'heading' => $this->input->post('heading'),
			'bodyContent' => auto_link($this->input->post('bodyContent'), 'both', TRUE)
		);
		
		// If form post data validates and CSRF $token == session $token update result
		if($this->form_validation->run() == TRUE && $this->input->post('token_admin') == $this->session->userdata('token_admin')) 
		{
			// Update news article
			$this->news_model->update_news($data);
			echo $this->update_text_message = '<span class="message_success">Article Updated!</span>';
		} 
		else 
		{
			echo validation_errors('<div class="message_error">', '</div>') . '<br />';
		}
		
	} //ENDS update_news()
	
	
	
	/*************************************************************************************/
	// FUNCTION delete_news()
	// Deletes a single result based on its 'athleteID'
	/*************************************************************************************/
	public function delete_news()
	{
		$this->form_validation->set_rules('newsID', 'News ID', 'trim');
		
		$data = $this->input->post('newsID');
		
		if($this->form_validation->run() == TRUE) 
		{
			$this->news_model->delete_news($data);
			echo $this->update_text_message = '<span class="message_success">News Article Deleted!</span>';
		}
	
	} // ENDS delete_news()
	
	
	


} // ENDS class Athlete_con