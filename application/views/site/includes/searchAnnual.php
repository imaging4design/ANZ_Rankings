<div class="col-sm-8 category">

	<?php echo form_open('site/results_con'); 

		echo form_hidden('searchType', 'annual'); // Track searchType to make the search form tabs 'sticky'!

		echo form_hidden('token', $token);

	?>

	<fieldset>
		<!-- <legend>ANNUAL LISTS</legend> -->

		<div class="row">
			<div class="col-sm-6 mar_bot20">
				<?php 
					// See global_helper
					// Pass in events $this->config->item($value))
					echo buildEventsDropdown('rankings_dropdown'); 
				?>
			</div><!-- ENDS col -->

			<div class="col-sm-6">
				<?php echo ranking_years(); ?>
			</div><!-- ENDS col -->
		</div><!-- ENDS row -->

		<br>

		<div class="row">

			<div class="col-sm-6">

				<div class="row no-gutter">

					<div class="col-xs-6">

						<!-- AGE GROUPS MEN -->
						<label class="radio-inline static-one">MEN</label>

						<?php
							$options_men = array(
								'MS'	=> 'Open',
								'M19' 	=> 'U20/Junior',
								'M17' 	=> 'U18/Youth'
							);

							foreach($options_men as $agekey => $value)	{

								$default = ( ! $this->input->post( 'ageGroup' ) ) ? 'MS' : $this->input->post( 'ageGroup' );
								$checked = ( $default == $agekey ) ? ' checked="checked" ' : '';

								echo '<label class="radio-inline">';
									echo '<input type="radio" class="catRadio" name="ageGroup" value="'. $agekey .'" ' . $checked . '> '. $value .' ';
									echo '<i class="fa fa-check fa-symbol"></i>';
								echo '</label>';

							}

						?>

					</div><!-- ENDS col -->

					<div class="col-xs-6">

						<!-- AGE GROUPS WOMEN -->
						<label class="radio-inline static-one">WOMEN</label>

						<?php
							$options_women = array(
								'WS'  	=> 'Open',
								'W19' 	=> 'U20/Junior',
								'W17' 	=> 'U18/Youth'
							);

							foreach($options_women as $agekey => $value)	{

								echo '<label class="radio-inline">';
									echo '<input type="radio" class="catRadio" name="ageGroup" value="'. $agekey .'" '. set_radio('ageGroup', "$agekey", $check) . '>	'. $value .' ';
									echo '<i class="fa fa-check fa-symbol"></i>';
								echo '</label>';

							}

						?>

					</div><!-- ENDS col -->

				</div><!-- ENDS row -->

			</div><!-- ENDS col -->

			

			<div class="col-sm-6">

				<div class="row no-gutter">

					<div class="col-xs-6">

						<!-- LIST DEPTH -->
						<label class="radio-inline static-one">LIST DEPTH</label>

						<?php
							$options_depth = array(
								'10'  	=> 'Top 10',
								'50' 	=> 'Top 50',
								'250' 	=> 'Full List'
							);

							foreach($options_depth as $key => $value)	{

								$default = ( ! $this->input->post( 'list_depth' ) ) ? '50' : $this->input->post( 'list_depth' );
								$checked = ( $default == $key ) ? ' checked="checked" ' : '';

								echo '<label class="radio-inline">';
									echo '<input type="radio" class="catRadio" name="list_depth" value="'. $key .'" ' . $checked . '> '. $value .' ';
									echo '<i class="fa fa-check fa-symbol"></i>';
								echo '</label>';

							}

						?>

					</div><!-- ENDS col -->

					<div class="col-xs-6">

						<!-- LIST TYPE -->
						<label class="radio-inline static-one">LIST BY</label>

						<?php
							$options_type = array(
								'0'  	=> 'Athlete',
								'1' 	=> 'Performances'
							);

							foreach($options_type as $key => $value)	{

								$default = ( ! $this->input->post( 'list_type' ) ) ? '0' : $this->input->post( 'list_type' );
								$checked = ( $default == $key ) ? ' checked="checked" ' : '';

								echo '<label class="radio-inline">';
									echo '<input type="radio" class="catRadio" name="list_type" value="'. $key .'" ' . $checked . '> '. $value .' ';
									echo '<i class="fa fa-check fa-symbol"></i>';
								echo '</label>';

							}


						?>


					</div><!-- ENDS col -->

				</div><!-- ENDS row -->

			</div><!-- ENDS col -->

		</div><!-- ENDS row -->

		<br>

		<div class="row">
			<div class="col-sm-6">
				<input type="submit" id="submit" class="btn btn-block btn-blue" value="Show Annual List">
			</div><!-- ENDS col -->

			<div class="col-sm-6">
				<?php
					/****************************************************************************************************************/
					// DISPLAY 'PDF' PRINT OUTPUT BUTTON
					/****************************************************************************************************************/
					// Display 'PRINT PDF' button .. only if 'event' and ageGroup have been selected
					if($this->input->post('eventID') && $this->input->post('ageGroup') && $this->input->post('searchType') == 'annual')
					{
						// Don't display PDF print button for 'Relay' events
						if(!in_array($this->input->post('eventID'), $this->config->item('relay_events')))
						{
							echo anchor('pdf/pdf_con/results_PDF','Download PDF <i class="fa fa-download" aria-hidden="true"></i>', array('class' => 'btn btn-block btn-dark hidden-xs', 'target' => '_blank'));
						}

					}
				
					// Show error message
					if( isset( $this->error_message ) )
					{
						echo $this->error_message;
					} 

				?>
			</div>
		</div><!-- ENDS col -->

	</fieldset>

	<?php echo form_close(); ?>

</div><!-- ENDS col -->
