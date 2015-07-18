<div class="colFull"><!--START COLLFULL-->
  
<h3>Add New Zealand Championship Medalists</h3><br />

<p id="delButton" style="display:none; margin-bottom:10px;" class="button">DELETE NZ CHAMPIONSHIP PERFORMANCE</p>

<div id="showDelete"></div><!--Load jQuery DELETE message-->
<div id="showEntry"></div><!--Load jQuery ENTRY message-->

	<?php echo form_open('admin/nzchamps_con/add_new_nzchamps', array('class' => 'results')); ?>

		<!--Adds hidden CSRF unique token
		This will be verified in the controller against
		the $this->session->userdata('token') before
		returning any results data-->
		<input type="hidden" name="token_admin" id="token_admin" value="<?php echo $token_admin; ?>" />

		<!--Tracks the athleteID -->
		<input type="hidden" name="athleteID" id="athleteID" value="<?php echo $this->uri->segment(4); ?>" />

		<div class="dotted"></div>

		<?php
			echo '<label for="year">Year:</label>';
			echo buildYearDropdown('year', set_value('year'), 'id="year"'); // See global helper
		?>

		<?php
			// Display full list of events drop down menu
			echo '<label for="eventID" style="margin-left:10px;">Event: </label>';
			// echo buildEventsDropdown(); // See global helper
			echo buildRecordEventsDropdown($value='', $selected='', $label='');
		?>

		

		<label for="ageGroup" style="margin-left:10px;">Age Group:</label>
		<input type="text" name="ageGroup" id="ageGroup" size="10" value="<?php echo set_value('ageGroup'); ?>" />


		<label for="performance" style="margin-left:10px;">Performance:</label>
		<input type="text" name="performance" id="performance" size="10" value="<?php echo set_value('performance'); ?>" />

		<label for="position" style="margin-left:10px;">Postition:</label>
		<input type="text" name="position" id="position" size="6" value="<?php echo set_value('position'); ?>" />

		<div class="dotted"></div>

		<label for="submit"></label>
		<input type="submit" name="submit" id="submit" value="Add NZ Medialist" />
		<?php echo anchor( base_url() . 'site/profiles_con/athlete/' . $this->uri->segment(4), 'Back to Profile', array('class' => 'button')); ?>

	<?php echo form_close(); ?>


</div><!--END COLLFULL-->


<!--JQUERY AJAX 'DELETE RESULT' SCRIPT-->
<script>

$(function() {
					 
$('#delButton').click(function(){
$('#showDelete').append('<img src="<?php echo base_url() . 'images/loading.gif' ?>" alt="Currently Loading" id="loading" />');
														 
	var repID = $("em").attr("title");
	
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