/****************************************************************************/
/* CUSTOM JAVASCRIPT */
/****************************************************************************/

// Auto populate Athlete Search Input
/****************************************************************************/
var autoAthlete = function(){
	$("#athleteID").autocomplete({
		source: function(request, response) {
			$.ajax({ url: 'site/home_con/get_auto_athletes',
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
};

autoAthlete();



/****************************************************************************/
// Append selection criteria to page ...
/****************************************************************************/
// Function to create background overlay
// var clickForm = function() {
//    var docHeight = $(document).height();

//    $('body').append("<div id='overlay'></div>");
//    $('#overlay').height(docHeight).addClass('overlay');
// };

// // Function to clear background overlay
// var clickOutForm = function() {
// 	$('#overlay').remove();
// 	$('#overlay').removeClass('overlay');
// };

// // Listen for click event to add overlay
// $('.search-head > .container-class').click(function(){
// 	clickForm();
// });

// // Listen for click event to remove overlay
// $(document).on('click', function (e) {
//     if ($(e.target).closest('.search-head > .container-class').length === 0) {
//         clickOutForm();
//     }
// });





/****************************************************************************/
// Highlight the active (selected) checkbox in main search form
/****************************************************************************/
var ageGroup = $("input[name='ageGroup']"),
	ageGroupLabel = ageGroup.parent(), // Get checkbox parent label
	listDepth = $("input[name='list_depth']"),
	listDepthLabel = listDepth.parent(), // Get checkbox parent label
	listType = $("input[name='list_type']"),
	listTypeLabel = listType.parent(), // Get checkbox parent label
	recentPerf = $("input[name='time_frame']"),
	recentPerfLabel = recentPerf.parent(), // Get checkbox parent label
	gender = $("input[name='gender']"),
	genderLabel = gender.parent(); // Get checkbox parent label


// makeActive function() 
// Accepts var 'checkbox' which determinds which set of checkboxes are being targeted
var makeActive = function(checkbox) {
	$( 'input[name="' + checkbox + '"]:checked' ).parent().addClass('checkbox-active');
};

ageGroup.change(function(){
	ageGroupLabel.removeClass('checkbox-active');
	makeActive('ageGroup');
});

listDepth.change(function(){
	listDepthLabel.removeClass('checkbox-active');
	makeActive('list_depth');
});

listType.change(function(){
	listTypeLabel.removeClass('checkbox-active');
	makeActive('list_type');
});

recentPerf.change(function(){
	recentPerfLabel.removeClass('checkbox-active');
	makeActive('time_frame');
});

gender.change(function(){
	genderLabel.removeClass('checkbox-active');
	makeActive('gender');
});

makeActive('ageGroup');
makeActive('list_depth');
makeActive('list_type');
makeActive('gender');
makeActive('time_frame');



/****************************************************************************/
// Submit 'Top Permormers form on home page'
/****************************************************************************/
(function(){
	$('#topPerformers :input').change(function() {
		//alert('Handler for .change() called.');
		this.form.submit("#topPerformers");
	}); 
})();


/****************************************************************************/
// Slide Toggle Appreviations
/****************************************************************************/
// (function() {
// 	$("a.abbrevLink").on('click', function(e) {
// 		e.preventDefault();
// 		$("#abbrev").css("display","visible");
// 		$("#abbrev").slideToggle('fast');
// 	});
// })();


/****************************************************************************/
// Google Analytics
/****************************************************************************/
var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-7102098-23']);
	_gaq.push(['_trackPageview']);

(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' === document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();


/****************************************************************************/
// Reduce height of top navbar on scroll ...
/****************************************************************************/
// $( window ).scroll(function() {

// 	var //navbarFixedTop = $('.navbar-fixed-top'),
// 		navbarNavListItems = $('.navbar-nav > li > a'),
// 		navbarBrand = $('.navbar-brand'),
// 		navbar = $('.navbar'),
// 		padSmall = 15,
// 		padLarge = 25,
// 		heightSmall = 50,
// 		heightLarge = 70;

// 	if (this.pageYOffset > 200) {
// 		//navbarFixedTop.css({'position': 'fixed', 'top': 0});
// 		navbarNavListItems.css({'padding-top': padSmall, 'padding-bottom': padSmall});
// 		navbarBrand.css({'height': heightSmall, 'backgroundSize': 90});
// 		navbar.css({'min-height': 0}).addClass('navbar-fixed-top');
// 		$('body').css({'padding-top': 50});

// 		// navbarNavListItems.addClass('transition-slow');
// 		// navbarBrand.addClass('transition-slow');

// 	} else {
// 		//navbarFixedTop.css({'position': 'absolute', 'top': 0});
// 		navbarNavListItems.css({'padding-top': padLarge, 'padding-bottom': padLarge});
// 		navbarBrand.css({'height': heightLarge, 'backgroundSize': 120});
// 		navbar.css({'min-height': 50}).removeClass('navbar-fixed-top');
// 		$('body').css({'padding-top': 0});
// 	}

// });


(function() {
	jQuery(function($){
		$('table').footable();
	});
})();


