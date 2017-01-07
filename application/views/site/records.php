<div class="container container-class search-form" id="record-form" style="padding-bottom: 30px;">

	<div class="row">

		<?php include('includes/menu.php'); ?>

		<div id="top_records"></div><!-- TARGET - this is where the page will auto scroll to after form is submited -->

		<div class="col-sm-12 category annual">

			<fieldset>

				<legend>SEARCH RECORDS</legend>
		
				<?php

					// Open form
					echo form_open('site/records_con/get_records');

					// Adds hidden CSRF unique token
					// This will be verified in the controller against
					// the $this->session->userdata('token') before
					// returning any results data
					echo form_hidden('token', $token);

				?>

				<div class="row">

					<div class="col-sm-3 lead-head mar_bot20">
						<!-- <label>Record Type</label> -->
						<?php echo recordType(set_value('recordType', 'NN')); // See global helper ?>
					</div>

					<div class="col-sm-3 lead-head mar_bot20">
						<!-- <label>Indoors/Outdoors</label> -->
						<?php echo in_out(set_value('in_out')); ?>
					</div>

					<div class="col-sm-3 lead-head mar_bot20">						
						<!-- <label>Age Group</label> -->
						<?php echo buildAgeGroup_records(set_value('ageGroup', 'MS')); // See global helper ?>
					</div>

					<div class="col-sm-3 lead-head mar_bot20">
						<!-- <label>&nbsp;</label> -->
						<?php echo form_submit('submit', 'View Records', 'id="submit" class="btn btn-block btn-blue"'); ?>
					</div>

				</div><!-- ENDS row -->


				<?php echo form_close(); ?>

			</fieldset>

		</div><!-- ENDS col -->

	</div><!--END row-->

</div><!-- ENDS container -->


<div class="container container-class" style="padding-top: 20px;">

		<?php
			// IF ADMIN IS LOGGED IN -> ALLOW ADMIN TO SELECT A RESULT TO EDIT
			$admin = FALSE;

			if($this->session->userdata('is_logged_in'))
			{
				$admin = TRUE;
			}
		?>

	



	<div class="row">

		<div class="col-sm-12">

			<?php
				// Display the (Human readable) record type label
				switch ( $this->input->post('recordType') ) {

					case 'NN':
						$recordType = 'NZ National';
					break;

					case 'AC':
						$recordType = 'NZ Allcomers';
					break;

					case 'RR':
						$recordType = 'NZ Resident';
					break;

					default:
						$recordType = 'NZ National';
					break;
				}


				// Display the correct (Human readable) ageGroup label
				switch ( $this->input->post('ageGroup') ) {

					case 'MS':
						$ageGroup = 'Open Men';
					break;

					case 'M19':
						$ageGroup = 'Men Under 20';
					break;

					case 'M18':
						$ageGroup = 'Men Under 19';
					break;

					case 'M17':
						$ageGroup = 'Men Under 18';
					break;

					case 'M16':
						$ageGroup = 'Men Under 17';
					break;

					case 'WS':
						$ageGroup = 'Open Women';
					break;

					case 'W19':
						$ageGroup = 'Women Under 20';
					break;

					case 'W18':
						$ageGroup = 'Women Under 19';
					break;

					case 'W17':
						$ageGroup = 'Women Under 18';
					break;

					case 'W16':
						$ageGroup = 'Women Under 17';
					break;

					default:
						$ageGroup = 'Men Open';
					break;
				}


				// Display the (Human readable) Indoor/Outdoor label
				switch ( $this->input->post('in_out') ) {

					case 'out':
						$in_out = 'Outdoors';
					break;

					case 'in':
						$in_out = 'Indoors';
					break;

					default:
						$in_out = 'Outdoors';
					break;
				}

			?>

			<!-- START Label of Record Type and AgeGroup -->
			<h2 class="h2-one"><strong>New Zealand</strong> Records</h2>
			<h3><?php echo $recordType; ?> <?php echo $ageGroup . ' <small>(' . $in_out . ')</small>'; ?></h3>

			<br>

		  
			<table class="table table-striped" data-toggle-column="last">
				<thead>
					<tr>
						<th>Event</th>
						<th data-type="html">Result</th>
						<th>Athlete</th>
						<th data-breakpoints="sm xs">Centre / Country</th>
						<th data-breakpoints="xs">Venue</th>
						<th data-breakpoints="xs">Date</th>
					</tr>
				</thead>

				<tbody>

					<?php

						if(isset($this->error_message))
						{
							echo $this->error_message;
						}

						if(isset($get_records))
						{
							foreach($get_records as $row):

							if($admin)
							{
								// Append 'in' or 'out' to end of URL so this can be accessed in teh controller 
								if( $in_out == 'Outdoors' ) {
									$result = anchor('admin/records_con/populate_records/' . $row->recordID . '/out', $row->result);
								} else {
									$result = anchor('admin/records_con/populate_records/' . $row->recordID . '/in', $row->result);
								}
								
							}
							else
							{
								$result = $row->result;
							}

							// Display implement details if exist
							$implement = ( $row->implement ) ? ' <span class="textGrey">('. ltrim($row->implement, 0) . ')</span>' : '';

							// This adds a highlight class to those rankings less than a week old!
							$dateClass = fresh_records($row->date); // from global_helper.php

							echo '<tr>
									<td>'. $row->eventName.' <span class="muted">' . $implement . '</span></td>
									<td><span class="'.$dateClass.'">'. $result .'</span></td>
									<td>'. $row->nameFirst . ' ' . strtoupper($row->nameLast) . '</td>
									<td>'. strtoupper($row->country) .'</td>
									<td>'. strtoupper($row->venue) .'</td>
									<td>'. $row->date .'</td>
								</tr>';

							endforeach;
						}

					?>

				</tbody>

			</table>

			<div class="center"><a href="" class="btn btn-search" id="bottom_records">New Search &nbsp; <i class="fa fa-chevron-up" aria-hidden="true"></i></a></div>

		</div><!--END col-sm-12-->
	
	</div><!--END row-->


</div><!--END container-->





<?php if( $this->input->post('token') ) { ?>

	<script>

		// ON LOAD (of results) - scroll to top of list
		// ************************************************************************
		$(window).load(function() {

			var winWidth = $( window ).width();
			var offSetDist = false;

			if( winWidth <= 752 ) {
				offSetDist = -50;
			} else {
				offSetDist = 0;
			}

			var resultsLoaded = $('h2').delay(10).velocity('scroll', { offset: offSetDist, duration: 500, easing: [ 0.17, 0.67, 0.83, 0.67 ]});
			
		});

	</script>	

<?php } ?>



<script>
	
	// BACK TO TOP (of search form)
	// ************************************************************************
	$(document).ready(function(){

		var winWidth = $( window ).width();
		var offSetDist = false;

		if( winWidth <= 752 ) {
			offSetDist = -45;
		} else {
			offSetDist = 0;
		}

		$("#bottom_records").on('click', function (){
			$('#record-form').velocity('scroll', { offset: offSetDist, duration: 500, easing: [ 0.17, 0.67, 0.83, 0.67 ]});
			return false;
		});

	});

</script>