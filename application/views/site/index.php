<div id="top_index"></div><!-- TARGET - this is where the page will auto scroll to after form is submited -->


	<div class="container container-class">
		<div class="row">
			<div id="latest">

				<!-- <div class="slab reversed textLarge">Latest</div><div class="slab textLarge lead_perfs blue"> News</div>
	  			<div style="clear:both;"></div> -->

	  			<!-- <h2 class="h2-one"><strong>Latest</strong> News</h2> -->

	  			<ul class="nav nav-pills nav-stacked nav-justified">
				<!-- <ul class="nav nav-pills"> -->
					<?php if( isset( $show_flash_news ) ) { // Only display is data is present 
						$flash_active = ( isset( $show_flash_news )) ? 'active' : '';
					?>
						<li class="active"><a href="#home" data-toggle="tab"><i class="fa fa-comment-o"></i>&nbsp; Announcements</a></li>
					<?php } ?>

					<?php if( isset( $show_news ) ) { // Only display is data is present ?>
						<li><a href="#news" data-toggle="tab"><i class="fa fa-map-o"></i>&nbsp; Latest News</a></li>
					<?php } ?>

					<?php if( isset( $ratified_record ) ) { // Only display is data is present ?>
						<li><a href="#records" data-toggle="tab"><i class="fa fa-flag-o"></i>&nbsp; Recent Records</a></li>
					<?php } ?>

					<?php if( isset( $records_this_day ) ) { // Only display is data is present ?>
						<li><a href="#history" data-toggle="tab"><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp; Today in History</a></li>
					<?php } ?>

					<?php if( isset( $born_this_day ) ) { // Only display is data is present ?>
						<li><a href="#birthdays" data-toggle="tab"><i class="fa fa-calendar"></i>&nbsp; Athlete Birthdays</a></li>
					<?php } ?>
				</ul>

				<!-- ========================================================================================== -->

				<div class="tab-content">

					<div class="tab-pane <?php echo $flash_active; ?>" id="home"><!-- STARTS News Flash -->
						<div class="latest-news">
							<?php

								// If admin logged in allow editing privilages ...
								$admin = ( $this->session->userdata('is_logged_in') ) ? TRUE : FALSE;


								// Display a special 'Flash' message on the home page!
								if(isset($show_flash_news)) {

									$date_expires = $show_flash_news->expires;
									$current_date = date("Y-m-d");

									if(strtotime($current_date) <= strtotime($date_expires)) { // Display message for a valid time period only!

										echo '<div class="news">';
											echo '<h5 class="news-date">DATE: '. $show_flash_news->date .'</h5>';
											echo '<h3>' . $show_flash_news->heading . '</h3>';
											//echo $show_flash_news->bodyContent;
											echo auto_link($show_flash_news->bodyContent, 'both', TRUE);
										echo '</div>';

										if( $admin )
										{
											echo anchor('admin/news_con/populate_news/' . $show_flash_news->newsID, 'Edit News Flash', array('class'=>'btn btn-default'));
										}

									}
								}
								
				  			?>

			  			</div><!-- ENDS latest-news -->
					</div><!-- ENDS News Flash -->

					<!-- ========================================================================================== -->

					<div class="tab-pane" id="news"><!-- STARTS News -->
						<div class="latest-news">

							<?php
								
								// Is admin logged in?
								$admin = ($this->session->userdata('is_logged_in')) ? TRUE : FALSE;
							
								if(isset($show_news))
								{

									foreach($show_news as $row):

										//Make data selectable as 'Admin Edit'
										if($admin)
										{
											$edit = anchor('admin/news_con/populate_news/' . $row->newsID, 'EDIT ARTICLE', array( 'class' => 'news_link' ));
										}
										else
										{
											$edit = '';
										}
										
										echo '<div class="news">';
											echo '<h5 class="news-date">DATE: '. $row->date .'</h5>';
											echo $row->bodyContent;
										echo '</div>';
										
										echo $edit; // Admin 'Edit Article' button

									endforeach;

								}
							?>
						</div><!-- ENDS latest-news -->
					</div><!-- ENDS News -->

					<!-- ========================================================================================== -->

					<div class="tab-pane" id="records">
						<div class="latest-news">

							<?php
								// Display a New NZ ratified record(s) on the home page!
					  			if( $ratified_record ) {

					  				echo '<h3>NZ Records ratified in the past month</h3>';

					  				echo '<table class="table table-striped" data-toggle-column="last">';
										
										echo '<thead>';
											echo '<tr>';
												echo '<th data-type="html">';
													echo '<strong>ATHLETE</strong>';
												echo '</th>';
												echo '<th>';
													echo '<strong>EVENT</strong>';
												echo '</th>';
												echo '<th>';
													echo '<strong>PERFORMANCE</strong>';
												echo '</th>';
												echo '<th data-breakpoints="md sm xs">';
													echo '<strong>TYPE</strong>';
												echo '</th>';
												echo '<th data-breakpoints="md sm xs">';
													echo '<strong>AGE GROUP</strong>';
												echo '</th>';
												echo '<th data-breakpoints="sm xs">';
													echo '<strong>DATE</strong>';
												echo '</th>';
											echo '</tr>';
										echo '</thead>';

										echo '<tbody>';
											foreach($ratified_record as $row):

												// Work out which type of record
												switch ($row->recordType){

													case 'NN':
													$recType = 'NZ National';
													break;

													case "RR":
													$recType = 'NZ Resident';
													break;

													case "AC":
													$recType = 'NZ All Commers';
													break;	
												}

												
												echo '<tr>';
													echo '<td>';
														echo $row->nameFirst . ' ' . strtoupper($row->nameLast);
													echo '</td>';
													echo '<td>';
														echo convertEventID($row->eventID)->eventName;
													echo '</td>';
													echo '<td>';
														echo $row->result;
													echo '</td>';
													echo '<td>';
														echo $recType;
													echo '</td>';
													echo '<td>';
														echo ageGroupRecordHistoryConvert($row->ageGroup);
													echo '</td>';
													echo '<td>';
														echo $row->newdate;
													echo '</td>';
												echo '</tr>';
													
							  				endforeach;

							  			echo '</tbody>';
									echo '</table>';

					  			} // ENDS $ratified_record
					  			else {
									echo '<p>No results found ...</p>';
								}
							?>

						</div><!-- ENDS latest-news -->
					</div>

					<!-- ========================================================================================== -->

					<div class="tab-pane" id="history"><!-- STARTS Day History -->
						<div class="latest-news">
							<h3>On this day in history ...</h3>

							<table class="table table-striped" data-toggle-column="last">
								<thead>
									<tr>
										<th><strong>WHEN</strong></th>
										<th><strong>ATHLETE</strong></th>
										<th data-breakpoints="sm xs"><strong>AGE GROUP</strong></th>
										<th data-breakpoints="sm xs"><strong>REC TYPE</strong></th>
										<th><strong>PERF</strong></th>
										<th data-breakpoints="xs"><strong>EVENT</strong></th>
										<th data-breakpoints="sm xs"><strong>VENUE</strong></th>

									</tr>
								</thead>

								<tbody>

								<?php

									// Shows records set athletes on this day in history ...
									if( isset( $records_this_day ) ) {

										$result = NULL;


										foreach ($records_this_day as $row):

											switch ($row->recordType){
												case 'AC':
													$recType = 'NZ Allcomers';
												break;
												case 'NN':
													$recType = 'NZ National';
												break;	
												case 'RR':
													$recType = 'NZ Resident';
												break;	
											}

											// This displays the actual age of the record in Years/Months/Days ...
											$nz_ageOfRecord = recordAgeHistory($row->date, date('Y')); // See global_helper.php
											

												if( $result == $row->result && $date == $row->date ) {

													// This will not run on the first time around
													// On the second or subsequent rounds - if the result and date match, that will indicate the record has more than one record type (i.e., All commers, national, resident)
													// Therefore, we need to combine these on one line instead of rendering them out on three separate lines
													// So, we remove (array_pop($records)) the previous record, but remember its recType and continue on 
													// When we have looped through the same record (max possible 3) we keep popping the previous off until we hit the last
													// Then we add in the saved 'recTypes' as an extra field over and above $recType

													array_pop($records);

													$AllRecType = $rememberRecType; // e.g. NZ Allcomers
													
													$records[] = 

													'<tr><td>' . $nz_ageOfRecord.'</td><td>' . $row->nameFirst . ' ' . $row->nameLast. '</td><td> set the ' . ageGroupRecordHistoryConvert($row->ageGroup) . '</td><td>' . $AllRecType . ' Record</td><td>' . $recType . ' ' . $row->result . '</td><td>' . $row->eventName . '</td><td>' . strtoupper($row->venue) . '</td></tr>';

													$rememberRecType .= $recType.', '; // e.g. NZ Allcomers
													

												} else {

													// This will run first and populate the '$records' array with the first record
													$rememberRecType = NULL;

													$records[] = 

													'<tr><td>' . $nz_ageOfRecord.'</td><td>' . $row->nameFirst . ' ' . $row->nameLast. '</td><td> set the ' . ageGroupRecordHistoryConvert($row->ageGroup) . '</td><td>' . $recType . ' Record</td><td> ' . $row->result . '</td><td>' . $row->eventName . '</td><td>' . strtoupper($row->venue) . '</td></tr>';

													$rememberRecType .= $recType.', '; // e.g. NZ Allcomers

												}


											$result = $row->result; // 88.20
											$date = $row->date;

											
											/*
											|-----------------------------------------------------------------------------------------------------------------
											| NOTE!!
											| If the above proves not to work - then delete all directly after the 'switch' statement
											| Then uncomment the lines below ..
											|-----------------------------------------------------------------------------------------------------------------
											*/

											// This displays the actual age of the record in Years/Months/Days ...
											// $nz_ageOfRecord = recordAgeHistory($row->date, date('Y')); // See global_helper.php

											//echo $nz_ageOfRecord.' - <strong>' . $row->nameFirst . ' ' . $row->nameLast. '</strong> set the ' . ageGroupRecordHistoryConvert($row->ageGroup) . ' ' . $recType . ' Record of <strong>' . $row->result . '</strong> for the ' . $row->eventName . ', ' . $row->venue . '<br />';
										
											
											
										endforeach;

										foreach ($records as $key => $value) {
											echo $value;
										}
										
										
										


									}
									else {
										echo 'No results found';
									}

								?>

								</tbody>
							</table>

						</div><!-- ENDS latest-news -->
					</div><!-- ENDS Day History -->

					<!-- ========================================================================================== -->

					<div class="tab-pane" id="birthdays"><!-- STARTS Birthdays -->
						<div class="latest-news index-profile">
							<?php
								// Shows Athletes born this day on home page
								if( isset( $born_this_day ) ) {

									echo '<h3>NZ Athletes with birthdays today (' . date('jS F', strtotime(date('Y-m-d'))) . ')</h3>';

									echo '<table class="table table-striped" data-toggle-column="last">';
										echo '<thead>';
											echo '<tr>';
												echo '<th data-type="html"><strong>NAME</strong></th>';
												echo '<th><strong>AGE</strong></th>';
												echo '<th data-breakpoints="xs"><strong>CLUB</strong></th>';
												echo '<th  data-type="html" data-breakpoints="xs"><strong>CENTRE</strong></th>';
											echo '</tr>';
										echo '</thead>';

										echo '<tbody>';

											foreach ($born_this_day as $row):

												// This displays the actual age of the athlete in Years/Months/Days ...
												$athlete_age = recordAgeYears($row->DOB, date('Y-m-d')); // See global_helper.php

												// Dynamically assign a centre flag to the centreID column
												// This is powered by 'includes/regional_flags.php' (an include)
												$centre_flag = get_centre_flag( $row->centreID );

												echo '<tr>';
													echo '<td>' . anchor('site/profiles_con/athlete/' . $row->athleteID, $row->nameFirst . ' ' . strtoupper($row->nameLast)) . '</td>';
													echo '<td>' . $athlete_age . '</td>';
													echo '<td>' . $row->clubName . '</td>';
													echo '<td>' . $centre_flag. ' ' . $row->centreID . ' </td>';
												echo '</tr>';
											endforeach;
										echo '</tbody>';
									echo '</table>';
								}
								else {
									echo '<p>No results found ...</p>';
								}
							?>
						</div><!-- ENDS latest-news -->
					</div><!-- ENDS Birthdays -->

					<!-- ========================================================================================== -->

				</div>
			</div><!--ENDS col-->

			<!-- <div class="col-sm-6">
				<h2 class="h2-one" style="margin-bottom:14px;"><strong>Latest</strong> Videos</h2>
				<p>Woemns 400 metre reals</p>
				<div class="embed-responsive embed-responsive-16by9">
					<iframe width="560" height="315" src="https://www.youtube.com/embed/9XwoaaUa_cY" frameborder="0" allowfullscreen></iframe>
				</div>
			</div> -->


		</div><!--ENDS row-->
	</div><!--ENDS container-->





<?php
	// From index() home_con
	if( isset( $show_target ) )
	{
		echo $show_target; // TARGET - move page down to Top Performers table (for phones)
	}
?>

<div class="container" style="background:white; padding-bottom:20px;">

	<div class="row">

		<?php
			/*************************************************************/
			// CREATE A LABEL HEADING FOR WHICH AGE GROUP IS BEING DISPLAYED
			/*************************************************************/

			// NEW! .. This give the new correct 'Age Group' Labels
			if( $this->input->post('ageGroup') ) {

				$age = '<strong>' . ageGroupLabels( $this->input->post('ageGroup') ) . '</strong>'; // see global_helper

			}
			else
			{
				$age = '<strong>Senior Men </strong>';
			}

		?>



		<div class="col-sm-4">
			<h3 class="leading lead-marks">LEADING MARKS <?php echo date('Y'); ?></h3>
			<h2 class="h2-one"><?php echo $age; ?></h2>
		</div>

		<div class="col-sm-4">
			<?php
				// Form to choose which ageGroup to show top 'Year' lists
				echo form_open('site/home_con', array( 'id' => 'topPerformers' ));

					echo '<div class="lead-head">';

						echo buildAgeGroup_topLists( set_value('ageGroup') ); // from global_helper
						//echo '<button type="submit"  id="top_performers" class="btn">VIEW</button>';

					echo '</div>';

				echo form_close();

			?>
		</div>
		
		<div class="col-sm-4">
			<p class="pull-right hidden-xs" style="margin-top: 15px;"><span class="fresh_results">1234</span> = Performances in last 14 days</p>
		</div>



		<?php

			/* 
			| WHAT IS THIS? 
			| A form that allows the user to click on an event name (e.g., 400m)
			| and auto submits showing rankings for that event, gender and ageGroup
			*/

			// Set up initial session vars on page load
			if( $this->input->post('ageGroup') ) {
				$this->session->set_userdata('ageGroup', $this->input->post('ageGroup'));
			} else {
				$this->session->set_userdata('ageGroup', 'MS');
			}
			
			$this->session->set_userdata('year', date('Y'));
			$this->session->set_userdata('list_depth', '50');
			$this->session->set_userdata('list_type', '0');

								

			echo form_open('site/results_con', array( 'class' => 'leadersForm', 'id' => 'leadersForm' ));

				echo form_hidden('token', $token);
				echo form_hidden('ageGroup', $this->session->userdata('ageGroup'));
				echo form_hidden('year', $this->session->userdata('year'));
				echo form_hidden('list_depth', $this->session->userdata('list_depth'));
				echo form_hidden('list_type', $this->session->userdata('list_type'));

		?>



		<div class="col-sm-12" style="margin-top:0px;">
			  
			<table class="table table-striped" data-toggle-column="last">
				<thead>
					<tr>
						<th data-type="html">EVENT</th>
						<th data-type="html">PERF</th>
						<th data-breakpoints="sm xs">WIND</th>
						<th data-type="html">ATHLETE</th>
						<th data-breakpoints="sm xs" data-type="html">Centre</th>
						<th data-breakpoints="sm xs">DOB</th>
						<th data-breakpoints="sm xs">COMPETITION</th>
						<th data-breakpoints="xs">VENUE</th>
						<th data-breakpoints="xs">DATE</th>
					</tr>
				</thead>
				<tbody>


			<?php include('includes/regional_flags.php'); // include regional_flags.php to display centre flags ?>
				
			  
			<?php

				/***************************************************************************************************/
				// Display individual events for the homepage 'Toplists'
				/***************************************************************************************************/
				if( isset( $top_performers ) )
				{
					foreach( $top_performers as $row ):

						// This adds a highlight class to those rankings less than a week old!
						$dateClass = fresh_results($row->date); // from global_helper.php

						// Dynamically assign a centre flag to the centreID column
						// This is powered by 'includes/regional_flags.php' (an include)
						$centre_flag = get_centre_flag( $row->centreID );

						$coach = ( $row->coach ) ? 'COACH: ' . $row->coach : '';

						$years = age_from_dob($row->DOB) . ' years';
						$days = daysLeftForBirthday($row->DOB) . ' days';

						$age = 'AGE: ' . $years . ', ' . $days. '<br>' . $coach;

						$in_out = ($row->in_out == 'in') ? '(i)' : ''; 

						echo '<tr>
								<td> <label><input type="radio" name="eventID" value="'.$row->eventID.'"> '.$row->eventName.'</label></td>								
								<td><span class="'.$dateClass.'">' . ltrim($row->time, 0) . '' . ltrim($row->distHeight, 0) . '</span>&nbsp;'. $in_out . ' <span class="hidden-phone textREDD">' . $row->record . '</span></td>
								<td>' . $row->wind . '</td>
								<td>' . anchor('site/profiles_con/athlete/' . $row->athleteID, $row->nameFirst . ' ' . strtoupper($row->nameLast)) . '</td>
								<td>' . $centre_flag . ' ' . $row->centreID . '</td>
								<td>' . $row->format_DOB . '</td>
								<td>' . $row->competition . '</td>
								<td>' . $row->venue . '</td>
								<td>' . $row->date . '</td>
							</tr>';

					endforeach;
				}

			?>
			  
			  
			<?php
				/***************************************************************************************************/
				// Display multi events for the homepage 'Toplists'
				/***************************************************************************************************/
				if(isset($topPerformers_Multis))
				{

				// This adds a highlight class to those rankings less than a week old!
				$dateClass = fresh_results($topPerformers_Multis->date); // from global_helper.php

				// Dynamically assign a centre flag to the centreID column
				// This is powered by 'includes/regional_flags.php' (an include)
				$centre_flag = get_centre_flag( $topPerformers_Multis->centreID );

				$coach = ( $row->coach ) ? 'COACH: ' . $topPerformers_Multis->coach : '';

				$years = age_from_dob($topPerformers_Multis->DOB) . ' years';
				$days = daysLeftForBirthday($topPerformers_Multis->DOB) . ' days';

				$age = 'AGE: ' . $years . ', ' . $days. '<br>' . $coach;

				echo '<tr>
						<td> <label><input type="radio" name="eventID" value="'.$topPerformers_Multis->eventID.'"> '.$topPerformers_Multis->eventName.'</label></td>
						<td><span class="'.$dateClass.'">' . $topPerformers_Multis->points . '</span></td>
						<td>&nbsp;</td>
						<td>' . anchor('site/profiles_con/athlete/' . $topPerformers_Multis->athleteID, $topPerformers_Multis->nameFirst . ' ' . strtoupper($topPerformers_Multis->nameLast)) . '</td>
						<td>' . $centre_flag . ' ' . $topPerformers_Multis->centreID . '</td>
						<td>' . $topPerformers_Multis->format_DOB . '</td>
						<td>' . $topPerformers_Multis->competition . '</td>
						<td>' . $topPerformers_Multis->venue . '</td>
						<td>' . $topPerformers_Multis->date . '</td>
					</tr>';

				}
			?>
			  
			  
			<?php
				/***************************************************************************************************/
				// Display relay events for the homepage 'Toplists'
				/***************************************************************************************************/
				if(isset($topPerformers_Relays))
				{
					foreach($topPerformers_Relays as $row):

					// This adds a highlight class to those rankings less than a week old!
					$dateClass = fresh_results($row->date); // from global_helper.php
					
					// Combine athletes (relay team members)
					$athletes = $row->athlete01 . ',<br>' . $row->athlete02 . ',<br>' . $row->athlete03 . ',<br>' . $row->athlete04;
					
						echo '<tr>
								<td> <label><input type="radio" name="eventID" value="'.$row->eventID.'"> '.$row->eventName.'</label></td>
								<td><span class="'.$dateClass.'">' . ltrim($row->time, 0) . '</span></td>
								<td>&nbsp;</td>
								<td>' . $athletes . '</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>' . $row->competition . '</td>
								<td>' . $row->venue . '</td>
								<td>' . $row->date . '</td>
							</tr>';

					endforeach;
				}



			?>

			</tbody>
			</table>


			<div class="center"><a href="#" class="btn btn-search" id="bottom_index">New Search &nbsp; <i class="fa fa-chevron-up" aria-hidden="true"></i></a></div>

		</div><!-- ENDS col-sm-12 -->

		<?php

			/* 
			| WHAT IS THIS? 
			| Ends the form
			*/

			echo form_close();
		?>

	</div><!-- ENDS row -->

</div><!-- ENDS container -->





<?php if( isset( $show_target ) ) { // Load the <script> only when form submitted !!! ?>

	<script>

		// ON LOAD (of results) - scroll to top of list
		// ************************************************************************
		$(window).load(function() {

			var winWidth = $( window ).width();
			var offSetDist = false;

			if( winWidth <= 752 ) {
				offSetDist = -55;
			} else {
				offSetDist = -10;
			}

			var resultsLoaded = $('.lead-marks').delay(10).velocity('scroll', { offset: offSetDist, duration: 500, easing: [ 0.17, 0.67, 0.83, 0.67 ]});

		});

	</script>

<?php } ?>


<script>
	
	$(document).ready(function(){

		// Submit form to results_con when user clicks on event name
		// ************************************************************************
		$("input[name='eventID']").on('click', function(event){
			$( ".leadersForm" ).submit();
		});

	});
		
</script>

