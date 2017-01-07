<div class="col-sm-12 category search-head">

	<?php
		echo form_open('site/compare_con/compare_athlete_data');
		echo form_hidden('token', $token);
	?>

		<fieldset>

			<div class="row hidden">

				<div class="col-md-5 col-md-offset-1 col-sm-6">

					<label class="radio-inline static-one">ATHLETE ONE</label>
					<input type="text" name="athlete[0]" id="athleteID" value="<?php echo $this->session->userdata('athlete[0]'); ?>" class="form-control" placeholder="Athlete Last Name" />

				</div><!-- END col -->


				<div class="col-md-5 col-sm-6">

					<label class="radio-inline static-three">ATHLETE TWO</label>
					<input type="text" name="athlete[1]" id="athleteID2" value="<?php echo $this->session->userdata('athlete[1]'); ?>" class="form-control ui-autocomplete-input" placeholder="Athlete Last Name" />

				</div><!-- END col -->

			</div><!-- ENDS row -->


			<div class="row hidden">
				<div class="col-md-5 col-md-offset-1 col-sm-6 mar_bot20">

					<?php 
						// See global_helper
						// Pass in events $this->config->item($value))
						echo buildEventsDropdown('rankings_dropdown'); 

						//echo buildAgeGroup_topLists( set_value('ageGroup') );
					?>

				</div>

				<div class="col-md-5 col-sm-6 mar_bot20">

					<input type="submit" class="btn btn-block btn-red" value="COMPARE NOW">

				</div><!-- END col -->
				
			</div>
			

		</fieldset>

	<?php echo form_close(); ?>

</div><!-- ENDS col -->


<script type="text/javascript">

	$(document).ready(function(){
		$('#athleteID').focus(function(){
			$(this).val(''); // Clear values on focus
		});

		$('#athleteID2').focus(function(){
			$(this).val(''); // Clear values on focus
		});
	});

</script>



