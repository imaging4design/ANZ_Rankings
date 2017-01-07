<div class="row">
	<div class="col-sm-12">

		<h1 class="title">Your file was successfully uploaded!</h1>


		<div class="well well-trans">

			<ul>
				<?php foreach ($upload_data as $item => $value):?>
					<li><?php echo $item;?>: <?php echo $value;?></li>
				<?php endforeach; ?>
			</ul>

			<?php 		
					// echo $success['upload_data']['file_name'] . '<br>';
					// echo $success['upload_data']['file_type'] . '<br>';
					// echo $success['upload_data']['file_path'] . '<br>';
					// echo $success['upload_data']['full_path'] . '<br>';
					// echo $success['upload_data']['raw_name'] . '<br>';
					// echo $success['upload_data']['orig_name'] . '<br>';
					// echo $success['upload_data']['client_name'] . '<br>';
					// echo $success['upload_data']['file_ext'] . '<br>';
					// echo $success['upload_data']['file_size'] . '<br>';
					// echo $success['upload_data']['is_image'] . '<br>';
					// echo $success['upload_data']['image_width'] . '<br>';
					// echo $success['upload_data']['image_height'] . '<br>';
					// echo $success['upload_data']['image_type'] . '<br>';
					// echo $success['upload_data']['image_size_str'];
			?>


			<?php

				$path = './img/adverts/';
				$map = directory_map($path);

				foreach($map as $image)
				{
				    echo '<div><img src="' . base_url() . './img/adverts/' . $image . '"/></div>';
				}

			?>

			<?php echo anchor('admin/upload', 'BACK TO ADVERTS', array( 'class' => 'btn btn-green' )); ?>

		</div><!-- ENDS well -->

	</div><!-- ENDS col -->
</div><!-- ENDS row -->