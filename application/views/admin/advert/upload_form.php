<div class="row">
	<div class="col-sm-12">
		
		<h1 class="title">Advert Manager</h1>


		<div class="row">
			<div class="col-md-12">
				<div id="showEntry"></div><!--Load jQuery ENTRY message-->
			</div>
		</div>


		<div class="well well-trans">

			<?php echo form_open_multipart('admin/upload/do_upload', array('class' => 'results')); ?>

			<!--Adds hidden CSRF unique token
			This will be verified in the controller against
			the $this->session->userdata('token') before
			returning any results data-->
			<input type="hidden" name="token_admin" id="token_admin" value="<?php echo $token_admin; ?>" />

			<div class="row">
				<div class="col-sm-12">
					<h4><strong>Instructions</strong></h4>
					<p>Please fill out all fields below and upload the advert image to the dimensions indicated. Select an expiry date - after the expiry date is reached the advert will automatically be removed.</p>
				</div>
			</div>

			<div class="row">
				<div class="col-md-8">
					<div class="form-group">
						<label for="campaign_title">Campaign Title</label>
						<p><small>The name of the advertising campaign (this will be used as the image 'alt' text)</small></p>
						<input type="text" name="campaign_title" id="campaign_title" class="form-control" value="<?php echo set_value('campaign_title'); ?>" />
					</div>
				</div><!--ENDS col-->

				<div class="col-md-4" id="show-expired">
					<div class="form-group">
						<label for="expires">Expires on</label>
						<p><small>Select the date the campaign will display up to</small></p>
						<input type="text" name="expires" id="date" class="form-control" value="<?php echo set_value('expires'); ?>" />
					</div>
				</div><!--ENDS col-->
				
			</div><!--ENDS row-->


			<div class="row">
				<div class="col-sm-8">
					<div class="form-group">
						<label for="url_location">URL Location</label>
						<p><small>The full URL (including http:// or https://) location</small></p>
						<input type="text" name="url_location" id="url_location" class="form-control" value="<?php echo set_value('url_location'); ?>" />
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						<label for="url_location">Upload Advert Image</label>
						<p><small>Image MUST be 728 x 90 pixels (jpg, png or gif format)</small></p>
						<input type="file" class="advert_image" id="advert_image" name="advert_image" value="<?php echo set_value('advert_image'); ?>" />
					</div>
				</div>
			</div>


			<div class="row">
				<div class="col-md-12">

					<?php 
						// Error messages
						if( $error['error'] ) {
							echo $error['error']; 
						}
						if ( $missing_field_errors ) {
							echo $missing_field_errors; 
						}
					?>

					<div class="form-group">
						<label for="submit"></label>
						<input type="submit" name="submit" id="submit" class="btn btn-green" value="upload" />
					</div>

				</div><!--ENDS col-->
			</div><!--ENDS row-->
			
			<?php echo form_close(); ?>

		</div><!-- ENDS well well-trans -->

	</div><!--ENDS col-->
</div><!--ENDS row-->




<!--JQUERY AJAX 'ADD RESULTS' SCRIPT-->
<script>

// $(function() {

// $('#submit').click(function() {
// $('#showEntry').append('<img src="<?php echo base_url() . 'img/loading.gif' ?>" alt="Currently Loading" id="loading" />');
	
// 	var token_admin = $('#token_admin').val();
// 	var campaign_title = $('#campaign_title').val();
// 	var expires = $('#date').val();
// 	//var advert_image = $('.advert_image').val();
// 	var advert_image = $(input[type=file]).val();
	
// 	$.ajax({
// 		url: '<?php echo base_url() . 'admin/upload/do_upload'; ?>',
// 		type: 'POST',
// 		data: 'token_admin=' + token_admin
// 		+ '&campaign_title=' + campaign_title
// 		+ '&expires=' + expires
// 		+ '&advert_image=' + advert_image,
		
// 		success: function(result) {
				
// 					$('#loading').fadeOut(500, function() {
// 							$(this).remove();
// 					});
					
// 					$('#showEntry').html(result);
								
// 				}
// 			});
		
// 		return false;
		
// 	});

// });

</script>