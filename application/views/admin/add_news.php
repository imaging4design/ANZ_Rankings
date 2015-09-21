<div class="row">
	<div class="col-sm-12">
		
		<h1 class="title">Add News Article</h1>

		<div class="row">
			<div class="col-md-12">
				<div id="showEntry"></div><!--Load jQuery ENTRY message-->
			</div>
		</div>


		<div class="well well-trans">

			<?php echo form_open('admin/news_con/add_news', array('class' => 'results')); ?>

			<!--Adds hidden CSRF unique token
			This will be verified in the controller against
			the $this->session->userdata('token') before
			returning any results data-->
			<input type="hidden" name="token_admin" id="token_admin" value="<?php echo $token_admin; ?>" />


			<div class="row">
				<div class="form-group">
					
					<div class="col-md-2">
						<div class="radio">
							<label>
								<input type="radio" name="type" id="type" value="N" checked>
								News Page
							</label>
						</div>
					</div><!--ENDS col-->

					<div class="col-md-2">
						<div class="radio">
							<label>
								<input type="radio" name="type" id="type" value="I">
								Info Page
							</label>
						</div>
					</div><!--ENDS col-->
				</div>

			</div><!--ENDS row-->



			<div class="row">
				<div class="col-md-8">
					<div class="form-group">
						<label for="heading" style="display:block;">Heading</label>
						<input type="text" name="heading" id="heading" class="form-control" value="<?php echo set_value('heading'); ?>" />
					</div>
				</div><!--ENDS col-->
			</div><!--ENDS row-->



			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label for="bodyContent" style="display:block;">Article:</label>
						<textarea name="bodyContent" id="bodyContent" cols="128" rows="20"><?php echo set_value('bodyContent'); ?></textarea>
						<!--DISPLAY THE CKEDITOR-->
						<?php echo form_ckeditor(array('id'=>'bodyContent')); ?>
					</div>
				</div><!--ENDS col-->
			</div><!--ENDS row-->



			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label for="submit"></label>
						<input type="submit" name="submit" id="submit" class="btn btn-green" value="Save Article" />
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
$('#showEntry').append('<img src="<?php echo base_url() . 'img/loading.gif' ?>" alt="Currently Loading" id="loading" />');


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
		
		success: function(result) {
				
					$('#loading').fadeOut(500, function() {
							$(this).remove();
					});
					
					$('#showEntry').html(result);
								
				}
			});
		
		return false;
		
	});

});

</script>