<div class="container"><!--START COL FULL-->

	<div class="row">

		<div class="col-sm-12 news">

			<?php
			$admin = FALSE;

			if($this->session->userdata('is_logged_in'))
			{
				$admin = TRUE;
			}
			?>

			<div class="slab reversed textLarge">Latest</div><div class="slab textLarge blue">News</div>
  			<div style="clear:both;"></div><br>

			<?php
			if( isset( $news_item ) )
			{

				//Make data selectable as 'Admin Edit'
				if($admin)
				{
					$edit = anchor('admin/news_con/populate_news/' . $news_item->newsID, 'EDIT ARTICLE', array( 'class' => 'btn' ));
				}
				else
				{
					$edit = '';
				}

				

				echo $edit; // Admin 'Edit Article' button

				echo '<div class="news_background">';
				echo '<div class="newsHolder"><div class="slab reversed textMed">DATE: </div><div class="slab textMed">' . $news_item->date . ' &raquo;</div>';
				echo '</div>';

				echo '<div class="clearfix"></div>';
				echo '<span class="news_item news_item_img">' . $news_item->bodyContent . '</span>';

					
			}
			?>

		</div><!--END col-sm-12-->

	</div><!--END row-->

</div><!--END container-->