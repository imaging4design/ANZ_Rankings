<div class="row">
	<div class="col-md-12">


			<?php 
			//Display success/error message
			if(isset($message))
			{
				echo $message;
			}

			echo form_open('admin/login_con/validate_credentials'); 

			// ANZ Logo
			$anz_logo = array(
				'src' => base_url() . 'img/anz_logo_black.png',
				'alt' => 'Athletics New Zealand',
				'class' => 'img-responsive center-block padBot20',
				'width' => '200',
				'height' => 'auto',
			);

			?>

			<div class="row">
				<div class="col-md-6 col-md-offset-3">

					<?php echo img($anz_logo); ?>
					
					<div class="form-group-lg">
						<label for"username_anz"></label>
						<input type="text" name="username_anz" id="username_anz" class="form-control" value="<?php echo set_value('username_anz'); ?>" placeholder="Username"/>
					</div>

					<div class="form-group-lg">
						<label for"password_anz"></label>
						<input type="password" name="password_anz" id="password_anz" class="form-control" value="<?php echo set_value('password_anz'); ?>" placeholder="Password"/>
					</div>

				
				</div><!--ENDS col-->
			</div><!--ENDS row-->

			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<div class="form-group-lg">
						<label for="submit"></label>
						<input type="submit" name="submit" id="submit" class="btn btn-lg btn-red btn-block" value="Login" />

						<?php
							//Display failed login attempt mesage ...
							if( $this->session->userdata('login_attempt') == 'fail')
							{
								echo '<div class="message_error text-center padTop20">Login Failed!</div>';
							}
						?>
					</div>
				</div><!--ENDS col-->
			</div><!--ENDS row-->


			<?php echo form_close(); ?>


	</div><!--ENDS col-->
</div><!--ENDS row-->