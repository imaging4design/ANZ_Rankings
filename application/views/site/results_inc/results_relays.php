<?php if( isset($relays)) { ?>

<table class="table table-striped" data-toggle-column="last">
	<thead>
		<tr>
			<th>Rank</th>
			<th data-type="html">Result</th>
			<th data-breakpoints="sm xs">Rec</th>
			<th>Team</th>
			<th data-breakpoints="sm xs">Athletes</th>
			<th data-breakpoints="sm xs">Place</th>
			<th data-breakpoints="sm xs">Competition</th>
			<th data-breakpoints="xs">Venue</th>
			<th>Date</th>
		</tr>
	</thead>

	<tbody>

		<?php
			$rank=1;
			
			foreach($relays as $row):
			
				// Left trim leading 0's
				$performance = ltrim($row->time, 0);
				
				// Combine athletes (relay tema members)
				$athletes = $row->athlete01 . ', ' . $row->athlete02 . ', ' . $row->athlete03 . ', ' . $row->athlete04;
				
				if($this->session->userdata('is_logged_in')) // Display editable link (on performance column)
				{
					$performance = anchor('admin/relays_con/populate_relays/' . $row->resultID, $performance);
				}

				// This adds a highlight class to those rankings less than a week old!
				$dateClass = fresh_results($row->date); // from global_helper.php
				
				echo '<tr>
						<td>' . $rank . '</td>
						<td><span class="'.$dateClass.'">' . $performance . '</span></td>
						<td>' . $row->record . '</td>
						<td>' . $row->team . '</td>
						<td>' . $athletes . '</td>
						<td>' . $row->placing . '</td>
						<td>' . $row->competition . '</td>
						<td>' . $row->venue . '</td>
						<td>' . $row->date . '</td>
					</tr>';
				
				$rank++;
			
			endforeach;
			
		?>

	</tbody>
</table>

<?php } ?>