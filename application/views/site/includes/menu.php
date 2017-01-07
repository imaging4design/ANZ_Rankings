<?php
	// Used to set the 'active' state on the menu buttons
	// Get current uri_string() - example ... site/home_con/archive_lists
	$current = uri_string();

	$home = ( $current == '' || $current == 'site/home_con') ? 'active' : '';
	$records = ( $current == 'site/records_con') ? 'active' : '';
	$recordForms = ( $current == 'site/records_con/forms') ? 'active' : '';
	$news = ( $current == 'site/news_con') ? 'active' : '';
	$teams = ( $current == 'site/team_con') ? 'active' : '';
	$archive = ( $current == 'site/home_con/archive_lists') ? 'active' : '';
	$publications = ( $current == 'site/home_con/publications') ? 'active' : '';
	$gen_info = ( $current == 'site/info_con') ? 'active' : '';
	$abbrev = ( $current == 'site/abbrev_con') ? 'active' : '';
	$contact = ( $current == 'site/home_con/contact') ? 'active' : '';
	$compare_athletes = ( $current == 'site/compare_con') ? 'active' : '';

	// ANZ Logo
	$anz_logo = array(
		'src' => base_url() . 'img/anz_logo_small.svg',
		'alt' => 'Athletics New Zealand',
		'class' => 'center-block',
		'width' => '100',
		'height' => 'auto',
	);
?>

<!--START HORIZONTAL MENU-->

<!-- MAIN NAV BAR -->
<!-- <div class="navbar navbar-default navbar-fixed-top hidden-xs" role="navigation"> -->
<div class="navbar navbar-default hidden-xs" role="navigation">
	<div class="container container-menu">

		<div class="row no-gutter">
			<div class="col-sm-12">

				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div><!-- ENDS navbar-header -->
			
				<div id="navbar" class="navbar-collapse collapse">

					<ul class="nav navbar-nav">
						<li class="<?php echo $contact ?>"><?php echo anchor('./', '<i class="fa fa-home" aria-hidden="true"></i> Rankings'); ?></li>
						<li class="dropdown">
							<a href="" class="dropdown-toggle" data-toggle="dropdown">Records<span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li class="<?php echo $records ?>"><?php echo anchor('site/records_con', 'New Zealand Records'); ?></li>
								<li class=""><?php echo anchor('userfiles/file/Para_Athletics_Records.pdf', 'New Zealand Para Records', array('target' => '_blank')); ?></li>
								<li><?php echo anchor('userfiles/file/Recognised_Supplementary_Records.pdf', 'Recognised Supplementary Records', array('target' => '_blank')); ?></li>
								<li><?php echo anchor('userfiles/file/Archived_Records.pdf', 'Archived Records', array('target' => '_blank')); ?></li>
								<li class="<?php echo $recordForms ?>"><?php echo anchor('site/records_con/forms', 'NZ Record Application Forms'); ?></li>
							</ul>
						</li><!-- ENDS dropdown -->

						<li class="dropdown">
              				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Resources<span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li class="<?php echo $abbrev ?>"><?php echo anchor('site/abbrev_con', 'Site Abbreviations'); ?></li>
								<li class="<?php echo $archive ?>"><?php echo anchor('site/home_con/archive_lists', 'Archived Lists'); ?></li>
								<!-- <li class="<?php //echo $news ?>"><?php //echo anchor('site/news_con', 'Archived News'); ?></li> -->
								<li class="<?php echo $publications ?>"><?php echo anchor('site/home_con/publications', 'Publications'); ?></li>
								<li class="<?php echo $gen_info ?>"><?php echo anchor('site/info_con', 'General Information'); ?></li>
								<li class="<?php echo $compare_athletes ?>"><?php echo anchor('site/compare_con', 'Compare Athletes'); ?></li>
							</ul>
            			</li><!-- ENDS dropdown -->

			            <li class="dropdown">
			              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Links<span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="http://www.athletics.org.nz" target="_blank">Athletics New Zealand</a></li>
								<li><a href="https://www.facebook.com/AthleticsNZ" target="_blank">ANZ Facebook</a></li>
								<li><a href="https://twitter.com/AthleticsNZ" target="_blank">ANZ Twitter</a></li>
								<li><a href="http://www.iaaf.org" target="_blank">IAAF</a></li>
								<li><a href="http://www.tilastopaja.org" target="_blank">Tilastopaja Rankings</a></li>
							</ul>
			            </li><!-- ENDS dropdown -->

            			<li class="<?php echo $contact ?>"><?php echo anchor('site/home_con/contact', 'Contact'); ?></li>

					</ul><!-- ENDS nav navbar-nav -->

				</div><!--ENDS navbar-collapse -->

			</div><!-- ENDS col -->

		</div><!-- ENDS row -->

	</div><!-- ENDS container -->

</div><!-- ENDS navbar -->



<!-- MOBILE NAV BAR -->
<nav id="mobile" class="visible-xs">
	<div id="menuToggle">
		<input type="checkbox" id="myCheckbox">

		<span></span>
		<span></span>
		<span></span>

		<ul id="menu">

			<li><?php echo anchor('./', 'Home'); ?></li>
			<li><?php echo anchor('site/records_con', 'New Zealand Records'); ?></li>
			<li><?php echo anchor('site/abbrev_con', 'Abbreviations'); ?></li>
			<li><?php echo anchor('site/home_con/archive_lists', 'Archived Lists'); ?></li>
			<li><?php echo anchor('site/home_con/publications', 'Publications'); ?></li>
			<li><?php echo anchor('site/info_con', 'General Information'); ?></li>
			<li><a href="http://www.athletics.org.nz" target="_blank">Athletics New Zealand</a></li>
			<li><a href="https://www.facebook.com/AthleticsNZ" target="_blank">ANZ Facebook</a></li>
			<li><a href="https://twitter.com/AthleticsNZ" target="_blank">ANZ Twitter</a></li>
			<!-- <li><a href="http://www.iaaf.org" target="_blank">IAAF</a></li> -->
			<!-- <li><a href="http://www.tilastopaja.org" target="_blank">Tilastopaja Rankings</a></li> -->

			<!-- <li><a href=""><i class="fa fa-chevron-right"></i> Records</a>
				<ul class="submenu">
					<li class="<?php echo $records ?>"><?php echo anchor('site/records_con', 'New Zealand Records'); ?></li>
					<li class=""><?php //echo anchor('userfiles/file/Para_Athletics_Records.pdf', 'New Zealand Para Records'); ?></li>
					<li class="<?php //echo $recordForms ?>"><?php //echo anchor('site/records_con/forms', 'NZ Record Application Forms'); ?></li>
				</ul>
			</li>

			<li><a href=""><i class="fa fa-chevron-right"></i> Archives &amp; News</a>
				<ul class="submenu">
					<li class="<?php //echo $archive ?>"><?php echo anchor('site/home_con/archive_lists', 'Archived Lists'); ?></li>
					<li class="<?php //echo $news ?>"><?php echo anchor('site/news_con', 'Archived News'); ?></li>
					<li class="<?php //echo $gen_info ?>"><?php echo anchor('site/info_con', 'General Information'); ?></li>
				</ul>
			</li>

			<li><a href=""><i class="fa fa-chevron-right"></i> Archives &amp; News</a>
				<ul class="submenu">
					<li><a href="http://www.athletics.org.nz" target="_blank">Athletics New Zealand</a></li>
					<li><a href="https://www.facebook.com/AthleticsNZ" target="_blank">ANZ Facebook</a></li>
					<li><a href="https://twitter.com/AthleticsNZ" target="_blank">ANZ Twitter</a></li>
					<li><a href="http://www.iaaf.org" target="_blank">IAAF</a></li>
					<li><a href="http://www.tilastopaja.org" target="_blank">Tilastopaja Rankings</a></li>
				</ul>
			</li> -->

		</ul><!-- ENDS ul menu -->

	</div>

</nav>


<div class="band-nav-mobile visible-xs">
	<div class="logo-large">
		<?php echo anchor(base_url(), '<i class="fa fa-home" aria-hidden="true"></i>'); ?>
	</div>
	<p>NZ Records &amp; Rankings</p>
</div><!--ENDS band-->