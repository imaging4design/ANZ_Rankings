<?php

	/********************************************************************************************************/

	// CONFIG AND CONVERSION FUNCTIONS
	
	/********************************************************************************************************/


	/***************************************************/
	// SPECIFY EVENT IDs ...
	/***************************************************/
	$sprints = array('1', '2', '3', '22', '23', '25'); // Sprints Track
	$middleTrack = array('4', '5', '6', '7', '8', '9', '10', '11', '20', '21'); // Middle DIstance Track
	$longTrack = array('16', '19'); // Long DIstance Track
	$field = array('26', '27', '28', '29', '30', '31', '32', '33'); // Field Events
	$multis = array('35', '36'); // Multi Events


	/***************************************************/
	// CONVERT TIME ...
	/***************************************************/

	// Middle Distance 'Time' converter
	function middleDistTime( $time = '00:00') {
		list( $mins, $secs ) = explode( ':', $time );
		return ( $mins * 60 ) + $secs;
	}

	// Long Distance 'Time' converter
	function longDistTime( $time = '00:00:00' ) {
		list( $hours, $mins, $secs ) = explode( ':', $time );
		return ( $hours * 3600 ) + ( $mins * 60 ) + $secs;
	}


	/***************************************************/
	// FORMAT TIME ...
	/***************************************************/

	// Time formatter - Middle Distance
	function convert_time_middle( $total_seconds, $divide_by_num )
	{
		$divide_by 			= sprintf( "%1.2f", ( $total_seconds / $divide_by_num ) ); 
		$milliseconds 		= substr( $divide_by, -3 );
		$seconds_only 		= substr( $divide_by, 0, -3 );
		$raw_time 			= gmdate( "H:i:s", $seconds_only ) . $milliseconds;
		$formatted_time 	= substr( $raw_time . $milliseconds, 3, 8 );

		return $formatted_time;
	}

	// Time formatter - Long Distance
	function convert_time_long( $total_seconds, $divide_by_num )
	{
		$divide_by 			= sprintf( "%1.2f", ( $total_seconds / $divide_by_num ) ); 
		$seconds_only 		= substr( $divide_by, 0, -3 );
		$raw_time 			= gmdate( "H:i:s", $seconds_only );
		$formatted_time 	= substr( $raw_time, 1, 8 );

		return $formatted_time;
	}



	/********************************************************************************************************/

	// DETERMIND THE EVENT TYPE
	
	/********************************************************************************************************/

	// Set the eventID var
	$this->eventID = $this->input->post('eventID');


	if( in_array($this->eventID, $sprints) ) {
		$type = 'sprints';

	} elseif ( in_array($this->eventID, $middleTrack) ) {
		$type = 'middleDistance';

	} elseif ( in_array($this->eventID, $longTrack) ) {
		$type = 'longDistance';

	} elseif ( in_array($this->eventID, $field) ) {
		$type = 'field';
		
	} else {
		$type = 'multis';
	}


	// START - Show medal image icon if position 1,2 or 3
	function show_medal( $position ) {

	    switch ($position)
	    {
	        case ( $position == '1' ):
	            $medal = array(
	                'src' => base_url() . 'img/icon_gold.png',
	                'alt' => 'Medal Position',
	                'width' => '12',
	                'height' => '12',
	                'style' => 'margin-top: -3px;'
	            );
	            $show_medal = img($medal);
	        break;
	        case ( $position == '2' ):
	            $medal = array(
	                'src' => base_url() . 'img/icon_silver.png',
	                'alt' => 'Medal Position',
	                'width' => '12',
	                'height' => '12',
	                'style' => 'margin-top: -3px;'
	            );
	            $show_medal = img($medal);
	        break;
	        case ( $position == '3' ):
	            $medal = array(
	                'src' => base_url() . 'img/icon_bronze.png',
	                'alt' => 'Medal Position',
	                'width' => '12',
	                'height' => '12',
	                'style' => 'margin-top: -3px;'
	            );
	            $show_medal = img($medal);
	        break;
	        default:
	            $show_medal = $position;
	    }

	    return $show_medal;

	}

?>

