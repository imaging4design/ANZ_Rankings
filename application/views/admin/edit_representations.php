<div class="row">
	<div class="col-md-12">

		<h1>Edit NZ Representations</h1>

		<div class="row">
			<div class="col-md-12">
				<div id="showEntry"></div><!--Load jQuery ENTRY message-->
				<div id="showDelete"></div><!--Load jQuery DELETE message-->
			</div>
		</div>


		<div class="well well-trans">

			<button id="delButton" class="btn btn-red pull-right" class="button">Delete Record</button>

			<?php echo form_open('admin/representation_con/update_representation', array('class' => 'results')); ?>

				<!--Adds hidden CSRF unique token
				This will be verified in the controller against
				the $this->session->userdata('token') before
				returning any results data-->
				<input type="hidden" name="token_admin" id="token_admin" value="<?php echo $token_admin; ?>" />

				<input type="hidden" name="repID" id="repID" value="<?php echo $pop_data->id; ?>" />

				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<?php
								echo '<label for="year">Year:</label>';
								echo buildYearDropdown('year', $pop_data->year, 'id="year", class="form-control"'); // See global helper
							?>
						</div>
					</div><!--ENDS col-->

					<div class="col-md-4">
						<div class="form-group">
							<label for="competition">Competition:</label>
							<input type="text" name="competition" id="competition" class="form-control" value="<?php echo $pop_data->competition; ?>" />
						</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->



				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<?php
								$eventName = convertEventID();

								// Display full list of events drop down menu
								echo '<label for="eventID">Event: </label>';
								// echo buildEventsDropdown($pop_data->eventID, $pop_data->eventID, $pop_data->eventName); // See global helper
								echo buildRecordEventsDropdown($pop_data->eventID, $pop_data->eventID, $pop_data->eventName); // See global helper
							?>
						</div>
					</div><!--ENDS col-->

					<div class="col-md-4">
						<div class="form-group">
							<label for="performance">Performance:</label>
							<input type="text" name="performance" id="performance" class="form-control" value="<?php echo $pop_data->performance; ?>" />
						</div>
					</div><!--ENDS col-->

					<div class="col-md-4">
						<div class="form-group">
							<label for="position">Postition:</label>
							<input type="text" name="position" id="position" class="form-control" value="<?php echo $pop_data->position; ?>" />
						</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->



				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<input type="submit" name="submit" id="submit" class="btn btn-green" value="Update Representation" />
						</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->


				<?php echo anchor( base_url() . 'site/profiles_con/athlete/' . $this->uri->segment(5), 'Back to Profile', array('class' => 'button')); ?>
				
				

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
	var repID = $('#repID').val();
	var year = $('#year').val();
	var competition = $('#competition').val();
	var eventID = $('#eventID').val();
	var performance = $('#performance').val();
	var position = $('#position').val();
	
	//var lineBreak = document.getElementById('lineBreak').checked; 
	//var enabled = document.getElementById('enabled').checked; 
	
	$.ajax({
		url: '<?php echo base_url() . 'admin/representation_con/update_representation'; ?>',
		type: 'POST',
		data: 'token_admin=' + token_admin
		+ '&repID=' + repID
		+ '&year=' + year
		+ '&competition=' + competition
		+ '&eventID=' + eventID
		+ '&performance=' + performance
		+ '&position=' + escape(position),
		
		success: function(result) {
				
					$('#loading').fadeOut(500, function() {
							$(this).remove();
					});
					
					$('#showEntry').html(result);
					$('#showDelete').empty();
					$("#delButton").show(300);
					
					//$("#year, #competition, #eventID, #performance, #position").val(''); 
					
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
$('#showDelete').append('<img src="<?php echo base_url() . 'img/loading.gif' ?>" alt="Currently Loading" id="loading" />');
														 
	var repID = $('#repID').val();
	
		$.ajax({
		url: '<?php echo base_url() . 'admin/representation_con/delete_representation'; ?>',
		type: 'POST',
		data: 'repID=' + repID,
		
		success: function(result) {
		
					$('#loading').fadeOut(1000, function() {
						$(this).remove();
					});
					
					$('#showDelete').html(result);
					$('#showEntry').empty();
					$("#delButton").show(300);
	
					$("#delButton").hide(300);

					$("#year, #competition, #eventID, #performance, #position").val('');
					
				}
		});
	
	});

});
</script>

