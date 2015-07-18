<div class="colFull"><!--START COLLFULL-->
  
<h3>Edit Results (Individual Events)</h3><br />

<p id="delButton" style="display:none; margin-bottom:10px;" class="button">DELETE RECORD</p>

<div id="showDelete"></div><!--Load jQuery DELETE message-->
<div id="showEntry"></div><!--Load jQuery ENTRY message-->

<?php echo form_open('admin/results_con/update_result_ind', array('class' => 'results')); ?>
  
  <!--Adds hidden CSRF unique token
	This will be verified in the controller against
	the $this->session->userdata('token') before
	returning any results data-->
  <input type="hidden" name="token_admin" id="token_admin" value="<?php echo $token_admin; ?>" />
  
  <!--Get the resultID-->
  <input type="hidden" name="resultID" id="resultID" value="<?php echo $this->uri->segment(4); ?>" />
  
  <label for="athlete">Athlete:</label>
  <input type="text" name="athleteID" id="athleteID" value="<?php echo $pop_data->athleteID; ?>" size="40" />
  <!--DON'T REMOVE class="athlete" (required for auto-populate!)-->
    
  <label for="time" style="margin-left:20px;">Time:</label>
  <input type="text" name="time" id="time" size="5" value="<?php echo ltrim($pop_data->time, 0); ?>" />
  
  <label for="wind" style="margin-left:20px;">Wind:</label>
  <input type="text" name="wind" id="wind" size="3" value="<?php echo $pop_data->wind; ?>" />
  
  <label for="distHeight" style="margin-left:20px;">Dist/Height:</label>
  <input type="text" name="distHeight" id="distHeight" size="4" value="<?php echo ltrim($pop_data->distHeight, 0); ?>" />
  
  <label for="placing" style="margin-left:20px;">Placing:</label>
  <input type="text" name="placing" id="placing" size="3" value="<?php echo $pop_data->placing; ?>" />
  
  <label for="record" style="margin-left:20px;">Record:</label>
  <input type="text" name="record" id="record" size="3" value="<?php echo $pop_data->record; ?>" />
  
  <div class="dotted"></div>
  
	<?php
		// Display full list of events drop down menu
		// This will initially show the existing value of the eventID column as 'Selected'
		echo '<label for="eventID" style="display:inline;">Event: </label>';
		// echo buildEventsDropdown($pop_data->eventID, $pop_data->eventID, $pop_data->eventName); // See global helper
		echo buildRecordEventsDropdown($pop_data->eventID, $pop_data->eventID, $pop_data->eventName); // See global helper
		
		// Display full list of ageGroups drop down menu
		// This will initially show the existing value of the ageGroup column as 'Selected'
		echo '<label for="ageGroup" style="margin-left:20px;">Age Group:</label>';
		echo buildAgeGroupDropdown($pop_data->ageGroup);
  ?>  
  
  <div class="dotted"></div>
  
  <label for="competition">Competition:</label>
  <input type="text" name="competition" id="competition" size="40" value="<?php echo $pop_data->competition; ?>" />
  
 
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
		// This will initially show the existing value of the venue column as 'Selected'
		echo get_venues($pop_data->venue); // See global helper
	?>
  
  <label for="venue_other" style="margin-left:20px;">Venue (Other):</label>
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
    <input type="submit" name="submit" id="submit" value="Update Result" />
  

</div><!--END COLLFULL-->

<?php echo form_close(); ?>


<!--JQUERY AJAX 'ADD RESULTS' SCRIPT-->
<script type="text/javascript">

$(function() {

$('#submit').click(function() {
$('#showEntry').append('<img src="<?php echo base_url() . 'images/loading.gif' ?>" alt="Currently Loading" id="loading" />');

	var token_admin = $('#token_admin').val();
	var resultID = $('#resultID').val();
	var athleteID = $('#athleteID').val();
	var time = $('#time').val();
	var wind = $('#wind').val();
	var distHeight = $('#distHeight').val();
	var record = $('#record').val();
	var placing = $('#placing').val();
	var eventID = $('#eventID').val();
	var ageGroup = $('#ageGroup').val();
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
		url: '<?php echo base_url() . 'admin/results_con/update_result_ind'; ?>',
		type: 'POST',
		data: 'token_admin=' + token_admin
		+ '&resultID=' + resultID
		+ '&athleteID=' + escape(athleteID)
		+ '&time=' + time
		+ '&wind=' + wind
		+ '&distHeight=' + distHeight
		+ '&record=' + record
		+ '&placing=' + placing
		+ '&eventID=' + eventID
		+ '&ageGroup=' + ageGroup
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
								
								$("#athleteID, #time, #distHeight, #placing, #record").val(''); 
								
								//Clears the AthleteID field when onFocus
								$('#competition, #venue_other').one("focus", function() {
									$(this).val("");
								});
								
								
						}
				});
		
		return false;
		
	});


	
	});

</script>



<!--JQUERY AJAX 'DELETE RESULTS' SCRIPT-->
<script>

$(function() {
					 
$('#delButton').click(function(){
$('#showDelete').append('<img src="<?php echo base_url() . 'images/loading.gif' ?>" alt="Currently Loading" id="loading" />');
														 
	var resultID = $('#resultID').val();
	
		$.ajax({
		url: '<?php echo base_url() . 'admin/results_con/delete_results'; ?>',
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