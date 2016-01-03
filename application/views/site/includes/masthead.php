<div class="masthead">
	<div class="container">
		<div class="row">
			
			<?php
				// Display the total number of ranked results and (unique) visitors to site
				// Only run these queries once! and save them to a session var
				// This prevents load on the database by having to run it every time!

				if( ! $this->session->userdata('total_num_results') )
				{
					$total_results = totalResults(); // From global_helper.php

					if( isset($total_results) )
					{
						$total_num_results = number_format($total_results);
						$this->session->set_userdata('total_num_results', $total_num_results);
					}
				}
				else
				{
					$total_num_results = $this->session->userdata('total_num_results');
				}


				// Display the total number of ranked athletes
				// Only run these queries once! and save them to a session var
				// This prevents load on the database by having to run it every time!

				if( ! $this->session->userdata('total_num_athletes') )
				{
					$total_athletes = totalAthletes(); // From global_helper.php
					if( isset($total_athletes) )
					{
						$total_num_athletes = number_format($total_athletes);
						$this->session->set_userdata('total_num_athletes', $total_num_athletes);
					}
				}
				else
				{
					$total_num_athletes = $this->session->userdata('total_num_athletes');
				}


				// ANZ Logo
				$anz_logo = array(
					'src' => base_url() . 'img/anz_logo_small.png',
					'alt' => 'Athletics New Zealand',
					'class' => 'post_images',
					'style' => 'float:left;',
					'width' => '340',
					'height' => '150',
				);

			
			?>

			<div class="span6 clearfix">
				<div class="clearfix">&nbsp;</div>

				<?php echo img( $anz_logo ); ?>
				<!-- <div class="slab textGiant">ATHLETICS</div>
				<div class="slab textGiant">NEW</div> <div class="slab textGiant">ZEALAND</div> -->
				<div class="slab textLarge" style="clear:both;">RANKINGS AND RECORDS</div>
				<div class="slab numRanks"><?php echo $total_num_results; ?> Ranked Performances</div><div class="slab textSmall stats"><?php echo 'by ' . $total_num_athletes; ?> Athletes</div>
			</div>

			<div class="span6 black">

				<h2 class="throb" style="margin-left:-20px;">Latest News - <?php echo date('d/M/Y'); ?></h2>

				<?php
					// Only show the latest '4' News items
					if( isset( $show_news ) )
					{
						$count = 1;
						foreach( $show_news as $row ):
							if( $count <= 5 ) {
								echo '<h4 style="margin-left:-20px;"><i class="icon-comment icon-white"></i> ' . character_limiter($row->heading, 60) . ' &nbsp; ' . anchor('site/news_con/news_item/' .$row->newsID, '...&nbsp;more') . '</h4>';
								echo '<hr>';
							}
						$count++;
						endforeach;
					}


				?>



			</div>

				

		</div>
	</div>
</div>