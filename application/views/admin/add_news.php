<div class="colFull"><!--START COLLFULL-->
  
<h3>Add News Article</h3><br />

<p id="delButton" style="display:none; margin-bottom:10px;" class="button">DELETE RECORD</p>

<div id="showDelete"></div><!--Load jQuery DELETE message-->
<div id="showEntry"></div><!--Load jQuery ENTRY message-->

<?php echo form_open('admin/news_con/add_news', array('class' => 'results')); ?>

  <!--Adds hidden CSRF unique token
	This will be verified in the controller against
	the $this->session->userdata('token') before
	returning any results data-->
  <input type="hidden" name="token_admin" id="token_admin" value="<?php echo $token_admin; ?>" />
  
  <!--What is the article type? News or Info page-->
  <label for="type" style="display:block;">Article Type:</label>
	<?php
	$news = array(
    'name'        => 'type',
    'id'          => 'type',
    'value'       => 'N',
    'checked'     => TRUE
    );
	
	$info = array(
    'name'        => 'type',
    'id'          => 'type',
    'value'       => 'I'
    );
	
	echo form_radio($news) . 'News Page';
	echo form_radio($info) . 'Info Page';
	?>

	<label for="heading" style="display:block;">Heading</label>
	<input type="text" name="heading" id="heading" value="<?php echo set_value('heading'); ?>" />
  
  <label for="bodyContent" style="display:block;">Article:</label>
  <textarea name="bodyContent" id="bodyContent" cols="128" rows="20"><?php echo set_value('bodyContent'); ?></textarea>
  <!--DISPLAY THE CKEDITOR-->
  <?php echo form_ckeditor(array('id'=>'bodyContent')); ?>
  
	<label for="submit"></label>
	<input type="submit" name="submit" id="submit" value="Add News Article" style="margin-top:10px;" />

<?php echo form_close(); ?>

</div><!--END COLLFULL-->


<!--JQUERY AJAX 'DELETE RESULT' SCRIPT-->
<script>

$(function() {
					 
$('#delButton').click(function(){
$('#showDelete').append('<img src="<?php echo base_url() . 'images/loading.gif' ?>" alt="Currently Loading" id="loading" />');
														 
	var newsID = $("em").attr("title");
	
		$.ajax({
		url: '<?php echo base_url() . 'admin/news_con/delete_news'; ?>',
		type: 'POST',
		data: 'newsID=' + newsID,
		
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


	//This will force all CKEDITOR instances in the form to update their respective fields-->
	for ( instance in CKEDITOR.instances )
							CKEDITOR.instances[instance].updateElement();

	//UPDATES THE CKEDITOR TEXTBOX (iFrame) WHEN PASTED INTO / NEEDS THIS TO PASS ITS VALUE ASYNCHRONOUSLY-->
	CKEDITOR.instances["bodyContent"].document.on('keydown', function(event)
	{
			CKEDITOR.tools.setTimeout( function()
			{ 
					$("#bodyContent").val(CKEDITOR.instances.bodyContent.getData()); 
			}, 0);
	});
	
	CKEDITOR.instances["bodyContent"].document.on('paste', function(event)
	{
			CKEDITOR.tools.setTimeout( function()
			{ 
					$("#bodyContent").val(CKEDITOR.instances.bodyContent.getData()); 
			}, 0);
	});
	
	

	var token_admin = $('#token_admin').val();
	var type = $('input:radio[name=type]:checked').val();
	var heading = $('#heading').val();
	var bodyContent = $('#bodyContent').val();
	
	//var lineBreak = document.getElementById('lineBreak').checked; 
	//var enabled = document.getElementById('enabled').checked; 
	
	$.ajax({
		url: '<?php echo base_url() . 'admin/news_con/add_news'; ?>',
		type: 'POST',
		data: 'token_admin=' + token_admin
		+ '&type=' + type
		+ '&heading=' + heading
		+ '&bodyContent=' + escape(bodyContent),
		
		success: 	function(result) {
				
								$('#loading').fadeOut(500, function() {
										$(this).remove();
								});
								
								$('#showEntry').html(result);
								$('#showDelete').empty();
								$("#delButton").show(300);
								
						}
				});
		
		return false;
		
	});


	
	});

</script>