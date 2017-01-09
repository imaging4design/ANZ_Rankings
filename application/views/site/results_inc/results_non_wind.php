<?php if( isset( $results )) { ?>

<table class="table table-striped" data-toggle-column="last">

	<thead>
		<tr>
			<th>Rank</th>
			<th data-type="html">Result</th>
			<th data-breakpoints="xs">Wind</th>
			<th data-type="html">&nbsp;</th>
			<th data-type="html">Name</th>
			<th data-breakpoints="sm xs" data-type="html">Centre</th>
			<th data-breakpoints="sm xs">DOB</th>
			<th data-breakpoints="sm xs">Place</th>
			<th data-breakpoints="sm xs">Competition</th>
			<th data-breakpoints="xs">Venue</th>
			<th data-breakpoints="xs">Date</th>
		</tr>
	</thead>

	<tbody>



		<?php

		echo $admin;
			/*
			|-----------------------------------------------------------------------------------------------------------------
			| IF NO RESULTS FOUND FROM USER SELECTION -> display (No Results Found)
			|-----------------------------------------------------------------------------------------------------------------
			*/
			// if( ! isset($results) && ! isset($legal_wind) && ! isset($illegal_wind) && ! isset($multis) && ! isset($relays) && ! isset($this->error_message))
			// {
			// 	echo '<div class="slab textMed">No Results Found</div>';
			// }
		?>



		<?php

			$rank = 1;
			$cur_performance = NULL;
			
			foreach($results as $row):

				// Dynamically assign a centre flag to the centreID column
				// See global_helper.php
				$centre_flag = get_centre_flag( $row->centreID );
				
				// IS THIS A TRACK EVENT OR A FIELD EVENT? 
				// Assign $row->time or $row->distHeight to $performance ( and trim leading 0's )
				$performance = ($row->time) ? ltrim($row->time, 0) : ltrim($row->distHeight, 0);

				// For 'All Time Lists' ....
				// If 'hand timed' (i.e., $row->record == 'h') - remove last '0'
				$performance = ( $row->record == 'h' || $row->record == 'y' ) ? substr_replace($performance , '',-1) : $performance;
				
				//Indoor / outdoor performance
				$in_out = ($row->in_out == 'in') ? $in_out = '(i)' : $in_out = '';

				
				if($this->session->userdata('is_logged_in')) // Display editable link (on performance column)
				{
					$performance = anchor('admin/results_con/populate_results/' . $row->resultID, $performance);
				}
				
				// This adds a highlight class to those rankings less than a week old!
				$dateClass = fresh_results($row->date); // from global_helper.php

				// When displaying 'Rank' number - show = sign if performances are the same!
				$rank_style = ( $cur_performance === $performance ) ? '' : $rank;

				// Hide '$row->record' on all-time lists
				$show_record = ( $this->input->post('year') == 1900 ) ? '' : $row->record;

				echo '<tr>
						<td>'. $rank_style .'</td>
						<td><span class="'.$dateClass.'">' . $performance . '</span> ' . $show_record . ' ' . $in_out . '</td>
						<td>' . $row->wind . '</td>
						<td>&nbsp;</td>
						<td>' . athleteName( $row->athleteID, $row->nameFirst, $row->nameLast, $this->input->post('eventID'), $this->config->item('multi_events') ). '</td>
						<td>' . $centre_flag . ' ' . showHide( $this->input->post('year'), $row->centreID ) . '</td>
						<td>' . $row->DOB . '</td>
						<td>' . showHide( $this->input->post('year'), $row->placing ) . '</td>
						<td>' . showHide( $this->input->post('year'), $row->competition ) . '</td>
						<td>' . $row->venue . '</td>
						<td>' . $row->date . '</td>
					</tr>';
				
				$rank++;

				$cur_performance = $performance;
			
			endforeach;
		
		?>

	</tbody>

</table>

<?php } ?>