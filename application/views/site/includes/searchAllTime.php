				<?php
				/**********************************************************************************************************************************************************************/
				// ALL TIME LISTS FORM
				/**********************************************************************************************************************************************************************/
				echo '<div class="allTime">';

					echo form_open('site/results_con', array('class' => 'hack'));

						echo '<fieldset>';
						echo '<legend>Search All Time Lists</legend>';

						

						// Adds hidden CSRF unique token
						// This will be verified in the controller against
						// the $this->session->userdata('token') before
						// returning any results data
						echo '<div class="row">';

						echo '<div class="span3">';

							echo '<div class="clearfix"><a href="#" id="annual"><div class="slab reversed textMed blue">&laquo; Annual Lists</div></a><div class="slab textMed red">All Time Lists</div></div>';

							echo form_hidden('searchType', 'allTime'); // Track if the user is searching 'Annual' or 'All Time' lists and make the search form 'sticky'!

							echo form_hidden('token', $token);

							// Drop down menu - List of events
							// See global helper
							echo buildEventsDropdown(); 

							// Drop down menu - List of years
							// See profile helper
							//echo ranking_years();



							// Submit button
							echo form_submit('submit', 'View', 'class="btn"', 'id="submit"');

							echo '<div class="separator visible-phone"></div>';

							/****************************************************************************************************************/
							// DISPLAY 'PDF' PRINT OUTPUT BUTTON - (DISABLED FOR ALL TIME LISTS) !!!!
							/****************************************************************************************************************/
							// Display 'PRINT PDF' button .. only if 'event' and ageGroup have been selected
							// if($this->input->post('eventID') && $this->input->post('ageGroup'))
							// {
							// 	// Don't display PDF print button for 'Relay' events
							// 	if(!in_array($this->input->post('eventID'), $this->config->item('relay_events')))
							// 	{
							// 		echo anchor('pdf/pdf_con/results_PDF','Download PDF', array('class' => 'btn hidden-phone', 'style' => 'margin-left:10px;'));
							// 	}

							// }

							echo '<p style="margin-top:15px;"><span class="fresh_results">XXXX</span> = Performances in last 14 days</p>';

						echo '</div>';


						echo '<div class="span2">';
						
							// Radio Button list of age groups
							echo '<label class="bold">AGE GROUP</label>';

							echo buildAgeGroupRadioAT(); // see global_helper.php

							echo '<div class="separator visible-phone"></div>';
							echo '</div>';


							//Set some required defaults - in hidden fields
							// Year
							// List Depth
							// List Type

							echo '<input type="hidden" name="year" value="1900">';
							echo '<input type="hidden" name="list_depth" value="Athletes">';
							echo '<input type="hidden" name="list_type" value="0">';


						echo '</div>';

						echo '</fieldset>';
					// Close form
					echo form_close();

				echo '</div>';