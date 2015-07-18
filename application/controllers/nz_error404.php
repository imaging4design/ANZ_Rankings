<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nz_error404 extends CI_Controller {

    // Display a custom 404 error page!
    public function __construct() 
    {
        parent::__construct(); 
    } 

    public function index() 
    { 
        $data['main_content'] = 'site/error';
        $this->load->view('site/includes/template', $data);
    } 
} 
?> 