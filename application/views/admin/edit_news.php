<div class="row">
	<div class="col-sm-12">
		
		<h1>Add News Article</h1>

		<div class="row">
			<div class="col-md-12">
				<div id="showEntry"></div><!--Load jQuery ENTRY message-->
				<div id="showDelete"></div><!--Load jQuery DELETE message-->
			</div>
		</div>


		<div class="well well-trans">

			<button id="delButton" class="btn btn-red pull-right" class="button">Delete Result</button>

			<?php echo form_open('admin/news_con/edit_news', array('class' => 'results')); ?>

				<!--Adds hidden CSRF unique token
				This will be verified in the controller against
				the $this->session->userdata('token') before
				returning any results data-->
				<input type="hidden" name="token_admin" id="token_admin" value="<?php echo $token_admin; ?>" />

				<input type="hidden" name="newsID" id="newsID" value="<?php echo $pop_news->newsID; ?>" />

				<!--What is the article type? News or Info page-->
				<div class="row">
					<div class="form-group">
						
						<div class="col-md-2">
							<div class="radio">
								<label>
								<input type="radio" name="type" id="type" value="N" <?php if($pop_news->type == 'N') { echo 'checked="checked"'; } ?> /> 
								News page
								</label>
							</div>
						</div><!--ENDS col-->

						<div class="col-md-2">
							<div class="radio">
								<label>
								<input type="radio" name="type" id="type" value="I" <?php if($pop_news->type == 'I') { echo 'checked="checked"'; } ?> /> 
								Info page
								</label>
							</div>
						</div><!--ENDS col-->

					</div>

				</div><!--ENDS row-->

				

				<div class="row">
					<div class="col-md-8">
						<div class="form-group">
							<label for="heading">Heading</label>
							<input type="text" name="heading" id="heading" class="form-control" value="<?php echo $pop_news->heading; ?>" />
						</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->



				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="bodyContent">Article:</label>
							<textarea name="bodyContent" id="bodyContent" cols="128" rows="20"><?php echo $pop_news->bodyContent; ?></textarea>
							<!--DISPLAY THE CKEDITOR-->
							<?php echo form_ckeditor(array('id'=>'bodyContent')); ?>
						</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->



				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="submit"></label>
							<input type="submit" name="submit" id="submit" class="btn btn-green" value="Update Article" />
						</div>
					</div><!--ENDS col-->
				</div><!--ENDS row-->
					

			<?php echo form_close(); ?>


		</div><!-- ENDS well well-trans -->

	</div><!--ENDS col-->
</div><!--ENDS row-->







<!--JQUERY AJAX 'ADD RESULTS' SCRIPT-->
<script type="text/javascript">

$(function() {

$('#submit').click(function() {
$('#showEntry').append('<img src="<?php echo base_url() . 'images/loading.gif' ?>" alt="Currently Loading" id="loading" />');


<!--This will force all CKEDITOR instances in the form to update their respective fields-->
	for ( instance in CKEDITOR.instances )
							CKEDITOR.instances[instance].updateElement();

	<!--UPDATES THE CKEDITOR TEXTBOX (iFrame) WHEN PASTED INTO / NEEDS THIS TO PASS ITS VALUE ASYNCHRONOUSLY-->
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
	var newsID = $('#newsID').val();
	var type = $('input:radio[name=type]:checked').val();
	var heading = $('#heading').val();
	var bodyContent = $('#bodyContent').val();
	
	//var lineBreak = document.getElementById('lineBreak').checked; 
	//var enabled = document.getElementById('enabled').checked; 
	
	$.ajax({
		url: '<?php echo base_url() . 'admin/news_con/update_news'; ?>',
		type: 'POST',
		data: 'token_admin=' + token_admin
		+ '&newsID=' + newsID
		+ '&type=' + type
		+ '&heading=' + heading
		+ '&bodyContent=' + escape(bodyContent),
		
		success: function(result) {
				
						$('#loading').fadeOut(500, function() {
								$(this).remove();
						});
						
						$('#showEntry').html(result);

						//$("#heading, #bodyContent").val('');
								
					}
			});
		
		return false;
		
	});

});

</script>



<!--JQUERY AJAX 'DELETE RESULT' SCRIPT-->
<script>

$(function() {
					 
$('#delButton').click(function(){
$('#showDelete').append('<img src="<?php echo base_url() . 'images/loading.gif' ?>" alt="Currently Loading" id="loading" />');
														 
var newsID = $('#newsID').val();
	
		$.ajax({
		url: '<?php echo base_url() . 'admin/news_con/delete_news'; ?>',
		type: 'POST',
		data: 'newsID=' + newsID,
		
		success: function(result) {

					$('#loading').fadeOut(1000, function() {
						$(this).remove();
					});
					
					$('#showDelete').html(result);
					$('#showEntry').empty();
					$("#delButton").show(300);

					$("#delButton").hide(300);

					$("#heading, #bodyContent").val(''); 
					
				}
		});
	
	});

});
</script>

