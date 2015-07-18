<div class="container">

	<div class="row">

		<div class="span6">

			<div class="slab reversed textLarge">Archived</div><div class="slab textLarge blue">Mens Lists</div>
	  		<div style="clear:both;"></div><br>

			<p>Each list contains archived perfomance rankings for: <br>Open Men, M19 and M16</p>

			<?php
				echo '<p>' . anchor($this->archive_path_url . '2012/Men_2012.pdf','All Mens Events (2012)') . ' <span class="textRed"></span></p>';
				echo '<p>' . anchor($this->archive_path_url . 'mens_track/MEN_TRACK_ALL.pdf','Mens Track (2008-2011)') . '</p>';
				echo '<p>' . anchor($this->archive_path_url . 'mens_field/MEN_FIELD_ALL.pdf','Mens Field (2008-2011)') . '</p>';
				echo '<p>' . anchor($this->archive_path_url . 'mens_multi/MEN_COMBINED_EVENTS.pdf','Mens Combined Events (2008-2011)') . '</p>';
				echo '<hr class="visible-phone">';
			?>

		</div><!--END span4-->



		<div class="span6">

			<div class="slab reversed textLarge">Archived</div><div class="slab textLarge blue">Womens Lists</div>
	  		<div style="clear:both;"></div><br>

			<p>Each list contains archived perfomance rankings for: <br>Open Women, W19 and W16</p>

			<?php
				echo '<p>' . anchor($this->archive_path_url . '2012/Women_2012.pdf','All Womens Events (2012)') . ' <span class="textRed"></span></p>';
				echo '<p>' . anchor($this->archive_path_url . 'womens_track/WOMEN_TRACK_ALL.pdf','Womens Track (2008-2011)') . '</p>';
				echo '<p>' . anchor($this->archive_path_url . 'womens_field/WOMEN_FIELD_ALL.pdf','Womens Field (2008-2011)') . '</p>';
				echo '<p>' . anchor($this->archive_path_url . 'womens_multi/WOMEN_COMBINED_EVENTS.pdf','Womens Combined Events (2008-2011)') . '</p>';
				echo '<hr class="visible-phone">';
			?>

		</div><!--END span4-->

	</div><!--END row-->

</div><!--END container-->






















