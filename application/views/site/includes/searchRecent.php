<div class="col-sm-8 category">

	<?php
		echo form_open('site/home_con/most_recent', array( 'class' => 'form-search' ));

		echo form_hidden('searchType', 'recent'); // Track searchType to make the search form tabs 'sticky'!
		echo form_hidden('token', $token);
	?>

		<fieldset>

			<legend>RECENT RESULTS</legend>

			<div class="row">

				<div class="col-sm-6 mar_bot20">

					<label class="radio-inline static-two">NEW PERFORMANCES ADDED</label>

					<div class="row no-gutter">

						<div class="col-xs-6">

							<?php
								// Recent Performances - day options
								$options = array(
									'3'  => 'Past 3 Days',
									'7' => 'Past 7 Days',
									'14' => 'Past 14 Days'
								);

								foreach($options as $key => $value)
								{
									echo '<label class="radio-inline">';

										$default = ( ! $this->input->post( 'time_frame' ) ) ? '7' : $this->input->post( 'time_frame' );
										$checked = ( $default == $key ) ? ' checked="checked" ' : '';

										echo '<input type="radio" class="catRadio" name="time_frame" value="'. $key .'" ' . $checked . '> '. $value .' ';
										echo '<i class="fa fa-check fa-symbol"></i>';

									echo '</label>';
								}

							?>

						</div><!-- END col -->
						
						<div class="col-xs-6">

							<?php

								// Gender options men
								echo '<label class="radio-inline">';
									$checkGender = ( $this->input->post( 'gender') === 'men' or ! $this->input->post( 'gender') ) ? 'checked' : ''; 
									echo '<input type="radio" class="catRadio" name="gender" value="men" ' . $checkGender . '> &nbsp; Men ';
									echo '<i class="fa fa-check fa-symbol"></i>';
								echo '</label>';

								// Gender options women
								echo '<label class="radio-inline">';
									$checkGender = ( $this->input->post( 'gender' ) === 'women' ) ? 'checked' : ''; 
									echo '<input type="radio" class="catRadio" name="gender" value="women" ' . $checkGender . '>&nbsp;  Women ';
									echo '<i class="fa fa-check fa-symbol"></i>';
								echo '</label>';

							?>

						</div><!-- END col -->

					</div><!-- ENDS row -->

					<br>

					<input type="submit" class="btn btn-block btn-yellow" value="Show Recent Results">

				</div><!-- END col -->


				<div class="col-sm-6">

					<p class="opacity-box">
						Recent Results display the latest performances by men and women over a specified number of days. Performances are grouped by event and are in descending order of result achieved.
					</p>

					<?php

						// Show error message
						if( isset( $this->error_message ) )
						{
							echo $this->error_message;
						} 

					?>
					
				</div> <!-- ENDS col --> 

			</div><!-- ENDS row -->
			

		</fieldset>

	<?php echo form_close(); ?>

</div><!-- ENDS col -->



