<div class="container container-class" style="padding-top: 20px;">

	<div class="row">
		<div class="col-sm-12">

			<a id="top"></a>
			
			<div class="clearfix"></div><!-- Stop the table wrapping up arounf the title block! -->


			

			<?php
				// From index() home_con
				if( isset( $show_target ) )
				{
					echo $show_target; // TARGET - move page down to Top Performers table (for phones)
				}
			?>


			<?php
			if( isset($most_recent) ) { 

				// Display main title
				$period = $this->input->post( 'time_frame');
				$gender = ( $this->input->post( 'gender' ) === 'men' ) ? 'Men' : 'Women';


				//echo '<div class="slab reversed textLarge">' . $gender . '</div><div class="slab textLarge blue">Past ' . $period . ' Days</div></br>';
				//echo '<div class="slab reversed textSmall">Ordered by: </div><div class="slab textSmall red"> Event / Best Result</div>';
				//echo '<div class="clearfix"></div>'; //Stop the table wrapping up around the title block!

				echo '<h2 class="h2-two"><strong>' . $gender . '</strong> Past ' . $period . ' Days</h2>';
				echo '<p>Ordered by: Event / Best Result</p>';

			?>

			<table class="table table-striped" data-toggle-column="last">
				<thead>
					<tr>
						<th>Event</th>
						<th data-breakpoints="sm xs">Imp</th>
						<th>Result</th>
						<th data-breakpoints="xs">Wind</th>
						<th>&nbsp;</th>
						<th data-type="html">Name</th>
						<th data-breakpoints="sm xs">DOB</th>
						<th data-breakpoints="sm xs">Place</th>
						<th data-breakpoints="sm xs">Competition</th>
						<th data-breakpoints="xs">Venue</th>
						<th data-breakpoints="xs">Date</th>
					</tr>
				</thead>

				<tbody>

			<?php

			// Event label
			$event = NULL; // Initialise
			$event_current = NULL; // Initialise

			foreach( $most_recent as $row ) {

				// IS THIS A TRACK EVENT OR A FIELD EVENT? 
				// Assign $row->time or $row->distHeight to $performance ( and trim leading 0's )
				$performance = ($row->time) ? ltrim($row->time, 0) : ltrim($row->distHeight, 0);

				// Describe implement
				$imp = ( $row->implement ) ? '<span class="muted">(' . ltrim($row->implement, 0) . ')</span>' : '';

				//Indoor / outdoor performance
				$in_out = ($row->in_out == 'in') ? $in_out = '(i)' : $in_out = '';

				// Event label
				$event = ( $event_current == $row->eventName ) ? '' : $row->eventName;

				echo '<tr>
						<td style="font-weight:900;">' . $event . '</td>
						<td>' . $imp . '</td>
						<td>' . $performance . ' ' . $in_out . ' <span class="textREDD">' . $row->record . '</span></td>
						<td>' . $row->wind . '</td>
						<td> &nbsp; </td>
						<td>' . anchor('site/profiles_con/athlete/' . $row->athleteID, $row->nameFirst.' '.strtoupper($row->nameLast)) . '</td>
						
						<td>' . $row->DOB . '</td>
						<td>' . $row->placing . '</td>
						<td>' . $row->competition . '</td>
						<td>' . $row->venue . '</td>
						<td>' . $row->date . '</td>
					</tr>';

				// Get the current event name so we don't repeat it in the next loop - if same event. 
				$event_current = $row->eventName;

			}


			if( isset( $most_recent_multis ) ) { 

				// Event label
				$multiEvent = NULL; // Initialise
				$multiEvent_current = NULL; // Initialise

				foreach( $most_recent_multis as $row ) {

					// Event label
					$multiEvent = ( $multiEvent_current == $row->eventName ) ? '' : $row->eventName;


					echo '<tr>
							<td>' . $multiEvent . '</td>
							<td>&nbsp;</td>
							<td>' . $row->points . ' ' . $row->record . '</td>
							<td>' . $row->wind . '</td>
							<td>' . $row->record . '</td>
							<td>' . anchor('site/profiles_con/athlete/' . $row->athleteID, $row->nameFirst.' '.strtoupper($row->nameLast)) . '</td>
							
							<td>' . $row->DOB . '</td>
							<td>' . $row->placing . '</td>
							<td>' . $row->competition . '</td>
							<td>' . $row->venue . '</td>
							<td>' . $row->date . '</td>
						</tr>';


					// Get the current event name so we don't repeat it in the next loop - if same event. 
					$multiEvent_current = $row->eventName;

				}

			}

			?>

				</tbody>

			</table>

			<?php

			}
			else
			{
				echo '<h3 class="h3-two">No results found</h3>';
			}
			
			?>
			

		</div>

		<div class="center"><a href="#" class="btn btn-search" id="bottom_recent">New Search &nbsp; <i class="fa fa-chevron-up" aria-hidden="true"></i></a></div>

	</div><!-- ENDS row -->

</div><!-- ENDS container -->


<?php
if( isset( $show_target ) ) // Load the <script> only when form submitted !!!
{
?>

	<script>

		// ON LOAD (of results) - scroll to top of list
		// ************************************************************************
		$(window).load(function() {

			var winWidth = $( window ).width();
			var offSetDist = false;

			if( winWidth <= 752 ) {
				offSetDist = -60;
			} else {
				offSetDist = 0;
			}

			var resultsLoaded = $('h2').delay(10).velocity('scroll', { offset: offSetDist, duration: 500, easing: [ 0.17, 0.67, 0.83, 0.67 ]});
			
		});

	</script>

<?php } ?>



<script>

	// BACK TO TOP (of search form)
	// ************************************************************************
	$(document).ready(function(){

		var winWidth = $( window ).width();
		var offSetDist = false;

		if( winWidth <= 752 ) {
			offSetDist = -45;
		} else {
			offSetDist = 0;
		}

		$("#bottom_recent").on('click', function (){
			$('.search-form').velocity('scroll', { offset: offSetDist, duration: 500, easing: [ 0.17, 0.67, 0.83, 0.67 ]});
			return false;
		});

	});

</script>