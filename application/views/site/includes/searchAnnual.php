				<?php
				/**********************************************************************************************************************************************************************/
				// ANNUAL LISTS FORM
				/**********************************************************************************************************************************************************************/
				echo '<div class="annual">';

					echo form_open('site/results_con', array('class' => 'hack'));

						echo '<fieldset>';
						echo '<legend>Search Annual Lists</legend>';

						// Adds hidden CSRF unique token
						// This will be verified in the controller against
						// the $this->session->userdata('token') before
						// returning any results data
						echo '<div class="row">';

						echo '<div class="span3">';

							echo '<div class="clearfix"><div class="slab reversed textMed blue">Annual Lists</div><a href="#" id="allTime"><div class="slab textMed">All Time Lists &raquo;</div></a></div>';

							echo form_hidden('searchType', 'annual'); // Track if the user is searching 'Annual' or 'All Time' lists and make the search form 'sticky'!

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
									echo anchor('pdf/pdf_con/results_PDF','Download PDF', array('class' => 'btn hidden-phone', 'style' => 'margin-left:10px;'));
								}

							}

							echo '<p style="margin-top:15px;"><span class="fresh_results">XXXX</span> = Performances in last 14 days</p>';

						echo '</div>';


						echo '<div class="span2">';
						// Radio Button list of age groups
						echo '<label class="bold">AGE GROUP</label>';

						echo buildAgeGroupRadio(); // see global_helper.php

						echo '<div class="separator visible-phone"></div>';
						echo '</div>';


						echo '<div class="span2">';
						// Drop down menu - List Depth
						$options = array(
							'10'  => 'Top 10',
							'50'  => 'Top 50',
							'250' => 'Deep List (250)'
						);

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

				echo '</div>';