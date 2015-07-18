<div class="colFull"><!--START COLLFULL-->
  
<h3>Edit Relays</h3><br />

<p id="delButton" style="display:none; margin-bottom:10px;" class="button">DELETE RECORD</p>

<div id="showDelete"></div><!--Load jQuery DELETE message-->
<div id="showEntry"></div><!--Load jQuery ENTRY message-->

<?php echo form_open('admin/relays_con/edit_relay', array('class' => 'results')); ?>

  <!--Adds hidden CSRF unique token
	This will be verified in the controller against
	the $this->session->userdata('token') before
	returning any results data-->
  <input type="hidden" name="token_admin" id="token_admin" value="<?php echo $token_admin; ?>" />
  
  <!--Get the resultID-->
  <input type="hidden" name="resultID" id="resultID" value="<?php echo $this->uri->segment(4); ?>" />
  
  <?php
	// Display full list of events drop down menu
	echo '<label for="eventID" style="display:inline;">Event: </label>';
	echo buildEventsDropdown($pop_data->eventID, $pop_data->eventID, $pop_data->eventName); // See global helper
	
	// Display full list of ageGroups drop down menu
	echo buildAgeGroupDropdown($pop_data->ageGroup);
  ?>
   
  <div class="dotted"></div>
  
  <label for="time">Time:</label>
  <input type="text" name="time" id="time" size="6" value="<?php echo $pop_data->time; ?>" />
  
  <label for="placing" style="margin-left:20px;">Placing:</label>
  <input type="text" name="placing" id="placing" size="3" value="<?php echo $pop_data->placing; ?>" />
  
  <label for="record" style="margin-left:20px;">Record:</label>
  <input type="text" name="record" id="record" size="3" value="<?php echo $pop_data->record; ?>" />
  
  <div class="dotted"></div>
  
  <label for="athlete01">Athlete 1:</label>
  <input type="text" name="athlete01" id="athlete01" size="20" value="<?php echo $pop_data->athlete01; ?>" />
  
  <label for="athlete02" style="margin-left:20px;">Athlete 2:</label>
  <input type="text" name="athlete02" id="athlete02" size="20" value="<?php echo $pop_data->athlete02; ?>" />
  
  <label for="athlete03" style="margin-left:20px;">Athlete 3:</label>
  <input type="text" name="athlete03" id="athlete03" size="20" value="<?php echo $pop_data->athlete03; ?>" />
  
  <label for="athlete04" style="margin-left:20px;">Athlete 4</label>
  <input type="text" name="athlete04" id="athlete04" size="20" value="<?php echo $pop_data->athlete04; ?>" />
  
  <div class="dotted"></div>
  
  <label for="team">Team:</label>
  <input type="text" name="team" id="team" size="20" value="<?php echo $pop_data->team; ?>" />
  
  <label for="competition" style="margin-left:10px;">Competition:</label>
  <input type="text" name="competition" id="competition" size="30" value="<?php echo $pop_data->competition; ?>" />
  
  <?php
	if($pop_data->in_out == 'out')
	{
		$in_out = 'Outdoors';
	}
	else
	{
		$in_out = 'Indoors';
	}
	?>
  <label for="in_out" style="margin-left:20px;">Indoors / Outdoors:</label>
  <select name="in_out" id="in_out">
    <option value="<?php echo $pop_data->in_out; ?>" selected="<?php echo $pop_data->in_out; ?>"><?php echo $in_out; ?></option>
    <option value="out">Outdoors</option>
    <option value="in">Indoors</option>
  </select>
  
  <div class="dotted"></div>
  
  <?php
	// Display drop down menu for default venues
	echo get_venues($pop_data->venue); // See global helper
	?>
  
  <label for="venue_other" style="margin-left:10px;">Venue (Other):</label>
  <input type="text" name="venue_other" id="venue_other" size="40" value="<?php echo set_value('venue_other'); ?>" />
  
  <div class="dotted"></div>
  
	<?php
		// Explode the date into segments (Day, month year)
		// Use these segments as 'selected' values for the date drop downs
		$dateArray=explode('-', $pop_data->date);
	
		// Display drop down menus for date (day, month, year)
		echo '<label for="date" style="display:inline;">Date: </label>';
		echo buildDayDropdown($name='day', $value=$dateArray[2], $id='id="day"'); // See global helper
		echo buildMonthDropdown($name='month', $value=$dateArray[1], $id='id="month"'); // See global helper
		echo '<input type="text" name="year" id="year" size="4" value="'.$value=$dateArray[0].'" />';
		//echo buildYearDropdown($name='year', $value=$dateArray[0], $id='id="year"'); // See global helper
	?>
  
  <div class="dotted"></div>
  
    <label for="submit"></label>
    <input type="submit" name="submit" id="submit" value="Update Relay Result" />
  

</div><!--END COLLFULL-->

<?php echo form_close(); ?>


<!--JQUERY AJAX 'DELETE RESULT' SCRIPT-->
<script>

$(function() {
					 
$('#delButton').click(function(){
$('#showDelete').append('<img src="<?php echo base_url() . 'images/loading.gif' ?>" alt="Currently Loading" id="loading" />');
														 
	var resultID = $('#resultID').val();
	
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
	var resultID = $('#resultID').val();
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
	var day = $('#day').val();
	var month = $('#month').val();
	var year = $('#year').val();
	
	//var lineBreak = document.getElementById('lineBreak').checked; 
	//var enabled = document.getElementById('enabled').checked; 
	
	$.ajax({
		url: '<?php echo base_url() . 'admin/relays_con/edit_relay'; ?>',
		type: 'POST',
		data: 'token_admin=' + token_admin
		+ '&resultID=' + resultID
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
		+ '&day=' + day
		+ '&month=' + month
		+ '&year=' + year,
		
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