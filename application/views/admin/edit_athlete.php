<div class="colFull"><!--START COLLFULL-->
  
<h3>Edit Athlete</h3><br />

<div id="showEntry"></div><!--Load jQuery ENTRY message-->

<?php echo form_open('admin/athlete_con/edit_athlete', array('class' => 'results')); ?>

  <!--Adds hidden CSRF unique token
	This will be verified in the controller against
	the $this->session->userdata('token') before
	returning any results data-->
  <input type="hidden" name="token_admin" id="token_admin" value="<?php echo $token_admin; ?>" />

  <label for="athleteID" style="display:inline-block;">Athlete ID</label>
  <input type="text" name="athleteID" id="athleteID" value="<?php echo $pop_data->athleteID; ?>" />
  
  <div class="dotted"></div>
  
  <label for="nameFirst">First Name</label>
  <input type="text" name="nameFirst" id="nameFirst" value="<?php echo $pop_data->nameFirst; ?>" size="30" />
  
  <label for="nameLast" style="margin-left:20px;">Last Name</label>
  <input type="text" name="nameLast" id="nameLast" value="<?php echo $pop_data->nameLast; ?>" size="30" />
  
  <div class="dotted"></div>
  
  <?php
		// Explode the date into segments (Day, month year)
		// Use these segments as 'selected' values for the date drop downs
		$dateArray=explode('-', $pop_data->DOB);
		
		// Display drop down menus for date (day, month, year)
		echo '<label for="date" style="display:inline;">Date of Birth: </label>';
		echo buildDayDropdown($name='day', $value=$dateArray[2], $id='id="day"'); // See global helper
		echo buildMonthDropdown($name='month', $value=$dateArray[1], $id='id="month"'); // See global helper
		echo '<input type="text" name="year" id="year" size="4" value="'.$value=$dateArray[0].'" />';
		//echo buildYearDOB($name='year', $value=$dateArray[0], $id='id="year"'); // See global helper
	?>
  
  <label for="gender" style="margin-left:20px;">Gender</label>
  <?php
	$options = array(
						'M'  => 'Male',
						'F'  => 'Female'
            );

	echo form_dropdown('gender', $options, set_value('gender', $pop_data->gender), 'id="gender"');
	?>
  
  <div class="dotted"></div>
  
  <?php
		// Display full list of 'centres' drop down menu
		echo '<label for="centreID">Centre: </label>';
		echo dropDownCentres($value = $pop_data->centreID, $selected = set_select('centreID', $pop_data->centreID), $label = $pop_data->centreName); // See global helper
		
		// Display full list of 'clubs' drop down menu
		echo '<label for="clubID" style="margin-left:20px;">Club: </label>';
		echo dropDownClubs($value = $pop_data->clubID, $selected = set_select('clubID', $pop_data->clubID), $label = $pop_data->clubName); // See global helper
  ?>  
  
  <div class="dotted"></div>
  
  <label for="coach" style="float:left;">Coach:</label>
  <input type="text" name="coach" id="coach" value="<?php echo $pop_data->coach; ?>" size="30" />
  
  <label for="coach_former" style="margin-left:10px;">Former Coaches:</label>
  <input type="text" name="coach_former" id="coach_former" value="<?php echo $pop_data->coach_former; ?>" size="80" />
  
  <div class="dotted"></div>
  
	<label for="submit"></label>
	<input type="submit" name="submit" id="submit" value="Update Athlete" />
  



<?php echo form_close(); ?>

</div><!--END COLLFULL-->


<!--JQUERY AJAX 'ADD RESULTS' SCRIPT-->
<script type="text/javascript">

$(function() {

$('#submit').click(function() {
$('#showEntry').append('<img src="<?php echo base_url() . 'images/loading.gif' ?>" alt="Currently Loading" id="loading" />');

	var token_admin = $('#token_admin').val();
	var athleteID = $('#athleteID').val();
	var nameFirst = $('#nameFirst').val();
	var nameLast = $('#nameLast').val();
	var day = $('#day').val();
	var month = $('#month').val();
	var year = $('#year').val();
	var gender = $('#gender').val();
	var centreID = $('#centreID').val();
	var clubID = $('#clubID').val();
	var coach = $('#coach').val();
	var coach_former = $('#coach_former').val();
	
	//var lineBreak = document.getElementById('lineBreak').checked; 
	//var enabled = document.getElementById('enabled').checked; 
	
	$.ajax({
		url: '<?php echo base_url() . 'admin/athlete_con/edit_athlete'; ?>',
		type: 'POST',
		data: 'token_admin=' + token_admin
		+ '&athleteID=' + escape(athleteID)
		+ '&nameFirst=' + escape(nameFirst)
		+ '&nameLast=' + escape(nameLast)
		+ '&day=' + day
		+ '&month=' + month
		+ '&year=' + year
		+ '&gender=' + gender
		+ '&centreID=' + centreID
		+ '&clubID=' + clubID
		+ '&coach=' + escape(coach)
		+ '&coach_former=' + escape(coach_former),
		
		success: 	function(result) {
				
								$('#loading').fadeOut(500, function() {
										$(this).remove();
								});
								
								$('#showEntry').html(result);
								$('#showDelete').empty();
								$("#delButton").show(300);
								
								$("#athleteID").val(''); 
								
						}
				});
		
		return false;
		
	});


	
	});

</script>