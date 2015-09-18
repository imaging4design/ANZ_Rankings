<div class="container">
	<div class="row">

		<div class="span12">
			<!--DISPLAY ATHLETES NAMES (Alpha) IN THIS DIV-->
  			<div class="athleteArea"></div>

  			<?php
				$date_value = "2015-09-18";
				$current_date = date("Y-m-d");

				if(strtotime($current_date) <= strtotime($date_value)) {
					echo '<div class="milestone center">';
					echo '<h1>Update Notice</h1>';
					echo '<p>I am currently on a break and during this period will not be able to upload any new performances to the ranking lists. Thank you for your patience and understanding. <br /><em class="text-muted">- Steve Hollings (Statistician)</em></p>';
					echo '<br />';
					echo '<div>';
				}
  			?>

		</div>

	</div>
</div>




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

			<div class="tabbable"> <!-- Only required for left/right tabs -->

				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab1" data-toggle="tab"><?php echo date('Y'); ?> LEADERS</a></li>
					<li><a href="#tab2" data-toggle="tab">LATEST NEWS</a></li>
				</ul>

				<div class="tab-content">

					<div class="tab-pane active" id="tab1">
						
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

							</div><!-- ENDS span6 -->

						</div><!-- ENDS row -->

					</div><!-- ENDS tab1 -->




					<div class="tab-pane" id="tab2">
						
						<div class="row">

							<div class="span12 news">

								<?php
								$admin = FALSE;

								if($this->session->userdata('is_logged_in'))
								{
									$admin = TRUE;
								}
								?>

								<div class="slab reversed textLarge">Latest</div><div class="slab textLarge blue">News</div>
					  			<div style="clear:both;"></div><br>

								<?php
								if(isset($show_news))
								{

									$count = 0;

									foreach($show_news as $row):

									
										//Make data selectable as 'Admin Edit'
										if($admin)
										{
											$edit = anchor('admin/news_con/populate_news/' . $row->newsID, 'EDIT ARTICLE', array( 'class' => 'btn' ));
										}
										else
										{
											$edit = '';
										}

										

										

										if( $count % 4 == 0 ) { echo '<div class="row">'; }	 // Modulus equation: If $count == 0 add class 'row'
										
											echo '<div class="span3">';

												echo $edit; // Admin 'Edit Article' button

												echo '<div class="news_background">';
												echo '<div class="newsHolder"><div class="slab reversed textMed">DATE: </div><div class="slab textMed red">' . $row->date . ' &raquo;</div>';
												echo '</div>' . character_limiter($row->bodyContent, 500, '') . ' &nbsp; ' . anchor('site/news_con/news_item/' .$row->newsID, '...&nbsp;view&nbsp;article ', array('class' => 'news_link')) . '</div>';
												echo '<hr>';

												

												// echo '<div class="news_background">';
												// echo '<div class="newsHolder"><div class="slab reversed textMed">DATE: </div><div class="slab textMed">' . $row->date . ' &raquo;</div>';
												// echo '</div><h2>' . $row->heading . '</h2> ' . $row->bodyContent . '</div>';
												// echo '<hr>';

											echo '</div>';
										
										
										if( $count % 4 == 3 ) { echo '</div>'; }	 // Modulus equation: If $count == 2 end class 'row'
										
										$count++;
									


									endforeach;

									// MODULUS Equation breakdown for each loop

									// $count( 0 ) % 3 = 0
									// $count( 1 ) % 3 = 1
									// $count( 2 ) % 3 = 2
									// $count( 3 ) % 3 = 0
									// $count( 4 ) % 3 = 1
									// $count( 5 ) % 3 = 2
									// $count( 6 ) % 3 = 0
									// $count( 7 ) % 3 = 1
									// $count( 8 ) % 3 = 2
									// $count( 9 ) % 3 = 0

									
								}
								?>

							</div><!--END span12-->

						</div><!-- ENDS row -->

					</div><!-- ENDS tab2 -->

				</div><!--ENDS tab-content -->

			</div><!--ENDS tabbable -->

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