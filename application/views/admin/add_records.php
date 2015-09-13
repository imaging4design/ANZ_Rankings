<div class="row">
	<div class="col-sm-12">
		
		<h1>Add New Record</h1>

		<div class="row">
			<div class="col-md-12">
				<div id="showEntry"></div><!--Load jQuery ENTRY message-->
			</div>
		</div>


		<div class="well well-trans">

			<?php echo form_open('admin/records_con/add_new_record', array('class' => 'results')); ?>

				<!--Adds hidden CSRF unique token
				This will be verified in the controller against
				the $this->session->userdata('token') before
				returning any results data-->
				<input type="hidden" name="token_admin" id="token_admin" value="<?php echo $token_admin; ?>" />


				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="nameFirst">Record Type:</label>
							<?php
								// Select type of record (i.e., Allcomers, National etc ...)
								echo recordType($selected = ''); 
							?>
						</div>
					</div><!--ENDS col-->

					<div class="col-md-4">
						<div class="form-group">
							<label for="nameFirst">Age Group:</label>
							<?php
								// Select an ageGroup
								echo buildAgeGroup_records($selected = set_value('ageGroup'));
							?>
						</div>
					</div><!--ENDS col-->

					<div class="col-md-4">
						<div class="form-group">
							<label for="nameFirst">Indoors/Outdoors:</label>
							<?php
								// Indoor / Outdoors
								echo in_out($selected='');
							?>
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
								echo buildRecordEventsDropdown($value='', $selected='', $label='');
								echo buildIndoorEventsDropdown($value='', $selected='', $label='');
							?>
						</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->



				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="nameFirst">First Name:</label>
							<input type="text" name="nameFirst" id="nameFirst" class="form-control" value="<?php echo set_value('nameFirst'); ?>" />
						</div>
					</div><!--ENDS col-->

					<div class="col-md-4">
						<div class="form-group">
							<label for="nameLast">Last Name:</label>
							<input type="text" name="nameLast" id="nameLast" class="form-control" value="<?php echo set_value('nameLast'); ?>" />
						</div>
					</div><!--ENDS col-->

					<div class="col-md-4">
						<div class="form-group">
							<label for="country">Country:</label>
							<input type="text" name="country" id="country" class="form-control" value="<?php echo set_value('country'); ?>" />
						</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->



				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="result">Result:</label>
							<input type="text" name="result" id="result" class="form-control" value="<?php echo set_value('result'); ?>" />
						</div>
					</div><!--ENDS col-->

					<div class="col-md-4">
						<div class="form-group">
							<label for="venue">Venue of Record:</label>
							<input type="text" name="venue" id="venue" class="form-control" value="<?php echo set_value('venue'); ?>" />
						</div>
					</div><!--ENDS col-->

					<div class="col-md-4">
						<div class="form-group">
							<!-- jQuery UI Date Picker -->
							<div class="form-group">
								<label for="date">Date: </label>
								<input type="text" id="date" class="form-control" name="date" />
							</div>
						</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->

				

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="submit"></label>
							<input type="submit" name="submit" id="submit" class="btn btn-green" value="Save Record" />
						</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->
			


			<?php echo form_close(); ?>

		</div><!-- ENDS well well-trans -->

	</div><!--ENDS col-->
</div><!--ENDS row-->





<!--JQUERY AJAX TOGGLE BETWEEN INDOOR AND OUTDOOR EVENTS (drop down menus)-->
<script>
$(function() {

$("#indoorEventID").hide(300);

$('#in_out').change(function() {
														 
		var in_out = $('#in_out').val();												 

		if (in_out == 'out') {
			$("#eventID").show(300);
			$("#indoorEventID").hide(300);
		}
		else {
			$("#eventID").hide(300);
			$("#indoorEventID").show(300);
		}
	
	});

});
</script>




<!--JQUERY AJAX 'ADD RESULTS' SCRIPT-->
<script type="text/javascript">

$(function() {

$('#submit').click(function() {
$('#showEntry').append('<img src="<?php echo base_url() . 'img/loading.gif' ?>" alt="Currently Loading" id="loading" />');

	var token_admin = $('#token_admin').val();
	var recordType = $('#recordType').val();
	var ageGroup = $('#ageGroup').val();
	var in_out = $('#in_out').val();
	var eventID = $('#eventID').val();
	var indoorEventID = $('#indoorEventID').val();
	var result = $('#result').val();
	var nameFirst = $('#nameFirst').val();
	var nameLast = $('#nameLast').val();
	var country = $('#country').val();
	var venue = $('#venue').val();
	var date = $('#date').val();
	
	//var lineBreak = document.getElementById('lineBreak').checked; 
	//var enabled = document.getElementById('enabled').checked; 
	
	$.ajax({
		url: '<?php echo base_url() . 'admin/records_con/add_new_record'; ?>',
		type: 'POST',
		data: 'token_admin=' + token_admin
		+ '&recordType=' + recordType
		+ '&in_out=' + in_out
		+ '&ageGroup=' + ageGroup
		+ '&eventID=' + eventID
		+ '&indoorEventID=' + indoorEventID
		+ '&result=' + result
		+ '&nameFirst=' + escape(nameFirst)
		+ '&nameLast=' + escape(nameLast)
		+ '&country=' + escape(country)
		+ '&venue=' + escape(venue)
		+ '&date=' + date,
		
		success: function(result) {
				
					$('#loading').fadeOut(500, function() {
						$(this).remove();
					});
					
					$('#showEntry').html(result);
					
					$("#result, #nameFirst, #nameLast, #country, #venue").val(''); 
								
				}
		});
		
		return false;
		
	});
	
});

</script>