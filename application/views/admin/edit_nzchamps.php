<div class="colFull"><!--START COLLFULL-->
  
<h3>Edit New Zealand Championship Medalists</h3><br />

<p id="delButton" style="display:none; margin-bottom:10px;" class="button">DELETE NZ CHAMPIONSHIP PERFORMANCE</p>

<div id="showDelete"></div><!--Load jQuery DELETE message-->
<div id="showEntry"></div><!--Load jQuery ENTRY message-->

	<?php echo form_open('admin/nzchamps_con/update_nzchamps', array('class' => 'results')); ?>

		<!--Adds hidden CSRF unique token
		This will be verified in the controller against
		the $this->session->userdata('token') before
		returning any results data-->
		<input type="hidden" name="token_admin" id="token_admin" value="<?php echo $token_admin; ?>" />

		<!--Tracks the athleteID -->
		<input type="hidden" name="repID" id="repID" value="<?php echo $pop_data->id; ?>" />

		<div class="dotted"></div>

		<?php
			echo '<label for="year">Year:</label>';
			echo buildYearDropdown('year', $pop_data->year, 'id="year"'); // See global helper
		?>

		<?php
			$eventName = convertEventID();

			// Display full list of events drop down menu
			echo '<label for="eventID" style="margin-left:10px;">Event: </label>';
			//echo buildEventsDropdown($pop_data->eventID, $pop_data->eventID, $eventName); // See global helper
			//echo buildEventsDropdown($pop_data->eventID, $pop_data->eventID, $pop_data->eventName); // See global helper
			echo buildRecordEventsDropdown($pop_data->eventID, $pop_data->eventID, $pop_data->eventName);
		?>


		<label for="ageGroup" style="margin-left:10px;">Age Group:</label>
		<input type="text" name="ageGroup" id="ageGroup" size="10" value="<?php echo $pop_data->ageGroup; ?>" />

		<label for="performance" style="margin-left:10px;">Performance:</label>
		<input type="text" name="performance" id="performance" size="10" value="<?php echo $pop_data->performance; ?>" />

		<label for="position">Postition:</label>
		<input type="text" name="position" id="position" size="6" value="<?php echo $pop_data->position; ?>" />

		<div class="dotted"></div>

		<label for="submit"></label>
		<input type="submit" name="submit" id="submit" value="Update NZ Medalist" />
		<?php echo anchor( base_url() . 'site/profiles_con/athlete/' . $this->uri->segment(5), 'Back to Profile', array('class' => 'button')); ?>

	<?php echo form_close(); ?>

	<?php 



	?>


</div><!--END COLLFULL-->

<!--JQUERY AJAX 'DELETE RESULT' SCRIPT-->
<script>

$(function() {
					 
$('#delButton').click(function(){
$('#showDelete').append('<img src="<?php echo base_url() . 'images/loading.gif' ?>" alt="Currently Loading" id="loading" />');
														 
	var repID = $('#repID').val();
	
		$.ajax({
		url: '<?php echo base_url() . 'admin/nzchamps_con/delete_nzchamps'; ?>',
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
					
				}
		});
	
	});

});
</script>




<!--JQUERY AJAX 'ADD RESULTS' SCRIPT-->
<script type="text/javascript">

$(function() {

$('#submit').click(function() {
$('#showEntry').append('<img src="<?php echo base_url() . 'images/loading.gif' ?>" alt="Currently Loading" id="loading" />');

	var token_admin = $('#token_admin').val();
	var repID = $('#repID').val();
	var year = $('#year').val();
	var eventID = $('#eventID').val();
	var ageGroup = $('#ageGroup').val();
	var performance = $('#performance').val();
	var position = $('#position').val();
	
	//var lineBreak = document.getElementById('lineBreak').checked; 
	//var enabled = document.getElementById('enabled').checked; 
	
	$.ajax({
		url: '<?php echo base_url() . 'admin/nzchamps_con/update_nzchamps'; ?>',
		type: 'POST',
		data: 'token_admin=' + token_admin
		+ '&repID=' + repID
		+ '&year=' + year
		+ '&eventID=' + eventID
		+ '&ageGroup=' + ageGroup
		+ '&performance=' + performance
		+ '&position=' + escape(position),
		
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