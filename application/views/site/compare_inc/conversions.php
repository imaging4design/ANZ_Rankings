<?php

	/********************************************************************************************************/

	// SPRINT CONVERSIONS
	
	/********************************************************************************************************/

	if( $type == 'sprints' ) {

		if( $personal_best_a >= $personal_best_b ) {
			$best_diff = ($personal_best_a - $personal_best_b);
			$best_diff = '-' . sprintf("%0.2f", $best_diff);
			$class = 'blue';
		} else {
			$best_diff = ($personal_best_b - $personal_best_a);
			$best_diff = '-' . sprintf("%0.2f", $best_diff);
			$class = 'red';
		}


		if( $total_a_10 >= $total_b_10 ) {
			$raw_diff_10 = $total_a_10 - $total_b_10;
			$class_10 = 'blue';
		} else {
			$raw_diff_10 = $total_b_10 - $total_a_10;
			$class_10 = 'red';
		}


		if( $total_a_20 >= $total_b_20 ) {
			$raw_diff_20 = $total_a_20 - $total_b_20;
			$class_20 = 'blue';
		} else {
			$raw_diff_20 = $total_b_20 - $total_a_20;
			$class_20 = 'red';
		}

		$diff_10 = '-' . sprintf("%0.2f", $raw_diff_10 / 10);
		$diff_20 = '-' . sprintf("%0.2f", $raw_diff_20 / 20);

		$average_a_10 = sprintf("%0.2f", $total_a_10 / 10);
		$average_a_20 = sprintf("%0.2f", $total_a_20 / 20);

		$average_b_10 = sprintf("%0.2f", $total_b_10 / 10);
		$average_b_20 = sprintf("%0.2f", $total_b_20 / 20);

		$name_pb = ($athlete_data_a->time < $athlete_data_b->time) ? $athlete_data_a->nameLast : $athlete_data_b->nameLast;
		$name_10 = ($total_a_10 < $total_b_10) ? $athlete_data_a->nameLast : $athlete_data_b->nameLast;
		$name_20 = ($total_a_20 < $total_b_20) ? $athlete_data_a->nameLast : $athlete_data_b->nameLast;

	}



	/********************************************************************************************************/

	// MIDDLE DISTANCE CONVERSIONS
	
	/********************************************************************************************************/

	if( $type == 'middleDistance' ) {

		// PERSONAL BEST COMPARE
		/***************************************************************************************/
		// Work out the 'middle column' time differences for 'Athlete A' vs 'Athlete B'
		if( $personal_best_a >= $personal_best_b ) {
			$best_diff = middleDistTime( $personal_best_a ) - middleDistTime( $personal_best_b );
			$class = 'blue';
		} else {
			$best_diff = middleDistTime( $personal_best_b ) - middleDistTime( $personal_best_a);
			$class = 'red';
		}

		// Variable to display the above function
		$best_diff = '-' . convert_time_middle( $best_diff, 1 );


		// AVERAGE TOP 10 & 20 BEST COMPARE
		/***************************************************************************************/
		// Work out the 'middle column' time differences for 'Athlete A' vs 'Athlete B' averages

		$average_a_10 = ltrim(convert_time_middle( $total_a_10, 10 ), 0);
		$average_a_20 = ltrim(convert_time_middle( $total_a_20, 20 ), 0);
		$average_b_10 = ltrim(convert_time_middle( $total_b_10, 10 ), 0);
		$average_b_20 = ltrim(convert_time_middle( $total_b_20, 20 ), 0);

		if( $total_a_10 >= $total_b_10 ) {
			$raw_diff_10 = middleDistTime($average_a_10) - middleDistTime($average_b_10);
			$class_10 = 'blue';
		} else {
			$raw_diff_10 = middleDistTime($average_b_10) - middleDistTime($average_a_10);
			$class_10 = 'red';
		}

		if( $total_a_20 >= $total_b_20 ) {
			$raw_diff_20 = middleDistTime($average_a_20) - middleDistTime($average_b_20);
			$class_20 = 'blue';
		} else {
			$raw_diff_20 = middleDistTime($average_b_20) - middleDistTime($average_a_20);
			$class_20 = 'red';
		}

		// Variable to display the above function
		$diff_10 = '-' . convert_time_middle( $raw_diff_10, 1 );
		$diff_20 = '-' . convert_time_middle( $raw_diff_20, 1 );

	
		// Display the athelete name who has the superior performance
		$name_pb = ($athlete_data_a->time < $athlete_data_b->time) ? $athlete_data_a->nameLast : $athlete_data_b->nameLast;
		$name_10 = ($total_a_10 < $total_b_10) ? $athlete_data_a->nameLast : $athlete_data_b->nameLast;
		$name_20 = ($total_a_20 < $total_b_20) ? $athlete_data_a->nameLast : $athlete_data_b->nameLast;

	}



	/********************************************************************************************************/

	// LONG DISTANCE CONVERSIONS
	
	/********************************************************************************************************/

	if( $type == 'longDistance' ) {

		// PERSONAL BEST COMPARE
		/***************************************************************************************/
		// Work out the 'middle column' time differences for 'Athlete A' vs 'Athlete B'
		if( $personal_best_a >= $personal_best_b ) {
			$best_diff = longDistTime( $personal_best_a ) - longDistTime( $personal_best_b );
			$class = 'blue';
		} else {
			$best_diff = longDistTime( $personal_best_b ) - longDistTime( $personal_best_a);
			$class = 'red';
		}

		// Variable to display the above function
		$best_diff = '-' . convert_time_long($best_diff, 1);


		// AVERAGE TOP 10 & 20 BEST COMPARE
		/***************************************************************************************/
		// Work out the 'middle column' time differences for 'Athlete A' vs 'Athlete B' averages

		$average_a_10 = ltrim(convert_time_long( $total_a_10, 10 ), 0);
		$average_a_20 = ltrim(convert_time_long( $total_a_20, 20 ), 0);
		$average_b_10 = ltrim(convert_time_long( $total_b_10, 10 ), 0);
		$average_b_20 = ltrim(convert_time_long( $total_b_20, 20 ), 0);

		if( $total_a_10 >= $total_b_10 ) {
			$raw_diff_10 = longDistTime($average_a_10) - longDistTime($average_b_10);
			$class_10 = 'blue';
		} else {
			$raw_diff_10 = longDistTime($average_b_10) - longDistTime($average_a_10);
			$class_10 = 'red';
		}

		if( $total_a_20 >= $total_b_20 ) {
			$raw_diff_20 = longDistTime($average_a_20) - longDistTime($average_b_20);
			$class_20 = 'blue';
		} else {
			$raw_diff_20 = longDistTime($average_b_20) - longDistTime($average_a_20);
			$class_20 = 'red';
		}

		// Variable to display the above function
		$diff_10 = '-' . convert_time_long( $raw_diff_10, 1 );
		$diff_20 = '-' . convert_time_long( $raw_diff_20, 1 );


		$name_pb = ($athlete_data_a->time < $athlete_data_b->time) ? $athlete_data_a->nameLast : $athlete_data_b->nameLast;
		$name_10 = ($total_a_10 < $total_b_10) ? $athlete_data_a->nameLast : $athlete_data_b->nameLast;
		$name_20 = ($total_a_20 < $total_b_20) ? $athlete_data_a->nameLast : $athlete_data_b->nameLast;

	}



	/********************************************************************************************************/

	// FIELD EVENTS CONVERSIONS
	
	/********************************************************************************************************/

	if( $type == 'field' ) {

		if( $personal_best_a >= $personal_best_b ) {
			$best_diff = ($personal_best_a - $personal_best_b);
			$best_diff = '+' . sprintf("%0.2f", $best_diff);
			$class = 'red';
		} else {
			$best_diff = ($personal_best_b - $personal_best_a);
			$best_diff = '+' . sprintf("%0.2f", $best_diff);
			$class = 'blue';
		}


		if( $total_a_10 >= $total_b_10 ) {
			$raw_diff_10 = $total_a_10 - $total_b_10;
			$class_10 = 'red';
		} else {
			$raw_diff_10 = $total_b_10 - $total_a_10;
			$class_10 = 'blue';
		}

		if( $total_a_20 >= $total_b_20 ) {
			$raw_diff_20 = $total_a_20 - $total_b_20;
			$class_20 = 'red';
		} else {
			$raw_diff_20 = $total_b_20 - $total_a_20;
			$class_20 = 'blue';
		}

		$diff_10 = '+' . round($raw_diff_10 / 10, 2);
		$diff_20 = '+' . round($raw_diff_20 / 20, 2);

		$average_a_10 = sprintf("%0.2f", $total_a_10 / 10);
		$average_a_20 = sprintf("%0.2f", $total_a_20 / 20);

		$average_b_10 = sprintf("%0.2f", $total_b_10 / 10);
		$average_b_20 = sprintf("%0.2f", $total_b_20 / 20);

		$name_pb = ($athlete_data_a->distHeight > $athlete_data_b->distHeight) ? $athlete_data_a->nameLast : $athlete_data_b->nameLast;
		$name_10 = ($total_a_10 > $total_b_10) ? $athlete_data_a->nameLast : $athlete_data_b->nameLast;
		$name_20 = ($total_a_20 > $total_b_20) ? $athlete_data_a->nameLast : $athlete_data_b->nameLast;

	}
