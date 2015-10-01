<?php
	// Remove 'Profile Links' from historic athletes (i.e., any athlete with an athleteID less than 500000) !
	function athleteName( $athleteID, $nameFirst, $nameLast)
	{
		if( $athleteID <= 499999 )
		{
			return $athleteName = $nameFirst.' '.strtoupper($nameLast);
		}
		else
		{
			// Returns the dynamic clickable Athlete Name / Profile / Mini Profile link
			return $athleteName = anchor('site/profiles_con/athlete/' . $athleteID, $nameFirst.' '.strtoupper($nameLast)) . ' ' . anchor('', '<i class="fa fa-search"></i>', array('class'=>'miniProfile', 'data-id'=>$athleteID));
		}

	}

	// Remove these columns if period selection = 'All Time'
	// Centre, Place and Competition
	function showHide( $selectPeriod, $rowName ) 
	{
		if( $selectPeriod == 1900 )
		{
			return $rowName = '';
		}
		else
		{
			return $rowName = $rowName;
		}

	}

?>


<div class="container">

	<div class="row">

		<div class="span12">

			<div id="top_results"></div><!-- TARGET - this is where the page will auto scroll to after form is submited -->

			<?php

			// Display error message if missing either (event, ageGroup or year) selection
			if(isset($this->error_message))
			{
				echo $this->error_message;
			}
			else
			{

			
				/**************************************************************************************************/
				// DISPLAY THE EVENT TITLE AND YEAR above the results (i.e., 100m / Javelin Throw)
				/**************************************************************************************************/
				$event_name = '';
				$year = '';
				
				if( isset( $event_info ) )
				{
					
					foreach($event_info as $event):
					
						if($event->eventID == $this->input->post('eventID'))
						{
							// Get event label
							$event_name = '<span class="strong">' . $event->eventName . '</span>';
							
							// Get year label
							if($this->input->post('year') == 0):
							
								$year = 'All (from 2008)';
								
							elseif($this->input->post('year') == 1900):

								$year = 'All Time';

							else:
							
								$year = $this->input->post('year');
								
							endif;
							
							
							// Switch labels depending on 'Annual' or 'All Time' lists
							// see global_helper (ageGroupLabels & ageGroupLabelsAT)
							
							if( $this->input->post('ageGroup') ) {

								//$ageGroup = ageGroupLabels( $this->input->post('ageGroup') ); // see global_helper
								$ageGroup = ( $this->input->post( 'year' ) == 1900 ) ? ageGroupLabelsAT( $this->input->post('ageGroup') ) : ageGroupLabels( $this->input->post('ageGroup') );

							}
							
						}
						
					endforeach;
				
				}

				// Switch CSS colour of title between 'Annual' and 'All Time' lists (i.e., blue to red)
				$highlight = ( $this->input->post( 'year' ) == 1900 ) ? 'red' : 'blue';

				echo '<a id="top"></a>';
				echo '<div class="slab reversed textLarge">' . $event_name . '</div><div class="slab textLarge '.$highlight.' ">' . $ageGroup . ' ' . $year . '</div>';

				
				/**************************************************************************************************/
				// Display the current NZ Record for this event and age group ...
				/**************************************************************************************************/
				if($current_nz_record)
				{
					foreach( $current_nz_record as $row ):

						$nz_record = $row->result;
						$nz_athlete = $row->nameFirst . ' ' . $row->nameLast;
						$nz_ageGroup = ageGroupRecordConvert($row->ageGroup);
						$nz_date = $row->date;

						// This displays the actual age of the record in Years/Months/Days ...
						$nz_ageOfRecord = recordAge($row->date, date('Y-m-d')); // See global_helper.php
						
						echo '<div class="record-wrapper">';
							echo '<div class="slab reversed textSmall">NZ Record ' . $nz_ageGroup . '</div><div class="slab textSmall">' . $nz_record . ' / ' . $nz_athlete . '<span class="hidden-phone"> / ' . $nz_date . '</span></div><div class="slab textSmall red hidden-phone hover-record">' .$nz_ageOfRecord . ' old</div>';
						echo '</div>';

					endforeach;
				}
				else 
				{
					echo '<div class="slab reversed textSmall">NZ Record</div><div class="slab textSmall">N/A</div>';
				}
				

			}

			?>

			
			<div class="clearfix"></div><!-- Stop the table wrapping up arounf the title block! -->

	  
			<?php
			// Display this master table header for ALL except the relays!
			if( ! isset( $relays ) )
			{
			?>
	  
			<table class="footable table-striped">
				<thead>
					<tr>
						<th data-class="expand">Rank</th>
						<th>Result</th>
						<th data-hide="phone">Wind</th>
						<th>&nbsp;</th>
						<th>Name</th>
						<th data-hide="phone,tablet"><?php echo showHide( $this->input->post('year'), 'Centre' )  ?></th>
						<th data-hide="phone,tablet">DOB</th>
						<th data-hide="phone,tablet"><?php echo showHide( $this->input->post('year'), 'Place' )  ?></th>
						<th data-hide="phone,tablet"><?php echo showHide( $this->input->post('year'), 'Competition' )  ?></th>
						<th data-hide="phone">Venue</th>
						<th data-hide="phone">Date</th>
					</tr>
				</thead>

				<tbody>

	  
			<?php } ?>
	  
	  
	  
			<?php
				// IF ADMIN IS LOGGED IN -> ALLOW ADMIN TO SELECT A RESULT TO EDIT
				$admin = FALSE;
				if($this->session->userdata('is_logged_in'))
				{
					$admin = TRUE;
				}
			?>


			<?php
			/*
			|-----------------------------------------------------------------------------------------------------------------
			| IF NO RESULTS FOUND FROM USER SELECTION -> display (No Results Found)
			|-----------------------------------------------------------------------------------------------------------------
			*/
			if( ! isset($results) && ! isset($legal_wind) && ! isset($illegal_wind) && ! isset($multis) && ! isset($relays) && ! isset($this->error_message))
			{
				echo '<div class="slab textMed">No Results Found</div>';
			}
			?>


	  
			<?php
			/****************************************************************************************************************/
			// TRACK OR FIELD EVENTS -> ALL RESULTS (Wind irrelevant + NOT hand timed) ... i.e., 2000m, javelin, high jump, marathon
			/****************************************************************************************************************/
			if(isset($results))
			{
				$rank = 1;
				$cur_performance = NULL;
				
				foreach($results as $row):
				
				// IS THIS A TRACK EVENT OR A FIELD EVENT? 
				// Assign $row->time or $row->distHeight to $performance ( and trim leading 0's )
				$performance = ($row->time) ? ltrim($row->time, 0) : ltrim($row->distHeight, 0);

				// For 'All Time Lists' ....
				// If 'hand timed' (i.e., $row->record == 'h') - remove last '0'
				$performance = ( $row->record == 'h' || $row->record == 'y' ) ? substr_replace($performance , '',-1) : $performance;
				
				//Indoor / outdoor performance
				$in_out = ($row->in_out == 'in') ? $in_out = '(i)' : $in_out = '';

				
				if($admin) // Display editable link (on performance column)
				{
					$performance = anchor('admin/results_con/populate_results/' . $row->resultID, $performance);
				}
				
				// This adds a highlight class to those rankings less than a week old!
				$dateClass = fresh_results($row->date); // from global_helper.php

				// When displaying 'Rank' number - show = sign if performances are the same!
				$rank_style = ( $cur_performance === $performance ) ? '' : $rank;
		
				echo '<tr>
						<td>'. $rank_style .'</td>
						<td><span class="'.$dateClass.'">' . $performance . ' ' . $row->record . '</span> ' . $in_out . '</td>
						<td>' . $row->wind . '</td>
						<td>&nbsp;</td>
						<td>' . athleteName( $row->athleteID, $row->nameFirst, $row->nameLast ). '</td>
						<td>' . showHide( $this->input->post('year'), $row->centreID ) . '</td>
						<td>' . $row->DOB . '</td>
						<td>' . showHide( $this->input->post('year'), $row->placing ) . '</td>
						<td>' . showHide( $this->input->post('year'), $row->competition ) . '</td>
						<td>' . $row->venue . '</td>
						<td>' . $row->date . '</td>
					</tr>';
				
				$rank++;

				$cur_performance = $performance;
				
				endforeach;
			
			}
			?>


	  
			<?php
			/****************************************************************************************************************/
			// TRACK EVENTS -> LEGAL WIND (< 2.1 m/s)
			/****************************************************************************************************************/
			if(isset($legal_wind))
			{
				
				$rank=1;
				$cur_performance = NULL;
				
				foreach($legal_wind as $row):


				// IMPORTANT :: See functions at top of page for formatting 'All Time' lists
				// athleteName()
				// showHide()


				// IS THIS A TRACK EVENT OR A FIELD EVENT? 
				// Assign $row->time or $row->distHeight to $performance ( and trim leading 0's )
				$performance = ($row->time) ? ltrim($row->time, 0) : ltrim($row->distHeight, 0);

				// For 'All Time Lists' ....
				// If 'hand timed' (i.e., $row->record == 'h') - remove last '0'
				$performance = ( $row->record == 'h' || $row->record == 'y' ) ? substr_replace($performance , '',-1) : $performance;
				
				//Indoor / outdoor performance
				$in_out = ($row->in_out == 'in') ? $in_out = '(i)' : $in_out = '';

				
				if($admin) // Display editable link (on performance column)
				{
					$performance = anchor('admin/results_con/populate_results/' . $row->resultID, $performance);
				}

				// This adds a highlight class to those rankings less than a week old!
				$dateClass = fresh_results($row->date); // from global_helper.php

				// When displaying 'Rank' number - show = sign if performances are the same!
				$rank_style = ( $cur_performance === $performance ) ? '' : $rank;

				
				echo '<tr>
						<td>' . $rank_style . '</td>
						<td><span class="'.$dateClass.'">' . $performance . '' . $row->record . ' ' . $in_out . '</span></td>
						<td>' . $row->wind . '</td>
						<td>&nbsp;</td>
						<td>' . athleteName( $row->athleteID, $row->nameFirst, $row->nameLast ) . '</td>
						<td>' . showHide( $this->input->post('year'), $row->centreID ) . '</td>
						<td>' . $row->DOB . '</td>
						<td>' . showHide( $this->input->post('year'), $row->placing )  . '</td>
						<td>' . showHide( $this->input->post('year'), $row->competition ) . '</td>
						<td>' . $row->venue . '</td>
						<td>' . $row->date . '</td>
					</tr>';
				
				$rank++;
				$cur_performance = $performance;
				
				endforeach;

				
			
			}
				
			?>


	  
			<?php
			/****************************************************************************************************************/
			// TRACK EVENTS -> ILLEGAL WIND (> 2.0 m/s)
			/****************************************************************************************************************/
			if( isset($illegal_wind) && $this->input->post( 'year' ) != 1900)
			{
				
				$rank = 1;
				$cur_performance = NULL;
				

				echo '<tr>';
					echo '<td colspan="11"><h3>WIND-AIDED PERFORMANCES</h3></td>';
				echo '</tr>';
				
				foreach($illegal_wind as $row):



				/*******************************************************************************************************************************************************************************/
				// DEVELOPMENT  DEVELOPMENT  DEVELOPMENT  DEVELOPMENT  DEVELOPMENT  DEVELOPMENT  DEVELOPMENT  DEVELOPMENT

				$compare =  legal_vs_windy($row->athleteID); // Currently in the test_helper.php file

				// DEVELOPMENT  DEVELOPMENT  DEVELOPMENT  DEVELOPMENT  DEVELOPMENT  DEVELOPMENT  DEVELOPMENT  DEVELOPMENT
				/*******************************************************************************************************************************************************************************/

				// IS THIS A TRACK EVENT OR A FIELD EVENT? 
				// Assign $row->time or $row->distHeight to $performance ( and trim leading 0's )
				$performance = ($row->time) ? ltrim($row->time, 0) : ltrim($row->distHeight, 0);

				//Indoor / outdoor performance
				$in_out = ($row->in_out == 'in') ? $in_out = '<span class="textRed">(i)</span>' : $in_out = '';
				

				if($admin) // Display editable link (on performance column)
				{
					$performance = anchor('admin/results_con/populate_results/' . $row->resultID, $performance);
				}

				// This adds a highlight class to those rankings less than a week old!
				$dateClass = fresh_results($row->date); // from global_helper.php

				// When displaying 'Rank' number - show = sign if performances are the same!
				$rank_style = ( $cur_performance === $performance ) ? '' : $rank;

				// Only display athlete (WINDY) performances if they are superior to their LEGAL performances!
				if( $row->time < ltrim( $compare->legal_time, 0 ) or $row->distHeight > ltrim( $compare->legal_distHeight, 0 ) ) {

					echo '<tr>
							<td>' . $rank_style . '</td>
							<td><span class="'.$dateClass.'">' . $performance . '' . $row->record . '</span> ' . $in_out . '</td>
							<td>' . $row->wind . '</td>
							<td>&nbsp;</td>
							<td>' . anchor('site/profiles_con/athlete/' . $row->athleteID, $row->nameFirst.' '.strtoupper($row->nameLast)) . '</td>
							<td>' . $row->centreID . '</td>
							<td>' . $row->DOB . '</td>
							<td>' . $row->placing . '</td>
							<td>' . $row->competition . '</td>
							<td>' . $row->venue . '</td>
							<td>' . $row->date . '</td>
						</tr>';

					$rank++;
					$cur_performance = $performance;

				}
			
				endforeach;
			
			}
			
			?>
	  
	  
			<?php
			/****************************************************************************************************************/
			// MULTI EVENTS RESULTS
			/****************************************************************************************************************/
			if( isset( $multis ) )
			{
				
				$rank=1;
				$data='';
				$cur_performance = NULL;
				
				foreach($multis as $row):
				
				// Create an array of each 'discipline' result within the Decathlon / Heptathlon
				$discipline = array($row->e01, $row->e02, $row->e03, $row->e04, $row->e05, $row->e06, $row->e07, $row->e08, $row->e09, $row->e10);


				// Loop through each 'discipline' result
				// Assign it to $mark
				// Display it as reduce_multiples($data)
				foreach($discipline as $mark)
				{ 
					$data .= $mark . '&nbsp; | &nbsp;'; 
				}
				
				if($admin) // Display editable link (on performance column)
				{
					$performance = anchor('admin/multis_con/populate_results/' . $row->resultID, $row->points);
				}
				else
				{
					$performance = $row->points;
				}

				// This adds a highlight class to those rankings less than a week old!
				$dateClass = fresh_results($row->date); // from global_helper.php
				
				// When displaying 'Rank' number - show = sign if performances are the same!
				$rank_style = ( $cur_performance === $performance ) ? '' : $rank;

				echo '<tr>
						<td>' . $rank_style . '</td>
						<td><span class="'.$dateClass.'">' . $performance . '' . $row->record . '</span></td>
						<td>' . $row->wind . '</td>
						<td>&nbsp;</td>
						<td>' . athleteName( $row->athleteID, $row->nameFirst, $row->nameLast ) . '</td>
						<td>' . showHide( $this->input->post('year'), $row->centreID ) . '</td>
						<td>' . $row->DOB . '</td>
						<td>' . showHide( $this->input->post('year'), $row->placing ) . '</td>
						<td>' . showHide( $this->input->post('year'), $row->competition ) . '</td>
						<td>' . $row->venue . '</td>
						<td>' . $row->date . '</td>
					</tr>';

				
				if( $this->input->post( 'year' ) != 1900) // Only display on 'Annual Lists' - NOT 'All Time Lists'
				{
					echo '<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td colspan="10">' .reduce_multiples($data, "&nbsp; | &nbsp;", TRUE) . '</td>
						</tr>';
				}

				
				$rank++;
				$data = '';
				$cur_performance = $performance;
				
				endforeach;
			
			}
			
			?>

			</tbody>
			</table>


	  
			<?php
			/****************************************************************************************************************/
			// RELAY EVENTS
			/****************************************************************************************************************/
			if(isset($relays))
			{
			?>

			<table class="footable">
				<thead>
					<tr>
						<th data-class="expand">Rank</th>
						<th>Result</th>
						<th data-hide="phone,tablet">&nbsp;</th>
						<th>Team</th>
						<th data-hide="phone,tablet">Athletes</th>
						<th data-hide="phone,tablet">Place</th>
						<th data-hide="phone,tablet">Competition</th>
						<th data-hide="phone">Venue</th>
						<th>Date</th>
					</tr>
				</thead>

				<tbody>

					<?php
					$rank=1;
					
					foreach($relays as $row):
					
						// Left trim leading 0's
						$performance = ltrim($row->time, 0);
						
						// Combine athletes (relay tema members)
						$athletes = $row->athlete01 . ', ' . $row->athlete02 . ', ' . $row->athlete03 . ', ' . $row->athlete04;
						
						if($admin) // Display editable link (on performance column)
						{
							$performance = anchor('admin/relays_con/populate_relays/' . $row->resultID, $performance);
						}

						// This adds a highlight class to those rankings less than a week old!
						$dateClass = fresh_results($row->date); // from global_helper.php
						
							echo '<tr>
									<td>' . $rank . '</td>
									<td><span class="'.$dateClass.'">' . $performance . '</span></td>
									<td>' . $row->record . '</td>
									<td>' . $row->team . '</td>
									<td>' . $athletes . '</td>
									<td>' . $row->placing . '</td>
									<td>' . $row->competition . '</td>
									<td>' . $row->venue . '</td>
									<td>' . $row->date . '</td>
								</tr>';
						
						$rank++;
					
					endforeach;
					
					}
						
				?>

				</tbody>
				</table>



			<div class="center"><a href="" class="to_top textSmall" id="bottom_results">Back To Top</a></div>
  
		</div><!--END span12-->

	</div><!--END row-->

</div><!--END container-->





<!-- This displays the athlete 'mini profile' that slides in from the left -->
<div class="flyout-btn" id="flyout-btn"><i class="fa fa-close"></i></div>
<div class="flyout">
	<div class="flyout-content" id="showEntry"></div>
</div>


<script>
	// This will (on hover) show the actual time the record has held for ...
	$(document).ready(function (){
		$('.record-wrapper').hover(function(){
			$(this).children().toggleClass('hover-record-show');
		});

	});

</script>


<script>
	// This (on page load) scolls to the top of the list being viewed
	$(document).ready(function (){
		$('html, body').animate({
		scrollTop: $("#top_results").offset().top
		}, 500);
	});
	

	// This (on click of #to_top link) scolls to the top of search criteria form
	$(document).ready(function (){
		$("#bottom_results").click(function (e){
			e.preventDefault();
			$('html, body').animate({
				scrollTop: $("#top_results_search").offset().top
			}, 500);
		});
	});

	// Dynamically adjust 'flyout-btn' height (keep it on screen at top)
	function flyoutBtnTop(){
		var position = window.pageYOffset;
		$('.flyout-btn').css('top', position);
	}
	
	window.addEventListener('scroll', flyoutBtnTop, false);


</script>


<!--JQUERY AJAX 'ADD RESULTS' SCRIPT-->
<script type="text/javascript">

$(function() {

$('.miniProfile').click(function() {
	
	$('#showEntry').append('<img src="<?php echo base_url() . 'img/loading.gif' ?>" alt="Currently Loading" id="loading" />');

	var athleteID = $(this).data("id");
	
	$.ajax({
		url: '<?php echo base_url() . 'site/profiles_con/athleteFlyout'; ?>',
		type: 'POST',
		data: '&athleteID=' + escape(athleteID),
		
		success: function(result) {
				
				$('#loading').fadeOut(500, function() {
					$(this).remove();
				});

				$('#showEntry').html(result);

				$('.flyout-btn').on('click', function(){
					$('.flyout').removeClass('open');
					$('.flyout-btn').removeClass('open');
				});
				
				$('.flyout').addClass('open');
				$('.flyout-btn').addClass('open');
					
			}

		});
		
		return false;
		
	});
	
});

</script>