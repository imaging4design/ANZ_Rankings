<?php
	// Do NOT display the menu nav bar unless admin is logged in ...
	if( $this->session->userdata('is_logged_in') == 1 && $this->session->userdata('admin') == 1) {
?>

<!--START HORIZONTAL MENU-->
<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<span class="navbar-brand">ATHLETICS NZ</span>
		</div>
		<div id="navbar" class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li><?php echo anchor('#','RANKINGS'); ?></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">RESULTS <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><?php echo anchor('admin/results_con/add_results','Individual'); ?></li>
						<li><?php echo anchor('admin/multis_con/add_multis','Multi Events'); ?></li>
						<li><?php echo anchor('admin/relays_con/add_relays','Relays'); ?></li>
					</ul>
				</li>
				<li><?php echo anchor('admin/records_con/add_records','RECORDS'); ?></li>
				<li><?php echo anchor('admin/athlete_con','NEW ATHLETE'); ?></li>
				<li><?php echo anchor('admin/news_con','ADD NEWS'); ?></li>
				<li>
					<?php
						//Show log out button only if a user is logged in
						if($this->session->userdata('is_logged_in'))
						{
							echo anchor('admin/login_con/logout','LOG OUT');
						}
					?>
				</li>
			</ul>
		</div><!--/.nav-collapse -->
	</div>
</nav>

<?php } ?>