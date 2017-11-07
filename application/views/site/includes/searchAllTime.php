<div class="col-sm-8 category">

	<?php echo form_open('site/results_con'); 

		echo form_hidden('searchType', 'allTime'); // Track searchType to make the search form tabs 'sticky'!

		echo form_hidden('token', $token);

		echo '<input type="hidden" name="year" value="1900">';
		echo '<input type="hidden" name="list_depth" value="50">';
		echo '<input type="hidden" name="list_type" value="0">';

	?>

	<fieldset>
		
		<legend>ALL TIME LISTS</legend>

		<div class="row">

			<div class="col-sm-6 mar_bot20">

				<?php 
					// See global_helper
					// Pass in events $this->config->item($value))
					echo buildEventsDropdown('alltime_dropdown'); 
				?>

				<div class="row no-gutter" style="margin-top:35px;">

					<div class="col-xs-6">

						<!-- AGE GROUPS MEN -->
						<label class="radio-inline static-three">MEN</label>

						<?php
							$options_men = array(
								'MS'	=> 'Open',
								// 'M19' 	=> 'U20/Junior',
								// 'M17' 	=> 'U18/Youth'
							);

							foreach($options_men as $agekey => $value)	{

								$default = ( ! $this->input->post( 'ageGroup' ) ) ? 'MS' : $this->input->post( 'ageGroup' );
								$checked = ( $default == $agekey ) ? ' checked="checked" ' : '';

								echo '<label class="radio-inline">';
									//echo '<input type="radio" class="catRadio" name="ageGroup" value="'. $key .'" '. set_radio('ageGroup', "$agekey", $check) . '> '. $value .' ';
									echo '<input type="radio" class="catRadio" name="ageGroup" value="'. $agekey .'" ' . $checked . '> '. $value .' ';
									echo '<i class="fa fa-check fa-symbol"></i>';
								echo '</label>';

							}

						?>

					</div><!-- ENDS col -->

					<div class="col-xs-6">

						<!-- AGE GROUPS WOMEN -->
						<label class="radio-inline static-three">WOMEN</label>

						<?php
							$options_women = array(
								'WS'  	=> 'Open',
								// 'W19' 	=> 'U20/Junior',
								// 'W17' 	=> 'U18/Youth'
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

				<br>

				<input type="submit" class="btn btn-block btn-red" value="Show All-Time List">

			</div><!-- ENDS col -->

			<div class="col-sm-6">

				<p class="opacity-box">
					<em>The All-Time lists have been constructed by taking the top 20 known and verifiable performances in each event prior to 2008. Since then, performances have been added where they are superior to the 20th best performance.</em>
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