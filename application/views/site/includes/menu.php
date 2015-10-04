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
	$info = ( $current == 'site/info_con') ? 'active' : '';
	$contact = ( $current == 'site/home_con/contact') ? 'active' : '';
?>

<!--START HORIZONTAL MENU-->

<div class="navbar navbar-inverse navbar-static-top">

	<div class="navbar-inner">
		<div class="container">

		<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		</button>

			<?php echo anchor('', 'Athletics New Zealand', array( 'class' => 'brand hidden-phone' )); ?>
			<?php echo anchor('', 'MENU', array( 'class' => 'brand visible-phone' )); ?>

			<div class="nav-collapse collapse">

			<ul class="nav">
				<li class="<?php echo $home ?>"><?php echo anchor('', 'Home'); ?></li>

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Records<b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li class="divider"></li>
						<li class="<?php echo $records ?>"><?php echo anchor('site/records_con', 'New Zealand Records'); ?></li>
						<li class=""><?php echo anchor('userfiles/file/Para_Athletics_Records.pdf', 'New Zealand Para Records'); ?></li>
						<li class="<?php echo $recordForms ?>"><?php echo anchor('site/records_con/forms', 'NZ Record Application Forms'); ?></li>
						<li class="divider"></li>
					</ul>
				</li>


				<!-- <li class="<?php //echo $teams ?>"><?php //echo anchor('site/standards_con', 'Standards'); ?></li> -->

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Archives | News | Info<b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li class="divider"></li>
						<li class="<?php echo $archive ?>"><?php echo anchor('site/home_con/archive_lists', 'Archived Lists'); ?></li>
						<li class="<?php echo $news ?>"><?php echo anchor('site/news_con', 'Archived News'); ?></li>
						<li class="<?php echo $publications ?>"><?php echo anchor('site/home_con/publications', 'Publications'); ?></li>
						<li class="<?php echo $info ?>"><?php echo anchor('site/info_con', 'General Information'); ?></li>
						<li class="divider"></li>
					</ul>
				</li>
				
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Links<b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li class="divider"></li>
						<li class="nav-header">ANZ Favourites</li>
						<li><a href="http://www.athletics.org.nz" target="_blank">Athletics New Zealand</a></li>
						<li><a href="http://performance.athletics.org.nz" target="_blank">ANZ High Performance</a></li>
						<li><a href="https://www.facebook.com/AthleticsNZ" target="_blank">ANZ Facebook</a></li>
						<li><a href="https://twitter.com/AthleticsNZ" target="_blank">ANZ Twitter</a></li>
						<li><a href="http://www.nzrun.com" target="_blank">NZ Run</a></li>
						
						<li class="divider"></li>
						<li class="nav-header">International</li>
						<li><a href="http://www.iaaf.org" target="_blank">IAAF</a></li>
						<li><a href="http://www.tilastopaja.org" target="_blank">Tilastopaja Rankings</a></li>
					</ul>
				</li>

				<li class="<?php echo $contact ?>"><?php echo anchor('site/home_con/contact', 'Contact'); ?></li>
			</ul>

			</div><!--/.nav-collapse -->
		</div>
	</div>
</div><!--ENDS navbar -->

<!--END HORIZONTAL MENU-->