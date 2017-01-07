<div class="container compare">

	<div class="row">

		<?php 

			include('includes/menu.php'); // Include Nav menu
			include('compare_inc/searchCompare.php'); // Include Search Form
			include('compare_inc/functions.php'); // Include Conversion Functions

		?>

	</div><!--END row-->



	<?php

	/********************************************************************************************************/

	// PARSE ATHLETE 'A' DATA
	
	/********************************************************************************************************/

	if($athlete_perfs_a) {

		// DO NOT SHOW DATA IF INSUFFICIENT PERFORMANCES !!!! 
		$a_10_insufficient = ( count($athlete_perfs_a) < 10 ) ? true : false;
		$a_20_insufficient = ( count($athlete_perfs_a) < 20 ) ? true : false;

		$count_a = 1;

		// Loop through each perf adding totals
		foreach($athlete_perfs_a as $row):

			$performance = ($row->time !=null) ? $row->time : $row->distHeight; // track or field event

			if($count_a <= 10) {

				if($type == 'sprints') {
					$total_a_10 += $performance;
				}
				if($type == 'middleDistance') {
					$total_a_10 += middleDistTime($performance);
				}
				if($type == 'longDistance') {
					$total_a_10 += longDistTime($performance);
				}
				if($type == 'field') {
					$total_a_10 += $performance;
				}

			}

			if($count_a <= 20) {

				if($type == 'sprints') {
					$total_a_20 += $performance;
				}
				if($type == 'middleDistance') {
					$total_a_20 += middleDistTime($performance);
				}
				if($type == 'longDistance') {
					$total_a_20 += longDistTime($performance);
				}
				if($type == 'field') {
					$total_a_20 += $performance;
				}

			}

			$count_a++;


		endforeach;


	} // ends Athlete A





	/********************************************************************************************************/

	// PARSE ATHLETE 'B' DATA
	
	/********************************************************************************************************/

	if($athlete_perfs_b) {

		// DO NOT SHOW DATA IF INSUFFICIENT PERFORMANCES !!!! 
		$b_10_insufficient = ( count($athlete_perfs_b) < 10 ) ? true : false;
		$b_20_insufficient = ( count($athlete_perfs_b) < 20 ) ? true : false;

		$count_b = 1;

		foreach($athlete_perfs_b as $row):

			$performance = ($row->time !=null) ? $row->time : $row->distHeight; // track or field event

			if($count_b <= 10) {

				if($type == 'sprints') {
					$total_b_10 += $performance;
				}
				if($type == 'middleDistance') {
					$total_b_10 += middleDistTime($performance);
				}
				if($type == 'longDistance') {
					$total_b_10 += longDistTime($performance);
				}
				if($type == 'field') {
					$total_b_10 += $performance;
				}

			}

			if($count_b <= 20) {

				if($type == 'sprints') {
					$total_b_20 += $performance;
				}
				if($type == 'middleDistance') {
					$total_b_20 += middleDistTime($performance);
				}
				if($type == 'longDistance') {
					$total_b_20 += longDistTime($performance);
				}
				if($type == 'field') {
					$total_b_20 += $performance;
				}

			}

			$count_b++;


		endforeach;


	} // ends Athlete B



	/********************************************************************************************************/

	// Work out max no. results and use to populate the centre column vertical number rank list

	/********************************************************************************************************/

	$count_c = ( $count_a > $count_b ) ? $count_a : $count_b;

	?>


	


	<!-- Small modal -->
	<button type="button" class="btn btn-dark pull-right" data-toggle="modal" data-target=".bs-example-modal-sm"><i class="fa fa-question-circle" aria-hidden="true"></i> INFO</button>

	<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	  <div class="modal-dialog modal-sm" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="h3-one"><strong>Compare Athletes</strong></h3>
			</div>

				<p>
					The athlete comparison pages show the performance achievements of two selected athletes (in the same event), displaying:
				</p>
				<ol>
					<li>the number of ranked performances (since 2008)</li>
					<li>each athletes personal best &amp; differencial</li>
					<li>the average of each athletes 'top 10' and 'top 20' performances and differencial <em>(if one or either athlete does not have enough performances to display averages - no data will be displayed).</em></li>
					<li>New Zealand Representational Honors (since 2008)</li>
					<li>National Championship Medals (since 2008)</li>
				</ol>

				<p>
					If you observe an abnormality in the data displayed, please email the Athletics New Zealand statistician, <a href="mailto:hollings@athletic.co.nz?subject=Athlete Comparison Page: <?php echo $athlete_data_a->nameFirst . ' ' . $athlete_data_a->nameLast .' vs ' . $athlete_data_b->nameFirst . ' ' . $athlete_data_b->nameLast; ?>"><strong>Dr Stephen Hollings</strong></a> to register your observation.
				</p>
			
			<p><strong>Note:</strong><small> performance comparisions have been rounded to the nearest decimal.</small></p>

	    </div>
	  </div>
	</div>

	

	<h2 class="h2-one"><strong><?php echo $eventName->eventName; ?></strong></h2>	

	<!-- START Header tables -->
	<div class="row no-gutters">

		<div class="col-sm-5 col-xs-4" style="text-align:center;">

			<?php

			$personal_best_a = ($athlete_data_a->distHeight !=null) ? $athlete_data_a->distHeight : $athlete_data_a->time;
			$personal_best_b = ($athlete_data_b->distHeight !=null) ? $athlete_data_b->distHeight : $athlete_data_b->time;

			// Work out which athlete (name) has the higher number of performances
			$name_perf = ( count($athlete_perfs_a) > count($athlete_perfs_b) ) ? $athlete_data_a->nameLast : $athlete_data_b->nameLast;

			// Work out the difference between each athletes number of performances
			if( count($athlete_perfs_a) > count($athlete_perfs_b) ) {
				$num_perfs = count($athlete_perfs_a) - count($athlete_perfs_b);
				$class_num = 'blue';
			} else {
				$num_perfs = count($athlete_perfs_b) - count($athlete_perfs_a);
				$class_num = 'yellow';
			}

			include('compare_inc/conversions.php'); // Include Conversion Functions ...

			/********************************************************************************************************/

			// DISPLAY ATHLETE 'A' DATA
			
			/********************************************************************************************************/

			echo '<div class="box big-text athlete-a">';
				echo $athlete_data_a->nameFirst.' <br class="visible-xs"> '.$athlete_data_a->nameLast;
			echo '</div>';

			echo '<div class="box">';
				echo 'No. Rankings: <br><span class="big-text blue">' . count($athlete_perfs_a) . '</span>';
			echo '</div>';
			
			echo '<div class="box">';
				echo 'Personal Best: <br><span class="big-text blue">' . ltrim($personal_best_a, 0) . '</span>';
			echo '</div>';

			// Show Average Top 10
			if( ! $a_10_insufficient && ! $b_10_insufficient ) {
				echo '<div class="box">';
					echo 'Average <span class="hidden-xs">Top</span> 10: <br><span class="big-text blue">' . $average_a_10 . '</span>';
				echo '</div>';
			}

			// Show Average Top 20
			if( ! $a_20_insufficient && ! $b_20_insufficient ) {
				echo '<div class="box">';
					echo 'Average <span class="hidden-xs">Top</span> 20: <br><span class="big-text blue">' . $average_a_20 . '</span>';
				echo '</div>';
			}

			// Show International Representation
			if( $athlete_rep_a ) {
				echo '<div class="box representations hidden-xs">';
					echo '<div style="text-transform: uppercase;"><strong>' . $eventName->eventName . '</strong></div>';
					foreach( $athlete_rep_a as $row ):
						$event = convertEventID($row->eventID);
						echo $row->year . ' ' . $row->competition . ' - ' . show_medal( $row->position ) . '<br/>';
					endforeach;
				echo '</div>';
			} else {
				echo '<div class="box representations hidden-xs">';
				echo '<div style="text-transform: uppercase;"><strong>' . $eventName->eventName . '</strong></div>';
					echo 'n/a';
				echo '</div>';
			}

			// Show National Champs Medals
			if( $athlete_medals_a ) {
				echo '<div class="box nz-medals hidden-xs">';
					echo '<div style="text-transform: uppercase;"><strong>' . $eventName->eventName . '</strong></div>';
					foreach( $athlete_medals_a as $row ):
						echo $row->year . ' ' . $row->ageGroup . ' - ' . show_medal( $row->position ) . '<br/>';
					endforeach;
				echo '</div>';
			} else {
				echo '<div class="box nz-medals hidden-xs">';
				echo '<div style="text-transform: uppercase;"><strong>' . $eventName->eventName . '</strong></div>';
					echo 'n/a';
				echo '</div>';
			}

			?>

		</div><!--END col-->


		<div class="col-sm-2 col-xs-4" style="text-align:center;">

			<?php

			/********************************************************************************************************/

			// DISPLAY MIDDLE COLUMN DATA
			
			/********************************************************************************************************/
			
			echo '<div class="box big-text">';
				echo '<span style="font-size:24px;">vs</span>';
			echo '</div>';

			echo '<div class="box">';
				echo $name_perf . ' by:<br><span class="big-text '.$class_num.'">' . $num_perfs . '</span>';
			echo '</div>';

			echo '<div class="box">';
				echo $name_pb . ' by:<br><span class="big-text '. $class .'">' . $best_diff . '</span>';
			echo '</div>';

			if( ! $a_10_insufficient && ! $b_10_insufficient ) {
				echo '<div class="box">';
					echo $name_10 . ' by:<br><span class="big-text '.$class_10.'">' . $diff_10 . '</span>';
				echo '</div>';
			}
			if( ! $a_20_insufficient && ! $b_20_insufficient ) {
				echo '<div class="box">';
					echo $name_20 . ' by:<br><span class="big-text '.$class_20.'">' . $diff_20 . '</span>';
				echo '</div>';
			}

			echo '<div class="box representations hidden-xs">';
				echo '<strong>International Honors</strong> <br/> (from 2002)';
			echo '</div>';
			echo '<div class="box nz-medals hidden-xs">';
				echo '<strong>National Championship <br/> Medals</strong> (from 2010)';
			echo '</div>';
			?>
			
		</div><!--END col-->


		<div class="col-sm-5 col-xs-4" style="text-align:center;">

			<?php

			/********************************************************************************************************/

			// DISPLAY ATHLETE 'B' DATA
			
			/********************************************************************************************************/

			$personal_best_b = ($athlete_data_b->distHeight !=null) ? $athlete_data_b->distHeight : $athlete_data_b->time;

			echo '<div class="box big-text athlete-b">';
				echo $athlete_data_b->nameFirst.' <br class="visible-xs"> '.$athlete_data_b->nameLast;
			echo '</div>';

			echo '<div class="box">';
				echo 'No. Rankings: <br><span class="big-text yellow">' . count($athlete_perfs_b) . '</span>';
			echo '</div>';

			echo '<div class="box">';
				echo 'Personal Best: <br><span class="big-text yellow">' . ltrim($personal_best_b, 0) . '</span>';
			echo '</div>';

			// Show Average Top 10
			if( ! $a_10_insufficient && ! $b_10_insufficient ) {
				echo '<div class="box">';
					echo 'Average <span class="hidden-xs">Top</span> 10: <br><span class="big-text yellow">' . $average_b_10 . '</span>';
				echo '</div>';
			}

			// Show Average Top 20
			if( ! $a_20_insufficient && ! $b_20_insufficient ) {
				echo '<div class="box">';
					echo 'Average <span class="hidden-xs">Top</span> 20: <br><span class="big-text yellow">' . $average_b_20 . '</span>';
				echo '</div>';
			}

			// Show International Representation
			if( $athlete_rep_b ) {
				echo '<div class="box representations hidden-xs">';
					echo '<div style="text-transform: uppercase;"><strong>' . $eventName->eventName . '</strong></div>';
					foreach( $athlete_rep_b as $row ):
						$event = convertEventID($row->eventID);
						echo $row->year . ' ' . $row->competition . ' - ' . show_medal( $row->position ) . '<br/>';
					endforeach;
				echo '</div>';
			} else {
				echo '<div class="box representations hidden-xs">';
				echo '<div style="text-transform: uppercase;"><strong>' . $eventName->eventName . '</strong></div>';
					echo 'n/a';
				echo '</div>';
			}

			// Show National Champs Medals
			if( $athlete_medals_b ) {
				echo '<div class="box nz-medals hidden-xs">';
					echo '<div style="text-transform: uppercase;"><strong>' . $eventName->eventName . '</strong></div>';
					foreach( $athlete_medals_b as $row ):
						echo $row->year . ' ' . $row->ageGroup . ' - ' . show_medal( $row->position ) . '<br/>';
					endforeach;
				echo '</div>';
			} else {
				echo '<div class="box nz-medals hidden-xs">';
				echo '<div style="text-transform: uppercase;"><strong>' . $eventName->eventName . '</strong></div>';
					echo 'n/a';
				echo '</div>';
			}

			?>

		</div><!--END col-->

	</div><!--END row-->



	



	<!-- START Performances tables -->
	<div class="row no-gutters">

		<div class="col-xs-5">

			<table class="table table-striped">

				<?php

				if($athlete_perfs_a) {

					$counter_a = 1;

					foreach($athlete_perfs_a as $row):

						$performance = ($row->distHeight !=null) ? $row->distHeight : $row->time;

						echo '<tr>';
							echo '<td class="hidden-xs pull-left">';
								echo $row->venue;
							echo '</td>';
							echo '<td class="hidden-xs center">';
								echo $row->date;
							echo '</td>';
							echo '<td class="pull-right">';
								echo ltrim($performance, 0);
							echo '</td>';
						echo '</tr>';

						$counter_a++;

					endforeach;

				}

				?>

			</table>

		</div><!--END col-->

		<div class="col-xs-2" style="text-align:center;">

			<table class="table" style="text-align:center;">
			<?php

				for($i=1; $i < $count_c; $i++) {

					echo '<tr>';
						echo '<td>';
							echo $i;
						echo '</td>';
					echo '</tr>';

				}

			?>
			</table>

		</div><!--END col-->

		<div class="col-xs-5" style="text-align:left;">

			<table class="table table-striped">

				<?php

				if($athlete_perfs_b) {

					$counter_b = 1;

					foreach($athlete_perfs_b as $row):

						$performance = ($row->distHeight !=null) ? $row->distHeight : $row->time;

						echo '<tr>';
							echo '<td class="pull-left">';
								echo ltrim($performance, 0);
							echo '</td>';
							echo '<td class="hidden-xs center">';
								echo $row->date;
							echo '</td>';
							echo '<td class="hidden-xs pull-right">';
								echo $row->venue;
							echo '</td>';
						echo '</tr>';

						$counter_b++;

					endforeach;

				}

				?>

			</table>


		</div><!--END col-->

	</div><!-- END row -->


	<div class="center"><a href="#" class="btn btn-search" id="bottom_results">Back to Top &nbsp; <i class="fa fa-chevron-up" aria-hidden="true"></i></a></div>



</div><!--END container-->



<script type="text/javascript">
	
	$(document).ready(function(){

		// Maintain consistent cell heights
	    $('.row').each(function(){  
	        var highestBox = 0;

	        $(this).find('.box.big-text').each(function(){
	            if($(this).height() > highestBox){  
	                highestBox = $(this).height();  
	            }
	        })

	        $(this).find('.box.big-text').height(highestBox);
	    });

	    // Maintain consistent cell heights
	    $('.row').each(function(){  
	        var highestBox = 0;

	        $(this).find('.box.representations').each(function(){
	            if($(this).height() > highestBox){  
	                highestBox = $(this).height();  
	            }
	        })

	        $(this).find('.box.representations').height(highestBox);
	    });

	    // Maintain consistent cell heights
	    $('.row').each(function(){  
	        var highestBox = 0;

	        $(this).find('.box.nz-medals').each(function(){
	            if($(this).height() > highestBox){  
	                highestBox = $(this).height();  
	            }
	        })

	        $(this).find('.box.nz-medals').height(highestBox);
	    });

		// Maintain consistent cell heights
	    $('.row').each(function(){  
	        var highestBox = 0;

	        $(this).find('.box:not(.big-text) .box:not(.representations) .box:not(.nz-medals)').each(function(){
	            if($(this).height() > highestBox){  
	                highestBox = $(this).height();  
	            }
	        })

	        $(this).find('.box:not(.big-text) .box:not(.representations) .box:not(.nz-medals)').height(highestBox);
	    });

	    
	    // Colour every 10th row (red)
	    $('table.table-striped').each(function(){
	    	$(this).find('tr:nth-child(10n+0)').each(function(){
	    		$(this).css({
	    			'background': '#EF4130',
	    			'color': '#FFF'
	    		});
	    	});
	    });

	});

	// BACK TO TOP (of search form)
	// ************************************************************************
	$(window).load(function(){

		var winWidth = $( window ).width();
		var offSetDist = false;

		if( winWidth <= 752 ) {
			offSetDist = -45;
		} else {
			offSetDist = 0;
		}

		$("#bottom_results").on('click', function (){
			$('.search-head').velocity('scroll', { offset: offSetDist, duration: 500, easing: [ 0.17, 0.67, 0.83, 0.67 ]});
			return false;
		});


		// ON LOAD (of results) - scroll to top of list
		// ************************************************************************
		if( winWidth <= 752 ) {
			offSetDist = -45;
		} else {
			offSetDist = 0;
		}

		$('h2').delay(10).velocity('scroll', { offset: offSetDist, duration: 500, easing: [ 0.17, 0.67, 0.83, 0.67 ]});
		
	});

</script>


