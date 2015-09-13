<div class="row">
	<div class="col-md-12">
  
		<h1>Add New Result <small>(Multi Event)</small></h1>

		<div class="row">
			<div class="col-md-12">
				<div id="showEntry"></div><!--Load jQuery ENTRY message-->
			</div>
		</div>

		<div class="well well-trans">

			<?php echo form_open('admin/multis_con/add_result_multi', array('class' => 'results')); ?>

				<!--Adds hidden CSRF unique token
				This will be verified in the controller against
				the $this->session->userdata('token') before
				returning any results data-->
				<input type="hidden" name="token_admin" id="token_admin" value="<?php echo $token_admin; ?>" />


				<div class="row">
					<div class="form-group">

						<div class="col-md-2">
							<div class="radio">
								<label>
									<input type="radio" name="eventID" class="eventID" value="36" checked>
									Decathlon
								</label>
							</div>
						</div><!--ENDS col-->

						<div class="col-md-2">
							<div class="radio">
								<label>
									<input type="radio" name="eventID" class="eventID" value="35">
									Heptathlon
								</label>
							</div>
						</div><!--ENDS col-->

						<div class="col-md-2">
							<div class="radio">
								<label>
									<input type="radio" name="eventID" class="eventID" value="34">
									Octathlon
								</label>
							</div>
						</div><!--ENDS col-->

						<div class="col-md-2">
							<div class="radio">
								<label>
									<input type="radio" name="eventID" class="eventID" value="54">
									Pentathlon
								</label>
							</div>
						</div><!--ENDS col-->

					</div><!--ENDS form-group-->
				</div><!--ENDS row-->


				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="athlete">Athlete:</label>
							<input type="text" name="athleteID" id="athleteID" class="form-control" />
							<!--DON'T REMOVE class="athlete" (required for auto-populate!)-->
						</div>
					</div><!--ENDS col-->

					<div class="col-md-2">
						<div class="form-group">
							<label for="points">Points:</label>
							<input type="text" name="points" id="points"class="form-control" value="<?php echo set_value('points'); ?>" />
						</div>
					</div><!--ENDS col-->

					<div class="col-md-2">
						<div class="form-group">
							<label for="wind">Wind:</label>
							<input type="text" name="wind" id="wind"class="form-control" value="<?php echo set_value('wind'); ?>" />
						</div>
					</div><!--ENDS col-->

					<div class="col-md-2">
						<div class="form-group">
							<label for="placing">Placing:</label>
							<input type="text" name="placing" id="placing"class="form-control" value="<?php echo set_value('placing'); ?>" />
						</div>
					</div><!--ENDS col-->

					<div class="col-md-2">
						<div class="form-group">
							<label for="record">Record:</label>
							<input type="text" name="record" id="record"class="form-control" value="<?php echo set_value('record'); ?>" />
						</div>
					</div><!--ENDS col-->

				</div><!--ENDS row-->



				<div class="row">
					<div class="col-md-1">
						<div class="form-group-sm">
							<label for="e01">E1:</label>
							<input type="text" name="e01" id="e01" class="form-control" value="<?php echo set_value('e01'); ?>" />
						</div>
					</div><!--ENDS col-->
					<div class="col-md-1">
						<div class="form-group-sm">
							<label for="e02">E2:</label>
							<input type="text" name="e02" id="e02" class="form-control" value="<?php echo set_value('e02'); ?>" />
						</div>
					</div><!--ENDS col-->
					<div class="col-md-1">
						<div class="form-group-sm">
							<label for="e03">E3:</label>
							<input type="text" name="e03" id="e03" class="form-control" value="<?php echo set_value('e03'); ?>" />
						</div>
					</div><!--ENDS col-->
					<div class="col-md-1">
						<div class="form-group-sm">
							<label for="e04">E4:</label>
							<input type="text" name="e04" id="e04" class="form-control" value="<?php echo set_value('e04'); ?>" />
						</div>
					</div><!--ENDS col-->
					<div class="col-md-1">
						<div class="form-group-sm">
							<label for="e05">E5:</label>
							<input type="text" name="e05" id="e05" class="form-control" value="<?php echo set_value('e05'); ?>" />
						</div>
					</div><!--ENDS col-->
					<div class="col-md-1">
						<div class="form-group-sm">
							<label for="e06">E6:</label>
							<input type="text" name="e06" id="e06" class="form-control" value="<?php echo set_value('e06'); ?>" />
						</div>
					</div><!--ENDS col-->
					<div class="col-md-1">
						<div class="form-group-sm">
							<label for="e07">E7:</label>
							<input type="text" name="e07" id="e07" class="form-control" value="<?php echo set_value('e07'); ?>" />
						</div>
					</div><!--ENDS col-->
					<div class="col-md-1">
						<div class="form-group-sm">
							<label for="e08">E8:</label>
							<input type="text" name="e08" id="e08" class="form-control" value="<?php echo set_value('e08'); ?>" />
						</div>
					</div><!--ENDS col-->
					<div class="col-md-1">
						<div class="form-group-sm">
							<label for="e09">E9:</label>
							<input type="text" name="e09" id="e09" class="form-control" value="<?php echo set_value('e09'); ?>" />
						</div>
					</div><!--ENDS col-->
					<div class="col-md-1">
						<div class="form-group-sm">
							<label for="e10">E10:</label>
							<input type="text" name="e10" id="e10" class="form-control" value="<?php echo set_value('e10'); ?>" />
						</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->



				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<?php
								// Display full list of events drop down menu
								echo '<label for="ageGroup">Age Group:</label>';
								echo buildAgeGroupDropdown(); // See global helper
							?> 
						</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->



				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="competition">Competition:</label>
							<input type="text" name="competition" id="competition" class="form-control" value="<?php echo set_value('competition'); ?>" />
						</div>
					</div><!--ENDS col-->

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
				</div><!--ENDS row-->

				
			  
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<!-- jQuery UI Date Picker -->
							<label for="date">Date: </label>
							<input type="text" id="date" class="form-control" name="date" />
						</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->



				<div class="row">
					<div class="col-md-4">
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
	$('.eventID').on('change', function() {

		console.log(this.value);
		
		// var test = $(".eventID :selected").text()
		// $('#eventDisplay').html(test);
	});
</script>




<!--JQUERY AJAX 'ADD RESULTS' SCRIPT-->
<script type="text/javascript">

$(function() {

$('#submit').click(function() {
$('#showEntry').append('<img src="<?php echo base_url() . 'images/loading.gif' ?>" alt="Currently Loading" id="loading" />');

	var token_admin = $('#token_admin').val();
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
	


	var eventID = $('.eventID').val();
	//var eventID = $('input:radio[name=eventID]:checked').val();
	var ageGroup = $('#ageGroup').val();
	var competition = $('#competition').val();
	var venue = $('#venue').val();
	var venue_other = $('#venue_other').val();
	var date = $('#date').val();


	console.log(eventID);
	
	//var lineBreak = document.getElementById('lineBreak').checked; 
	//var enabled = document.getElementById('enabled').checked; 
	
	$.ajax({
		url: '<?php echo base_url() . 'admin/multis_con/add_result_multi'; ?>',
		type: 'POST',
		data: 'token_admin=' + token_admin
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
		+ '&date=' + date,
		
		success: function(result) {
				
				$('#loading').fadeOut(500, function() {
					$(this).remove();
				});
				
				$('#showEntry').html(result);
				
				$("#athleteID, #points, #placing, #record, #e01, #e02, #e03, #e04, #e05, #e06, #e07, #e08, #e09, #e10").val(''); 
				
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