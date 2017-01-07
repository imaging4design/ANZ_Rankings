<?php if( isset($illegal_wind) && $this->input->post( 'year' ) != 1900) { ?>

<h4>Wind Aided Performances</h4>

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
		
			$rank = 1;
			$cur_performance = NULL;
		
			foreach($illegal_wind as $row):

			/*******************************************************************************************************************************************************************************/
			// DEVELOPMENT  DEVELOPMENT  DEVELOPMENT  DEVELOPMENT  DEVELOPMENT  DEVELOPMENT  DEVELOPMENT  DEVELOPMENT

			$compare =  legal_vs_windy($row->athleteID); // Currently in the test_helper.php file

			// DEVELOPMENT  DEVELOPMENT  DEVELOPMENT  DEVELOPMENT  DEVELOPMENT  DEVELOPMENT  DEVELOPMENT  DEVELOPMENT
			/*******************************************************************************************************************************************************************************/

			// Dynamically assign a centre flag to the centreID column
			// This is powered by 'includes/regional_flags.php' (an include)
			$centre_flag = get_centre_flag( $row->centreID );

			// IS THIS A TRACK EVENT OR A FIELD EVENT? 
			// Assign $row->time or $row->distHeight to $performance ( and trim leading 0's )
			$performance = ($row->time) ? ltrim($row->time, 0) : ltrim($row->distHeight, 0);

			//Indoor / outdoor performance
			$in_out = ($row->in_out == 'in') ? $in_out = '<span class="textRed">(i)</span>' : $in_out = '';

			
			// Display editable link (on performance column)
			if($this->session->userdata('is_logged_in')) 
			{
				$performance = anchor('admin/results_con/populate_results/' . $row->resultID, $performance);
			}
			

			// This adds a highlight class to those rankings less than a week old!
			$dateClass = fresh_results($row->date); // from global_helper.php

			// When displaying 'Rank' number - show = sign if performances are the same!
			$rank_style = ( $cur_performance === $performance ) ? '' : $rank;

			// Only display athlete (WINDY) performances if they are superior to their LEGAL performances!
			if( $row->time < ltrim( $compare->legal_time, 0 ) or $row->distHeight > ltrim( $compare->legal_distHeight, 0 ) ) {

				echo '<tr>
						<td>' . $rank_style . '</td>
						<td><span class="'.$dateClass.'">' . $performance . '</span> ' . $row->record . ' ' . $in_out . '</td>
						<td>' . $row->wind . '</td>
						<td>&nbsp;</td>
						<td>' . anchor('site/profiles_con/athlete/' . $row->athleteID, $row->nameFirst.' '.strtoupper($row->nameLast)) . '</td>
						<td>' . $centre_flag . ' ' . $row->centreID . '</td>
						<td>' . $row->DOB . '</td>
						<td>' . $row->placing . '</td>
						<td>' . $row->competition . '</td>
						<td>' . $row->venue . '</td>
						<td>' . $row->date . '</td>
					</tr>';

				$rank++;
				$cur_performance = $performance;

			}

			endforeach;

		?>

	</tbody>
</table>

<?php } ?>