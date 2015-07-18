<?php
$this->css_path_url = base_url().'css/css_images/'; //CSS image path

/************************************************************/
//START IMPORTING WEBSITE SECTIONS
/************************************************************/
$this->load->view('admin/includes/header'); //Header and meta info

$this->load->view('admin/includes/menu'); //Site navigation menu

$this->load->view($main_content); //Main content

$this->load->view('admin/includes/footer'); //Footer info

?>