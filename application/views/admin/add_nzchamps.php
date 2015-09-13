<div class="row">
	<div class="col-md-12">

		<h1>Add NZ Championships Medals</h1>

		<div class="row">
			<div class="col-md-12">
				<div id="showEntry"></div><!--Load jQuery ENTRY message-->
			</div>
		</div>


		<div class="well well-trans">
  
			<?php echo form_open('admin/nzchamps_con/add_new_nzchamps', array('class' => 'results')); ?>

				<!--Adds hidden CSRF unique token
				This will be verified in the controller against
				the $this->session->userdata('token') before
				returning any results data-->
				<input type="hidden" name="token_admin" id="token_admin" value="<?php echo $token_admin; ?>" />

				<!--Tracks the athleteID -->
				<input type="hidden" name="athleteID" id="athleteID" value="<?php echo $this->uri->segment(4); ?>" />

				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<?php
								echo '<label for="year">Year:</label>';
								echo buildYearDropdown('year', set_value('year'), 'id="year", class="form-control"'); // See global helper
							?>
						</div>
					</div><!--ENDS col-->

					<div class="col-md-6">
						<div class="form-group">
							<?php
								// Display full list of events drop down menu
								echo '<label for="eventID" style="margin-left:10px;">Event: </label>';
								// echo buildEventsDropdown(); // See global helper
								echo buildRecordEventsDropdown($value='', $selected='', $label='');
							?>
						</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->


				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="ageGroup">Age Group:</label>
							<input type="text" name="ageGroup" id="ageGroup" class="form-control" value="<?php echo set_value('ageGroup'); ?>" />
						</div>
					</div><!--ENDS col-->

					<div class="col-md-4">
						<div class="form-group">
							<label for="performance">Performance:</label>
							<input type="text" name="performance" id="performance" class="form-control" value="<?php echo set_value('performance'); ?>" />
						</div>
					</div><!--ENDS col-->

					<div class="col-md-4">
						<div class="form-group">
							<label for="position">Postition:</label>
							<input type="text" name="position" id="position" class="form-control"value="<?php echo set_value('position'); ?>" />
						</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->


				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<input type="submit" name="submit" id="submit" class="btn btn-green" value="Save Performance" />
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
	var year = $('#year').val();
	var eventID = $('#eventID').val();
	var ageGroup = $('#ageGroup').val();
	var performance = $('#performance').val();
	var position = $('#position').val();
	
	$.ajax({
		url: '<?php echo base_url() . 'admin/nzchamps_con/add_new_nzchamps'; ?>',
		type: 'POST',
		data: 'token_admin=' + token_admin
		+ '&athleteID=' + athleteID
		+ '&year=' + year
		+ '&eventID=' + eventID
		+ '&ageGroup=' + ageGroup
		+ '&performance=' + performance
		+ '&position=' + position,
		
		success: function(result) {
				
						$('#loading').fadeOut(500, function() {
							$(this).remove();
						});
						
						$('#showEntry').html(result);
						$('#showDelete').empty();
						$("#delButton").show(300);
						
						$("#year, #competition, #eventID, #performance, #position").val(''); 
							
					}
				});
		
		return false;
		
	});
	
});

</script>