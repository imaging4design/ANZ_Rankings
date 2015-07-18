<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Helper function to retrieve views data for each page
 * 
 */

/********************************************************************/
// FUNCTION find_qual_dates()
// Returns the 'Qualification Dates' of the selected Championship
/********************************************************************/
function find_qual_dates( $data )
{
	$CI = &get_instance();
	//$CI->load->model('site/team_model');
	$var = $CI->team_model->find_qual_dates( $data );

	//return the data $query
	if($query = $var) 
	{
		return $query;
	}

}



/********************************************************************/
// FUNCTION find_qual_marks()
// Returns the 'Qualifying Standards' of the selected Championship
/********************************************************************/
function find_qual_marks( $data )
{
	$CI = &get_instance();
	//$CI->load->model('site/team_model');
	$var = $CI->team_model->find_qual_marks( $data );

	//return the data $query
	if($query = $var) 
	{
		return $query;
	}

}



/********************************************************************/
// FUNCTION buildEventsDropdown()
// Creates drop down menu for ALL events
// Function accepts three arguements
// 1) $value - if specified, this will be the posted 'value'
// 2) $selected - if specified, this will be the 'option' selected
// 3) $label - if specified, this will be the 'option name' selected
/********************************************************************/
function champsDropdown($value='', $selected='', $label='')
{
	$CI = &get_instance();
	//$CI->load->model('site/team_model');
	$var = $CI->team_model->champsDropdown();

	$data = array();
	//gets the list of categorys to display in left column
	if($query = $var)
	{
		$data = $query;
	}

	echo '<select name="champID" class="span3" id="champID">';

	if($value)
	{
		echo '<option value="'.$value.'"'.set_select('champID', $selected).'>'.$label.'</option>';
	}
	else
	{
		echo '<option value="" selected="selected">Select Championship</option>';
	}

	foreach($data as $row):
		echo '<option value="'.$row->id.'"'.set_select('champID', $row->id).'>'.$row->shortName.'</option>';
	endforeach;	

	echo '</select>';


}