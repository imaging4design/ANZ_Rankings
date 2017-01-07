<div class="col-sm-8 category">

	<?php echo form_open('site/profiles_con/search_proxy', array('class' => 'form-search')); ?>

		<fieldset>

			<legend>SEARCH PROFILES</legend>

			<div class="row">

				<div class="col-sm-6">

					<!-- <label class="radio-inline static">ATHLETES</label> -->
					
						<input type="text" name="athleteID" id="athleteID" class="form-control" placeholder="Athlete Last Name" />
						<!-- <span class="input-group-btn">
							<button type="submit" class="btn btn-default" type="button">Search</button>
						</span> -->

						<br>

						<input type="submit" class="btn btn-block btn-green" value="Search">
					

					<input type="hidden" name="auto_complete" value="auto_complete" />

						<?php
							if( $this->session->flashdata( 'bad_search' ) )
							{
								echo '<div class="horz_line"></div>';
								echo '<div class="alert alert-block"><button type="button" class="close" data-dismiss="alert">&times;</button>' . $this->session->flashdata( 'bad_search' ) . '</div>';
								echo '<div class="horz_line"></div>';
							}
						?>

					<br>

				</div><!-- ENDS col -->

				<div class="col-sm-6">
					<p class="opacity-box">
						Athletes who have performances registered in the rankings database from 2008 onwards will have individual profiles showing their Best Performances (PB's), Annual Progressions, NZ Championship Medals won and NZ Representative Honours.
					</p>
				</div><!-- ENDS col -->

			</div><!-- ENDS row -->
			
		</fieldset>

	<?php echo form_close(); ?>

</div><!-- ENDS col -->



