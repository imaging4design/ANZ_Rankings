<div class="row">
	<div class="col-md-12">

		<h1 class="title">Edit Result<small> (Individual Event)</small></h1>

		<div class="row">
			<div class="col-md-12">
				<div id="showEntry"></div><!--Load jQuery ENTRY message-->
				<div id="showDelete"></div><!--Load jQuery DELETE message-->
			</div>
		</div>


		<div class="well well-trans" id="well">
  
			<button id="delButton" class="btn btn-red pull-right" class="button">Delete Result</button>

			<?php echo form_open('admin/results_con/update_result_ind', array('class' => 'results', 'id'=>'form')); ?>
			  
				<!--Adds hidden CSRF unique token
				This will be verified in the controller against
				the $this->session->userdata('token') before
				returning any results data-->
				<input type="hidden" name="token_admin" id="token_admin" value="<?php echo $token_admin; ?>" />

				<!--Get the resultID-->
				<input type="hidden" name="resultID" id="resultID" value="<?php echo $this->uri->segment(4); ?>" />



				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<?php
								// Display full list of events drop down menu
								// This will initially show the existing value of the eventID column as 'Selected'
								echo '<label for="eventID">Event: </label>';
								echo buildRecordEventsDropdown($pop_data->eventID, $pop_data->eventID, $pop_data->eventName); // See global helper
							?>
						</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->



				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="athlete">Athlete:</label>
							<input type="text" name="athleteID" id="athleteID" class="form-control" value="<?php echo $pop_data->athleteID; ?>" />
							<!--DON'T REMOVE class="athlete" (required for auto-populate!)-->
						</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->


			  
			  	<div class="row">

					<div class="col-md-2">
						<div class="form-group" id="trackEvent"><!-- Show/Hide with jQuery depending on event selected! -->
							<label for="time">Time:</label>
							<input type="text" name="time" id="time" class="form-control" value="<?php echo ltrim($pop_data->time, 0); ?>" />
						</div>
					</div><!-- ENDS col -->

					<div class="col-md-2">
						<div class="form-group" id="fieldEvent"><!-- Show/Hide with jQuery depending on event selected! -->
							<label for="distHeight">Dist/Height:</label>
							<input type="text" name="distHeight" id="distHeight" class="form-control" value="<?php echo ltrim($pop_data->distHeight, 0); ?>" />
						</div>
					</div><!-- ENDS col -->

					<div class="col-md-2">
						<div class="form-group">
							<label for="wind">Wind:</label>
							<input type="text" name="wind" id="wind" class="form-control" value="<?php echo $pop_data->wind; ?>" />
						</div>
					</div><!-- ENDS col -->

					<div class="col-md-3">
						<div class="form-group">
							<label for="placing">Placing:</label>
							<input type="text" name="placing" id="placing" class="form-control" value="<?php echo $pop_data->placing; ?>" />
						</div>
					</div><!-- ENDS col -->

					<div class="col-md-3">
						<div class="form-group">
							<label for="record">Record:</label>
							<input type="text" name="record" id="record" class="form-control" value="<?php echo $pop_data->record; ?>" />
						</div>
					</div><!-- ENDS col -->

				</div><!--ENDS row-->
			    

				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<?php
								// Display full list of ageGroups drop down menu
								// This will initially show the existing value of the ageGroup column as 'Selected'
								echo '<label for="ageGroup">Age Group:</label>';
								echo buildAgeGroupDropdown($pop_data->ageGroup);
							?>
						</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->



				<div class="row">
					<div class="col-md-8">
						<div class="form-group">	
							<label for="competition">Competition:</label>
							<input type="text" name="competition" id="competition" class="form-control" value="<?php echo $pop_data->competition; ?>" />
						</div>
					</div><!--ENDS col-->

					<div class="col-md-4">
						<div class="form-group">
							<?php $in_out = ($pop_data->in_out == 'out') ? 'Outdoors' : 'Indoors'; ?>

							<label for="in_out">Indoors / Outdoors:</label>
							<select name="in_out" id="in_out" class="form-control">
								<option value="<?php echo $pop_data->in_out; ?>" selected="<?php echo $pop_data->in_out; ?>"><?php echo $in_out; ?></option>
								<option value="out">Outdoors</option>
								<option value="in">Indoors</option>
							</select>
						</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->
				

			  
			  	<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<?php
								// Display drop down menu for default venues
								// This will initially show the existing value of the venue column as 'Selected'
								echo get_venues($pop_data->venue); // See global helper
							?>
						</div>
					</div><!--ENDS col-->

					<div class="col-md-3">
						<div class="form-group">
							<label for="venue_other">Venue (Other):</label>
							<input type="text" name="venue_other" id="venue_other" class="form-control" value="<?php echo set_value('venue_other'); ?>" />
						</div>
					</div><!--ENDS col-->

					<div class="col-md-2">
						<div class="form-group">
							<?php
								// Explode the date into segments (Day, month year)
								// Use these segments as 'selected' values for the date drop downs
								$dateArray=explode('-', $pop_data->date);

								// Display drop down menus for date (day, month, year)
								echo '<label for="date">Date (Day): </label>';
								echo buildDayDropdown($name='day', $value=$dateArray[2], $id='id="day", class="form-control"'); // See global helper
							?>
						</div>
					</div><!--ENDS col-->

					<div class="col-md-2">
						<div class="form-group">
							<?php
								// Explode the date into segments (Day, month year)
								// Use these segments as 'selected' values for the date drop downs
								$dateArray=explode('-', $pop_data->date);

								// Display drop down menus for date (day, month, year)
								echo '<label for="date">Date (Month): </label>';
								echo buildMonthDropdown($name='month', $value=$dateArray[1], $id='id="month", class="form-control"'); // See global helper
							?>
						</div>
					</div><!--ENDS col-->

					<div class="col-md-2">
						<div class="form-group">
							<?php
								// Explode the date into segments (Day, month year)
								// Use these segments as 'selected' values for the date drop downs
								$dateArray=explode('-', $pop_data->date);

								// Display drop down menus for date (day, month, year)
								echo '<label for="date">Date (Year): </label>';
								echo '<input type="text" name="year" id="year" class="form-control" value="'.$value=$dateArray[0].'" />';
							?>
						</div>
					</div><!--ENDS col-->


				</div><!--ENDS row-->
			  	
			  
			 	
			 	<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<input type="submit" name="submit" id="submit" class="btn btn-green" value="Update Result" />
						</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->
			
			  

			<?php echo form_close(); ?>

		</div><!-- ENDS well well-trans -->

	</div><!--ENDS col-->
</div><!--ENDS row-->


<!--JQUERY AJAX 'ADD RESULTS' SCRIPT-->
<script type="text/javascript">

$(function() {

$('#submit').click(function() {
$('#showEntry').append('<img src="<?php echo base_url() . 'img/loading.gif' ?>" alt="Currently Loading" id="loading" />');

	var token_admin = $('#token_admin').val();
	var resultID = $('#resultID').val();
	var athleteID = $('#athleteID').val();
	var time = $('#time').val();
	var wind = $('#wind').val();
	var distHeight = $('#distHeight').val();
	var record = $('#record').val();
	var placing = $('#placing').val();
	var eventID = $('#eventID').val();
	var ageGroup = $('#ageGroup').val();
	var competition = $('#competition').val();
	var in_out = $('#in_out').val();
	var venue = $('#venue').val();
	var venue_other = $('#venue_other').val();
	var day = $('#day').val();
	var month = $('#month').val();
	var year = $('#year').val();
	
	//var lineBreak = document.getElementById('lineBreak').checked; 
	//var enabled = document.getElementById('enabled').checked; 
	
	$.ajax({
		url: '<?php echo base_url() . 'admin/results_con/update_result_ind'; ?>',
		type: 'POST',
		data: 'token_admin=' + token_admin
		+ '&resultID=' + resultID
		+ '&athleteID=' + escape(athleteID)
		+ '&time=' + time
		+ '&wind=' + wind
		+ '&distHeight=' + distHeight
		+ '&record=' + record
		+ '&placing=' + placing
		+ '&eventID=' + eventID
		+ '&ageGroup=' + ageGroup
		+ '&competition=' + escape(competition) 
		+ '&in_out=' + in_out
		+ '&venue=' + venue
		+ '&venue_other=' + escape(venue_other)
		+ '&day=' + day
		+ '&month=' + month
		+ '&year=' + year,
		
		success: function(result) {
				
					$('#loading').fadeOut(500, function() {
							$(this).remove();
					});
					
					$('#showEntry').html(result);
					$('#showDelete').empty();
					$("#delButton").show(300);
					
					//$("#athleteID, #time, #distHeight, #placing, #record").val(''); 
					
					//Clears the AthleteID field when onFocus
					$('#competition, #venue_other').one("focus", function() {
						$(this).val("");
					});
								
								
				}
			});
		
		return false;
		
	});
	
});

</script>



<!--JQUERY AJAX 'DELETE RESULTS' SCRIPT-->
<script>

$(function() {
					 
$('#delButton').click(function(){
$('#showDelete').append('<img src="<?php echo base_url() . 'img/loading.gif' ?>" alt="Currently Loading" id="loading" />');
														 
	var resultID = $('#resultID').val();
	
		$.ajax({
		url: '<?php echo base_url() . 'admin/results_con/delete_results'; ?>',
		type: 'POST',
		data: 'resultID=' + resultID,
		
		success: function(result) {

					$('#loading').fadeOut(1000, function() {
						$(this).remove();
					});
					
					$('#showDelete').html(result);
					$('#showEntry').empty();
					$("#delButton").show(300);
	
					$("#delButton").hide(300);

					// Clear all form field values
					$("#eventID, #athleteID, #time, #distHeight, #wind, #placing, #record, #ageGroup, #competition, #in_out, #venue, #venue_other").val('');

					// Hide form (wrapped by well) - we don;t want to try and add a result in this place
					$('#well').hide();
					
				}

		});
	
	});

});
</script>