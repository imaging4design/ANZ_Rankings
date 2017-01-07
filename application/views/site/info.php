<div class="container container-class">

	<div class="row">

		<?php include('includes/menu.php'); ?>

		<div class="col-sm-12">

			<?php
			$admin = FALSE;
			if($this->session->userdata('is_logged_in'))
			{
				$admin = TRUE;
			}
			?>

			<br>
	  		<h2 class="h2-one">General <strong>Information</strong></h2>

			<?php
			if(isset($info))
			{
				foreach($info as $row):

					// Make data selectable as 'Admin Edit'
					if($admin)
					{
						$edit = '<p>' . anchor('admin/news_con/populate_news/' . $row->newsID, '[EDIT ARTICLE]') . '</p>';
					}
					else
					{
						$edit = '';
					}

					echo $edit;
					echo $row->bodyContent;

					echo '<div class="dotted">&nbsp;</div>';

				endforeach;
			}
			?>

		</div><!--END col-sm-12-->

	</div><!--END row-->

</div><!--END container-->