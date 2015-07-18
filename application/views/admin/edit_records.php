<div class="colFull"><!--START COLLFULL-->
  
<h3>Edit Records</h3><br />

<p id="delButton" style="display:none; margin-bottom:10px;" class="button">DELETE RECORD</p>

<div id="showDelete"></div><!--Load jQuery DELETE message-->
<div id="showEntry"></div><!--Load jQuery ENTRY message-->

<?php echo form_open('admin/records_con/add_new_record', array('class' => 'results')); ?>

  <!--Adds hidden CSRF unique token
	This will be verified in the controller against
	the $this->session->userdata('token') before
	returning any results data-->
  <input type="hidden" name="token_admin" id="token_admin" value="<?php echo $token_admin; ?>" />
  
  <input type="hidden" name="recordID" id="recordID" value="<?php echo $pop_data->recordID; ?>" />
  
  <?php
	// Select type of record (i.e., Allcomers, National etc ...)
	echo recordType($pop_data->recordType);
	
	// Select an ageGroup
	echo buildAgeGroup_records($pop_data->ageGroup);
	?>
  
  <div class="dotted"></div>
  
  <?php
	// Select an ageGroup
	echo buildRecordEventsDropdown($pop_data->eventID, $pop_data->eventID, $pop_data->eventName);
	?>
    
  <label for="result" style="margin-left:10px;">Result:</label>
  <input type="text" name="result" id="result" size="6" value="<?php echo $pop_data->result; ?>" />
  
  <label for="nameFirst" style="margin-left:10px;">First Name:</label>
  <input type="text" name="nameFirst" id="nameFirst" size="15" value="<?php echo $pop_data->nameFirst; ?>" />
  
  <label for="nameLast" style="margin-left:10px;">Last Name:</label>
  <input type="text" name="nameLast" id="nameLast" size="20" value="<?php echo $pop_data->nameLast; ?>" />
  
  <label for="country" style="margin-left:10px;">Country:</label>
  <input type="text" name="country" id="country" size="20" value="<?php echo $pop_data->country; ?>" />
  
  <div class="dotted"></div>
  
  <label for="venue">Venue of Record:</label>
  <input type="text" name="venue" id="venue" size="30" value="<?php echo $pop_data->venue; ?>" />
  
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
  <input type="submit" name="submit" id="submit" value="Update Record" />
  

</div><!--END COLLFULL-->

<?php echo form_close(); ?>


<!--JQUERY AJAX 'DELETE RESULT' SCRIPT-->
<script>

$(function() {
					 
$('#delButton').click(function(){
$('#showDelete').append('<img src="<?php echo base_url() . 'images/loading.gif' ?>" alt="Currently Loading" id="loading" />');
														 
	var recordID = $('#recordID').val();
	
		$.ajax({
		url: '<?php echo base_url() . 'admin/records_con/delete_record'; ?>',
		type: 'POST',
		data: 'recordID=' + recordID,
		
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
		
		success: 	function(result) {
				
								$('#loading').fadeOut(500, function() {
										$(this).remove();
								});
								
								$('#showEntry').html(result);
								$('#showDelete').empty();
								$("#delButton").show(300);
								
								$("#result, #nameFirst, #nameLast, #country, #venue").val(''); 
								
						}
				});
		
		return false;
		
	});


	
	});

</script>