	<footer>
	<div class="container container-class">
		<div class="row">
			<div class="col-sm-5 center">
					<hr>
					<p><a href="http://www.athletics.org.nz" target="_blank">Athletics New Zealand</a> | <a href="https://www.facebook.com/AthleticsNZ" target="_blank">Our Facebook</a> | <a href="https://twitter.com/AthleticsNZ" target="_blank">Our Twitter</a></p>
			</div>
			<div class="col-sm-7 center">
					<hr>
					<p>&copy; Athletics New Zealand 2013 - All Rights Reserved. &nbsp; | &nbsp; Website by: <a href="mailto:lovegrovemail@gmail.com">Gavin Lovegrove</a></p>
			</div>
		</div>
	</div>
	</footer>





	<!-- Le javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="<?php echo base_url() . 'js/lib/bootstrap.js'; ?>" type="text/javascript"></script><!--BOOTSTRAP JS-->

	<script src="<?php echo base_url() . 'foo_table/js/footable.js'; ?>" type="text/javascript"></script><!--FOO TABLE JS-->

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

	<script type="text/javascript" async src="<?php echo base_url() . 'js/site-min.js' ?>"></script>

	<script>
		$(document).ready(function() {
			$(function() {
				$("#athleteID").autocomplete({
					source: function(request, response) {
						$.ajax({ url: "<?php echo site_url('site/home_con/get_auto_athletes'); ?>",
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


		$(document).ready(function() {
			$(function() {
				$("#athleteID2").autocomplete({
					source: function(request, response) {
						$.ajax({ url: "<?php echo site_url('site/home_con/get_auto_athletes'); ?>",
						data: { athletes: $("#athleteID2").val()},
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