<div class="container compare">

	<div class="row">

		<?php 

			include('includes/menu.php'); // Include Nav menu
			include('compare_inc/searchCompare.php'); // Include Search Form
			include('compare_inc/functions.php'); // Include Conversion Functions

		?>

	</div><!--END row-->



	<?php

	// if($athlete_perfs_a) {
	// 	echo '<pre>';
	// 	echo print_r($athlete_perfs_a);
	// 	echo '</pre>';
	// }

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
	<button type="button" class="btn btn-dark pull-right" data-toggle="modal" data-target=".bs-example-modal-sm">SHOW INFO <i class="fa fa-question-circle" aria-hidden="true"></i></button>

	<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	  <div class="modal-dialog modal-sm" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="h3-one"><strong>Head to Head</strong></h3>
			</div>

				<p>
					The athlete Head-to-Head pages show the performance achievements of two selected athletes (in the same event), displaying:
				</p>
				<ol>
					<li>Each athletes number of ranked performances</li>
					<li>Each athletes personal best &amp; differencial</li>
					<li>The average of each athletes 'top 10' and 'top 20' performances and differencial <em>(if one or either athlete does not have enough performances to display averages - no data will be displayed).</em></li>
					<li>Each athletes annual progressions <em>(with their age at the time of performance)</em></li>
					<li>New Zealand representational honours</li>
					<li>National Championship medals</li>
				</ol>

				<p>
					If you observe an abnormality in the data displayed, please email the Athletics New Zealand Statistician, <a href="mailto:hollings@athletic.co.nz?subject=Athlete Comparison Page: <?php echo $athlete_data_a->nameFirst . ' ' . $athlete_data_a->nameLast .' vs ' . $athlete_data_b->nameFirst . ' ' . $athlete_data_b->nameLast; ?>"><strong>Dr Stephen Hollings</strong></a> to register your observation.
				</p>
			
			<p>
				<strong>Note (1)</strong><small> All performance data displayed is from 2008 onwards.</small><br>
				<strong>Note (2)</strong><small> Performance comparisions have been rounded to the nearest decimal.</small><br>
				<strong>Note (3)</strong><small> Multi events are not currently supported with this feature.</small>
			</p>

	    </div>
	  </div>
	</div>

	

	<h2 class="h2-three"><strong><?php echo $eventName->eventName; ?></strong></h2>	

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
				$class_num = 'red';
			} else {
				$num_perfs = count($athlete_perfs_b) - count($athlete_perfs_a);
				$class_num = 'blue';
			}

			include('compare_inc/conversions.php'); // Include Conversion Functions ...

			/********************************************************************************************************/

			// DISPLAY ATHLETE 'A' DATA
			
			/********************************************************************************************************/

			// This displays the actual age of the athlete in Years/Months/Days ...
			$athlete_age = recordAge($athlete_data_a->DOB, date('Y-m-d')); // See global_helper.php
			$athlete_ageY = recordAgeY($athlete_data_a->DOB, date('Y-m-d')); // See global_helper.php

			echo '<div class="box big-text athlete-a">';
				echo '<div class="hidden-xs">' . $athlete_data_a->nameFirst.' <br class="visible-xs"> '.$athlete_data_a->nameLast. '<br><span class="ath-age">' . $athlete_age . '</span></div>';
				echo '<div class="visible-xs">' . $athlete_data_a->nameFirst.' <br class="visible-xs"> '.$athlete_data_a->nameLast. '<br><span class="ath-age">' . $athlete_ageY . '</span></div>';
			echo '</div>';

			echo '<div class="box">';
				$imp = ( $athlete_perfs_a[0]->implement ) ? ' <strong><br>(for ' . ltrim($athlete_perfs_a[0]->implement,0) . ')</strong>' : '';
				echo '<div class="hidden-xs">Number of ranked performances since 2008'. $imp .'<br><span class="big-text red">' . count($athlete_perfs_a) . '</span></div>';
				echo '<div class="visible-xs">No. Rankings'. $imp .'<br><span class="big-text red">' . count($athlete_perfs_a) . '</span></div>';
			echo '</div>';
			
			echo '<div class="box">';
				echo 'Personal Best<br><span class="big-text red">' . ltrim($personal_best_a, 0) . '</span>';
			echo '</div>';

			// Show Average Top 10
			if( ! $a_10_insufficient && ! $b_10_insufficient ) {
				echo '<div class="box">';
					echo '<div class="hidden-xs">Average of best 10 performances<br><span class="big-text red">' . $average_a_10 . '</span></div>';
					echo '<div class="visible-xs">Avg best 10<br><span class="big-text red">' . $average_a_10 . '</span></div>';
				echo '</div>';
			}

			// Show Average Top 20
			if( ! $a_20_insufficient && ! $b_20_insufficient ) {
				echo '<div class="box">';
					echo '<div class="hidden-xs">Average of best 20 performances<br><span class="big-text red">' . $average_a_20 . '</span></div>';
					echo '<div class="visible-xs">Avg best 20<br><span class="big-text red">' . $average_a_20 . '</span></div>';
				echo '</div>';
			}

			// Show Athlete Progressions
			if($athlete_progressions_a) {
				echo '<div class="box progressions hidden-xs">';
					echo '<div style="text-transform: uppercase;"><strong>' . $eventName->eventName . '</strong></div>';
					foreach( $athlete_progressions_a as $row ):
						$performance = ( $row->time ) ? $row->time : $row->distHeight;
						$implement = ( $row->implement ) ? '(' .ltrim($row->implement, 0). ')' : '';
						$highlight = ( $personal_best_a == $performance ) ? 'bold red' : '';
						$calcAge = date_diff(date_create($row->DOB), date_create($row->date));
						$age = ' - ' . $calcAge->format('%y yrs, %m months');

						echo '<div class=" '.$highlight.' "><strong>' . $row->year . '</strong> - ' . ltrim($performance, 0) . ' ' . $implement . ' ' . $age . '</div>';
					endforeach;
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
				// echo '<span style="font-size:24px;"><i class="fa fa-sliders"></i></span>';
				// echo '<input type="text" id="date" style="width:100%; text-align:center;" placeholder=" ' . date('d-M-Y') . ' ">';
				echo 'AND<span class="ath-age">' . date('d M Y') . '</span>';
			echo '</div>';

			echo '<div class="box">';
				echo '<div class="hidden-xs">' . $name_perf . ' by:<br><span class="big-text '.$class_num.'">' . $num_perfs . '</span></div>';
				echo '<div class="visible-xs">Difference:<br><span class="big-text '.$class_num.'">' . $num_perfs . '</span></div>';
			echo '</div>';

			echo '<div class="box">';
				echo '<div class="hidden-xs">' . $name_pb . ' by:<br><span class="big-text '. $class .'">' . $best_diff . '</span></div>';
				echo '<div class="visible-xs">Difference:<br><span class="big-text '. $class .'">' . $best_diff . '</span></div>';
			echo '</div>';

			if( ! $a_10_insufficient && ! $b_10_insufficient ) {
				echo '<div class="box">';
					echo '<div class="hidden-xs">' . $name_10 . ' by:<br><span class="big-text '.$class_10.'">' . $diff_10 . '</span></div>';
					echo '<div class="visible-xs">Difference:<br><span class="big-text '.$class_10.'">' . $diff_10 . '</span></div>';
				echo '</div>';
			}
			if( ! $a_20_insufficient && ! $b_20_insufficient ) {
				echo '<div class="box">';
					echo '<div class="hidden-xs">' . $name_20 . ' by:<br><span class="big-text '.$class_20.'">' . $diff_20 . '</span></div>';
					echo '<div class="visible-xs">Difference:<br><span class="big-text '.$class_20.'">' . $diff_20 . '</span></div>';
				echo '</div>';
			}

			echo '<div class="box progressions hidden-xs">';
				echo '<strong>ANNUAL PROGRESSIONS</strong> <br/> (from 2008)';
			echo '</div>';

			echo '<div class="box representations hidden-xs">';
				echo '<strong>INTERNATIONAL HONOURS</strong> <br/> (from 2002)';
			echo '</div>';

			echo '<div class="box nz-medals hidden-xs">';
				echo '<strong>NEW ZEALAND <br>CHAMPIONSHIP MEDALS</strong><br> (from 2010)';
			echo '</div>';
			?>
			
		</div><!--END col-->


		<div class="col-sm-5 col-xs-4" style="text-align:center;">

			<?php

			/********************************************************************************************************/

			// DISPLAY ATHLETE 'B' DATA
			
			/********************************************************************************************************/

			// This displays the actual age of the athlete in Years/Months/Days ...
			$athlete_age = recordAge($athlete_data_b->DOB, date('Y-m-d')); // See global_helper.php
			$athlete_ageY = recordAgeY($athlete_data_b->DOB, date('Y-m-d')); // See global_helper.php

			echo '<div class="box big-text athlete-b">';
				echo '<div class="hidden-xs">' . $athlete_data_b->nameFirst.' <br class="visible-xs"> '.$athlete_data_b->nameLast. '<br><span class="ath-age">' . $athlete_age . '</span></div>';
				echo '<div class="visible-xs">' . $athlete_data_b->nameFirst.' <br class="visible-xs"> '.$athlete_data_b->nameLast. '<br><span class="ath-age">' . $athlete_ageY . '</span></div>';
			echo '</div>';

			echo '<div class="box">';
				$imp = ( $athlete_perfs_b[0]->implement ) ? ' <strong><br>(for ' . ltrim($athlete_perfs_b[0]->implement,0) . ')</strong>' : '';
				echo '<div class="hidden-xs">Number of ranked performances since 2008'. $imp .'<br><span class="big-text blue">' . count($athlete_perfs_b) . '</span></div>';
				echo '<div class="visible-xs">No. Rankings'. $imp .'<br><span class="big-text blue">' . count($athlete_perfs_b) . '</span></div>';
			echo '</div>';

			echo '<div class="box">';
				echo 'Personal Best <br><span class="big-text blue">' . ltrim($personal_best_b, 0) . '</span>';
			echo '</div>';

			// Show Average Top 10
			if( ! $a_10_insufficient && ! $b_10_insufficient ) {
				echo '<div class="box">';
					echo '<div class="hidden-xs">Average of best 10 performances<br><span class="big-text blue">' . $average_b_10 . '</span></div>';
					echo '<div class="visible-xs">Avg best 10<br><span class="big-text blue">' . $average_b_10 . '</span></div>';
				echo '</div>';
			}

			// Show Average Top 20
			if( ! $a_20_insufficient && ! $b_20_insufficient ) {
				echo '<div class="box">';
					echo '<div class="hidden-xs">Average of best 10 performances<br><span class="big-text blue">' . $average_b_20 . '</span></div>';
					echo '<div class="visible-xs">Avg best 20<br><span class="big-text blue">' . $average_b_20 . '</span></div>';
				echo '</div>';
			}

			// Show Athlete Progressions
			if($athlete_progressions_b) {
				echo '<div class="box progressions hidden-xs">';
					echo '<div style="text-transform: uppercase;"><strong>' . $eventName->eventName . '</strong></div>';
						
					foreach( $athlete_progressions_b as $row ):
						$performance = ( $row->time ) ? $row->time : $row->distHeight;
						$implement = ( $row->implement ) ? '(' .ltrim($row->implement, 0). ')' : '';
						$highlight = ( $personal_best_b == $performance ) ? 'bold blue' : '';
						$calcAge = date_diff(date_create($row->DOB), date_create($row->date));
						$age = ' - ' . $calcAge->format('%y yrs, %m months');

						echo '<div class=" '.$highlight.' "><strong>' . $row->year . '</strong> - ' . ltrim($performance, 0) . ' ' . $implement . ' ' . $age . '</div>';
					endforeach;
						
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
			<div class="box med-text">
				Best Performances
			</div>
		</div>

		<div class="col-xs-2">
			<div class="box med-text">
				Rank No.
			</div>
		</div>

		<div class="col-xs-5">
			<div class="box med-text">
				Best Performances
			</div>
		</div>
	</div>

	
	<div class="row no-gutters">

		<div class="col-xs-5">

			<table class="table table-striped perfs">

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

			<table class="table perfs" style="text-align:center;">
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

			<table class="table table-striped perfs">

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


	<div class="center"><a href="#" class="btn btn-red" id="show_all">SHOW ALL PERFORMANCES &nbsp;<i class="fa fa-search" aria-hidden="true"></i></a></div>
	<br>
	<div class="center"><a href="#" class="btn btn-search" id="bottom_results">Back to Top &nbsp;<i class="fa fa-chevron-up" aria-hidden="true"></i></a></div>



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

	        $(this).find('.box.progressions').each(function(){
	            if($(this).height() > highestBox){  
	                highestBox = $(this).height();  
	            }
	        })

	        $(this).find('.box.progressions').height(highestBox);
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

	        $(this).find('.box:not(.big-text).box:not(.representations).box:not(.nz-medals).box:not(.progressions)').each(function(){
	            if($(this).height() > highestBox){  
	                highestBox = $(this).height();  
	            }
	        })

	        $(this).find('.box:not(.big-text).box:not(.representations).box:not(.nz-medals).box:not(.progressions)').height(highestBox);
	    });

	    
	    // Colour every 10th row (blue)
	    $('table.table-striped, .perfs').each(function(){
	    	$(this).find('tr:nth-child(10n+0)').each(function(){
	    		$(this).css({
	    			'background': '#334249',
	    			'color': '#FFF',
	    			'fontWeight': 'bold'
	    		});
	    	});
	    });



	    // Only show top 20 performances - hide rest
	    // Click 'Show More' button to display all
		// ************************************************************************
		var perfsTable = $('table.perfs'),
			count = 0;

		perfsTable.each(function(){

			$(this).find('tr').each(function(count){

				if(count >= 20) {
					$(this).hide();
				} 

				count++;

			});
			
		});

		// Click 'Show All' button to display all performances
		$('#show_all').on('click', function(){
			perfsTable.each(function(){
				$(this).find('tr').fadeIn(1500);
				$('#show_all').hide();
			});
			return false;
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


