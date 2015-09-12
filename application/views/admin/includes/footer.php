</div><!--ENDS container-->

<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h6>&copy;Copyright 2012 Imaging4Design Ltd</h6>
		</div><!--ENDS col-->
	</div><!--ENDS row-->
</div><!--ENDS container-->


<script src="<?php echo base_url() . 'js/admin/bootstrap.js'; ?>" type="text/javascript"></script><!--BOOTSTRAP JS-->


<!--JQUERY FOR AUTO-COMPLETE FUNCTION-->
<script type="text/javascript">
$(document).ready(function() {
	$(function() {
		$("#athleteID").autocomplete({
			source: function(request, response) {
				$.ajax({ url: "<?php echo site_url('admin/admin_con/get_auto_athletes'); ?>",
				data: { athletes: $("#athleteID").val()},
				dataType: "json",
				type: "POST",
				success: function(data){
					response(data);
				}
			});
		},
		minLength: 2
		});
	});
});
</script>

</body>
</html>