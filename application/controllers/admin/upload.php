<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller
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
		$this->load->model('admin/advert_model');

		//$this->load->helper(array('form', 'url'));

		$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
		$this->output->set_header('Pragma: no-cache');
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

		$data['error'] = '';
		$data['main_content'] = 'admin/advert/upload_form';
		$this->load->view('admin/includes/template', $data);

	} // ENDS index()
	
	
	
	/*************************************************************************************/
	// FUNCTION do_upload()
	// Adds a new 'advert' to the database
	// Upload accompanying image to directory
	/*************************************************************************************/
	public function do_upload()
	{
		// Form validation rules ...
		$this->form_validation->set_rules('token_admin', 'Token Admin', 'trim|required');
		$this->form_validation->set_rules('campaign_title', 'Campaign Title', 'trim|required');
		$this->form_validation->set_rules('expires', 'Expires On', 'trim|required');
		$this->form_validation->set_rules('url_location', 'URL Location', 'trim|required');

		// File upload config options
		$config['upload_path'] = './img/adverts/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '1000';
		$config['max_width']  = '728';
		$config['max_height']  = '90';
		$config['remove_spaces'] = TRUE;

		// Rename file to the same as the 'Campaign Title'
		$config['file_name'] = $this->input->post('campaign_title');

		// Initilise $config items
		$this->load->library('upload', $config);
		$this->upload->initialize($config);


		//If form post data validates and CSRF $token == session $token update result
		if($this->form_validation->run() == TRUE && $this->input->post('token_admin') == $this->session->userdata('token_admin')) 
		{

			// Deletes ALL files in advert folder ...
			$dir_files = directory_map('./img/adverts/');
			$len = sizeOf($dir_files);
			for($i=0; $i<$len;$i++){
				unlink('./img/adverts/'.$dir_files[$i]);
			}

			// ONLY IF VALIDATION PASSES - then invoke the file (image) upload function
			if ( ! $this->upload->do_upload('advert_image') )
			{
				// Codeigniter image upload errors
				$error = array('error' => $this->upload->display_errors());

				// Send errors and view
				$data['token_admin'] = $this->auth->token_admin();
				$data['error'] = $error;
				$data['main_content'] = 'admin/advert/upload_form';
				$this->load->view('admin/includes/template', $data);
			
			} else {

				// 1. Codeigniter image success data
				$success = array('upload_data' => $this->upload->data());

				/*******************************************************/

				// 2. Create results $data array()
				$advert_data = array(
					'campaign_title' => $this->input->post('campaign_title'),
					'expires' => $this->input->post('expires'),
					'url_location' => $this->input->post('url_location'),
					'image_name' => str_replace(' ', '_', $this->input->post('campaign_title').$success['upload_data']['file_ext'])
				);

				/*******************************************************/
				
				// 3. Insert new advert
				$this->advert_model->add_advert($advert_data);

				/*******************************************************/
				// 5. Send success and view

				$data['success'] = $success;
				$data['main_content'] = 'admin/advert/upload_success';
				$this->load->view('admin/includes/template', $data);


			} // ENDS $this->upload->do_upload()


		} else {

			$data['token_admin'] = $this->auth->token_admin();

			$data['missing_field_errors'] = validation_errors('<div class="message_error"><i class="fa fa-times"></i> ', '</div>');
			$data['main_content'] = 'admin/advert/upload_form';
			$this->load->view('admin/includes/template', $data);

		} // ENDS $this->form_validation->run()

		
	} //ENDS Upload()
	

} // ENDS class Athlete_con