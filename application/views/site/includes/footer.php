	<footer>
	<div class="container">
		<div class="row">
			<div class="span5 center">
					<hr>
					<p><a href="http://www.athletics.org.nz" target="_blank">Athletics New Zealand</a> | <a href="https://www.facebook.com/AthleticsNZ" target="_blank">Our Facebook</a> | <a href="https://twitter.com/AthleticsNZ" target="_blank">Our Twitter</a></p>
			</div>
			<div class="span7 center">
					<hr>
					<p>&copy; Athletics New Zealand 2013 - All Rights Reserved. &nbsp; | &nbsp; Website by: <?php echo anchor('http://www.lovegrovedesign.co.nz', 'Lovegrove Design'); ?></p>
			</div>
		</div>
	</div>
	</footer>





	<!-- Le javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="<?php echo base_url() . 'js/bootstrap.js'; ?>" type="text/javascript"></script><!--BOOTSTRAP JS-->

	<script src="<?php echo base_url() . 'foo_table/js/footable-0.1.js'; ?>" type="text/javascript"></script><!--FOO TABLE JS-->
	<script type="text/javascript">
		$(function() {
			$('table').footable();
		});
	</script>


	<script>
	
		// Animate the new 'NEWS' title heading
		function throb() {
			var throb = $('.throb');
			throb.animate({
				'opacity' : 0.3
			}, { duration: 1000 })
			.animate({
				'opacity' : 1
			}, { duration: 1000})
		}

		setInterval( function() {
			throb()
		}, 1000);

	</script>


	<script type="text/javascript">
		// Submit 'Top Permormers form on home page'
		(function(){
			$('#topPerformers :input').change(function() {
				//alert('Handler for .change() called.');
				this.form.submit("#topPerformers");
			}); 
		})();
	</script>
	

	<!--JQUERY FOR AUTO-COMPLETE FUNCTION-->
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
	</script>


	<!-- Slide Toggle Appreviations -->
	<script>
		(function() {
			//$("#abbrev").hide();
			//$("#abbrev").css("display","none");
			$("a.abbrevLink").on('click', function(e) {
				e.preventDefault();
				$("#abbrev").css("display","visible");
				$("#abbrev").slideToggle('fast');
			});
		})();
	</script>


	<!-- Some Analytics -->
	<script type="text/javascript">
		var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-7102098-23']);
			_gaq.push(['_trackPageview']);

		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>



	

	<!--
	<script src="js/bootstrap-transition.js"></script>
	<script src="js/bootstrap-alert.js"></script>
	<script src="js/bootstrap-modal.js"></script>
	<script src="js/bootstrap-dropdown.js"></script>
	<script src="js/bootstrap-scrollspy.js"></script>
	<script src="js/bootstrap-tab.js"></script>
	<script src="js/bootstrap-tooltip.js"></script>
	<script src="js/bootstrap-popover.js"></script>
	<script src="js/bootstrap-button.js"></script>
	<script src="js/bootstrap-collapse.js"></script>
	<script src="js/bootstrap-carousel.js"></script>
	<script src="js/bootstrap-typeahead.js"></script>
	-->


</body>
</html>