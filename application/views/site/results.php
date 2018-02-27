<?php
	// Remove 'Profile Links' from historic athletes (i.e., any athlete with an athleteID less than 500000) !
	function athleteName( $athleteID, $nameFirst, $nameLast, $eventID, $eventType)
	{
		if( $athleteID <= 499999 )
		{
			return $athleteName = $nameFirst.' '.strtoupper($nameLast);
		}
		else
		{
			// Returns the dynamic clickable Athlete Name / Profile / Mini Profile link
			// Not visible on mobile

			// return $athleteName = anchor('site/profiles_con/athlete/' . $athleteID, $nameFirst.' '.strtoupper($nameLast)) . '</a>';
			if( in_array($eventID, $eventType) ) {
				return $athleteName = anchor('site/profiles_con/athlete/' . $athleteID, $nameFirst.' '.strtoupper($nameLast)) . ' <span class="hidden-xs"><a href="#;" data-toggle="modal" data-target="#exampleModal" data-whatever="'.$athleteID.'"><i class="fa fa-search"></i></a></span>';
			} else {
				return $athleteName = '<input type="checkbox" name="athlete[]" value="'.strtoupper($nameLast).' ' . $nameFirst .', '.$athleteID.'"> ' . anchor('site/profiles_con/athlete/' . $athleteID, $nameFirst.' '.strtoupper($nameLast));
			}
			
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


<div class="container container-class" style="padding-top: 20px;">

	<!-- <div class="row no-gutter">

		<div class="col-sm-12">

			<div class="new-compare-feature">
				<div class="large"><strong>New Feature:</strong> <br class="visible-xs">Athletes - Head to Head</div>
				<p>Check the box next to two athlete (names) for a head-to-head comparison.</p>
			</div>

		</div>

	</div> -->

	<div class="row">

		<div class="col-sm-12">

			<div id="top_results"></div><!-- TARGET - this is where the page will auto scroll to after form is submited -->
			
            <p class="pull-right hidden-xs" style="margin-top: 15px;"><span class="fresh_results">XXXX</span> = Performances in last 14 days</p>
			
			<?php

				// Display error message if missing either (event, ageGroup or year) selection
				if( ! isset($this->error_message) )
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
					$highlight = ( $this->input->post( 'year' ) != 1900 ) ? 'h2-one' : 'h2-three';

					//echo '<a id="top"></a>';
					//echo '<div class="slab reversed textLarge">' . $event_name . '</div><div class="slab textLarge '.$highlight.' ">' . $ageGroup . ' ' . $year . '</div>';

					echo '<h2 class="' . $highlight . '"><strong>' . $event_name . '</strong> ' . $ageGroup . ' ' . $year . '</h2>';
					
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
							
							
							// echo '<div class="record-wrapper">';
							// 	echo '<div class="slab reversed textSmall">NZ Record ' . $nz_ageGroup . '</div><div class="slab textSmall">' . $nz_record . ' / ' . $nz_athlete . '<span class="hidden-phone"> / ' . $nz_date . '</span></div><div class="slab textSmall red hover-record">' .$nz_ageOfRecord . ' ago</div>';
							// echo '</div>';

							echo '<div class="record">';
								echo '<h3>NZ ' . $nz_ageGroup . ' Record: ' . $nz_record . ', <strong><br class="visible-xs">' . $nz_athlete . '</strong><span class="hidden-phone">, ' . $nz_date . ' ';
								echo '<br class="visible-xs"><small> Set: ' . $nz_ageOfRecord . ' ago</small></h3>';
							echo '</div>';

						endforeach;
					}
					else 
					{
						echo '<div class="slab reversed textSmall">NZ Record</div><div class="slab textSmall">N/A</div>';
					}
					

				} // Ends error message

			?>

			
			<div class="clearfix"></div><!-- Stop the table wrapping up around the title block! -->

	  

			<?php

				echo form_open('site/compare_con/compare_athlete_data', array('id' => 'compare'));
				echo form_hidden('token', $token);
				echo form_hidden('eventID', $this->session->userdata('eventID'));
				echo form_hidden('ageGroup', $this->session->userdata('ageGroup'));

				//echo form_hidden('athleteID', 521419);
				//echo form_hidden('athleteID2', 504628);

					// IF ADMIN IS LOGGED IN -> ALLOW ADMIN TO SELECT A RESULT TO EDIT
					//if($this->session->userdata('is_logged_in'))
					
					// Include ...
					// TRACK OR FIELD EVENTS -> ALL RESULTS (Wind irrelevant + NOT hand timed) ... i.e., 2000m, javelin, high jump, marathon
					$this->load->view('site/results_inc/results_non_wind');
					
					
					// Include ...
					// TRACK EVENTS -> LEGAL WIND (< 2.1 m/s)
					$this->load->view('site/results_inc/results_wind');


					// Include ...
					// TRACK EVENTS -> ILLEGAL WIND (> 2.0 m/s)
					$this->load->view('site/results_inc/results_wind_illegal');


					// Include ...
					// MULTI EVENTS RESULTS
					$this->load->view('site/results_inc/results_multis');


					// Include ...
					// RELAY EVENTS
					$this->load->view('site/results_inc/results_relays');

				echo form_close();
				
			?>
	  

			<div class="center"><a href="#" class="btn btn-search" id="bottom_results">New Search &nbsp; <i class="fa fa-chevron-up" aria-hidden="true"></i></a></div>
  
		</div><!--END col-sm-12-->

	</div><!--END row-->

</div><!--END container-->





<!-- DISPLAYS MINI-PROFILE POP-UP MODAL -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<img src="<?php echo base_url() . 'img/anz_logo_small.svg'; ?>" width="140px" height="auto">
				<!-- <h4 class="modal-title" id="exampleModalLabel">Athlete Profile</h4> -->
			</div>
		<div class="modal-body">
			<!-- Dynamic content inserted here ... -->
		</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>




<script>

	// BACK TO TOP (of search form)
	// ************************************************************************
	$(window).load(function(){

		var winWidth = $( window ).width();
		var offSetDist = false;

		if( winWidth <= 752 ) {
			offSetDist = -45;
		} else {
			offSetDist = 0;
		}

		$("#bottom_results").on('click', function (){
			$('.search-head').velocity('scroll', { offset: offSetDist, duration: 500, easing: [ 0.17, 0.67, 0.83, 0.67 ]});
			return false;
		});


		// ON LOAD (of results) - scroll to top of list
		// ************************************************************************
		if( winWidth <= 752 ) {
			offSetDist = -45;
		} else {
			offSetDist = 0;
		}

		$('#top_results').delay(10).velocity('scroll', { offset: offSetDist, duration: 500, easing: [ 0.17, 0.67, 0.83, 0.67 ]});
		
	});
	


	// JQUERY AJAX 'ADD RESULTS' SCRIPT
	// ************************************************************************
	$('#exampleModal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Button that triggered the modal
		var athleteID = button.data('whatever') // Extract info from data-* attributes

		var modal = $(this)
		
		$.ajax({
			url: 'profiles_con/athleteFlyout',
			type: 'POST',
			data: '&athleteID=' + escape(athleteID),
			success: function(result) {
				modal.find('.modal-body').html(result)
			}
		});

	});



	// SEND 'COMPARE' FORM DATA
	// ************************************************************************
	$("input[name='athlete[]']").change(function(){

		//Submit form when two x athlete (checkboxes) have been seletected.
		if( $("input[name='athlete[]']:checked").length === 2 ) {
			$( "#compare" ).submit();
		}

	});

</script>