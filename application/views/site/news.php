<div class="container"><!--START COL FULL-->

	<div class="row">

		<div class="span12 news">

			<?php
			$admin = FALSE;

			if($this->session->userdata('is_logged_in'))
			{
				$admin = TRUE;
			}
			?>

			<div class="slab reversed textLarge">Archived</div><div class="slab textLarge blue">News</div>
  			<div style="clear:both;"></div><br>

			<?php
			if( isset( $archive_news ) )
			{

				$count = 0;

				foreach($archive_news as $row):

				
					//Make data selectable as 'Admin Edit'
					if($admin)
					{
						$edit = anchor('admin/news_con/populate_news/' . $row->newsID, 'EDIT ARTICLE', array( 'class' => 'btn' ));
					}
					else
					{
						$edit = '';
					}

					

					

					if( $count % 4 == 0 ) { echo '<div class="row">'; }	 // Modulus equation: If $count == 0 add class 'row'
					
						echo '<div class="span3">';

							echo $edit; // Admin 'Edit Article' button

							echo '<div class="news_background">';
								echo '<div class="newsHolder"><div class="slab reversed textMed">DATE: </div><div class="slab textMed red">' . $row->date . ' &raquo;</div>';
								echo '<div class="clearfix"></div>';
								//echo '</div>' . character_limiter($row->bodyContent, 20, '') . ' &nbsp; ' . anchor('site/news_con/news_item/' .$row->newsID, '...&nbsp;view&nbsp;article ', array('class' => 'news_link'));
								echo '</div><h3>' . $row->heading . '</h3> <p>' . anchor('site/news_con/news_item/' .$row->newsID, '...&nbsp;view&nbsp;article ', array('class' => 'news_link')) . '</p>';
							echo '</div>';
							echo '<hr>';

						echo '</div>';
					
					
					if( $count % 4 == 3 ) { echo '</div>'; }	 // Modulus equation: If $count == 2 end class 'row'
					
					$count++;
				


				endforeach;

				// MODULUS Equation breakdown for each loop

				// $count( 0 ) % 3 = 0
				// $count( 1 ) % 3 = 1
				// $count( 2 ) % 3 = 2
				// $count( 3 ) % 3 = 0
				// $count( 4 ) % 3 = 1
				// $count( 5 ) % 3 = 2
				// $count( 6 ) % 3 = 0
				// $count( 7 ) % 3 = 1
				// $count( 8 ) % 3 = 2
				// $count( 9 ) % 3 = 0

				
			}
			?>

		</div><!--END span12-->

	</div><!--END row-->

</div><!--END container-->