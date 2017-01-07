<!-- ************************************************************************************** -->

<!-- STARTS THE ATHLETE PERSONAL DATA -->

<!-- ************************************************************************************** -->


<!-- TARGET - this is where the page will auto scroll to after form is submited -->
<div id="top_profile"></div>


<!-- IF ADMIN IS LOGGED IN -> ALLOW ADMIN TO SELECT A RESULT TO EDIT -->
<?php $admin = ( $this->session->userdata('is_logged_in') ) ? TRUE : FALSE; ?>











<!-- ************************************************************************************** -->

<!-- STARTS THE ATHLETE LIST DATA -->

<!-- ************************************************************************************** -->

<div class="col-sm-12 category">


	<?php

		/***********************************************************************************/
		// START DISPLAY SEARCH PROFILES PARAMETERS PANEL
		/***********************************************************************************/
		// The athlete profile data (via athleteID) can be sourced from both
		// $this->uri->segment(4)
		// OR 
		// $this->input->post('athleteID')
		// Depending if you click on an 'Athlete Name link' in the lists OR if you do a search in the 'auto populate box' !!!
		// Tricky one!! be careful!

		$athleteID = ( $this->input->post('athleteID') ) ? substr($this->input->post('athleteID'), -6) : $this->uri->segment(4);

		// Open form
		echo form_open('site/profiles_con/athlete_data/' . $athleteID);

		// Adds hidden CSRF unique token
		// This will be verified in the controller against
		// the $this->session->userdata('token') before
		// returning any results data
		echo '<input type="hidden" name="token" id="token" value="' . $token . '" />';

		echo form_hidden('athleteID', $athleteID);

	?>

	<fieldset>
		<legend>ATHLETE PROFILE</legend>

		<div class="row">

			<div class="col-sm-4">

				<?php

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
						$coach_former = ( $athlete->coach_former != '' ) ? '<strong>FORMER COACH(ES): </strong>' . $athlete->coach_former : ''; // Only show if they have one!
						
						// Display Athlete Name Date of Birth details
						echo '<h2 class="h2-four">' . $athlete->nameFirst . ' <strong>' . strtoupper($athlete->nameLast) . '</strong></h2>';

						echo '<div class="record">';

							echo '<div class="row">';

								echo '<div class="col-sm-12">';

									echo '<p><strong>DATE OF BIRTH: </strong>' . $DOB . '<br>';
									
									// Only display athlete age (in years / days) if they are still alive
									if( in_array( $athlete->athleteID, $this->config->item('passed') ))
									{
										echo '<strong>AGE: </strong>n/a';
									}
									else {
										// This displays the actual age of the athlete in Years/Months/Days ...
										$athlete_age = recordAge($athlete->DOB, date('Y-m-d')); // See global_helper.php
										echo '<strong>AGE: </strong>' . $athlete_age . '</p>';
									}
									echo '<hr class="dotted">';

									// Display Athlete Club and Coach Details
									echo '<p><strong>CLUB: </strong>' . $athlete->clubName . '<br>';
									echo '<strong>CENTRE: </strong>' . $athlete->centreID . ' ' . get_centre_flag( $athlete->centreID ) . '</p>';
									
									echo '<hr class="dotted">';

									echo '<p><strong>COACH: </strong>' . $coach . '<br>';
									echo $coach_former . '</p>';


								echo '</div>';

							echo '</div>';

						echo '</div>';						

					}

				?>

			</div><!-- ENDS col -->


			<div class="col-sm-4">

				<!-- Drop down menu - List of events -->
				<!-- ONLY show events this athlete has results in -->
				<!-- See profile helper -->
				<?php echo pro_listEvents(); ?>
				<div>&nbsp;</div>

				<!-- Drop down menu - List of years -->
				<!-- See profile helper -->
				<?php echo profile_years(); ?>
				<div>&nbsp;</div>


				<!-- Radio box - Order By (Date / Performance) -->
				<?php
					$options = array(
						'0'  => 'Best Result',
						'1'   => 'Date (newest to oldest)'
					);
				?>

				<label class="radio-inline static-four">ORDER PERFORMANCES BY</label>

				<?php
					$check = '0';
					foreach($options as $key => $value)
					{
						if( $key == $check ) { $checked = 'checked'; } else { $checked = ''; }
						
						echo '<label class="radio-inline">';
							echo '<input type="radio" class="catRadio" name="order_by" value="'. $key .'" '.$checked.'>	'. $value .' ';
							echo '<i class="fa fa-check fa-symbol"></i>';
						echo '</label>';

					}
				?>

				<input type="submit" class="btn btn-block btn-green" style="margin: 15px 0;" value="Show Performances">

			</div><!-- ENDS col -->





			<div class="col-sm-4 anchors">

				<h3><strong>Athlete Career History</strong></h3>
				<p class="opacity-box">Click links below to view this athletes NZ Championship medal history, national representational honours, personal best performances and full yearly progressions.</p>

				<?php if( $this->uri->segment(3) == 'athlete' ) { ?>
					<a href="#NZCM"><label class="radio-inline"><i class="fa fa-search" aria-hidden="true"></i> NZ Championships Medals</label></a>
					<a href="#NZR"><label class="radio-inline"><i class="fa fa-search" aria-hidden="true"></i> NZ Representation</label></a>
					<a href="#BP"><label class="radio-inline"><i class="fa fa-search" aria-hidden="true"></i> Best Performances</label></a>
					<a href="#AP"><label class="radio-inline"><i class="fa fa-search" aria-hidden="true"></i> Annual Progressions</label></a>
				<?php } else { 

						if($this->uri->segment(3) != 'athlete')
						{
							// Return to 'Athlete Profile' home-page
							echo anchor('site/profiles_con/athlete/' . $athlete->athleteID, '<i class="fa fa-refresh" aria-hidden="true"></i> REFRESH ATHLETE HISTORY DATA', array('class' => 'btn-profile'));
						}

					}

					if($admin) {
						// FOR ADMIN - Add link to edit athlete details
						echo '<div class="admin">';
							echo anchor('admin/athlete_con/populate_athlete/' . $athlete->athleteID, '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> EDIT ATHLETE', array( 'class' => 'btn btn-admin') );
							echo anchor('admin/representation_con/add_representation/' . $athlete->athleteID, '<i class="fa fa-plus-square" aria-hidden="true"></i> ADD REPRESENTATION', array( 'class' => 'btn btn-admin') );
							echo anchor('admin/nzchamps_con/add_nzchamps/' . $athlete->athleteID, '<i class="fa fa-plus-square" aria-hidden="true"></i> ADD NZ MEDALS', array( 'class' => 'btn btn-admin' ) );
						echo '</div>';
					}

				?>


				<?php
					// Display error message if no selections are made
	                if(isset($this->error_message))
	                {
	                    echo $this->error_message;
	                }
				?>

			</div>


			
		</div><!--ENDS row-->

	</fieldset>

	<!-- Close form -->
	<?php echo form_close(); ?>

</div><!-- ENDS col -->









