<div class="row">
	<div class="col-md-12">

		<h1>Edit Result <small>(Relays)</small></h1>

		<div class="row">
			<div class="col-md-12">
				<div id="showEntry"></div><!--Load jQuery ENTRY message-->
				<div id="showDelete"></div><!--Load jQuery DELETE message-->
			</div>
		</div>

		<div class="well well-trans">

			<button id="delButton" class="btn btn-red pull-right" class="button">Delete Result</button>

			<?php echo form_open('admin/relays_con/edit_relay', array('class' => 'results')); ?>

				<!--Adds hidden CSRF unique token
				This will be verified in the controller against
				the $this->session->userdata('token') before
				returning any results data-->
				<input type="hidden" name="token_admin" id="token_admin" value="<?php echo $token_admin; ?>" />

				<!--Get the resultID-->
				<input type="hidden" name="resultID" id="resultID" value="<?php echo $this->uri->segment(4); ?>" />


				<div class="row">
					<div class="col-md-4">
						<?php
							// Display full list of events drop down menu
							echo '<label for="eventID">Event: </label>';
							echo buildEventsDropdown($pop_data->eventID, $pop_data->eventID, $pop_data->eventName); // See global helper
						?>
					</div><!--ENDS col-->

					<div class="col-md-4">
						<?php
							// Display full list of ageGroups drop down menu
							echo '<label for="ageGroup">Age Group: </label>';
							echo buildAgeGroupDropdown($pop_data->ageGroup);
						?>
					</div><!--ENDS col-->
				</div><!--ENDS row-->



				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="time">Time:</label>
			  				<input type="text" name="time" id="time" class="form-control" value="<?php echo $pop_data->time; ?>" />
			  			</div>
					</div><!--ENDS col-->

					<div class="col-md-4">
						<div class="form-group">
							<label for="placing">Placing:</label>
			 				<input type="text" name="placing" id="placing" class="form-control" value="<?php echo $pop_data->placing; ?>" />
			 			</div>
					</div><!--ENDS col-->

					<div class="col-md-4">
						<div class="form-group">
							<label for="record">Record:</label>
			  				<input type="text" name="record" id="record" class="form-control" value="<?php echo $pop_data->record; ?>" />
			  			</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->



				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label for="athlete01">Athlete 1:</label>
			  				<input type="text" name="athlete01" id="athlete01" class="form-control" value="<?php echo $pop_data->athlete01; ?>" />
			  			</div>
					</div><!--ENDS col-->

					<div class="col-md-3">
						<div class="form-group">
							<label for="athlete02">Athlete 2:</label>
			  				<input type="text" name="athlete02" id="athlete02" class="form-control" value="<?php echo $pop_data->athlete02; ?>" />
			 			</div>
					</div><!--ENDS col-->

					<div class="col-md-3">
						<div class="form-group">
							<label for="athlete03">Athlete 3:</label>
			  				<input type="text" name="athlete03" id="athlete03" class="form-control" value="<?php echo $pop_data->athlete03; ?>" />
			  			</div>
					</div><!--ENDS col-->

					<div class="col-md-3">
						<div class="form-group">
							<label for="athlete04">Athlete 4</label>
			  				<input type="text" name="athlete04" id="athlete04" class="form-control" value="<?php echo $pop_data->athlete04; ?>" />
			  			</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->



				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="team">Team:</label>
			  				<input type="text" name="team" id="team" class="form-control" value="<?php echo $pop_data->team; ?>" />
			  			</div>
					</div><!--ENDS col-->

					<div class="col-md-4">
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
								echo '<label for="date">Date (Day):</label>';
								echo buildDayDropdown($name='day', $value=$dateArray[2], $id='id="day", class="form-control"'); // See global helper
							?>
			 			</div>
					</div><!--ENDS col-->

					<div class="col-md-2">
						<div class="form-group">
							<?php
								echo '<label for="date">Date (Month):</label>';
								echo buildMonthDropdown($name='month', $value=$dateArray[1], $id='id="month", class="form-control"'); // See global helper
							?>
			 			</div>
					</div><!--ENDS col-->

					<div class="col-md-2">
						<div class="form-group">
							<?php
								echo '<label for="date">Date (Year):</label>';
								echo '<input type="text" name="year" id="year" class="form-control" value="'.$value=$dateArray[0].'" />';
							?>
			 			</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->



				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="submit"></label>
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
$('#showEntry').append('<img src="<?php echo base_url() . 'images/loading.gif' ?>" alt="Currently Loading" id="loading" />');

	var token_admin = $('#token_admin').val();
	var resultID = $('#resultID').val();
	var eventID = $('#eventID').val();
	var ageGroup = $('#ageGroup').val();
	var time = $('#time').val();
	var placing = $('#placing').val();
	var record = $('#record').val();
	var athlete01 = $('#athlete01').val();
	var athlete02 = $('#athlete02').val();
	var athlete03 = $('#athlete03').val();
	var athlete04 = $('#athlete04').val();
	var team = $('#team').val();
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
		url: '<?php echo base_url() . 'admin/relays_con/edit_relay'; ?>',
		type: 'POST',
		data: 'token_admin=' + token_admin
		+ '&resultID=' + resultID
		+ '&eventID=' + eventID
		+ '&ageGroup=' + ageGroup
		+ '&time=' + time
		+ '&placing=' + placing
		+ '&record=' + record
		+ '&athlete01=' + escape(athlete01)
		+ '&athlete02=' + escape(athlete02)
		+ '&athlete03=' + escape(athlete03)
		+ '&athlete04=' + escape(athlete04)
		+ '&team=' + escape(team)
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
					
					//$("#time, #placing, #record, #athlete01, #athlete02, #athlete03, #athlete04, #venue_other").val(''); 
								
				}

			});
		
		return false;
		
	});
	
});

</script>


<!--JQUERY AJAX 'DELETE RESULT' SCRIPT-->
<script>

$(function() {
					 
$('#delButton').click(function(){
$('#showDelete').append('<img src="<?php echo base_url() . 'images/loading.gif' ?>" alt="Currently Loading" id="loading" />');
														 
	var resultID = $('#resultID').val();
	
		$.ajax({
		url: '<?php echo base_url() . 'admin/relays_con/delete_relay'; ?>',
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

					$("#eventID, #ageGroup, #time, #placing, #record, #athlete01, #athlete02, #athlete03, #athlete04, #team, #competition, #in_out, #venue, #venue_other").val('');
					
				}

		});
	
	});

});
</script>

