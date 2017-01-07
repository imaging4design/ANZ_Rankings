<div class="row">
	<div class="col-md-12">

		<h1 class="title">Add New Result <small>(Relays)</small></h1>

		<div class="row">
			<div class="col-md-12">
				<div id="showEntry"></div><!--Load jQuery ENTRY message-->
			</div>
		</div>

		<div class="well well-trans">

			<?php echo form_open('admin/relays_con/add_new_relay', array('class' => 'results')); ?>

			  <!--Adds hidden CSRF unique token
				This will be verified in the controller against
				the $this->session->userdata('token') before
				returning any results data-->
			  <input type="hidden" name="token_admin" id="token_admin" value="<?php echo $token_admin; ?>" />
			  

			  	<div class="row">
					<div class="col-md-6">
						<?php
							// Display full list of events drop down menu
							echo '<div class="form-group">';
							echo '<label for="eventID">Event: </label>';
							echo buildEventsDropdown('relays_dropdown'); // See global helper
							echo '</div>';
						?>
					</div><!--ENDS col-->

					<div class="col-md-6">
						<?php
							// Display full list of ageGroups drop down menu
							echo '<div class="form-group">';
							echo '<label for="ageGroup">AgeGroup: </label>';
							echo buildAgeGroupDropdown(); // See global helper
							echo '</div>';
						?>
					</div><!--ENDS col-->
				</div><!--ENDS row-->


			  
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="time">Time:</label>
			  				<input type="text" name="time" id="time" class="form-control" value="<?php echo set_value('time'); ?>" />
			  			</div>
					</div><!--ENDS col-->

					<div class="col-md-4">
						<div class="form-group">
							<label for="placing">Placing:</label>
			 				<input type="text" name="placing" id="placing" class="form-control" value="<?php echo set_value('placing'); ?>" />
			 			</div>
					</div><!--ENDS col-->

					<div class="col-md-4">
						<div class="form-group">
							<label for="record">Record:</label>
			  				<input type="text" name="record" id="record" class="form-control" value="<?php echo set_value('record'); ?>" />
			  			</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->



				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label for="athlete01">Athlete 1:</label>
			  				<input type="text" name="athlete01" id="athlete01" class="form-control" value="<?php echo set_value('athlete01'); ?>" />
			  			</div>
					</div><!--ENDS col-->

					<div class="col-md-3">
						<div class="form-group">
							<label for="athlete02">Athlete 2:</label>
			  				<input type="text" name="athlete02" id="athlete02" class="form-control" value="<?php echo set_value('athlete02'); ?>" />
			 			</div>
					</div><!--ENDS col-->

					<div class="col-md-3">
						<div class="form-group">
							<label for="athlete03">Athlete 3:</label>
			  				<input type="text" name="athlete03" id="athlete03" class="form-control" value="<?php echo set_value('athlete03'); ?>" />
			  			</div>
					</div><!--ENDS col-->

					<div class="col-md-3">
						<div class="form-group">
							<label for="athlete04">Athlete 4</label>
			  				<input type="text" name="athlete04" id="athlete04" class="form-control" value="<?php echo set_value('athlete04'); ?>" />
			  			</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->



				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="team">Team:</label>
			  				<input type="text" name="team" id="team" class="form-control" value="<?php echo set_value('team'); ?>" />
			  			</div>
					</div><!--ENDS col-->

					<div class="col-md-4">
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
						<div class="form-group">
							<?php
								// Display drop down menu for default venues
								echo get_venues(); // See global helper
							?>
			  			</div>
					</div><!--ENDS col-->

					<div class="col-md-4">
						<div class="form-group">
							<label for="venue_other">Venue (Other):</label>
			  				<input type="text" name="venue_other" id="venue_other" class="form-control" value="<?php echo set_value('venue_other'); ?>" />
			 			</div>
					</div><!--ENDS col-->

					<div class="col-md-4">
						<div class="form-group">
							<!-- jQuery UI Date Picker -->
							<label for="date">Date: </label>
							<input type="text" id="date" class="form-control" name="date" />
			 			</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->



				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="submit"></label>
							<input type="submit" name="submit" id="submit" class="btn btn-green" value="Save Result" />
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
	var date = $('#date').val();
	
	//var lineBreak = document.getElementById('lineBreak').checked; 
	//var enabled = document.getElementById('enabled').checked; 
	
	$.ajax({
		url: '<?php echo base_url() . 'admin/relays_con/add_new_relay'; ?>',
		type: 'POST',
		data: 'token_admin=' + token_admin
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
		+ '&date=' + date,
		
		success: 	function(result) {
				
								$('#loading').fadeOut(500, function() {
										$(this).remove();
								});
								
								$('#showEntry').html(result);
								
								$("#time, #placing, #record, #athlete01, #athlete02, #athlete03, #athlete04, #venue_other").val(''); 
								
								
						}
				});
		
		return false;
		
	});


	
	});

</script>