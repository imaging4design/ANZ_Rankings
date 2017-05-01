<div class="row">
	<div class="col-md-12">

		<h1 class="title">Rankings Statistics</h1>

		<div class="well well-trans">

			<?php 

			echo form_open('admin/results_con/statistics', array('class' => 'stats-form')); 

				echo '<div class="row">';

					echo '<div class="col-sm-4">';
						echo buildYearDropdownPast('year');
						echo '<input type="submit" name="submit" id="submit" class="btn btn-green" value="Show Stats" />';
					echo '</div>';

				echo '</div>';

			echo form_close();

			?>


		
			<?php

				// echo '<pre>';
				// print_r($statistics);
				// echo '</pre>';

				if(isset($statistics)) {

					$getWidth = null;

					// Work out the hightest volume of reseult (i.e., in which month)
					foreach($statistics as $month):

						if($getWidth < $month[1]) {
							$getWidth = $month[1];
							$getMonth = substr($month[0], 0, 3);
							$getYear = substr($month[0], 3, 7);
						}

						$total += $month[1];

					endforeach;


					// Display month high
					echo '<h4>Total for ' . $getYear .': <strong>(' . $total . ')</strong></h4>';

					// Display month high
					echo '<h4>Highest Month: <strong>' . $getMonth .' (' . $getWidth . ')</strong></h4>';

					foreach($statistics as $month):

						// Convert $width as a percentage
						$width = round($month[1] / $getWidth * 100, 2);

						// Work out the colour codes for the graph
						if($width <= 25) {
							$code = '#ef4130';
						} elseif($width >25 and $width <=50) {
							$code = '#FF9900';
						} elseif($width >50 and $width <=75) {
							$code = 'rgba(0, 149, 218, 1)';
						} else {
							$code = '#33C4B3';
						}

						// Display data
						echo $month[0] . ' <strong> - ' . $month[1] . '</strong> <small>'.$width.'%</small>';

						// Display graph
						echo '<div style="width:'.$width.'%; background: '.$code.'; margin-bottom:3px;">';
							echo '&nbsp;';
						echo '</div>';

					endforeach;
								
				}

			?>

		</div>

	</div><!--ENDS col-->
</div><!--ENDS row-->

<script>

	$(document).ready(function(){

		var selectYear = $('select[name="year"]');

		selectYear.addClass('form-control');

		selectYear.change(function() {
		    this.form.submit();
		});

		//$('form.stats-form').submit().die();

		

	});

</script>
