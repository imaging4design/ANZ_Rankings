<div class="row">
	<div class="col-md-12">

		<h1>Admin <small>(Please login to proceed)</small></h1>

		<div class="well well-trans">

			<?php 
			//Display success/error message
			if(isset($message))
			{
				echo $message;
			}

			echo form_open('admin/login_con/validate_credentials', array('style' => 'margin-bottom:30px;')); 

			?>

			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					
					<div class="form-group-lg">
						<label for"username_anz"><strong>Username:</strong></label>
						<input type="text" name="username_anz" id="username_anz" class="form-control" value="<?php echo set_value('username_anz'); ?>" />
					</div>

					<div class="form-group-lg">
						<label for"password_anz"><strong>Password:</strong></label>
						<input type="password" name="password_anz" id="password_anz" class="form-control" value="<?php echo set_value('password_anz'); ?>"/>
					</div>

				
				</div><!--ENDS col-->
			</div><!--ENDS row-->

			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<div class="form-group-lg">
						<label for="submit"></label>
						<input type="submit" name="submit" id="submit" class="btn btn-lg btn-red" value="Login" />
					</div>
				</div><!--ENDS col-->
			</div><!--ENDS row-->


			
			  
			<?php

				//Display failed login attempt mesage ...
				if( $this->session->userdata('login_attempt') == 'fail')
				{
					echo '<span class="message_error" style="display:inline-block;">Login Failed!</span>';
				}
			?>

			<?php

			echo form_close(); 

			?>

		</div><!-- ENDS well well-trans -->

	</div><!--ENDS col-->
</div><!--ENDS row-->