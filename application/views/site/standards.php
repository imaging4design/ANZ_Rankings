<div class="searchBand"><!-- This is an anchor where the page will scroll up to wne search the 'Recent Rankings' -->

	<div class="container">

		<div class="row">

			<div class="span12">


				<?php
				/*
				|-----------------------------------------------------------------------------------------------------------------
				| DISPLAY 'MODAL' POP UP DISCLAIMER!!!
				| Only display once. When user activates a 'SESSION' it will disable Modal
				|-----------------------------------------------------------------------------------------------------------------
				*/
				if( $this->input->post( 'token' ) )
				{
					$this->session->set_userdata( 'no_modal', TRUE );
				}

				?>

				<?php if( $this->session->userdata('no_modal') != TRUE ) { ?>

				<!-- DISPLAY 'MODAL' POP UP DISCLAIMER!!! -->
				<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-header">
						<h3 id="myModalLabel">Performance Standards - Disclaimer</h3>
					</div>
					<div class="modal-body">
						<p>
							<strong><span class="textBlue">PLEASE NOTE:</span></strong> These lists display athletes who have met or exceeded performance standards within the respective qualification period for upcoming championships.  The lists are shown as a guide only and are in no way definitive, nor do they guarantee nomination or selection for any athlete.  Athletes must comply with all nomination criteria in order to be considered for selection - please refer to the relevant selection policy for further details.  No responsibility is accepted for any errors.
						</p>
					</div>
					<div class="modal-footer"><button class="btn" data-dismiss="modal" aria-hidden="true">I Agree to proceed</button></div>
				</div>

				<?php } ?>



				<div class="slab reversed textLarge">Championship</div><div class="slab textLarge blue">Standards</div>
	  			<div style="clear:both;"></div><br>

  			</div>

  		</div>

  		<div class="row">

  			<div class="span7">

				<?php
				/*
				|-----------------------------------------------------------------------------------------------------------------
				| Open form
				|-----------------------------------------------------------------------------------------------------------------
				*/
				echo form_open('site/standards_con/find_qualified', array( 'class' => 'form-search hack' ));

				echo '<fieldset>';
				echo '<legend>Athletes who have achieved performance standards for:</legend>';
				
				echo form_hidden('token', $token);

				echo champsDropdown($value='', $selected='', $label=''); // From Team_helper.php

				echo '&nbsp; &nbsp;';

				//Gender options
				echo '<label class="radio">';
					$checkGender = ( $this->input->post( 'gender') === 'MS' or ! $this->input->post( 'gender') ) ? 'checked' : ''; 
					echo '<input type="radio" name="gender" value="MS" ' . $checkGender . '> &nbsp; Men';
				echo '</label>';

				echo '&nbsp; | &nbsp;'; // spacer

				echo '<label class="radio">';
					$checkGender = ( $this->input->post( 'gender' ) === 'WS' ) ? 'checked' : ''; 
					echo '<input type="radio" name="gender" value="WS" ' . $checkGender . '>&nbsp;  Women';
				echo '</label>';

				echo '<br><br>';

				// Submit button
				echo form_submit('submit', 'View', 'class="btn"', 'id="submit"');

				echo '</fieldset>';

				echo form_close();

				?>

			</div>

			<div class="span5">
				<h3>Performance Standards - Disclaimer</h3>
				<p><span class="textBlue"><strong>Please note: </strong></span>These lists display athletes who have met or exceeded performance standards within the respective qualification period for upcoming championships. <br>  The lists are shown as a guide only and are in no way definitive, nor do they guarantee nomination or selection for any athlete.  Athletes must comply with all nomination criteria in order to be considered for selection - please refer to the relevant selection policy for further details.  No responsibility is accepted for any errors.</p>
			</div>

		</div>

	</div>

</div>





<div class="container">

	<div class="row">

		<div class="span12">


  			<?php
  			/*
			|-----------------------------------------------------------------------------------------------------------------
			| Work out the gender selected by user
			|-----------------------------------------------------------------------------------------------------------------
			*/

  			$gender = ( $this->input->post('gender') == 'MS' ) ? 'Men\'s' : 'Women\'s';

  			/*
  			|-----------------------------------------------------------------------------------------------------------------
  			| Start looping through ALL performances and ONLY display those with marks EQUAL or BETTER than the qualifying standard
  			|-----------------------------------------------------------------------------------------------------------------
  			*/
  			if( isset( $show_qualified ) )
  			{
  				

  				
  				if( isset( $dates ) )
	  			{
	  				echo '<div class="slab reversed textLarge">' . $dates->year . '</div><div class="slab textLarge red">' . $dates->champName . '</div>';
	  				echo '<div class="slab reversed textSmall">' . $gender . ' Events</div><div class="slab textSmall blue">Qualifying period <strong>('.$dates->qualStartFormat.' - '.$dates->qualEndFormat.')*</strong></div>';
	  				echo '<div style="clear:both;"></div>';

	  				// Show 'A' or 'B' qaulifying standard icon
					$qual_a = array(
						'src' => $this->css_path_url . 'icons/qual_a.png',
						'alt' => 'Qualification Standard',
						'width' => '15',
						'height' => '15',
						'style' => 'margin-top:-3px;'
					);

					$qual_b = array(
						'src' => $this->css_path_url . 'icons/qual_b.png',
						'alt' => 'Qualification Standard',
						'width' => '15',
						'height' => '15',
						'style' => 'margin-top:-3px;'
					);


					echo '<p><strong>*Note:</strong> The Marathon, Decathlon and Heptathlon have an extended qualification period. <strong>('.$dates->qualStartExtFormat.' - ' .$dates->qualEndExtFormat. ')</strong></p>';

					echo '<div style="margin: 20px 0;">' . img($qual_a) . ' Performance Standard &nbsp; &nbsp;' . img($qual_b) . ' Performance Standard</div>';

	  			}

  				echo '<table class="footable  table-striped">
						<thead>
							<tr>
								<th>Event</th>
								<th data-hide="phone,tablet">Athlete</th>
								<th data-hide="expand">Performance</th>
								<th><span class="pull-right">Venue</span></th>
								<th data-hide="phone,tablet"><span class="pull-right">Date</span></th>
							</tr>
						</thead>

					<tbody>';
  				
	  				foreach( $show_qualified as $row ):

	  					if( $row ):

		  					foreach($row as $result):

		  						$perf = ( in_array($result->eventID, $this->config->item('track_events')) ) ? $result->time : $result->distHeight;

		  						$genderStd = ($this->input->post('gender') == 'MS' ) ? $result->menA : $result->womenA;

	  						
		  						// Is this an 'A' or 'B' standard performance?
		  						// Run 'Greater than' or 'Less than' comparators
		  						if( in_array($result->eventID, $this->config->item('track_events')) )
		  						{
		  							$std = ( $perf <= $genderStd ) ? 'A' : 'B';
		  							$class = ( $perf <= $genderStd ) ? 'qual_a' : 'qual_b';
		  						}
		  						else
		  						{
		  							$std = ( $perf >= $genderStd ) ? 'A' : 'B';
		  							$class = ( $perf >= $genderStd ) ? 'qual_a' : 'qual_b';
		  						}


		  						// Show 'A' or 'B' qaulifying standard icon
								$qual_icon = array(
									'src' => $this->css_path_url . 'icons/'.$class.'.png',
									'alt' => 'Qualification Standard',
									'width' => '15',
									'height' => '15',
									'style' => 'margin-top:-3px;'
								);

	 	
		 						echo '<tr>
								<td>'. $result->eventName .'</td>
								<td>' . $result->nameFirst . ' ' . $result->nameLast . '</td>
								<td>' . img($qual_icon) . ' ' . ltrim($perf, 0) . '</td>
								<td><span class="pull-right">' . $result->venue . '</span></td>
								<td><span class="pull-right">' . $result->date . '</span></td>
								</tr>';


		  					endforeach;

	  					endif;

	  				endforeach;


	  				/*
	  				|-----------------------------------------------------------------------------------------------------------------
	  				| Show Multi Events Qualifiers
	  				|-----------------------------------------------------------------------------------------------------------------
	  				*/

	  				foreach( $show_qualified_multis as $row ):

	  					if( $row ):

		  					foreach($row as $result):

		  						$perf = $result->points;

		  						$genderStd = ($this->input->post('gender') == 'MS' ) ? $result->menA : $result->womenA;

	  						
		  						// Is this an 'A' or 'B' standard performance?
		  						// Run 'Greater than' or 'Less than' comparators
		  						$std = ( $perf >= $genderStd ) ? 'A' : 'B';
		  						$class = ( $perf >= $genderStd ) ? 'qual_a' : 'qual_b';
		  						

		  						// Show 'A' or 'B' qaulifying standard icon
								$qual_icon = array(
									'src' => $this->css_path_url . 'icons/'.$class.'.png',
									'alt' => 'Qualification Standard',
									'width' => '15',
									'height' => '15',
									'style' => 'margin-top:-3px;'
								);

	 	
		 						echo '<tr>
								<td>'. $result->eventName .'</td>
								<td>' . $result->nameFirst . ' ' . $result->nameLast . '</td>
								<td>' . img($qual_icon) . ' ' . ltrim($perf, 0) . '</td>
								<td><span class="pull-right">' . $result->venue . '</span></td>
								<td><span class="pull-right">' . $result->date . '</span></td>
								</tr>';


		  					endforeach;

	  					endif;

	  				endforeach;


	  				echo '</tbody>';

				echo '</table>';

				echo '<hr>';

  			}
  			?>

  			

  			<?php
  			/*
  			|-----------------------------------------------------------------------------------------------------------------
  			| Display the Full list of qualifying standards for the selected event
  			|-----------------------------------------------------------------------------------------------------------------
  			*/
  			if( isset( $standards ) )
  			{
  				echo '<div class="slab reversed textMed">Performance</div><div class="slab textMed blue">Standards</div>';

  				echo '<table class="footable  table-striped">
					<thead>
						<tr>
							<th>Men A</th>
							<th data-hide="phone,tablet">Men B</th>
							<th data-hide="expand" style="text-align:center;">Event</th>
							<th><span class="pull-right">Women A</span></th>
							<th data-hide="phone,tablet"><span class="pull-right">Women B</span></th>
						</tr>
					</thead>

					<tbody>';

	  				foreach( $standards as $row ):

	  					echo '<tr>
								<td>'. ltrim($row->menA, 0) .'</td>
								<td>'. ltrim($row->menB, 0) .'</td>
								<td style="text-align:center;">'. $row->eventName .'</td>
								<td><span class="pull-right">'. ltrim($row->womenA, 0) .'</span></td>
								<td><span class="pull-right">'. ltrim($row->womenB, 0) .'</span></td>

							</tr>';

	  				endforeach;

  					echo '</tbody>';

				echo '</table>';

  			}

  			if( isset($_POST['submit']) && ! isset( $standards ) ) {
  				echo 'No qualifying standards available yet.';
  			}

  			?>




		</div><!--END span12-->

	</div><!--END row-->

</div><!--END container-->


	
	<?php
		// Show Championship Logos
		$beijing = array(
			'src' => $this->css_path_url . 'main/championships/2014_beijing.jpg',
			'alt' => '2014 beijing',
			'width' => '200px',
			'height' => '140px',
			'class' => 'img-polaroid',
			'style' => 'margin-right:20px;'
		);

	?>



<div class="container">
	<div class="row">
		<div class="span12">
			<h3>Upcoming Championships ...</h3>
		</div>
	</div>	

	<div class="row">

		<?php
			echo '<div class="span4">' . anchor( 'http://www.iaaf.org/competitions/iaaf-world-championships', img($beijing), array( 'target' => '_blank') ) . '<h4><span id="beijing"></span> To Go!</h4></div>';
		?>

		</div><!--END span12-->
	</div><!--END row-->
</div><!--END container-->



<script>
// Activates the 'Modal' pop up (Disclaimer) ..
$(window).load(function() {

	$('#myModal').modal({
		show: true,
		backdrop: 'static'
	});

});
</script>


<script>

    CountDownTimer('08/22/2015 7:35 AM', 'beijing');

    function CountDownTimer(dt, id)
    {
        var end = new Date(dt);

        var _second = 1000;
        var _minute = _second * 60;
        var _hour = _minute * 60;
        var _day = _hour * 24;
        var timer;

        function showRemaining() {
            var now = new Date();
            var distance = end - now;
            if (distance < 0) {

                clearInterval(timer);
                document.getElementById(id).innerHTML = 'NOW ON';

                return;
            }
            var days = Math.floor(distance / _day);
            var hours = Math.floor((distance % _day) / _hour);
            var minutes = Math.floor((distance % _hour) / _minute);
            var seconds = Math.floor((distance % _minute) / _second);

            document.getElementById(id).innerHTML = days + ' days ';
            document.getElementById(id).innerHTML += hours + 'hrs ';
            document.getElementById(id).innerHTML += minutes + 'mins ';
            document.getElementById(id).innerHTML += seconds + 'secs';
        }

        timer = setInterval(showRemaining, 1000);
    }

</script>