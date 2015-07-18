<div class="colFull"><!--START COLLFULL-->
  
<h3>Add Records</h3><br />

<p id="delButton" style="display:none; margin-bottom:10px;" class="button">DELETE RECORD</p>

<div id="showDelete"></div><!--Load jQuery DELETE message-->
<div id="showEntry"></div><!--Load jQuery ENTRY message-->

<?php echo form_open('admin/records_con/add_new_record', array('class' => 'results')); ?>

  <!--Adds hidden CSRF unique token
	This will be verified in the controller against
	the $this->session->userdata('token') before
	returning any results data-->
  <input type="hidden" name="token_admin" id="token_admin" value="<?php echo $token_admin; ?>" />
  
  <?php
	// Select type of record (i.e., Allcomers, National etc ...)
	echo recordType($selected = '');
	
	// Select an ageGroup
	echo buildAgeGroup_records($selected = set_value('ageGroup'));
	
	// Indoor / Outdoors
	echo in_out($selected='');
	?>
  
  <div class="dotted"></div>
  
  <?php
	// Select an ageGroup
	echo buildRecordEventsDropdown($value='', $selected='', $label='');
	echo buildIndoorEventsDropdown($value='', $selected='', $label='');
	?>
    
  <label for="result" style="margin-left:10px;">Result:</label>
  <input type="text" name="result" id="result" size="6" value="<?php echo set_value('result'); ?>" />

  <label for="nameFirst" style="margin-left:10px;">First Name:</label>
  <input type="text" name="nameFirst" id="nameFirst" size="15" value="<?php echo set_value('nameFirst'); ?>" />
  
  <label for="nameLast" style="margin-left:10px;">Last Name:</label>
  <input type="text" name="nameLast" id="nameLast" size="20" value="<?php echo set_value('nameLast'); ?>" />

  <label for="country" style="margin-left:10px;">Country:</label>
  <input type="text" name="country" id="country" size="20" value="<?php echo set_value('country'); ?>" />
  
  <div class="dotted"></div>
  
  <label for="venue">Venue of Record:</label>
  <input type="text" name="venue" id="venue" size="30" value="<?php echo set_value('venue'); ?>" />
  
  <?php
		// Display drop down menus for date (day, month, year)
		echo '<label for="date" style="display:inline; margin-left:10px;">Date: </label>';
		echo buildDayDropdown($name='day', $value='1', $id='id="day"') . ' '; // See global helper
		echo buildMonthDropdown($name='month', $value='', $id='id="month"') . ' '; // See global helper
		echo '<input type="text" name="year" id="year" size="4" value="" />';
	?>
  
  <div class="dotted"></div>
  
  <label for="submit"></label>
  <input type="submit" name="submit" id="submit" value="Add Record" />
  

</div><!--END COLLFULL-->

<?php echo form_close(); ?>


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


<!--JQUERY AJAX 'DELETE RESULT' SCRIPT-->
<script>

$(function() {
					 
$('#delButton').click(function(){
$('#showDelete').append('<img src="<?php echo base_url() . 'images/loading.gif' ?>" alt="Currently Loading" id="loading" />');
														 
	var recordID = $("em").attr("title");
	
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
	var day = $('#day').val();
	var month = $('#month').val();
	var year = $('#year').val();
	
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