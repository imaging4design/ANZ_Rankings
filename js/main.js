	// This (on page load) scolls to the top of the list being viewed
	$(document).ready(function (){
		$('html, body').animate({
		scrollTop: $("#top_results").offset().top
		}, 500);
	});
	

	// This (on click of #to_top link) scolls to the top of search criteria form
	$(document).ready(function (){
		$("#bottom_results").click(function (e){
			e.preventDefault();
			$('html, body').animate({
				scrollTop: $("#top_results_search").offset().top
			}, 500);
		});
	});

	// Displays the 'Flyout' of athlete mini-profile
	$(document).ready(function (){
		$(".testme").click(function (e){
			e.preventDefault();
			$('.flyout').addClass('flyout-show');
		});
	});

	// Displays the 'Flyout' of athlete mini-profile
	$(document).ready(function (){
		$(".flyout-close").click(function (){
			$('.flyout').removeClass('flyout-show');
		});
	});



// JQUERY AJAX 'ADD RESULTS' SCRIPT-->

$(function() {

$('.testme').click(function() {

	var athleteID = $(this).data("id");
	
	$.ajax({
		url: '<?php echo base_url() . 'site/profiles_con/athleteFly/'; ?>',
		type: 'POST',
		data: '&athleteID=' + escape(athleteID),
		
		success: function(result) {
				
				$('#loading').fadeOut(500, function() {
					$(this).remove();
				});
				
				$('#showEntry').html(result);
					
			}

		});
		
		return false;
		
	});
	
});