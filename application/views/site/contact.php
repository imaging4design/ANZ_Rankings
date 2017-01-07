<div class="container container-class">

	<div class="row">

		<?php include('includes/menu.php'); ?>

		<div class="col-sm-12">

			<br>
			<h2 class="h2-one">Contact <strong>Us</strong></h2>

			<h4>If you have any questions regarding the records and rankings listed on this site please email Steve Hollings (Statistician):</h4>
			<p><span class="strong">Please include:</span><br />
			Your Name<br />
			Athlete Name<br />
			Details of performance in question
			</p>
			<p><?php echo safe_mailto('hollings@athletic.co.nz?subject=Rankings Enquiry', 'Click Here to Contact Admin', array( 'class' => 'btn btn-search' ) ); ?></p>

		</div><!--END col-sm-12-->

	</div><!--END row-->

</div><!--END container-->