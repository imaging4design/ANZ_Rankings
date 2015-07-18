<div class="colFull"><!--START COLLFULL-->
  
<h3>Add Results (Multi Events)</h3><br />

<p id="delButton" style="display:none; margin-bottom:10px;" class="button">DELETE RECORD</p>

<div id="showDelete"></div><!--Load jQuery DELETE message-->
<div id="showEntry"></div><!--Load jQuery ENTRY message-->

<?php echo form_open('admin/multis_con/update_result_multi', array('class' => 'results')); ?>

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
    
  <label for="points" style="margin-left:20px;">Points:</label>
  <input type="text" name="points" id="points" size="5" value="<?php echo $pop_data->points; ?>" />
  
  <label for="wind" style="margin-left:20px;">Wind:</label>
  <input type="text" name="wind" id="wind" size="3" value="<?php echo $pop_data->wind; ?>" />
  
  <label for="placing" style="margin-left:20px;">Placing:</label>
  <input type="text" name="placing" id="placing" size="3" value="<?php echo $pop_data->placing; ?>" />
  
  <label for="record" style="margin-left:20px;">Record:</label>
  <input type="text" name="record" id="record" size="3" value="<?php echo $pop_data->record; ?>" />
  
  <div class="dotted"></div>
  
  <label for="e01">Evt 1:</label>
  <input type="text" name="e01" id="e01" size="3" value="<?php echo $pop_data->e01; ?>" />
  
  <label for="e02" style="margin-left:8px;">Evt 2:</label>
  <input type="text" name="e02" id="e02" size="3" value="<?php echo $pop_data->e02; ?>" />
  
  <label for="e03" style="margin-left:8px;">Evt 3:</label>
  <input type="text" name="e03" id="e03" size="3" value="<?php echo $pop_data->e03; ?>" />
  
  <label for="e04" style="margin-left:8px;">Evt 4:</label>
  <input type="text" name="e04" id="e04" size="3" value="<?php echo $pop_data->e04; ?>" />
  
  <label for="e05" style="margin-left:8px;">Evt 5:</label>
  <input type="text" name="e05" id="e05" size="3" value="<?php echo $pop_data->e05; ?>" />
  
  <label for="e06" style="margin-left:8px;">Evt 6:</label>
  <input type="text" name="e06" id="e06" size="3" value="<?php echo $pop_data->e06; ?>" />
  
  <label for="e07" style="margin-left:8px;">Evt 7:</label>
  <input type="text" name="e07" id="e07" size="3" value="<?php echo $pop_data->e07; ?>" />
  
  <label for="e08" style="margin-left:8px;">Evt 8:</label>
  <input type="text" name="e08" id="e08" size="3" value="<?php echo $pop_data->e08; ?>" />
  
  <label for="e09" style="margin-left:8px;">Evt 9:</label>
  <input type="text" name="e09" id="e09" size="3" value="<?php echo $pop_data->e09; ?>" />
  
  <label for="e10" style="margin-left:8px;">Evt 10:</label>
  <input type="text" name="e10" id="e10" size="3" value="<?php echo $pop_data->e10; ?>" />
  
  <div class="dotted"></div>
  
	<?php
		// Display full list of events drop down menu
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
		echo buildYearDropdown($name='year', $value=$dateArray[0], $id='id="year"'); // See global helper
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
	var points = $('#points').val();
	var wind = $('#wind').val();
	var placing = $('#placing').val();
	var record = $('#record').val();
	
	var e01 = $('#e01').val();
	var e02 = $('#e02').val();
	var e03 = $('#e03').val();
	var e04 = $('#e04').val();
	var e05 = $('#e05').val();
	var e06 = $('#e06').val();
	var e07 = $('#e07').val();
	var e08 = $('#e08').val();
	var e09 = $('#e09').val();
	var e10 = $('#e10').val();
	
	var eventID = $('#eventID').val();
	var ageGroup = $('#ageGroup').val();
	var competition = $('#competition').val();
	var venue = $('#venue').val();
	var venue_other = $('#venue_other').val();
	var day = $('#day').val();
	var month = $('#month').val();
	var year = $('#year').val();
	
	//var lineBreak = document.getElementById('lineBreak').checked; 
	//var enabled = document.getElementById('enabled').checked; 
	
	$.ajax({
		url: '<?php echo base_url() . 'admin/multis_con/update_result_multi'; ?>',
		type: 'POST',
		data: 'token_admin=' + token_admin
		+ '&resultID=' + resultID
		+ '&athleteID=' + escape(athleteID)
		+ '&points=' + points
		+ '&wind=' + wind
		+ '&placing=' + placing
		+ '&record=' + record
		+ '&e01=' + e01
		+ '&e02=' + e02
		+ '&e03=' + e03
		+ '&e04=' + e04
		+ '&e05=' + e05
		+ '&e06=' + e06
		+ '&e07=' + e07
		+ '&e08=' + e08
		+ '&e09=' + e09
		+ '&e10=' + e10
		+ '&eventID=' + eventID
		+ '&ageGroup=' + ageGroup
		+ '&competition=' + escape(competition) 
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
								
								$("#athleteID, #points, #placing, #record, #e01, #e02, #e03, #e04, #e05, #e06, #e07, #e08, #e09, #e10").val(''); 
								
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



<!--JQUERY AJAX 'DE:ETE RESULTS' SCRIPT-->
<script>

$(function() {
					 
$('#delButton').click(function(){
$('#showDelete').append('<img src="<?php echo base_url() . 'images/loading.gif' ?>" alt="Currently Loading" id="loading" />');
														 
	var resultID = $("em").attr("title");
	
		$.ajax({
		url: '<?php echo base_url() . 'admin/multis_con/delete_results_multi'; ?>',
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