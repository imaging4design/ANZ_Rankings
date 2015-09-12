<div class="row">
	<div class="col-sm-12">

		<h1>Administration Menu</h1>

		<div class="well well-trans">

			<p>Add Results:</p>

			<?php
				echo anchor('admin/results_con/add_results', 'Individual Events', array('class' => 'btn btn-red'));
				echo anchor('admin/multis_con/add_multis', 'Multi Events', array('class' => 'btn btn-red'));
				echo anchor('admin/relays_con/add_relays', 'Relays', array('class' => 'btn btn-red'));
			?>

			<p class="strong">Add Records:</p>
			<?php echo anchor('admin/records_con/add_records', 'Add Records', array('class' => 'btn btn-red')); ?>

			<p class="strong">Add Athletes:</p>
			<?php echo anchor('admin/athlete_con', 'New Athlete', array('class' => 'btn btn-red')); ?>

			<p class="strong">Add News Article:</p>
			<?php echo anchor('admin/news_con', 'Add News/Info', array('class' => 'btn btn-red')); ?>

		</div><!-- ENDS well well-trans -->

	</div><!--ENDS col-->
</div><!--ENDS row-->