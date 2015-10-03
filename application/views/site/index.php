<div class="newsflashBand">


	<div class="container">
		<div class="row">
			<div class="span12">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#home" data-toggle="tab">Announcements</a></li>
					<li><a href="#news" data-toggle="tab">Latest News</a></li>
					<li><a href="#records" data-toggle="tab">Recent NZ Records</a></li>
					<li><a href="#history" data-toggle="tab">Today in History</a></li>
					<li><a href="#birthdays" data-toggle="tab">Athlete Birthdays</a></li>
				</ul>

				<!-- ========================================================================================== -->

				<div class="tab-content">

					<div class="tab-pane active" id="home"><!-- STARTS News Flash -->
						<div class="latest-news">
							<?php

								// If admin logged in allow editing privilages ...
								$admin = ( $this->session->userdata('is_logged_in') ) ? TRUE : FALSE;


								// Display a special 'Flash' message on the home page!
								if(isset($show_flash_news)) {

									$date_expires = $show_flash_news->expires;
									$current_date = date("Y-m-d");

									if(strtotime($current_date) <= strtotime($date_expires)) { // Display message for a valid time period only!

										echo '<h3>' . $show_flash_news->heading . '</h3>';
										echo $show_flash_news->bodyContent;

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
							
								echo '<h3>Latest News </h3>';

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
										
										echo '<hr>';

										echo '<div class="news_background">';
											echo '<h5>DATE: '. $row->date .'</h5>';
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

									foreach($ratified_record as $row):

										// Work out which type of record
										switch ($row->recordType){

											case 'NN':
											$recType = 'NZ National';
											break;

											case "NR":
											$recType = 'NZ Resident';
											break;

											case "AC":
											$recType = 'NZ All Commers';
											break;	
										}

										echo '<strong>' . $row->nameFirst . ' ' . $row->nameLast . '</strong> | ' . $recType . ' | ' . convertEventID($row->eventID)->eventName . ' | ' . ageGroupLabels($row->ageGroup) . ' | ' . $row->result . ' | ' . $row->newdate . '<br>';

					  				endforeach;

					  			} // ENDS $ratified_record
					  			else {
									echo '<p>Nothing to display ...</p>';
								}
							?>

						</div><!-- ENDS latest-news -->
					</div>

					<!-- ========================================================================================== -->

					<div class="tab-pane" id="history"><!-- STARTS Day History -->
						<div class="latest-news">
							<h3>On this day in history ...</h3>

							<?php
								// Shows records set athletes on this day in history ...
								if( isset( $records_this_day ) ) {
									foreach ($records_this_day as $row) {

										switch ($row->recordType){
											case 'AC':
												$recType = 'Allcomers';
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

										echo date('jS F', strtotime(date('Y-m-d'))) . ' ' .$row->recordDate . ', '.$nz_ageOfRecord.' - <strong>' . $row->nameFirst . ' ' .$row->nameLast . '</strong> (' . strtoupper($row->country) . ') sets a ' . ageGroupRecordHistoryConvert($row->ageGroup) . ' ' . $recType . ' Record of <strong>' . $row->result . '</strong> for the ' . $row->eventName . ', ' . $row->venue . '<br />';
									}
								}
								else {
									echo '<p>Nothing to display ...</p>';
								}

							?>

						</div><!-- ENDS latest-news -->
					</div><!-- ENDS Day History -->

					<!-- ========================================================================================== -->

					<div class="tab-pane" id="birthdays"><!-- STARTS Birthdays -->
						<div class="latest-news">
							<?php
								// Shows Athletes born this day on home page
								if( isset( $born_this_day ) ) {

									echo '<h3>NZ Athletes with birthdays today (' . date('jS F', strtotime(date('Y-m-d'))) . ')</h3>';

									echo '<table class="table table-striped">';
										echo '<tr>';
											echo '<td><strong>Name</strong></td>';
											echo '<td class="hidden-phone"><strong>Club</strong></td>';
											echo '<td><strong>Centre</strong></td>';
										echo '</tr>';

										foreach ($born_this_day as $row):
											echo '<tr>';
												echo '<td>' . $row->nameFirst . ' ' . strtoupper($row->nameLast) . '</td>';
												echo '<td class="hidden-phone">' . $row->clubName . '</td>';
												echo '<td>' . $row->centreID . ' </td>';
											echo '</tr>';
										endforeach;
									echo '</table>';
								}
								else {
									echo '<p>Nothing to display ...</p>';
								}
							?>
						</div><!-- ENDS latest-news -->
					</div><!-- ENDS Birthdays -->

					<!-- ========================================================================================== -->

				</div>
			</div><!--ENDS col-->
		</div><!--ENDS row-->
	</div><!--ENDS container-->

</div><!-- ENDS newsflash-band -->




<div id="top_index"></div><!-- TARGET - this is where the page will auto scroll to after form is submited -->

<?php
	// From index() home_con
	if( isset( $show_target ) )
	{
		echo $show_target; // TARGET - move page down to Top Performers table (for phones)
	}
?>

<div class="container">

	<div class="row">

		<div class="span12">

			<div class="slab reversed textLarge">Leading Performances</div><div class="slab textLarge lead_perfs blue"> <?php echo date('Y'); ?></div>
	  		<div style="clear:both;"></div>

			<?php
				// Form to choose which ageGroup to show top 'Year' lists
				echo form_open('site/home_con', array( 'id' => 'topPerformers' ));

				echo '<label></label>';
				echo buildAgeGroup_topLists( set_value('ageGroup') ); // from global_helper

				echo '<label></label>';
				echo '<button type="submit"  id="top_performers" class="btn">VIEW</button>';

				echo form_close();

			?>

			<?php
				/*************************************************************/
				// CREATE A LABEL HEADING FOR WHICH AGE GROUP IS BEING DISPLAYED
				/*************************************************************/

				// NEW! .. This give the new correct 'Age Group' Labels
				if( $this->input->post('ageGroup') ) {

					echo '<div class="slab reversed textMed ">' . ageGroupLabels( $this->input->post('ageGroup') ) . '</div><div class="slab textMed lead_perfs">' . date('Y') . '</div>'; // see global_helper

				}
				else
				{
					echo '<div class="slab reversed textMed">Senior Men</div><div class="slab textMed lead_perfs">' . date('Y') . '</div>';
				}

			?>

			  
			<table class="footable table-striped">
				<thead>
					<tr>
						<th data-class="expand">EVENT</th>
						<th>PEFR</th>
						<th data-hide="phone">WIND</th>
						<th>ATHLETE</th>
						<th data-hide="phone,tablet">Centre</th>
						<th data-hide="phone,tablet">DOB</th>
						<th data-hide="phone,tablet">COMPETITION</th>
						<th data-hide="phone">VENUE</th>
						<th data-hide="phone">DATE</th>
					</tr>
				</thead>
				<tbody>
				
			  
			<?php
				/***************************************************************************************************/
				// Display individual events for the homepage 'Toplists'
				/***************************************************************************************************/
				if( isset( $top_performers ) )
				{
					foreach( $top_performers as $row ):

						// This adds a highlight class to those rankings less than a week old!
						$dateClass = fresh_results($row->date); // from global_helper.php

						$coach = ( $row->coach ) ? 'COACH: ' . $row->coach : '';

						$years = age_from_dob($row->DOB) . ' years';
						$days = daysLeftForBirthday($row->DOB) . ' days';

						$age = 'AGE: ' . $years . ', ' . $days. '<br>' . $coach;

						$in_out = ($row->in_out == 'in') ? '(i)' : ''; 

						echo '<tr>
								<td>' . $row->eventName . '</td>
								<td><span class="'.$dateClass.'">' . ltrim($row->time, 0) . '' . ltrim($row->distHeight, 0) . '</span>&nbsp;'. $in_out .'</td>
								<td>' . $row->wind . '</td>
								<td>' . anchor('site/profiles_con/athlete/' . $row->athleteID, $row->nameFirst . ' ' . strtoupper($row->nameLast), array( 'class' => 'example', 'rel' => 'tooltip', 'title' =>$age )) . '</td>
								<td>' . $row->centreID . '</td>
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

				$coach = ( $row->coach ) ? 'COACH: ' . $topPerformers_Multis->coach : '';

				$years = age_from_dob($topPerformers_Multis->DOB) . ' years';
				$days = daysLeftForBirthday($topPerformers_Multis->DOB) . ' days';

				$age = 'AGE: ' . $years . ', ' . $days. '<br>' . $coach;

				echo '<tr>
						<td>' . $topPerformers_Multis->eventName . '</td>
						<td><span class="'.$dateClass.'">' . $topPerformers_Multis->points . '</span></td>
						<td>&nbsp;</td>
						<td>' . anchor('site/profiles_con/athlete/' . $topPerformers_Multis->athleteID, $topPerformers_Multis->nameFirst . ' ' . strtoupper($topPerformers_Multis->nameLast), array( 'class' => 'example', 'rel' => 'tooltip', 'title' => $age )) . '</td>
						<td>' . $topPerformers_Multis->centreID . '</td>
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
								<td>' . $row->eventName . '</td>
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


		</div><!-- ENDS span12 -->

		<div class="center"><a href="" class="to_top textSmall" id="bottom_index">Back To Top</a></div>

	</div><!-- ENDS row -->

</div><!-- ENDS container -->



<?php
if( isset( $show_target ) ) // Load the <script> only when form submitted !!!
{
?>

	<script>

		// Scroll Top Performers list to top of page
		$(document).ready(function (){
			$('html, body').animate({
			scrollTop: $(".top_home").offset().top
			}, 500);
		});

	</script>

<?php } ?>


<script>

	// This (on click of #bottom_index link) scolls to the top of search criteria form
	$(document).ready(function (){

		$('#top_performers').hide();
		
		$("#bottom_index").click(function (e){
			e.preventDefault();
			$('html, body').animate({
				scrollTop: $("#top_index").offset().top
			}, 500);
		});
	});

</script>

<script>
	// Displays tooltip of athletes age
	$(document).ready(function () {
		if ($("[rel=tooltip]").length) {
			$("[rel=tooltip]").tooltip({
				placement: 'right',
				html: true
			});
		}
	});
	
</script>