<div class="colFull"><!--START COLLFULL-->
  
<h3>Add Results (Individual Events)</h3><br />

<p id="delButton" style="display:none; margin-bottom:10px;" class="button">DELETE RECORD</p>

<div id="showDelete"></div><!--Load jQuery DELETE message-->
<div id="showEntry"></div><!--Load jQuery ENTRY message-->

<?php echo form_open('admin/results_con/add_result_ind', array('class' => 'results')); ?>

	<!--Adds hidden CSRF unique token
	This will be verified in the controller against
	the $this->session->userdata('token') before
	returning any results data-->
	<input type="hidden" name="token_admin" id="token_admin" value="<?php echo $token_admin; ?>" />

	<?php
		// Display full list of events drop down menu
		echo '<label for="eventID" style="display:inline;">Event: </label>';
		//echo buildEventsDropdown(); // See global helper
		echo buildRecordEventsDropdown($value='', $selected='', $label=''); // See global helper
	?> 

	<div class="dotted"></div>

	<label for="athlete">Athlete:</label>
	<input type="text" name="athleteID" id="athleteID" size="40" />
	<!--DON'T REMOVE id="athlete" (required for auto-populate!)-->


	<span id="trackEvent"><!-- Show/Hide with jQuery depending on event selected! -->
		<label for="time" style="margin-left:20px;">Time:</label>
		<input type="text" name="time" id="time" size="6" value="<?php echo set_value('time'); ?>" />
	</span>

	<span id="fieldEvent"><!-- Show/Hide with jQuery depending on event selected! -->
		<label for="distHeight" style="margin-left:20px;">Dist/Height:</label>
		<input type="text" name="distHeight" id="distHeight" size="4" value="<?php echo set_value('distHeight'); ?>" />
	</span>


	<label for="wind" style="margin-left:20px;">Wind:</label>
	<input type="text" name="wind" id="wind" size="3" value="<?php echo set_value('wind'); ?>" />

	<label for="placing" style="margin-left:20px;">Placing:</label>
	<input type="text" name="placing" id="placing" size="3" value="<?php echo set_value('placing'); ?>" />

	<label for="record" style="margin-left:20px;">Record:</label>
	<input type="text" name="record" id="record" size="3" value="<?php echo set_value('record'); ?>" />

	<div class="dotted"></div>
  
	

	<?php
		// Display full list of events drop down menu
		echo '<label for="ageGroup" style="margin-left:20px;">Age Group:</label>';
		echo buildAgeGroupDropdown(); // See global helper
	?> 
  
	<div class="dotted"></div>

	<label for="competition">Competition:</label>
	<input type="text" name="competition" id="competition" size="40" value="<?php echo set_value('competition'); ?>" />

	<label for="in_out" style="margin-left:20px;">Indoors / Outdoors:</label>
	<?php echo in_out(set_value('in_out')); ?>

	<div class="dotted"></div>

	<?php
		// Display drop down menu for default venues
		echo get_venues(); // See global helper
	?>

	<label for="venue_other" style="margin-left:20px;">Venue (Other):</label>
	<input type="text" name="venue_other" id="venue_other" size="40" value="<?php echo set_value('venue_other'); ?>" />

	<div class="dotted"></div>

	<!-- jQuery UI Date Picker -->
	<label for="date" style="display:inline;">Date: </label>
	<input type="text" id="date" name="date" />

	<div class="dotted"></div>

	<label for="submit"></label>
	<input type="submit" name="submit" id="submit" value="Add Result" />
  

</div><!--END COLLFULL-->

<?php echo form_close(); ?>


<script>
	
	// Used to hide either the 'Time' or 'Dist/Height' input boxes depending on what event is selected
	// Example :: If the 400m (track event is selected) hide the 'Dist/Height' input box
	// WHY? :: To prevent data being accidentally entered into the wrong field!

	// Initiate var
	var selectedEvent = false;

	$('#trackEvent').hide();
	$('#fieldEvent').hide();

	$('#eventID').on('change', function() {
		var selectedEvent = this.value;
		//alert( selectedEvent ); // or $(this).val()
		
		// This array contains 'Field Event IDs' ONLY!!
		var field = ['26', '27', '28', '29', '30', '31', '32', '33'];

		if ($.inArray(selectedEvent, field) > -1)
		{
			//console.log('I\'m a Field Event!');
			$('#trackEvent').hide();
			$('#fieldEvent').show();

		} else {

			$('#trackEvent').show();
			$('#fieldEvent').hide();
		}

    });

	
</script>



<!--JQUERY AJAX 'DELETE RESULT' SCRIPT-->
<script>

$(function() {
					 
$('#delButton').click(function(){
$('#showDelete').append('<img src="<?php echo base_url() . 'images/loading.gif' ?>" alt="Currently Loading" id="loading" />');
														 
	var resultID = $("em").attr("title");
	
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




<!--JQUERY AJAX 'ADD RESULTS' SCRIPT-->
<script type="text/javascript">

$(function() {

$('#submit').click(function() {
$('#showEntry').append('<img src="<?php echo base_url() . 'images/loading.gif' ?>" alt="Currently Loading" id="loading" />');

	var token_admin = $('#token_admin').val();
	var athleteID = $('#athleteID').val();
	var time = $('#time').val();
	var distHeight = $('#distHeight').val();
	var wind = $('#wind').val();
	var record = $('#record').val();
	var placing = $('#placing').val();
	var eventID = $('#eventID').val();
	var ageGroup = $('#ageGroup').val();
	var competition = $('#competition').val();
	var in_out = $('#in_out').val();
	var venue = $('#venue').val();
	var venue_other = $('#venue_other').val();
	var date = $('#date').val();
	
	
	$.ajax({
		url: '<?php echo base_url() . 'admin/results_con/add_result_ind'; ?>',
		type: 'POST',
		data: 'token_admin=' + token_admin
		+ '&athleteID=' + escape(athleteID)
		+ '&time=' + time
		+ '&distHeight=' + distHeight
		+ '&wind=' + wind
		+ '&record=' + record
		+ '&placing=' + placing
		+ '&eventID=' + eventID
		+ '&ageGroup=' + ageGroup
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