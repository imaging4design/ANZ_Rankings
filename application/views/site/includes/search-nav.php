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

<?php
	/*
	|-----------------------------------------------------------------------------------------------------------------
	| Determinds which 'tab' has the 'active' class applied to it
	|-----------------------------------------------------------------------------------------------------------------
	*/
	// Initiate var
	if( $this->input->post('searchType') ) {
		$this->session->set_userdata('searchType', $this->input->post('searchType') );
		$searchType = $this->session->userdata( 'searchType' );
	} elseif( $this->session->userdata( 'searchType' ) ) {
		$searchType = $this->session->userdata( 'searchType' );
	} else {
		$searchType = 'annual';
	}
	

	$active_annual = ( $searchType == 'annual' ) ? 'active in' : '';
	$active_allTime = ( $searchType == 'allTime' ) ? 'active in' : '';
	$active_recent = ( $searchType == 'recent' ) ? 'active in' : '';
	$active_profiles = ( $searchType == 'profiles' ) ? 'active in' : '';

?>

<div class="col-sm-4 search-nav">

	<!-- <ul class="search-nav"> -->
	<ul class="nav nav-pills nav-stacked">
		<li class="<?php echo $active_annual; ?> blue" role="presentation">
			<a id="annual-tab" aria-expanded="false" aria-controls="annual" data-toggle="tab" role="tab" href="#annual"><p>Annual Lists <i class="fa fa-angle-double-right hidden-xs" aria-hidden="true"></i><span class="tabs-stats"> <?php echo number_format( totalResults() ); ?> performances</span></p></a>
		</li>
		<li class="<?php echo $active_allTime; ?> red" role="presentation">
			<a id="allTime-tab" aria-expanded="false" aria-controls="allTime" data-toggle="tab" role="tab" href="#allTime"><p>All-Time Lists <i class="fa fa-angle-double-right hidden-xs" aria-hidden="true"></i><span class="tabs-stats"> Spanning over 80 years</span></p></a>
		</li>
		<li class="<?php echo $active_recent; ?> yellow" role="presentation">
			<a id="recent-tab" aria-expanded="false" aria-controls="recent" data-toggle="tab" role="tab" href="#recent"><p>Recent Results <i class="fa fa-angle-double-right hidden-xs" aria-hidden="true"></i><span class="tabs-stats"> <?php echo number_format( rankings_added_month() ); ?> new in <?php echo date('F'); ?></span></p></a>
		</li>
		<li class="<?php echo $active_profiles; ?> green" role="presentation">
			<a id="profiles-tab" aria-expanded="false" aria-controls="profiles" data-toggle="tab" role="tab" href="#profiles"><p>Search Profiles <i class="fa fa-angle-double-right hidden-xs" aria-hidden="true"></i><span class="tabs-stats"> <?php echo $total_num_athletes; ?> athletes</span></p></a>
		</li>
	</ul>

</div><!-- ENDS col -->

<div id="myTabContent" class="tab-content">
	<div aria-labelledby="annual-tab" id="annual" role="tabpanel" class="tab-pane fade <?php echo $active_annual; ?>"> 
		<?php include('searchAnnual.php'); ?>
	</div>
	<div aria-labelledby="allTime-tab" id="allTime" role="tabpanel" class="tab-pane fade <?php echo $active_allTime; ?>"> 
		<?php include('searchAllTime.php'); ?>
	</div>
	<div aria-labelledby="recent-tab" id="recent" role="tabpanel" class="tab-pane fade <?php echo $active_recent; ?>"> 
		<?php include('searchRecent.php'); ?>
	</div>
	<div aria-labelledby="profiles-tab" id="profiles" role="tabpanel" class="tab-pane fade <?php echo $active_profiles; ?>"> 
		<?php include('searchAthlete.php'); ?>
	</div>
</div>
