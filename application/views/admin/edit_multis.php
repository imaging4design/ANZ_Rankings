<div class="row">
	<div class="col-md-12">
  
		<h1>Edit Results <small>(Multi Events)</small></h1>

		<div class="row">
			<div class="col-md-12">
				<div id="showEntry"></div><!--Load jQuery ENTRY message-->
				<div id="showDelete"></div><!--Load jQuery DELETE message-->
			</div>
		</div>


		<div class="well well-trans">

			<button id="delButton" class="btn btn-red pull-right" class="button">Delete Result</button>

			<?php echo form_open('admin/multis_con/update_result_multi', array('class' => 'results')); ?>

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
								echo '<label for="eventID">Event: </label>';
								// echo buildEventsDropdown($pop_data->eventID, $pop_data->eventID, $pop_data->eventName); // See global helper
								echo buildRecordEventsDropdown($pop_data->eventID, $pop_data->eventID, $pop_data->eventName); // See global helper
							?>  
						</div><!--ENDS form-group-->
					</div><!--ENDS col-->
				</div><!--ENDS row-->



				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="athlete">Athlete:</label>
							<input type="text" name="athleteID" id="athleteID" class="form-control" value="<?php echo $pop_data->athleteID; ?>" />
							<!--DON'T REMOVE class="athlete" (required for auto-populate!)-->
						</div>
					</div><!--ENDS col-->

					<div class="col-md-2">
						<div class="form-group">
							<label for="points">Points:</label>
							<input type="text" name="points" id="points" class="form-control" value="<?php echo $pop_data->points; ?>" />
						</div>
					</div><!--ENDS col-->

					<div class="col-md-2">
						<div class="form-group">
							<label for="wind">Wind:</label>
							<input type="text" name="wind" id="wind" class="form-control" value="<?php echo $pop_data->wind; ?>" />
						</div>
					</div><!--ENDS col-->

					<div class="col-md-2">
						<div class="form-group">
							<label for="placing">Placing:</label>
							<input type="text" name="placing" id="placing" class="form-control" value="<?php echo $pop_data->placing; ?>" />
						</div>
					</div><!--ENDS col-->

					<div class="col-md-2">
						<div class="form-group">
							<label for="record">Record:</label>
							<input type="text" name="record" id="record" class="form-control" value="<?php echo $pop_data->record; ?>" />
						</div>
					</div><!--ENDS col-->

				</div><!--ENDS row-->



				<div class="row">
					<div class="col-md-1">
						<div class="form-group-sm">
							<label for="e01">E1:</label>
							<input type="text" name="e01" id="e01" class="form-control" value="<?php echo $pop_data->e01; ?>" />
						</div>
					</div><!--ENDS col-->
					<div class="col-md-1">
						<div class="form-group-sm">
							<label for="e02">E2:</label>
							<input type="text" name="e02" id="e02" class="form-control" value="<?php echo $pop_data->e02; ?>" />
						</div>
					</div><!--ENDS col-->
					<div class="col-md-1">
						<div class="form-group-sm">
							<label for="e03">E3:</label>
							<input type="text" name="e03" id="e03" class="form-control" value="<?php echo $pop_data->e03; ?>" />
						</div>
					</div><!--ENDS col-->
					<div class="col-md-1">
						<div class="form-group-sm">
							<label for="e04">E4:</label>
							<input type="text" name="e04" id="e04" class="form-control" value="<?php echo $pop_data->e04; ?>" />
						</div>
					</div><!--ENDS col-->
					<div class="col-md-1">
						<div class="form-group-sm">
							<label for="e05">E5:</label>
							<input type="text" name="e05" id="e05" class="form-control" value="<?php echo $pop_data->e05; ?>" />
						</div>
					</div><!--ENDS col-->
					<div class="col-md-1">
						<div class="form-group-sm">
							<label for="e06">E6:</label>
							<input type="text" name="e06" id="e06" class="form-control" value="<?php echo $pop_data->e06; ?>" />
						</div>
					</div><!--ENDS col-->
					<div class="col-md-1">
						<div class="form-group-sm">
							<label for="e07">E7:</label>
							<input type="text" name="e07" id="e07" class="form-control" value="<?php echo $pop_data->e07; ?>" />
						</div>
					</div><!--ENDS col-->
					<div class="col-md-1">
						<div class="form-group-sm">
							<label for="e08">E8:</label>
							<input type="text" name="e08" id="e08" class="form-control" value="<?php echo $pop_data->e08; ?>" />
						</div>
					</div><!--ENDS col-->
					<div class="col-md-1">
						<div class="form-group-sm">
							<label for="e09">E9:</label>
							<input type="text" name="e09" id="e09" class="form-control" value="<?php echo $pop_data->e09; ?>" />
						</div>
					</div><!--ENDS col-->
					<div class="col-md-1">
						<div class="form-group-sm">
							<label for="e10">E10:</label>
							<input type="text" name="e10" id="e10" class="form-control" value="<?php echo $pop_data->e10; ?>" />
						</div>
					</div><!--ENDS col-->
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
					<div class="col-md-4">
						<div class="form-group">
							<label for="competition">Competition:</label>
							<input type="text" name="competition" id="competition" class="form-control" value="<?php echo $pop_data->competition; ?>" />
						</div>
					</div><!--ENDS col-->

					<div class="col-md-4">
						<div class="form-group">
							<?php
								// Display drop down menu for default venues
								// This will initially show the existing value of the venue column as 'Selected'
								echo get_venues($pop_data->venue); // See global helper
							?>
						</div>
					</div><!--ENDS col-->

					<div class="col-md-4">
						<div class="form-group">
							<label for="venue_other">Venue (Other):</label>
							<input type="text" name="venue_other" id="venue_other" class="form-control" value="<?php echo set_value('venue_other'); ?>" />
						</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->



				<div class="row">
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
								// Display drop down menus for date (day, month, year)
								echo '<label for="date">Date (Month): </label>';
								echo buildMonthDropdown($name='month', $value=$dateArray[1], $id='id="month", class="form-control"'); // See global helper
							?>
						</div>
					</div><!--ENDS col-->

					<div class="col-md-2">
						<div class="form-group">
							<?php
								// Display drop down menus for date (day, month, year)
								echo '<label for="date">Date (Year): </label>';
								echo buildYearDropdown($name='year', $value=$dateArray[0], $id='id="year", class="form-control"'); // See global helper
							?>
						</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->

				

				<div class="row">
					<div class="col-md-4">
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
$('#showEntry').append('<img src="<?php echo base_url() . 'images/loading.gif' ?>" alt="Currently Loading" id="loading" />');

	var token_admin = $('#token_admin').val();
	var resultID = $('#resultID').val();
	var athleteID = $('#athleteID').val();
	var points = $('#points').val();
	var wind = $('#wind').val();
	var placing = $('#placing').val();
	var record = $('#record').val();
	
	var e01 = $('#e01').val();
	var e02 = $('#e02').val();
	var e03 = $('#e03').val();
	var e04 = $('#e04').val();
	var e05 = $('#e05').val();
	var e06 = $('#e06').val();
	var e07 = $('#e07').val();
	var e08 = $('#e08').val();
	var e09 = $('#e09').val();
	var e10 = $('#e10').val();
	
	var eventID = $('#eventID').val();
	var ageGroup = $('#ageGroup').val();
	var competition = $('#competition').val();
	var venue = $('#venue').val();
	var venue_other = $('#venue_other').val();
	var day = $('#day').val();
	var month = $('#month').val();
	var year = $('#year').val();
	
	//var lineBreak = document.getElementById('lineBreak').checked; 
	//var enabled = document.getElementById('enabled').checked; 
	
	$.ajax({
		url: '<?php echo base_url() . 'admin/multis_con/update_result_multi'; ?>',
		type: 'POST',
		data: 'token_admin=' + token_admin
		+ '&resultID=' + resultID
		+ '&athleteID=' + escape(athleteID)
		+ '&points=' + points
		+ '&wind=' + wind
		+ '&placing=' + placing
		+ '&record=' + record
		+ '&e01=' + e01
		+ '&e02=' + e02
		+ '&e03=' + e03
		+ '&e04=' + e04
		+ '&e05=' + e05
		+ '&e06=' + e06
		+ '&e07=' + e07
		+ '&e08=' + e08
		+ '&e09=' + e09
		+ '&e10=' + e10
		+ '&eventID=' + eventID
		+ '&ageGroup=' + ageGroup
		+ '&competition=' + escape(competition) 
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
					
					//$("#athleteID, #points, #placing, #record, #e01, #e02, #e03, #e04, #e05, #e06, #e07, #e08, #e09, #e10").val(''); 
					
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



<!--JQUERY AJAX 'DE:ETE RESULTS' SCRIPT-->
<script>

$(function() {
					 
$('#delButton').click(function(){
$('#showDelete').append('<img src="<?php echo base_url() . 'images/loading.gif' ?>" alt="Currently Loading" id="loading" />');
											
	var resultID = $('#resultID').val();
	
		$.ajax({
		url: '<?php echo base_url() . 'admin/multis_con/delete_results_multi'; ?>',
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

					$("#eventID, #athleteID, #points, #wind, #placing, #record, #e01, #e02, #e03, #e04, #e05, #e06, #e07, #e08, #e09, #e10, #ageGroup, #competition, #venue, #venue_other").val('');
					
				}

		});
	
	});

});
</script>