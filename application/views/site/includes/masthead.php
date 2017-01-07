<?php
	// Display the total number of ranked results and (unique) visitors to site
	// Only run these queries once! and save them to a session var
	// This prevents load on the database by having to run it every time!

	if( ! $this->session->userdata('total_num_results') )
	{
		$total_results = totalResults(); // From global_helper.php

		if( isset($total_results) )
		{
			$total_num_results = number_format($total_results);
			$this->session->set_userdata('total_num_results', $total_num_results);
		}
	}
	else
	{
		$total_num_results = $this->session->userdata('total_num_results');
	}


	// Display the total number of ranked athletes
	// Only run these queries once! and save them to a session var
	// This prevents load on the database by having to run it every time!

	if( ! $this->session->userdata('total_num_athletes') )
	{
		$total_athletes = totalAthletes(); // From global_helper.php
		if( isset($total_athletes) )
		{
			$total_num_athletes = number_format($total_athletes);
			$this->session->set_userdata('total_num_athletes', $total_num_athletes);
		}
	}
	else
	{
		$total_num_athletes = $this->session->userdata('total_num_athletes');
	}


	// ANZ Logo
	$anz_logo = array(
		'src' => base_url() . 'img/anz_logo_small.svg',
		'alt' => 'Athletics New Zealand',
		'class' => 'img-responsive',
		'style' => 'margin-top: 10px;',
		'width' => '260',
		'height' => 'auto',
	);


?>

<?php
	// Some statistics displaying No. of ranked performances added this month
	if( isset($rankings_added_month) )
	{
		$total_rankings_added_month = $rankings_added_month;
	}

	// Some statistics displaying No. of ranked performances added this week
	if( isset($rankings_seven_days) )
	{
		$total_rankings_seven_days = $rankings_seven_days;
	} else {
		$total_rankings_seven_days = 0;
	}

?>

<div class="masthead">
	<div class="container">

		<div class="row">
			<div class="col-sm-3">
				<a href="http://www.athletics.org.nz/" target="_blank"><?php echo img($anz_logo); ?></a>
			</div>

			<!-- DISPLAYS ADVERTISING IMAGE WITH URL LINK -->
			<div class="col-sm-9">

				<?php 
					// From global_helper.php
					$advert = show_advert(); 

					// Display advertising image from database
					$anz_logo = array(
						'src' => base_url() . 'img/adverts/' . $advert->image_name,
						'alt' =>  $advert->campaign_title,
						'class' => 'pull-right img-responsive advert',
						'width' => '728',
						'height' => 'auto',
					);

					// echo $advert->expires . ' Expires <br>';
					// echo date('Y-m-d') . ' Today';

					// Only display advert if it has not reached its expiry date!!!
					if( $advert->expires > date('Y-m-d') ) {  

						if( isset($advert) )
						{
							echo anchor($advert->url_location, img($anz_logo), array( 'target' => '_blank' ));
						}

					}

				?>

			</div>
		</div><!--ENDS row-->

	</div><!-- ENDS container -->


	
		<div class="container">

			<div class="row">
				<div class="col-sm-12 center">
					<h1 class="title">Athletics New Zealand Records and Rankings</h1>
				</div>
			</div><!--ENDS row-->

		</div><!-- ENDS container -->
</div><!-- ENDS masthead -->




