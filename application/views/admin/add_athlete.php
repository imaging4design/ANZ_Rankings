<div class="row">
	<div class="col-md-12">
		
		<h1>Add New Athlete</h1>

		<div class="row">
			<div class="col-md-12">
				<div id="showEntry"></div><!--Load jQuery ENTRY message-->
			</div>
		</div>


		<div class="well well-trans">

			<?php echo form_open('admin/athlete_con/add_athlete', array('class' => 'results')); ?>

			<!--Adds hidden CSRF unique token
			This will be verified in the controller against
			the $this->session->userdata('token') before
			returning any results data-->
			<input type="hidden" name="token_admin" id="token_admin" value="<?php echo $token_admin; ?>" />

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="athleteID">Athlete ID</label>
						<input type="text" name="athleteID" id="athleteID" class="form-control" value="<?php echo set_value('athleteID'); ?>" />
					</div>
				</div><!--ENDS col-->
			</div><!--ENDS row-->



			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="nameFirst">First Name</label>
						<input type="text" name="nameFirst" id="nameFirst" class="form-control" value="<?php echo set_value('nameFirst'); ?>" />
					</div>
				</div><!--ENDS col-->

				<div class="col-md-6">
					<div class="form-group">
						<label for="nameLast">Last Name</label>
						<input type="text" name="nameLast" id="nameLast" class="form-control" value="<?php echo set_value('nameLast'); ?>" />
					</div>
				</div><!--ENDS col-->
			</div><!--ENDS row-->



			<div class="row">
				<div class="col-md-8">
					<div class="form-group">
						<?php
							// Display drop down menus for date (day, month, year)
							echo '<label for="date">Date of Birth: </label>';
						?>
						<div class="row">
							<div class="col-sm-4">
								<?php echo buildDayDropdown($name='day', $value='1', $id='id="day", class="form-control"'); // See global helper ?>
							</div><!--ENDS col-->

							<div class="col-sm-4">
								<?php echo buildMonthDropdown($name='month', $value='', $id='id="month", class="form-control"'); // See global helper ?>
							</div><!--ENDS col-->

							<div class="col-sm-4">
								<?php echo buildYearDOB($name='year', $value='', $id='id="year", class="form-control"'); // See global helper ?>
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

						echo form_dropdown('gender', $options, set_value('M', 'gender'), 'id="gender", class="form-control"');
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
							echo dropDownCentres(); // See global helper
						?>
					</div>
				</div><!--ENDS col-->

				<div class="col-md-4">
					<div class="form-group">
						<?php
							// Display full list of 'clubs' drop down menu
							echo '<label for="clubID">Club: </label>';
							echo dropDownClubs(); // See global helper
						?>  
					</div>
				</div><!--ENDS col-->
			</div><!--ENDS row-->



			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label for="coach">Coach:</label>
						<input type="text" name="coach" id="coach" class="form-control" value="<?php echo set_value('coach'); ?>" />
					</div>
				</div><!--ENDS col-->

				<div class="col-md-8">
					<div class="form-group">
						<label for="coach_former">Former Coaches:</label>
						<input type="text" name="coach_former" id="coach_former" class="form-control" value="<?php echo set_value('coach_former'); ?>" />
					</div>
				</div><!--ENDS col-->
			</div><!--ENDS row-->



			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="submit"></label>
						<input type="submit" name="submit" id="submit" class="btn btn-red" value="Save Athlete" />
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
		url: '<?php echo base_url() . 'admin/athlete_con/add_athlete'; ?>',
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
					
					$("#athleteID, #nameFirst, #nameLast, #gender, #coach, #coach_former").val(''); 
								
				}
			});
		
		return false;
		
	});

});

</script>