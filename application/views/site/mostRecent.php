<div class="container">
	<div class="row">
		<div class="span12">

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

				echo '<div class="slab reversed textLarge">' . $gender . '</div><div class="slab textLarge blue">Past ' . $period . ' Days</div></br>';
				echo '<div class="slab reversed textSmall">Ordered by: </div><div class="slab textSmall red"> Event / Best Result</div>';
				echo '<div class="clearfix"></div>'; //Stop the table wrapping up around the title block!

			?>

			<table class="footable">
				<thead>
					<tr>
						<th data-class="expand">Event</th>
						<th data-hide="phone,tablet">Imp</th>
						<th>Result</th>
						<th data-hide="phone">Wind</th>
						<th>&nbsp;</th>
						<th>Name</th>
						<th data-hide="phone,tablet">DOB</th>
						<th data-hide="phone,tablet">Place</th>
						<th data-hide="phone,tablet">Competition</th>
						<th data-hide="phone">Venue</th>
						<th data-hide="phone">Date</th>
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
						<td>' . $event . '</td>
						<td>' . $imp . '</td>
						<td>' . $performance . ' ' . $in_out . '</td>
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
				echo '<h4>No results found for this period.</h4>';
			}
			
			?>
			

		</div>

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
				scrollTop: $(".searchBand").offset().top
			}, 500);
		});
	});

</script>