<div class="row">
	<div class="col-sm-12">

		<h1 class="title">Edit Record</h1>

		<div class="row">
			<div class="col-md-12">
				<div id="showEntry"></div><!--Load jQuery ENTRY message-->
				<div id="showDelete"></div><!--Load jQuery DELETE message-->
			</div>
		</div>


		<div class="well well-trans">

			<button id="delButton" class="btn btn-red pull-right" class="button">Delete Record</button>

			<?php echo form_open('admin/records_con/add_new_record', array('class' => 'results')); ?>

				<!--Adds hidden CSRF unique token
				This will be verified in the controller against
				the $this->session->userdata('token') before
				returning any results data-->
				<input type="hidden" name="token_admin" id="token_admin" value="<?php echo $token_admin; ?>" />

				<input type="hidden" name="recordID" id="recordID" value="<?php echo $pop_data->recordID; ?>" />


				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label for="redoctdType">Record Type:</label>
							<?php
								// Select type of record (i.e., Allcomers, National etc ...)
								echo recordType($pop_data->recordType);
							?>
						</div>
					</div><!--ENDS col-->

					<div class="col-md-3">
						<div class="form-group">
							<label for="ageGroup">Age Group:</label>
							<?php
								// Select an ageGroup
								echo buildAgeGroup_records($pop_data->ageGroup);
							?>
						</div>
					</div><!--ENDS col-->

					<div class="col-md-3">
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
					<div class="col-md-6">
						<div class="form-group">
							<label for="nameFirst">Event:</label>
							<?php
								// Select an ageGroup
								// Javascript hides/shows one of these depending if indoor or outdoor selected from dropdown
								if( $pop_data->in_out == 'out' ) {
									echo buildRecordEventsDropdown($pop_data->eventID, $pop_data->eventID, $pop_data->eventName);
								} else {
									echo buildIndoorEventsDropdown($pop_data->eventID, $pop_data->eventID, $pop_data->eventName);
								}
							?>
						</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->



				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="nameFirst">First Name:</label>
							<input type="text" name="nameFirst" id="nameFirst" class="form-control" value="<?php echo $pop_data->nameFirst; ?>" />
						</div>
					</div><!--ENDS col-->

					<div class="col-md-4">
						<div class="form-group">
							<label for="nameLast">Last Name:</label>
							<input type="text" name="nameLast" id="nameLast" class="form-control" value="<?php echo $pop_data->nameLast; ?>" />
						</div>
					</div><!--ENDS col-->

					<div class="col-md-4">
						<div class="form-group">
							<label for="country">Country:</label>
							<input type="text" name="country" id="country" class="form-control" value="<?php echo $pop_data->country; ?>" />
						</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->



				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label for="result">Result:</label>
							<input type="text" name="result" id="result" class="form-control" value="<?php echo $pop_data->result; ?>" />
						</div>
					</div><!--ENDS col-->

					<div class="col-md-3">
						<div class="form-group">
							<label for="venue">Venue of Record:</label>
							<input type="text" name="venue" id="venue" class="form-control" value="<?php echo $pop_data->venue; ?>" />
						</div>
					</div><!--ENDS col-->

					<div class="col-md-2">
						<div class="form-group">
							<?php
								// Explode the date into segments (Day, month year)
								// Use these segments as 'selected' values for the date drop downs
								$dateArray=explode('-', $pop_data->date);

								// Display drop down menus for date (day, month, year)
								echo '<label for="date">Date: </label>';
								echo buildDayDropdown($name='day', $value=$dateArray[2], $id='id="day", class="form-control"'); // See global helper
							?>
						</div>
					</div><!--ENDS col-->

					<div class="col-md-2">
						<div class="form-group">
							<?php
								// Display drop down menus for date (day, month, year)
								echo '<label for="date">Date: </label>';
								echo buildMonthDropdown($name='month', $value=$dateArray[1], $id='id="month", class="form-control"'); // See global helper
							?>
						</div>
					</div><!--ENDS col-->

					<div class="col-md-2">
						<div class="form-group">
							<?php
								// Display drop down menus for date (day, month, year)
								echo '<label for="date">Date: </label>';
								echo '<input type="text" name="year" id="year" class="form-control" value="'.$value=$dateArray[0].'" />';
							?>
						</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->



				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="submit"></label>
							<input type="submit" name="submit" id="submit" class="btn btn-green" value="Update Record" />
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
	var recordID = $('#recordID').val();
	var recordType = $('#recordType').val();
	var ageGroup = $('#ageGroup').val();
	var eventID = $('#eventID').val();
	var result = $('#result').val();
	var nameFirst = $('#nameFirst').val();
	var nameLast = $('#nameLast').val();
	var country = $('#country').val();
	var venue = $('#venue').val();
	var day = $('#day').val();
	var month = $('#month').val();
	var year = $('#year').val();
	
	//var lineBreak = document.getElementById('lineBreak').checked; 
	//var enabled = document.getElementById('enabled').checked; 
	
	$.ajax({
		url: '<?php echo base_url() . 'admin/records_con/update_record'; ?>',
		type: 'POST',
		data: 'token_admin=' + token_admin
		+ '&recordID=' + recordID
		+ '&recordType=' + recordType
		+ '&ageGroup=' + ageGroup
		+ '&eventID=' + eventID
		+ '&result=' + result
		+ '&nameFirst=' + escape(nameFirst)
		+ '&nameLast=' + escape(nameLast)
		+ '&country=' + escape(country)
		+ '&venue=' + escape(venue)
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
					
					//$("#result, #nameFirst, #nameLast, #country, #venue").val(''); 
								
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
														 
	var recordID = $('#recordID').val();
	
		$.ajax({
		url: '<?php echo base_url() . 'admin/records_con/delete_record'; ?>',
		type: 'POST',
		data: 'recordID=' + recordID,
		
		success: function(result) {
		
					$('#loading').fadeOut(1000, function() {
						$(this).remove();
					});
					
					$('#showDelete').html(result);
					$('#showEntry').empty();
					$("#delButton").show(300);
	
					$("#delButton").hide(300);

					$("#recordType, #ageGroup, #in_out, #eventID, #indoorEventID, #nameFirst, #nameLast, #country, #result, #venue").val('');
					
				}
		});
	
	});

});
</script>

