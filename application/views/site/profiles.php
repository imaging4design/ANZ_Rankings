<div class="container">

	<div class="row">

		<div id="top_profile"></div><!-- TARGET - this is where the page will auto scroll to after form is submited -->
		
		<?php
		// IF ADMIN IS LOGGED IN -> ALLOW ADMIN TO SELECT A RESULT TO EDIT
		$admin = ( $this->session->userdata('is_logged_in') ) ? TRUE : FALSE;
		?>

		<?php
		/************************************************************************************************************************************************************/

		// CONFIGURE THE EVENT TITLE AND YEAR above the results (i.e., 100m / Javelin Throw)

		/************************************************************************************************************************************************************/
		$event_name = '';
		$year = '';

		if(isset($event_info))
		{

		foreach($event_info as $event):

			if($event->eventID == $this->input->post('eventID'))
			{
				// Get event label
				$event_name = $event->eventName;

				// Get year label
				$year = ($this->input->post('year') == 0) ? 'All (from 2008)' : $this->input->post('year');
			}

		endforeach;

		}

		echo '<div class="span12">';

			// Display error message if no selections are made
			if(isset($this->error_message))
			{
				echo $this->error_message;
			}

			echo '</div>';

		echo '</div>';

		

		echo '<div class="row">';

		echo '<div class="span6">';

		

			/************************************************************************************************************************************************************/

			// TOP SECTION CONTAINING THE ATHLETE DETAILS (Date of Birth, Age, Club and Coaches)

			/************************************************************************************************************************************************************/
			if( $athlete )
			{
				// Initiate these vars
				$DOB = FALSE;
				$coach = FALSE;
				$coach_former = FALSE;

				// Configure these vars
				$DOB = ( $athlete->birthDate ) ? $athlete->birthDate : '';
				$coach = ( $athlete->coach ) ? $athlete->coach : 'n/a';
				$coach_former = ( $athlete->coach_former != '' ) ? '<p>Former Coach(es): ' . $athlete->coach_former . '</p>' : ''; // Only show if they have one!
				
				// Display Athlete Name Date of Birth details
				echo '<div class="slab reversed textLarge">' . $athlete->nameFirst . ' ' . strtoupper($athlete->nameLast) . '</div>';
				echo '<div style="clear:both;"></div>';
				echo '<div class="slab reversed textMed">Date of Birth</div><div class="slab textMed red">' . $DOB . '</div><br>';
				
				// Only display athlete age (in years / days) if they are still alive
				if( in_array( $athlete->athleteID, $this->config->item('passed') ))
				{
					echo '<div class="slab reversed textSmall">Age </div><div class="slab textSmall red"><img src="../../../css/css_images/icons/cross.png"></div>';
				}
				else {
					echo '<div class="slab reversed textSmall">Age </div><div class="slab textSmall red">' . age_from_dob($athlete->DOB) . ' years ' . daysLeftForBirthday($athlete->DOB) . ' days</div>';
				}

				echo '<div style="clear:both;"></div>';




				if($this->uri->segment(3) != 'athlete')
				{
					// Display the 'View Best Perfomances' button
					echo anchor('site/profiles_con/athlete/' . $athlete->athleteID, 'View Full Profile', array('class' => 'btn', 'style' => 'margin-top:5px;'));
				}

		echo '</div>';


		echo '<div class="span6">';

				// Display Athlete Club and Coach Details
				echo '<div class="hidden-phone">';
					echo '<div class="slab reversed textSmall">' . $athlete->clubName . ', ' . $athlete->centreID . '</div>';
					echo '<div style="clear:both;"></div>';
					echo '<div class="slab reversed textSmall">Coach</div><div class="slab textSmall red">' . $coach . '</div>';
					echo '<div style="clear:both;"></div>';
					echo $coach_former;
				echo '</div>';

				
				if($admin)
				{
					// FOR ADMIN - Add link to edit athlete details
					echo anchor('admin/athlete_con/populate_athlete/' . $athlete->athleteID, 'EDIT ATHLETE', array( 'class' => 'btn', 'style' => 'margin:0 5px 0 0;' ) );
					echo anchor('admin/representation_con/add_representation/' . $athlete->athleteID, 'ADD REPRESENTATION', array( 'class' => 'btn', 'style' => 'margin:0 5px 0 0;' ) );
					echo anchor('admin/nzchamps_con/add_nzchamps/' . $athlete->athleteID, 'ADD NZ MEDALS', array( 'class' => 'btn' ) );
				}

			}


			?>

		</div><!--ENDS span6-->

	</div><!--ENDS row-->



	


	<div class="row">

		<div class="span12">
			<?php

			/************************************************************************************************************************************************************/

			// DISPLAYS EACH ATHLETES 'NZ CHAMPIONSHIPS MED PERFORMANCES'

			/************************************************************************************************************************************************************/

			// Get list of athlete 'NZ Medal Performances'
			$athleteID = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : substr($this->input->post('athleteID'), -6);

			$nzchamps = get_nzchamps($athleteID);

			if( isset( $nzchamps ) && ! $this->input->post('eventID') ) // Hide the honours list when looking at athletes individual events!
			{

			echo '<hr>';
			echo '<div class="slab reversed textMed">NZ Championships Medals</div><div class="slab textMed blue">(from 2010)</div>';

			echo '<table class="footable table-striped">
					<thead>
						<tr>
							<th data-class="expand" class="w20">Year</th>
							<th>Event</th>
							<th data-hide="phone" class="w20">Age Group</th>
							<th data-hide="phone" class="w20">Performance</th>
							<th data-hide="phone" class="w20 right">Position</th>
						</tr>

			</thead>
			<tbody>';


				// Loop through and display
				foreach ($nzchamps as $row) {

					// Correctly label Age Groups
					$ageGroup = $row->ageGroup;

					switch ($ageGroup)
					{
						case ($ageGroup == 'MS'): $row->ageGroup = 'Open Men'; break;
						case ($ageGroup == 'M19'): $row->ageGroup = 'Junior Men'; break;
						case ($ageGroup == 'M18'): $row->ageGroup = 'M19'; break;
						case ($ageGroup == 'M17'): $row->ageGroup = 'Youth Men'; break;
						case ($ageGroup == 'M16'): $row->ageGroup = 'M16'; break;
						case ($ageGroup == 'WS'): $row->ageGroup = 'Open Women'; break;
						case ($ageGroup == 'W19'): $row->ageGroup = 'Junior Women'; break;
						case ($ageGroup == 'W18'): $row->ageGroup = 'W19'; break;
						case ($ageGroup == 'W17'): $row->ageGroup = 'Youth Women'; break;
						case ($ageGroup == 'W16'): $row->ageGroup = 'W16'; break;
					}


					// START - Show medal image icon if position 1,2 or 3
					$medal_pos = $row->position;

					switch ($medal_pos)
					{
						case ( $medal_pos == '1' ):
							$medal = array(
								'src' => base_url() . 'img/icon_gold.png',
								'alt' => 'Medal Position',
								//'class' => 'post_images',
								'width' => '20',
								'height' => '20'
							);
							$show_medal = img($medal);
						break;
						case ( $medal_pos == '2' ):
							$medal = array(
								'src' => base_url() . 'img/icon_silver.png',
								'alt' => 'Medal Position',
								//'class' => 'post_images',
								'width' => '20',
								'height' => '20'
							);
							$show_medal = img($medal);
						break;
						case ( $medal_pos == '3' ):
							$medal = array(
								'src' => base_url() . 'img/icon_bronze.png',
								'alt' => 'Medal Position',
								//'class' => 'post_images',
								'width' => '20',
								'height' => '20'
							);
							$show_medal = img($medal);
						break;
						default:
							$show_medal = $row->position;
					}
					// END - Show medal image icon if position 1,2 or 3

					$edit = NULL;

					if($admin)
					{
						$edit = anchor('admin/nzchamps_con/populate_nzchamps/' . $row->id . '/' . $this->uri->segment(4) , ' - Edit');
					}

					
					echo '<tr>
							<td class="w20">' . $row->year . ' ' . $edit . '</td>
							<td>' . $row->eventName . '</td>
							<td class="w20">' . $row->ageGroup . '</td>
							<td class="w20">' . $row->performance . '</td>
							<td class="w20 right">' . $show_medal . '</td>
						</tr>';
					
				}
			}

			echo '</tbody>';
			echo '</table>';

			?>

		</div>





		


		<div class="span12">
			<?php

			/************************************************************************************************************************************************************/

			// DISPLAYS EACH ATHLETES 'HONOURS / NZ REPRESENTATIONS'

			/************************************************************************************************************************************************************/

			// Get list of athlete 'Honours' and 'Representation'
			$athleteID = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : substr($this->input->post('athleteID'), -6);

			$reps = get_representations($athleteID);

			if( isset( $reps ) && ! $this->input->post('eventID') ) // Hide the honours list when looking at athletes individual events!
			{

			echo '<hr>';
			echo '<div class="slab reversed textMed">New Zealand Representation</div><div class="slab textMed blue">(from 2002)</div>';

			echo '<table class="footable table-striped">
					<thead>
						<tr>
							<th data-class="expand" class="w15">Year</th>
							<th>Competition</th>
							<th data-hide="phone" class="w15">Event</th>
							<th data-hide="phone" class="w15">Performance</th>
							<th data-hide="phone" class="w15 right">Position</th>
						</tr>

			</thead>
			<tbody>';


				// Loop through and display
				foreach ($reps as $row) {


					// START - Show medal image icon if position 1,2 or 3
					$medal_pos = $row->position;

					switch ($medal_pos)
					{
						case ( $medal_pos == '1' ):
							$medal = array(
								'src' => base_url() . 'img/icon_gold.png',
								'alt' => 'Medal Position',
								//'class' => 'post_images',
								'width' => '20',
								'height' => '20'
							);
							$show_medal = img($medal);
						break;
						case ( $medal_pos == '2' ):
							$medal = array(
								'src' => base_url() . 'img/icon_silver.png',
								'alt' => 'Medal Position',
								//'class' => 'post_images',
								'width' => '20',
								'height' => '20'
							);
							$show_medal = img($medal);
						break;
						case ( $medal_pos == '3' ):
							$medal = array(
								'src' => base_url() . 'img/icon_bronze.png',
								'alt' => 'Medal Position',
								//'class' => 'post_images',
								'width' => '20',
								'height' => '20'
							);
							$show_medal = img($medal);
						break;
						default:
							$show_medal = $row->position;
					}
					// END - Show medal image icon if position 1,2 or 3

					$edit = NULL;

					if($admin)
					{
						$edit = anchor('admin/representation_con/populate_representation/' . $row->id . '/' . $this->uri->segment(4) , ' - Edit');
					}

					
					echo '<tr>
							<td class="w15">' . $row->year . ' ' . $edit . '</td>
							<td>' . $row->competition . '</td>
							<td class="w15">' . $row->eventName . '</td>
							<td class="w15">' . $row->performance . '</td>
							<td class="w15 right">' . $show_medal . '</td>
						</tr>';
					
				}
			}

			echo '</tbody>';
			echo '</table>';

			?>

		</div>



		<div class="span12">
  	
  
			<?php
			/************************************************************************************************************************************************************/

			// DISPLAYS EACH ATHLETES PERSONAL BEST PERFORMANCES (in each 'INDIVIDUAL' event)

			/************************************************************************************************************************************************************/
			if( isset( $personal_bests ) )
			{
				
				echo '<br>';
				echo '<div class="slab reversed textMed">Best Performances</div><div class="slab textMed blue">(from 2008)</div>';

				echo '<table class="footable table-striped">
						<thead>
							<tr>
								<th data-class="expand"  class="w5">Event</th>
								<th data-hide="phone" class="w10 muted">Implement</th>
								<th class="w10">Perf</th>
								<th data-hide="phone,tablet" class="w5">Wind</th>
								<th data-hide="phone,tablet" class="w5">Place</th>
								<th data-hide="phone,tablet">Competition</th>
								<th data-hide="phone" class="w15">Venue</th>
								<th class="w15 right">Date</th>
							</tr>

				</thead>
				<tbody>';
				


				foreach($personal_bests as $row)
				{	
					// TIME/DISTHEIGHT - Is performance a time or distance/height?
					$performance = ( $row->time ) ? ltrim($row->time, 0) : ltrim($row->distHeight, 0);

					// This adds a highlight class to those rankings less than a week old!
					$dateClass = fresh_results($row->date); // from global_helper.php

					echo '<tr>
							<td class="w10">' . $row->eventName . '</td>
							<td class="w10"><span class="muted">' . ltrim($row->implement,0) . '</span></td>
							<td class="w10"><span class="'.$dateClass.'">' . $performance . '</span> ' . $row->record . '</td>
							<td class="w5">' . $row->wind . '</td>
							<td class="w5">' . $row->placing . '</td>
							<td>' . $row->competition . '</td>
							<td class="w15">' . $row->venue . '</td>
							<td class="w15 right">' . $row->date . '</td>
						</tr>';
				
				}

				//echo '</tbody>';
				//echo '</table>';
				
			}

			?>
			



			<?php
			/************************************************************************************************************************************************************/

			// DISPLAYS EACH ATHLETES PERSONAL BEST PERFORMANCES (in each 'MULTI' event)

			/************************************************************************************************************************************************************/
			if( isset( $personal_bests_multis ) )
			{

				foreach($personal_bests_multis as $row)
				{

					$performance = '<span class="strong">' . ltrim($row->MAX_points, 0) . '</span>';

					$data='';

					// Create an array of each 'discipline' result within the Decathlon / Heptathlon
					$discipline = array($row->e01, $row->e02, $row->e03, $row->e04, $row->e05, $row->e06, $row->e07, $row->e08, $row->e09, $row->e10);

					// Loop through each 'discipline' result
					// Assign it to $mark
					// Display it as reduce_multiples($data)
					foreach($discipline as $mark)
					{ 
						$data .= $mark . '&nbsp; <span class="textRed">|</span> &nbsp;'; 
					}

					// This adds a highlight class to those rankings less than a week old!
					$dateClass = fresh_results($row->date); // from global_helper.php

					echo '<tr>
							<td class="w10">' . $row->eventName . '</td>
							<td class="w10">&nbsp;</td>
							<td class="w10"><span class="'.$dateClass.'">' . $performance . '</span></td>
							<td class="w5">&nbsp;</td>
							<td class="w5">' . $row->placing . '</td>
							<td>' . $row->competition . '</td>
							<td class="w15">' . $row->venue . '</td>
							<td class="w15 right">' . $row->date . '</td>
						</tr>
						<tr>
							<td colspan="8">' .reduce_multiples($data, '&nbsp; <span class="textRed">|</span> &nbsp;', TRUE) . '</td>
						</tr>';

				}

				echo '</tbody>';
				echo '</table>';
			}
			else
			{
				echo '</tbody>';
				echo '</table>';
			}
			?>

	




	


























	<?php
	/*
	|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	|
	|  START 'Year by Year' PROGESSIONS HERE
	|
	|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	*/

	/************************************************************************************************************************************************************/
	// INDIVIDULAL EVENTS - DISPLAYS ATHLETES PERSONAL YEARLY PROGRESSION
	/************************************************************************************************************************************************************/

	$event = get_athlete_events(); // from profile_helper.php

	echo '<br>'; // Keep this as separator

	// DON'T SHOW THIS DATA IF USER HAS SELECTED 
	// TO SEE A SPECIFIC EVENT FROM THE DROP DOWNS 
	// (this would post 'token')
	if( ! $this->input->post('token') )
	{
		
		echo '<div class="slab reversed textMed">Annual Progressions</div>';
		echo '<div style="clear:both;"></div>';

		foreach($event as $row)
		{
			
			$progessions = progessions( $row->eventID ); // From profile_helper.php

			// Display the Event Title heading
			echo '<div class="slab textMed red">'. $row->eventName .'</div>';

			if( isset( $progessions ) )
			{
				
				echo '<table class="footable table-striped" style="margin-bottom:20px;">
					<thead>
						<tr>
							<th data-class="expand" class="w10">Year</th>
							<th data-hide="phone" class="w10 muted">Implement</th>
							<th class="w10">Perf</th>
							<th data-hide="phone,tablet" class="w5">Wind</th>
							<th data-hide="phone,tablet" class="w5">Place</th>
							<th data-hide="phone,tablet">Competition</th>
							<th data-hide="phone" class="w15">Venue</th>
							<th class="w15 right">Date</th>
						</tr>

					</thead>

				<tbody>';



					foreach($progessions as $row)
					{
					
						// TIME/DISTHEIGHT - Is performance a time or distance/height?
						$performance = ( $row->time ) ? ltrim($row->time, 0) : ltrim($row->distHeight, 0);


						// WIND - Is this is a windy performance? If so, show (w) symbol
						$wind = ( $row->wind > 2.0 or $row->wind == 'nwr' ) ? '(w)' : '';
						$hand_timed = ( $row->record == 'ht' ) ? '(ht)' : '';


						// IMPORTANT! - initiate this var
						$best_legal = FALSE;


						// SHOWS BEST LEGAL MARK (only if athlete best mark is wind-aided)
						if( in_array($row->eventID, $this->config->item('track_events_wind')) or in_array($row->eventID, $this->config->item('field_events_wind')) )
						{
							$best_legal = legal_vs_windy_profile($row->athleteID, $row->eventID, $row->year);

							// This adds a highlight class to those rankings less than a week old!
							if( $best_legal )
							{
								$dateClass = fresh_results($best_legal->date); // from global_helper.php
							}
							
						}

						
							/********************************************************************************************************/
							// Display athlete best LEGAL performance ONLY!

							if( $best_legal && ($row->wind > 2.0 || $row->wind === 'nwr' || $row->record === 'ht') )
							{
								$extra_row = '<tr>
												<td class="w10">&nbsp;</td>
												<td class="w10"><span class="muted">' . ltrim($row->implement,0) . '</span></td>
												<td class="w10"><span class="'.$dateClass.'">' . ltrim($best_legal->legal_time, 0) . ' ' . ltrim($best_legal->legal_distHeight, 0) . '</span></td>
												<td class="w5"></td>
												<td class="w5">' . $best_legal->placing . '</td>
												<td>' . $best_legal->competition . '</td>
												<td class="w15">' . $best_legal->venue . '</td>
												<td class="w15 right">' . $best_legal->date . '</td>
											</tr>';
							}
							else
							{
								$extra_row = '';
							}

						// Display athlete best LEGAL performance ONLY!
						/********************************************************************************************************/

						$dateClass = fresh_results($row->date); // from global_helper.php


						// Display athlete best performance regardless of wind reading
						echo 	'<tr>
									<td class="w10">' . $row->year . '</td>
									<td class="w10"><span class="muted">' . ltrim($row->implement,0) . '</span></td>
									<td class="w10"><span class="'.$dateClass.'">' . $performance . '</span></td>
									<td class="w5">' . $wind . ' ' . $hand_timed . ' </td>
									<td class="w5">' . $row->placing . '</td>
									<td>' . $row->competition . '</td>
									<td class="w15">' . $row->venue . '</td>
									<td class="w15 right">' . $row->date . '</td>
								</tr>
								' . $extra_row . ' ';

					}

				echo '</tbody>';
				echo '</table>';

			}

		}



		/************************************************************************************************************************************************************/
		// INDIVIDULAL EVENTS - DISPLAYS ATHLETES PERSONAL YEARLY PROGRESSION
		/************************************************************************************************************************************************************/
		$progessions_multis = progessions_multis( $row->eventID ); // From profile_helper.php

		if( isset( $progessions_multis ) )
		{
				
				echo '<table class="footable table-striped" style="margin-bottom:20px;">
					<thead>
						<tr>
							<th data-class="expand" class="w10">Year</th>
							<th class="w10">Perf</th>
							<th data-hide="phone,tablet" class="w10">Place</th>
							<th data-hide="phone,tablet">Competition</th>
							<th data-hide="phone" class="w15">Venue</th>
							<th class="w15 right">Date</th>
						</tr>
					</thead>
				<tbody>';

				foreach($progessions_multis as $row)
				{
					// This adds a highlight class to those rankings less than a week old!
					$dateClass = fresh_results($row->date); // from global_helper.php

					echo 	'<tr>
								<td class="w10">' . $row->year . '</td>
								<td class="w10"><span class="'.$dateClass.'">' . $row->points . '</span></td>
								<td class="w10">' . $row->placing . '</td>
								<td>' . $row->competition . '</td>
								<td class="w15">' . $row->venue . '</td>
								<td class="w15 right">' . $row->date . '</td>
							</tr>';

				}

				echo '</tbody>';
				echo '</table>';

		}



	} // ENDS if( ! $this->input->post('token') )
	
	?>

	


	
  
  
  	

  
  	




























  	<?php
	/**************************************************************************************************/
	// PROFILE RESULTS FOR (INDIVIDUAL) EVENTS
	/**************************************************************************************************/
	if(isset($athlete_data))
	{
		
		// Display the Event Title heading
		echo '<div class="slab reversed textMed">' . $event_name . '</div><div class="slab textMed bg_red">'. $year .'</div>';

		echo '<table class="footable table-striped" style="margin-bottom:20px;">
				<thead>
					<tr>
						<th data-class="expand" class="w5">Rank</th>
						<th class="w10">Perf</th>
						<th data-hide="phone,tablet" class="w10">Wind</th>
						<th data-hide="phone,tablet" class="w5">Note</th>
						<th data-hide="phone,tablet" class="w5">Place</th>
						<th data-hide="phone">Competition</th>
						<th data-hide="phone" class="w15">Venue</th>
						<th class="w15 right">Date</th>
					</tr>

				</thead>
			<tbody>';


					
		
		// Initiate some label vars
		$eventID = $this->input->post('eventID');
		$label = FALSE;
		$label_looped = FALSE;
		$rank = 1;
		$cur_performance = NULL;
		
		
		/**************************************************************************************************/
		// DISPLAY EVENTS THAT NEED TO BE SEPARATED BY IMPLEMENT WEIGHT / HURDLE HEIGHTS
		/**************************************************************************************************/
		// Is the selected event in the $this->config->item('seperate_performances')?
		// If so, loop through results - separating them into implement weight or hurdle height clusters
		
		if(in_array($eventID, $this->config->item('seperate_performances')))
		{
			
			foreach($athlete_data as $row):

				//Indoor / outdoor performance
				$in_out = ( $row->in_out == 'in' ) ? '<span class="strong">i</span>' : '';
			
				// Create implement weight / hurdle height labels to define each cluster section
				$label = ltrim($row->implement, 0);


				if($label_looped != $label)
				{
					echo '<tr><td colspan="8"><h4>' . $label . '</h4></td></tr>';
				}

				if($label_looped != $label)
				{
					$rank = 1;
				}
					
					$performance = ($row->time) ? ltrim($row->time, 0) : ltrim($row->distHeight, 0);
					
					if($admin) // Display editable link (on performance column)
					{
						$performance = anchor('admin/results_con/populate_results/' . $row->resultID, $performance);
					}

					// This adds a highlight class to those rankings less than a week old!
					$dateClass = fresh_results($row->date); // from global_helper.php

					// When displaying 'Rank' number - show = sign if performances are the same!
					$rank_style = ( $cur_performance === $performance ) ? '' : $rank;

					echo '<tr>
								<td class="w5">' . $rank_style . '</td>
								<td class="w10"><span class="'.$dateClass.'">' . $performance . ' ' . $in_out . '</span></td>
								<td class="w10">' . $row->wind . '</td>
								<td class="w5">' . $row->record . '</td>
								<td class="w5">' . $row->placing . '</td>
								<td>' . $row->competition . '</td>
								<td class="w15">' . $row->venue . '</td>
								<td class="w15 right">' . $row->date . '</td>
							</tr>';
								
					$rank++;
					$label_looped = $label; // Monitor this value

					// Remove 'Tied' ranked function if 'Order By Date'
					if( $this->input->post('order_by') !=1)
					{
						$cur_performance = $performance; // Monitor this value
					}
										
					
			endforeach;

			//if( $this->input->post('order_by')) { echo 'by date'; }
			
			
		} // ENDS if(in_array($eventID, $this->config->item('seperate_performances')))
		
		
		/**************************************************************************************************/
		// DISPLAY EVENTS THAT DON'T NEED TO BE SEPARATED BY IMPLEMENT WEIGHT / HURDLE HEIGHTS
		/**************************************************************************************************/
		else
		{
			foreach($athlete_data as $row):
			
				//Indoor / outdoor performance
				if($row->in_out == 'in')
				{
					$in_out = '<span class="strong">i</span>';
				}
				else
				{
					$in_out = '';
				}
				
			
				$performance = ($row->time) ? ltrim($row->time, 0) : ltrim($row->distHeight, 0);
				
				if($admin) // Display editable link (on performance column)
				{
					$performance = anchor('admin/results_con/populate_results/' . $row->resultID, $performance);
				}

				// This adds a highlight class to those rankings less than a week old!
				$dateClass = fresh_results($row->date); // from global_helper.php

				// When displaying 'Rank' number - show = sign if performances are the same!
				$rank_style = ( $cur_performance === $performance ) ? '' : $rank;
				
				echo '<tr>
						<td class="w5">' . $rank_style . '</td>
						<td class="w10"><span class="'.$dateClass.'">' . $performance . ' ' . $in_out . '</span></td>
						<td class="w10">' . $row->wind . ' </td>
						<td class="w5">' . $row->record . '</td>
						<td class="w5">' . $row->placing . '</td>
						<td>' . $row->competition . '</td>
						<td class="w15">' . $row->venue . '</td>
						<td class="w15 right">' . $row->date . '</td>
					</tr>';
							
				$rank++;

				// Remove 'Tied' ranked function if 'Order By Date'
				if( $this->input->post('order_by') !=1)
				{
					$cur_performance = $performance; // Monitor this value
				}
			
				
			endforeach;
		}

		echo '</tbody>';
		echo '</table>';
		
		
	} // ENDS if(isset($athlete_data))
	
	?>
  
  
  
  
  <?php
	/************************************************************************************/
	// PROFILE RESULTS FOR (MULTI) EVENTS
	/************************************************************************************/
	if(isset($athlete_multi_data))
	{
		
		echo '<div class="slab reversed textMed">' . $event_name . '</div><div class="slab textMed bg_red">'. $year .'</div>';
		echo '<table class="footable table-striped" style="margin-bottom:20px;">
				<thead>
					<tr>
						<th data-class="expand" class="w5">Rank</th>
						<th class="w10">Perf</th>
						<th data-hide="phone,tablet" class="w10">Wind</th>
						<th data-hide="phone,tablet" class="w5">Note</th>
						<th data-hide="phone,tablet" class="w5">Place</th>
						<th data-hide="phone">Competition</th>
						<th data-hide="phone" class="w15">Venue</th>
						<th class="w15 right">Date</th>
					</tr>

				</thead>
			<tbody>';
					
		
		$rank = 1;
		$data='';
		$cur_performance = NULL;
		
		foreach($athlete_multi_data as $row):
		
		// Create an array of each 'discipline' result within the Decathlon / Heptathlon
		$discipline = array($row->e01, $row->e02, $row->e03, $row->e04, $row->e05, $row->e06, $row->e07, $row->e08, $row->e09, $row->e10);
		
		// Loop through each 'discipline' result
		// Assign it to $mark
		// Display it as reduce_multiples($data)
		foreach($discipline as $mark)
		{ 
			$data .= $mark . '&nbsp; <span class="textRed">|</span> &nbsp;'; 
		}

			// This adds a highlight class to those rankings less than a week old!
			$dateClass = fresh_results($row->date); // from global_helper.php

			// When displaying 'Rank' number - show = sign if performances are the same!
			$rank_style = ( $cur_performance === $row->points ) ? '' : $rank;


			$performance = $row->points;

			if($admin) // Display editable link (on performance column)
			{
				$performance = anchor('admin/multis_con/populate_results/' . $row->resultID, $row->points);
			}
			
				
			echo '<tr>
					<td class="w5">' . $rank_style . '</td>
					<td class="w10"><span class="'.$dateClass.'">' . $performance . '</span></td>
					<td class="w10">&nbsp;</td>
					<td class="w5">' . $row->record . '</td>
					<td class="w5">' . $row->placing . '</td>
					<td>' . $row->competition . '</td>
					<td class="w15">' . $row->venue . '</td>
					<td class="w15 right">' . $row->date . '</td>
				</tr>
				<tr>
					<td colspan="8">' .reduce_multiples($data, '&nbsp; <span class="textRed">|</span> &nbsp;', TRUE) . '</td>
				</tr>';
		
		$rank++;
		$data = '';
		$cur_performance = $row->points; // Monitor this value
		
		endforeach;

		echo '</tbody>';
		echo '</table>';
		
	}
	?>

	<div class="center"><a href="" class="to_top textSmall" id="bottom_profile">Back To Top</a></div>
  
	</div>
	</div>

</div><!--END container-->

<script>
	
	// This (on page load) scolls to the top of the list being viewed
	$(document).ready(function (){
		$('html, body').animate({
			scrollTop: $("#top_profile").offset().top
		}, 500);
	});
	

	// This (on click of #to_top link) scolls to the top of search criteria form
	$(document).ready(function (){
		$("#bottom_profile").click(function (e){
			e.preventDefault();
			$('html, body').animate({
				scrollTop: $("#top_results_search").offset().top
			}, 500);
		});
	});	
	

</script>