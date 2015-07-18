<div class="colFull"><!--START COLLFULL-->
  
<h3>Add Relays</h3><br />

<p id="delButton" style="display:none; margin-bottom:10px;" class="button">DELETE RECORD</p>

<div id="showDelete"></div><!--Load jQuery DELETE message-->
<div id="showEntry"></div><!--Load jQuery ENTRY message-->

<?php echo form_open('admin/relays_con/add_new_relay', array('class' => 'results')); ?>

  <!--Adds hidden CSRF unique token
	This will be verified in the controller against
	the $this->session->userdata('token') before
	returning any results data-->
  <input type="hidden" name="token_admin" id="token_admin" value="<?php echo $token_admin; ?>" />
  
  <?php
	// Display full list of events drop down menu
	echo '<label for="eventID" style="display:inline;">Event: </label>';
	echo buildEventsDropdown(); // See global helper
	
	// Display full list of ageGroups drop down menu
	echo buildAgeGroupDropdown(); // See global helper
  ?>

   
  <div class="dotted"></div>
  
  <label for="time">Time:</label>
  <input type="text" name="time" id="time" size="6" value="<?php echo set_value('time'); ?>" />
  
  <label for="placing" style="margin-left:20px;">Placing:</label>
  <input type="text" name="placing" id="placing" size="3" value="<?php echo set_value('placing'); ?>" />
  
  <label for="record" style="margin-left:20px;">Record:</label>
  <input type="text" name="record" id="record" size="3" value="<?php echo set_value('record'); ?>" />
  
  <div class="dotted"></div>
  
  <label for="athlete01">Athlete 1:</label>
  <input type="text" name="athlete01" id="athlete01" size="20" value="<?php echo set_value('athlete01'); ?>" />
  
  <label for="athlete02" style="margin-left:20px;">Athlete 2:</label>
  <input type="text" name="athlete02" id="athlete02" size="20" value="<?php echo set_value('athlete02'); ?>" />
  
  <label for="athlete03" style="margin-left:20px;">Athlete 3:</label>
  <input type="text" name="athlete03" id="athlete03" size="20" value="<?php echo set_value('athlete03'); ?>" />
  
  <label for="athlete04" style="margin-left:20px;">Athlete 4</label>
  <input type="text" name="athlete04" id="athlete04" size="20" value="<?php echo set_value('athlete04'); ?>" />
  
  <div class="dotted"></div>
  
  <label for="team">Team:</label>
  <input type="text" name="team" id="team" size="20" value="<?php echo set_value('team'); ?>" />
  
  <label for="competition" style="margin-left:10px;">Competition:</label>
  <input type="text" name="competition" id="competition" size="30" value="<?php echo set_value('competition'); ?>" />
  
  <label for="in_out" style="margin-left:10px;">Indoors / Outdoors:</label>
  <?php
	echo in_out(set_value('in_out'));
	?>
  
  <div class="dotted"></div>
  
  <?php
	// Display drop down menu for default venues
	echo get_venues(); // See global helper
	?>
  
  <label for="venue_other" style="margin-left:10px;">Venue (Other):</label>
  <input type="text" name="venue_other" id="venue_other" size="40" value="<?php echo set_value('venue_other'); ?>" />
  
  <div class="dotted"></div>
  
	<!-- jQuery UI Date Picker -->
	<label for="date" style="display:inline;">Date: </label>
	<input type="text" id="date" name="date" />
  
  <div class="dotted"></div>
  
    <label for="submit"></label>
    <input type="submit" name="submit" id="submit" value="Add Relay Result" />
  

</div><!--END COLLFULL-->

<?php echo form_close(); ?>


<!--JQUERY AJAX 'DELETE RESULT' SCRIPT-->
<script>

$(function() {
					 
$('#delButton').click(function(){
$('#showDelete').append('<img src="<?php echo base_url() . 'images/loading.gif' ?>" alt="Currently Loading" id="loading" />');
														 
	var resultID = $("em").attr("title");
	
		$.ajax({
		url: '<?php echo base_url() . 'admin/relays_con/delete_relay'; ?>',
		type: 'POST',
		data: 'resultID=' + resultID,
		
		success: 	function(result) {
		
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
								$('#showDelete').empty();
								$("#delButton").show(300);
								
								$("#time, #placing, #record, #athlete01, #athlete02, #athlete03, #athlete04, #venue_other").val(''); 
								
								
						}
				});
		
		return false;
		
	});


	
	});

</script>