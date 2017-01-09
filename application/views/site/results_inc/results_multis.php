<?php if( isset( $multis )) { ?>


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
			<th data-breakpoints="lg md sm xs">Marks</th>
		</tr>
	</thead>

	<tbody>
		  
		  
		<?php
				
			$rank=1;
			$data='';
			$cur_performance = NULL;
			
			foreach($multis as $row):
			
				// Create an array of each 'discipline' result within the Decathlon / Heptathlon
				$discipline = array($row->e01, $row->e02, $row->e03, $row->e04, $row->e05, $row->e06, $row->e07, $row->e08, $row->e09, $row->e10);

				// Dynamically assign a centre flag to the centreID column
				// This is powered by 'includes/regional_flags.php' (an include)
				$centre_flag = get_centre_flag( $row->centreID );

				// Loop through each 'discipline' result
				// Assign it to $mark
				// Display it as reduce_multiples($data)
				foreach($discipline as $mark)
				{ 
					$data .= $mark . '&nbsp; - &nbsp;'; 


				}
				
				if($this->session->userdata('is_logged_in')) // Display editable link (on performance column)
				{
					$performance = anchor('admin/multis_con/populate_results/' . $row->resultID, $row->points);
				}
				else
				{
					$performance = $row->points;
				}

				// This adds a highlight class to those rankings less than a week old!
				$dateClass = fresh_results($row->date); // from global_helper.php
				
				// When displaying 'Rank' number - show = sign if performances are the same!
				$rank_style = ( $cur_performance === $performance ) ? '' : $rank;

				echo '<tr>
						<td>' . $rank_style . '</td>
						<td><span class="'.$dateClass.'">' . $performance . '</span> ' . $row->record . '</td>
						<td>' . $row->wind . '</td>
						<td>&nbsp;</td>
						<td>' . athleteName( $row->athleteID, $row->nameFirst, $row->nameLast, $this->input->post('eventID'), $this->config->item('multi_events') ). '</td>
						<td>' . $centre_flag . ' ' . showHide( $this->input->post('year'), $row->centreID ) . '</td>
						<td>' . $row->DOB . '</td>
						<td>' . showHide( $this->input->post('year'), $row->placing ) . '</td>
						<td>' . showHide( $this->input->post('year'), $row->competition ) . '</td>
						<td>' . $row->venue . '</td>
						<td>' . $row->date . '</td>
						<td>' . reduce_multiples($data, '&nbsp; - &nbsp;', TRUE) . '</td>
					</tr>';

				
				if( $this->input->post( 'year' ) != 1900) // Only display on 'Annual Lists' - NOT 'All Time Lists'
				{
					// echo '<tr>
					// 		<td>&nbsp;</td>
					// 		<td>&nbsp;</td>
					// 		<td>&nbsp;</td>
					// 		<td>&nbsp;</td>
					// 		<td>' .reduce_multiples($data, "&nbsp; | &nbsp;", TRUE) . '</td>
					// 	</tr>';
				}

				
				$rank++;
				$data = '';
				$cur_performance = $performance;

			
			endforeach;

		?>

	</tbody>
</table>

<?php } ?>