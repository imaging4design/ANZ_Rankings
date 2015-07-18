<div class="searchBand"><!-- This is an anchor where the page will scroll up to wne search the 'Recent Rankings' -->

	<div class="container">

		<div class="row">

			<div class="span7">

				

				<?php
				/***********************************************************************************/
				// START DISPLAY SEARCH RANKINGS PARAMETERS PANEL
				/***********************************************************************************/
				if($this->uri->segment(2) != 'profiles_con')
				{
				?>

				

				<?php
				// Open form
				echo form_open('site/results_con', array('class' => 'hack'));

				echo '<fieldset>';
				echo '<legend>Search Rankings Lists</legend>';

				// Adds hidden CSRF unique token
				// This will be verified in the controller against
				// the $this->session->userdata('token') before
				// returning any results data
				echo '<div class="row">';

					echo '<div class="span3">';
						echo form_hidden('token', $token);
						
						// Drop down menu - List of events
						// See global helper
						echo buildEventsDropdown(); 

						// Drop down menu - List of years
						// See profile helper
						echo ranking_years();

						// Submit button
						echo form_submit('submit', 'View', 'class="btn"', 'id="submit"');

						echo '<div class="separator visible-phone"></div>';

						/****************************************************************************************************************/
						// DISPLAY 'PDF' PRINT OUTPUT BUTTON
						/****************************************************************************************************************/
						// Display 'PRINT PDF' button .. only if 'event' and ageGroup have been selected
						if($this->input->post('eventID') && $this->input->post('ageGroup'))
						{
							// Don't display PDF print button for 'Relay' events
							if(!in_array($this->input->post('eventID'), $this->config->item('relay_events')))
							{
								echo anchor('pdf/pdf_con/results_PDF','Download PDF', array('class' => 'btn pull-right hidden-phone'));
							}

						}

					echo '<p style="margin-top:15px;"><span class="fresh_results">XXXX</span> = Performances in last 14 days</p>';

					echo '</div>';

					echo '<div class="span2">';
						// Radio Button list of age groups
						echo '<label class="bold">AGE GROUP</label>';
						echo buildAgeGroupRadio(set_value('ageGroup')); // see global_helper.php

						echo '<div class="separator visible-phone"></div>';
					echo '</div>';


					echo '<div class="span2">';
						// Drop down menu - List Depth
						$options = array(
							'10'  => 'Top 10',
							'50'  => 'Top 50',
							'250' => 'Deep List (250)'
						);

						// echo form_dropdown('list_depth', $options, set_value('list_depth', '50'), 'style="margin-left:20px;"');
						echo '<label class="bold">LIST DEPTH</label>';
						$check = '50';
						foreach($options as $key => $value)
						{
							if( $key == $check ) { $checked = 'checked'; } else { $checked = ''; }
							
							echo '<label class="radio">';
								echo '<input type="radio" name="list_depth" value="'. $key .'" '.$checked.'>	'. $value .'';
							echo '</label>';
						}
						echo '<div class="separator visible-phone"></div>';

						// Drop down menu - List Type
						$options = array(
							'0'  => 'Athletes',
							'1'   => 'Performances'
						);

						//echo form_dropdown('list_type', $options, set_value('list_type'));
						echo '<label class="bold">LIST BY:</label>';
						$check = '0';
						foreach($options as $key => $value)
						{
							if( $key == $check ) { $checked = 'checked'; } else { $checked = ''; }
							
							echo '<label class="radio">';
								echo '<input type="radio" name="list_type" value="'. $key .'" '.$checked.'>	'. $value .'';
							echo '</label>';
						}
						echo '<div class="separator visible-phone"></div>';

					echo '</div>';

					
				echo '</div>';

				echo '</fieldset>';
				// Close form
				echo form_close();
				?>




				<?php
				} 
				/***********************************************************************************/
				// START DISPLAY SEARCH PROFILES PARAMETERS PANEL
				/***********************************************************************************/
				else
				{
				?>



						<?php
						// The athlete profile data (via athleteID) can be sourced from both
						// $this->uri->segment(4)
						// OR 
						// $this->input->post('athleteID')
						// Depending if you click on an 'Athlete Name link' in the lists OR if you do a search in the 'auto populate box' !!!
						// Tricky one!! be careful!

						$athleteID = ( $this->input->post('athleteID') ) ? substr($this->input->post('athleteID'), -6) : $this->uri->segment(4);

						// Open form
						echo form_open('site/profiles_con/athlete_data/' . $athleteID);

							echo '<fieldset>';
							echo '<legend>Athlete Profiles</legend>';

							echo '<div class="row">';
								echo '<div class="span3">';

									// Adds hidden CSRF unique token
									// This will be verified in the controller against
									// the $this->session->userdata('token') before
									// returning any results data
									echo '<input type="hidden" name="token" id="token" value="' . $token . '" />';

									echo form_hidden('athleteID', $athleteID);

									// Drop down menu - List of events
									// ONLY show events this athlete has results in
									// See profile helper
									echo pro_listEvents();

									// Drop down menu - List of years
									// See profile helper
									echo profile_years();

									// Submit button
									//echo '<label for="submit" style="display:inline; margin-left:20px;"></label>';
									echo form_submit('submit', 'View', 'class="btn"', 'id="sub_profile"');

									echo '<p style="margin-top:15px;"><span class="fresh_results">1234</span> = Performances in last 14 days</p>';

								echo '</div>';


								echo '<div class="span4">';
								echo '<br class="visible-phone">';

									// Radio box - Order By (Date / Performance)
									$options = array(
										'0'  => 'Performance',
										'1'   => 'Date (newest to oldest)'
									);

									echo '<label class="bold">ORDER BY:</label>';
									$check = '0';
									foreach($options as $key => $value)
									{
										if( $key == $check ) { $checked = 'checked'; } else { $checked = ''; }
										
										echo '<label class="radio">';
											echo '<input type="radio" name="order_by" value="'. $key .'" '.$checked.'>	'. $value .'';
										echo '</label>';
									}


								echo '</div>';

							echo '</div>';

							echo '</fieldset>';

							// Close form
							echo form_close();
								
						?>

				<?php } ?>

			</div><!--ENDS span7-->


			


			<!-- ****************************************************************************************************************************************** -->
			<!-- START OF 'AUTO-POPULATE' INPUT TEXT FIELD TO SEARCH FOR ATHLETES -->
			<!-- ****************************************************************************************************************************************** -->
			<div class="span5">

				<?php
				// Create session vars of posted (search rankings) parameters
				// These are required for the 'PDF print' function
				$searchData = array(
					'eventID'  		=> $this->input->post('eventID'),
					'ageGroup' 		=> $this->input->post('ageGroup'),
					'year'     		=> $this->input->post('year'),
					'list_depth' 	=> $this->input->post('list_depth'),
					'list_type'  	=> $this->input->post('list_type')
				);

				$this->session->set_userdata($searchData);

				?>



				<?php
				//echo form_open('site/profiles_con/athlete/' . $athleteID, array('class' => 'form-search')); // Old method
				echo form_open('site/profiles_con/search_proxy', array('class' => 'form-search hack'));
				

					echo '<fieldset>';
					echo '<legend>Search Athletes</legend>';

					//echo '<label for="athlete">Start typing athletes last name ...</label>';
					//echo '<input type="text" name="athleteID" id="athleteID" size="40" />';
					//DON'T REMOVE id="athlete" (required for auto-populate!)-->

					echo '<div class="input-append">';
					echo '<label for="athleteID">Enter athlete\'s last name ... <span class="hidden-phone">wait for dropdown list</span></label><br />';
					echo '<input type="text" name="athleteID" id="athleteID" class="search-query" placeholder="Athlete Last Name" />';
					echo '<button type="submit" class="btn">Search</button>';
					echo '</div>';

					echo '<input type="hidden" name="auto_complete" value="auto_complete" />';

					if( $this->session->flashdata( 'bad_search' ) )
					{
						echo '<div class="horz_line"></div>';
						echo '<div class="alert alert-block"><button type="button" class="close" data-dismiss="alert">&times;</button>' . $this->session->flashdata( 'bad_search' ) . '</div>';
						echo '<div class="horz_line"></div>';
					}
					
					echo '</fieldset>';
						
				echo form_close();

				?>




				<!-- ****************************************************************************************************************************************** -->
				<!-- SHOW FORM SO USER CAN SELECT TO VIEW THE MOST RECENT ADDITIONS TO THE RANKINGS DATABASE -->
				<!-- ****************************************************************************************************************************************** -->
				<?php
				echo form_open('site/home_con/most_recent', array( 'class' => 'form-search hack' ));



					echo form_hidden('token', $token);

					echo '<fieldset>';
					echo '<legend>New Performances Added </legend>';

					
					echo '<select name="time_frame" class="span2">';
						echo '<option value="3" '. set_select('time_frame', '3', TRUE) . ' >Past 3 Days</option>';
						echo '<option value="4" '. set_select('time_frame', '4') . ' >Past 4 Days</option>';
						echo '<option value="5" '. set_select('time_frame', '5') . ' >Past 5 Days</option>';
						echo '<option value="10" '. set_select('time_frame', '10') . ' >Past 10 Days</option>';
						echo '<option value="15" '. set_select('time_frame', '15') . ' >Past 15 Days</option>';
					echo '</select>';


					echo '<span class="hidden-phone">&nbsp; &nbsp; </span><br class="visible-phone">'; // spacer


					// Gender options
					echo '<label class="radio">';
						$checkGender = ( $this->input->post( 'gender') === 'men' or ! $this->input->post( 'gender') ) ? 'checked' : ''; 
						echo '<input type="radio" name="gender" value="men" ' . $checkGender . '> &nbsp; Men';
					echo '</label>';

					echo '&nbsp; &nbsp;'; // spacer

					echo '<label class="radio">';
						$checkGender = ( $this->input->post( 'gender' ) === 'women' ) ? 'checked' : ''; 
						echo '<input type="radio" name="gender" value="women" ' . $checkGender . '>&nbsp;  Women';
					echo '</label>';
					

					// Submit button
					echo '<label for="submit" style="display:inline; margin-left:20px;"></label>';
					echo form_submit('submit', 'View', 'class="btn"', 'id="sub_profile"');

					echo '</fieldset>';

				echo form_close();

				?>

			</div><!--ENDS span5-->

		</div><!--ENDS row-->
	
	</div><!--ENDS container-->

</div><!--ENDS blackBand-->