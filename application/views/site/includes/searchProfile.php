<section class="search-head">
	<div class="container container-class search-form">
		<div class="row">

			<?php

				/***********************************************************************************/
				// START DISPLAY SEARCH RANKINGS PARAMETERS PANEL
				/***********************************************************************************/
				if($this->uri->segment(2) != 'profiles_con' )
				{
					
					// Insert 'Menu'
					include('menu.php');

					// Insert Search Forms
					include('search-nav.php');
					
				} 

				if($this->uri->segment(2) == 'profiles_con' )
				{
					
					// Insert 'Menu'
					include('menu.php');

					// Insert 'Athlete' Search Forms
					include('search_individual.php');

				}

			?>

		</div><!-- ENDS row -->

	</div><!--ENDS container-->

</section><!-- ENDS search-head -->

