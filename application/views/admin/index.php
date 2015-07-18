<div class="colFull"><!--START COLLEFT-->

<?php 
//Display success/error message
if(isset($message))
{
	echo $message;
}

echo form_open('admin/login_con/validate_credentials', array('style' => 'margin-bottom:30px;')); 

?>
  <label for"username_anz"><strong>Username:</strong></label>
  <input type="text" name="username_anz" id="username_anz" size="30" value="<?php echo set_value('username_anz'); ?>" />
  
  <label for"password_anz"><strong>Password:</strong></label>
  <input type="password" name="password_anz" id="password_anz" size="30" value="<?php echo set_value('password_anz'); ?>"/>
  
  <input type="submit" name="submit" id="submit" value="Login" style="display:block;" />
  
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
</div>