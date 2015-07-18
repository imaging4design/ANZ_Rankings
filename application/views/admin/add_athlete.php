<div class="colFull"><!--START COLLFULL-->
  
<h3>Add Athlete</h3><br />

<p id="delButton" style="display:none; margin-bottom:10px;" class="button">DELETE RECORD</p>

<div id="showDelete"></div><!--Load jQuery DELETE message-->
<div id="showEntry"></div><!--Load jQuery ENTRY message-->

<?php echo form_open('admin/athlete_con/add_athlete', array('class' => 'results')); ?>

  <!--Adds hidden CSRF unique token
	This will be verified in the controller against
	the $this->session->userdata('token') before
	returning any results data-->
  <input type="hidden" name="token_admin" id="token_admin" value="<?php echo $token_admin; ?>" />

  <label for="athleteID" style="display:inline-block;">Athlete ID</label>
  <input type="text" name="athleteID" id="athleteID" value="<?php echo set_value('athleteID'); ?>" />
  
  <div class="dotted"></div>
  
  <label for="nameFirst">First Name</label>
  <input type="text" name="nameFirst" id="nameFirst" value="<?php echo set_value('nameFirst'); ?>" size="30" />
  
  <label for="nameLast" style="margin-left:20px;">Last Name</label>
  <input type="text" name="nameLast" id="nameLast" value="<?php echo set_value('nameLast'); ?>" size="30" />
  
  <div class="dotted"></div>
  
  <?php
		// Display drop down menus for date (day, month, year)
		echo '<label for="date" style="display:inline;">Date of Birth: </label>';
		echo buildDayDropdown($name='day', $value='1', $id='id="day"'); // See global helper
		echo buildMonthDropdown($name='month', $value='', $id='id="month"'); // See global helper
		echo buildYearDOB($name='year', $value='', $id='id="year"'); // See global helper
	?>
  
  <label for="gender" style="margin-left:20px;">Gender</label>
  <?php
	$options = array(
						'M'  => 'Male',
						'F'  => 'Female'
            );

	echo form_dropdown('gender', $options, set_value('M', 'gender'), 'id="gender"');
	?>
  
  <div class="dotted"></div>
  
  <?php
		// Display full list of 'centres' drop down menu
		echo '<label for="centreID">Centre: </label>';
		echo dropDownCentres(); // See global helper
		
		// Display full list of 'clubs' drop down menu
		echo '<label for="clubID" style="margin-left:20px;">Club: </label>';
		echo dropDownClubs(); // See global helper
  ?>  
  
  <div class="dotted"></div>
  
  <label for="coach" style="float:left;">Coach:</label>
  <input type="text" name="coach" id="coach" value="<?php echo set_value('coach'); ?>" size="30" />
  
  <label for="coach_former" style="margin-left:10px;">Former Coaches:</label>
  <input type="text" name="coach_former" id="coach_former" value="<?php echo set_value('coach_former'); ?>" size="80" />
  
  <div class="dotted"></div>
  
	<label for="submit"></label>
	<input type="submit" name="submit" id="submit" value="Add Athlete" />
  



<?php echo form_close(); ?>

</div><!--END COLLFULL-->


<!--JQUERY AJAX 'DELETE RESULT' SCRIPT-->
<script>

$(function() {
					 
$('#delButton').click(function(){
$('#showDelete').append('<img src="<?php echo base_url() . 'images/loading.gif' ?>" alt="Currently Loading" id="loading" />');
														 
	var athleteID = $("em").attr("title");
	
		$.ajax({
		url: '<?php echo base_url() . 'admin/athlete_con/delete_athlete'; ?>',
		type: 'POST',
		data: 'athleteID=' + athleteID,
		
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
		url: '<?php echo base_url() . 'admin/athlete_con/add_athlete'; ?>',
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
								
								$("#athleteID, #nameFirst, #nameLast, #gender, #coach, #coach_former").val(''); 
								
						}
				});
		
		return false;
		
	});


	
	});

</script>