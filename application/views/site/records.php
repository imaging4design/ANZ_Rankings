<div class="blackBand">

	<div class="container">

		<div class="row">

			<div id="top_records"></div><!-- TARGET - this is where the page will auto scroll to after form is submited -->

			<div class="span12">
				<div class="slab reversed textLarge">New Zealand</div><div class="slab textLarge blue">Records</div>
	  			<div style="clear:both;"></div>

				<legend>Search Records</legend>
			</div>

		<?php

			// Open form
			echo form_open('site/records_con/get_records');

			// Adds hidden CSRF unique token
			// This will be verified in the controller against
			// the $this->session->userdata('token') before
			// returning any results data
			echo form_hidden('token', $token);

			echo '<div class="span3">';
				// Drop down menu - List of record types
				// See global helper
				echo '<label>Record Type</label>';
				echo recordType(set_value('recordType', 'NN'));
			echo '</div>';

			echo '<div class="span3">';
				// Drop down menu - Indoors / Outdoors
				echo '<label>Indoors/Outdoors</label>';
				echo in_out(set_value('in_out'));
			echo '</div>';

			echo '<div class="span3">';
				// Drop down menu - List of age groups
				// See global helper
				echo '<label>Age Group</label>';
				echo buildAgeGroup_records(set_value('ageGroup', 'MS'));
			echo '</div>';

			echo '<div class="span3">';
				// Submit button
				echo '<label>&nbsp;</label>';
				echo form_submit('submit', 'View Records', 'id="submit" class="btn"');
			echo '</div>';

			echo '<div class="clearfix"></div>';

			echo form_close();

		?>

		
	</div><!--END row-->

	  </div>
  </div>


  <div class="container">

		<?php
			// IF ADMIN IS LOGGED IN -> ALLOW ADMIN TO SELECT A RESULT TO EDIT
			$admin = FALSE;

			if($this->session->userdata('is_logged_in'))
			{
				$admin = TRUE;
			}
		?>

	



	<div class="row">
		<div class="span12">

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
			<div class="slab reversed textMed"><?php echo $recordType; ?></div><div class="slab textMed blue"><?php echo $ageGroup . ' (' . $in_out . ')'; ?></div>

			<br>

		  
			<table class="footable">
				<thead>
					<tr>
						<th data-class="expand">Event</th>
						<th>Result</th>
						<th>Athlete</th>
						<th data-hide="phone,tablet">Centre / Country</th>
						<th data-hide="phone">Venue</th>
						<th data-hide="phone">Date</th>
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
									<td>'. $row->recordID . ' ' . $row->eventName.' <span class="muted">' . $implement . '</span></td>
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

			<div class="center"><a href="" class="to_top textSmall" id="bottom_records">Back To Top</a></div>

		</div><!--END span12-->
	</div><!--END row-->
</div><!--END container-->

<script>
	
	// This (on click of #to_top link) scolls to the top of search criteria form
	$(document).ready(function (){
		$("#bottom_records").click(function (e){
			e.preventDefault();
			$('html, body').animate({
				scrollTop: $("#top_records").offset().top
			}, 500);
		});
	});

</script>