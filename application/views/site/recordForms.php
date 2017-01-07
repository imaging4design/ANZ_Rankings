<div class="container container-class"><!--START COL FULL-->

	<div class="row">

		<?php include('includes/menu.php'); ?>

		<div class="col-sm-12">
			<br>
			<h2 class="h2-one">New Zealand Record<strong> Application Forms</strong></h2>
		</div>

		

	</div><!--END row-->

	<div class="row appForms-wrapper">
		<div class="col-sm-3"><?php echo anchor($this->recordApp_path_url . 'TRACK_RecordApp.pdf', '<i class="fa fa-cloud-download"></i> TRACK Form', array( 'class' => 'appForms' ) ) ?></div>
		<div class="col-sm-3"><?php echo anchor($this->recordApp_path_url . 'FIELD_RecordApp.pdf', '<i class="fa fa-cloud-download"></i> FIELD Form', array( 'class' => 'appForms' ) ) ?></div>
		<div class="col-sm-3"><?php echo anchor($this->recordApp_path_url . 'COMBINED_RecordApp.pdf', '<i class="fa fa-cloud-download"></i> COMBINED Form', array( 'class' => 'appForms' ) ) ?></div>
		<div class="col-sm-3"><?php echo anchor($this->recordApp_path_url . 'ROAD_RecordApp.pdf', '<i class="fa fa-cloud-download"></i> ROAD Form', array( 'class' => 'appForms' ) ) ?></div>
	</div>

</div><!--END container-->