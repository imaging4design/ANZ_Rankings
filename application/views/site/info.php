<div class="container">

	<div class="row">

		<div class="span12">

			<?php
			$admin = FALSE;
			if($this->session->userdata('is_logged_in'))
			{
				$admin = TRUE;
			}
			?>

			<div class="slab reversed textLarge">General</div><div class="slab textLarge blue">Information</div>
	  		<div style="clear:both;"></div><br>

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

		</div><!--END span12-->

	</div><!--END row-->

</div><!--END container-->