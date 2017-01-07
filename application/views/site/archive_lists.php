<div class="container container-class">

	<div class="row">

		<?php include('includes/menu.php'); ?>

		<div class="col-sm-6">

			<br>
			<h2 class="h2-one">Archived Lists <strong>Men</strong></h2>

			<p>Each list contains archived perfomance rankings for: <br>Open Men, M19 and M16</p>

			<?php
				echo anchor($this->archive_path_url . '2012/Men_2012.pdf','<i class="fa fa-cloud-download"></i> All Mens Events (2012)', array('class'=>'appForms'));
				echo anchor($this->archive_path_url . 'mens_track/MEN_TRACK_ALL.pdf','<i class="fa fa-cloud-download"></i> Mens Track (2008-2011)', array('class'=>'appForms'));
				echo anchor($this->archive_path_url . 'mens_field/MEN_FIELD_ALL.pdf','<i class="fa fa-cloud-download"></i> Mens Field (2008-2011)', array('class'=>'appForms'));
				echo anchor($this->archive_path_url . 'mens_multi/MEN_COMBINED_EVENTS.pdf','<i class="fa fa-cloud-download"></i> Mens Combined Events (2008-2011)', array('class'=>'appForms'));
				echo '<hr class="visible-xs">';
			?>

		</div><!--END col-sm-4-->



		<div class="col-sm-6">

			<br>
			<h2 class="h2-one">Archived Lists <strong>Women</strong></h2>

			<p>Each list contains archived perfomance rankings for: <br>Open Women, W19 and W16</p>

			<?php
				echo anchor($this->archive_path_url . '2012/Women_2012.pdf','<i class="fa fa-cloud-download"></i> All Womens Events (2012)', array('class'=>'appForms'));
				echo anchor($this->archive_path_url . 'womens_track/WOMEN_TRACK_ALL.pdf','<i class="fa fa-cloud-download"></i> Womens Track (2008-2011)', array('class'=>'appForms'));
				echo anchor($this->archive_path_url . 'womens_field/WOMEN_FIELD_ALL.pdf','<i class="fa fa-cloud-download"></i> Womens Field (2008-2011)', array('class'=>'appForms'));
				echo anchor($this->archive_path_url . 'womens_multi/WOMEN_COMBINED_EVENTS.pdf','<i class="fa fa-cloud-download"></i> Womens Combined Events (2008-2011)', array('class'=>'appForms'));
				echo '<hr class="visible-xs">';
			?>

		</div><!--END col-sm-4-->

	</div><!--END row-->

</div><!--END container-->






















