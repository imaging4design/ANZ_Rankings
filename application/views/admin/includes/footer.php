</div><!--END CONTENT AREA-->
</div><!--END MAIN / CLEARFIX-->

<div id="footer">
 <h6>&copy;Copyright 2012 Imaging4Design Ltd</h6>
</div>

</div><!--END WRAP-->

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