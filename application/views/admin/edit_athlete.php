<div class="row">
	<div class="col-md-12">

		<h1>Edit Athlete</h1>

		<div class="row">
			<div class="col-md-12">
				<div id="showEntry"></div><!--Load jQuery ENTRY message-->
			</div>
		</div>


		<div class="well well-trans">
  			
			<?php echo form_open('admin/athlete_con/edit_athlete', array('class' => 'results')); ?>

			<!--Adds hidden CSRF unique token
			This will be verified in the controller against
			the $this->session->userdata('token') before
			returning any results data-->
			<input type="hidden" name="token_admin" id="token_admin" value="<?php echo $token_admin; ?>" />


			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="athleteID">Athlete ID</label>
						<input type="text" name="athleteID" id="athleteID" class="form-control" value="<?php echo $pop_data->athleteID; ?>" />
					</div>
				</div><!--ENDS col-->
			</div><!--ENDS row-->



			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="nameFirst">First Name</label>
						<input type="text" name="nameFirst" id="nameFirst" class="form-control" value="<?php echo $pop_data->nameFirst; ?>" />
					</div>
				</div><!--ENDS col-->

				<div class="col-md-6">
					<div class="form-group">
						<label for="nameLast">Last Name</label>
						<input type="text" name="nameLast" id="nameLast" class="form-control" value="<?php echo $pop_data->nameLast; ?>" />
					</div>
				</div><!--ENDS col-->
			</div><!--ENDS row-->



			<div class="row">
				<div class="col-md-8">
					<div class="form-group">
						
						<div class="row">
							<div class="col-sm-4">
								<?php
									// Explode the date into segments (Day, month year)
									// Use these segments as 'selected' values for the date drop downs
									$dateArray=explode('-', $pop_data->DOB);
									
									// Display drop down menus for date (day, month, year)
									echo '<label for="date">Date of Birth (Day): </label>';
									echo buildDayDropdown($name='day', $value=$dateArray[2], $id='id="day", class="form-control"'); // See global helper
								?>
							</div><!--ENDS col-->

							<div class="col-sm-4">
								<?php
									// Display drop down menus for date (day, month, year)
									echo '<label for="date">Date of Birth (Month): </label>';
									echo buildMonthDropdown($name='month', $value=$dateArray[1], $id='id="month", class="form-control"'); // See global helper
								?>
							</div><!--ENDS col-->

							<div class="col-sm-4">
								<?php
									// Display drop down menus for date (day, month, year)
									echo '<label for="date">Date of Birth (Year): </label>';
									echo '<input type="text" name="year" id="year" class="form-control" value="'.$value=$dateArray[0].'" />';
								?>
							</div><!--ENDS col-->
						</div><!--ENDS row-->
						
					</div>
				</div><!--ENDS col-->

				<div class="col-md-4">
					<div class="form-group">
						<label for="gender">Gender</label>
						<?php
						$options = array(
							'M'  => 'Male',
							'F'  => 'Female'
						);

						echo form_dropdown('gender', $options, set_value('gender', $pop_data->gender), 'id="gender", class="form-control"');
						?>
					</div>
				</div><!--ENDS col-->
			</div><!--ENDS row-->



			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<?php
							// Display full list of 'centres' drop down menu
							echo '<label for="centreID">Centre: </label>';
							echo dropDownCentres($value = $pop_data->centreID, $selected = set_select('centreID', $pop_data->centreID), $label = $pop_data->centreName); // See global helper
						?>  
					</div>
				</div><!--ENDS col-->

				<div class="col-md-4">
					<div class="form-group">
						<?php
							// Display full list of 'clubs' drop down menu
							echo '<label for="clubID" style="margin-left:20px;">Club: </label>';
							echo dropDownClubs($value = $pop_data->clubID, $selected = set_select('clubID', $pop_data->clubID), $label = $pop_data->clubName); // See global helper
						?>  
					</div>
				</div><!--ENDS col-->
			</div><!--ENDS row-->



			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label for="coach">Coach:</label>
						<input type="text" name="coach" id="coach" class="form-control" value="<?php echo $pop_data->coach; ?>" />
					</div>
				</div><!--ENDS col-->

				<div class="col-md-8">
					<div class="form-group">
						<label for="coach_former">Former Coaches:</label>
						<input type="text" name="coach_former" id="coach_former" class="form-control" value="<?php echo $pop_data->coach_former; ?>" />
					</div>
				</div><!--ENDS col-->
			</div><!--ENDS row-->



			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="submit"></label>
						<input type="submit" name="submit" id="submit" class="btn btn-green" value="Update Athlete" />
					</div>
				</div><!--ENDS col-->
			</div><!--ENDS row-->


			<?php echo anchor( base_url() . 'site/profiles_con/athlete/' . $this->uri->segment(4), 'Back to Profile', array('class' => 'button')); ?>



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
	var athleteID = $('#athleteID').val();
	var nameFirst = $('#nameFirst').val();
	var nameLast = $('#nameLast').val();
	var day = $('#day').val();
	var month = $('#month').val();
	var year = $('#year').val();
	var gender = $('#gender').val();
	var centreID = $('#centreID').val();
	var clubID = $('#clubID').val();
	var coach = $('#coach').val();
	var coach_former = $('#coach_former').val();
	
	//var lineBreak = document.getElementById('lineBreak').checked; 
	//var enabled = document.getElementById('enabled').checked; 
	
	$.ajax({
		url: '<?php echo base_url() . 'admin/athlete_con/edit_athlete'; ?>',
		type: 'POST',
		data: 'token_admin=' + token_admin
		+ '&athleteID=' + escape(athleteID)
		+ '&nameFirst=' + escape(nameFirst)
		+ '&nameLast=' + escape(nameLast)
		+ '&day=' + day
		+ '&month=' + month
		+ '&year=' + year
		+ '&gender=' + gender
		+ '&centreID=' + centreID
		+ '&clubID=' + clubID
		+ '&coach=' + escape(coach)
		+ '&coach_former=' + escape(coach_former),
		
		success: function(result) {
				
					$('#loading').fadeOut(500, function() {
							$(this).remove();
					});
					
					$('#showEntry').html(result);
					$('#showDelete').empty();
					$("#delButton").show(300);
					
					//$("#athleteID").val(''); 
								
				}

			});
		
		return false;
		
	});

});

</script>