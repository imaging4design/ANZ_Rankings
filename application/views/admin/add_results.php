<div class="row">
	<div class="col-md-12">
		
		<h1>Add New Result <small>(Individual Event)</small></h1>

		<div class="row">
			<div class="col-md-12">
				<div id="showEntry"></div><!--Load jQuery ENTRY message-->
			</div>
		</div>


		<div class="well well-trans">

			<?php echo form_open('admin/results_con/add_result_ind'); ?>

				<!--Adds hidden CSRF unique token
				This will be verified in the controller against
				the $this->session->userdata('token') before
				returning any results data-->
				<input type="hidden" name="token_admin" id="token_admin" value="<?php echo $token_admin; ?>" />

				<div class="row">
					<div class="col-md-4">
						<?php
							// Display full list of events drop down menu
							echo '<div class="form-group">';
							echo '<label for="eventID">Event: </label>';
							//echo buildEventsDropdown(); // See global helper
							echo buildRecordEventsDropdown($value='', $selected='', $label=''); // See global helper
							echo '</div>';
						?>
					</div><!--ENDS col-->
					<div class="col-md-8">
						<div class="form-group">
							<h1 class="padTop10"><strong id="eventDisplay"></strong></h1>
						</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->


				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="athlete">Athlete:</label>
							<input type="text" name="athleteID" class="form-control" id="athleteID" />
							<!--DON'T REMOVE id="athlete" (required for auto-populate!)-->
						</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->


				<div class="row">

					<div class="col-md-2">
						<div class="form-group" id="trackEvent"><!-- Show/Hide with jQuery depending on event selected! -->
							<label for="time">Time:</label>
							<input type="text" name="time" id="time" class="form-control" value="<?php echo set_value('time'); ?>" />
						</div>
					</div><!-- ENDS col -->

					<div class="col-md-2">
						<div class="form-group" id="fieldEvent"><!-- Show/Hide with jQuery depending on event selected! -->
							<label for="distHeight">Dist/Height:</label>
							<input type="text" name="distHeight" id="distHeight" class="form-control" value="<?php echo set_value('distHeight'); ?>" />
						</div>
					</div><!-- ENDS col -->

					<div class="col-md-2">
						<div class="form-group">
							<label for="wind">Wind:</label>
							<input type="text" name="wind" id="wind" class="form-control" value="<?php echo set_value('wind'); ?>" />
						</div>
					</div><!-- ENDS col -->

					<div class="col-md-3">
						<div class="form-group">
							<label for="placing">Placing:</label>
							<input type="text" name="placing" id="placing" class="form-control" value="<?php echo set_value('placing'); ?>" />
						</div>
					</div><!-- ENDS col -->

					<div class="col-md-3">
						<div class="form-group">
							<label for="record">Record:</label>
							<input type="text" name="record" id="record" class="form-control" value="<?php echo set_value('record'); ?>" />
						</div>
					</div><!-- ENDS col -->

				</div><!--ENDS row-->
				

				<div class="row">
					<div class="col-md-6">

						<?php
							// Display full list of events drop down menu
							echo '<div class="form-group">';
							echo '<label for="ageGroup">Age Group:</label>';
							echo buildAgeGroupDropdown(); // See global helper
							echo '</div>';
						?> 

					</div><!--ENDS col-->
				</div><!--ENDS row-->
			  

				<div class="row">
					<div class="col-md-8">
						<div class="form-group">	
							<label for="competition">Competition:</label>
							<input type="text" name="competition" id="competition" class="form-control" value="<?php echo set_value('competition'); ?>" />
						</div>
					</div><!--ENDS col-->

					<div class="col-md-4">
						<div class="form-group">
							<label for="in_out">Indoors / Outdoors:</label>
							<?php echo in_out(set_value('in_out')); ?>
						</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->


				<div class="row">
					<div class="col-md-4">
						<?php
							// Display drop down menu for default venues
							echo '<div class="form-group">';
							echo get_venues(); // See global helper
							echo '</div>';
						?>
					</div><!--ENDS col-->

					<div class="col-md-4">
						<div class="form-group">
							<label for="venue_other">Venue (Other):</label>
							<input type="text" name="venue_other" id="venue_other" class="form-control" value="<?php echo set_value('venue_other'); ?>" />
						</div>
					</div><!--ENDS col-->

					<div class="col-md-4">
						<!-- jQuery UI Date Picker -->
						<div class="form-group">
							<label for="date">Date: </label>
							<input type="text" id="date" class="form-control" name="date" />
						</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->


				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<input type="submit" name="submit" id="submit" class="btn btn-green" value="Save Result" />
						</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->
			  

			<?php echo form_close(); ?>

		</div><!-- ENDS well well-trans -->

	</div><!--ENDS col-->
</div><!--ENDS row-->





<script>
	$('#eventID').on('change', function() {
		
		var showEventLabel = $("#eventID :selected").text()
		$('#eventDisplay').html(showEventLabel);
	});
</script>


<script>
	
	// Used to hide either the 'Time' or 'Dist/Height' input boxes depending on what event is selected
	// Example :: If the 400m (track event is selected) hide the 'Dist/Height' input box
	// WHY? :: To prevent data being accidentally entered into the wrong field!

	// Initiate var
	var selectedEvent = false;

	$('#trackEvent').hide();
	$('#fieldEvent').hide();

	$('#eventID').on('change', function() {
		var selectedEvent = this.value;
		//alert( selectedEvent ); // or $(this).val()
		
		// This array contains 'Field Event IDs' ONLY!!
		var field = ['26', '27', '28', '29', '30', '31', '32', '33'];

		if ($.inArray(selectedEvent, field) > -1)
		{
			//console.log('I\'m a Field Event!');
			$('#trackEvent').hide();
			$('#fieldEvent').show();

		} else {

			$('#trackEvent').show();
			$('#fieldEvent').hide();
		}

    });

	
</script>



<!--JQUERY AJAX 'ADD RESULTS' SCRIPT-->
<script type="text/javascript">

$(function() {

$('#submit').click(function() {
$('#showEntry').append('<img src="<?php echo base_url() . 'img/loading.gif' ?>" alt="Currently Loading" id="loading" />');

	var token_admin = $('#token_admin').val();
	var athleteID = $('#athleteID').val();
	var time = $('#time').val();
	var distHeight = $('#distHeight').val();
	var wind = $('#wind').val();
	var record = $('#record').val();
	var placing = $('#placing').val();
	var eventID = $('#eventID').val();
	var ageGroup = $('#ageGroup').val();
	var competition = $('#competition').val();
	var in_out = $('#in_out').val();
	var venue = $('#venue').val();
	var venue_other = $('#venue_other').val();
	var date = $('#date').val();
	
	
	$.ajax({
		url: '<?php echo base_url() . 'admin/results_con/add_result_ind'; ?>',
		type: 'POST',
		data: 'token_admin=' + token_admin
		+ '&athleteID=' + escape(athleteID)
		+ '&time=' + time
		+ '&distHeight=' + distHeight
		+ '&wind=' + wind
		+ '&record=' + record
		+ '&placing=' + placing
		+ '&eventID=' + eventID
		+ '&ageGroup=' + ageGroup
		+ '&competition=' + escape(competition) 
		+ '&in_out=' + in_out
		+ '&venue=' + venue
		+ '&venue_other=' + escape(venue_other)
		+ '&date=' + date,
		
		success: function(result) {
				
				$('#loading').fadeOut(500, function() {
					$(this).remove();
				});
				
				$('#showEntry').html(result);
				
				$("#athleteID, #time, #distHeight, #placing, #record").val('');
				
				// Clears the AthleteID field when onFocus
				$('#competition, #venue_other').one("focus", function() {
					$(this).val("");
				});
					
			}

		});
		
		return false;
		
	});
	
});

</script>
