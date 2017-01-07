/****************************************************************************/
/* CUSTOM JAVASCRIPT */
/****************************************************************************/

// Moves the Vertical Search Nav Tabs to top on screen on click
/****************************************************************************/
var searchTabsTop = function(){
	var winWidth = $( window ).width();
	var offSetDist = false;

	if( winWidth <= 752 ) {
		offSetDist = -45;
	} else {
		offSetDist = 0;
	}

	$('.search-nav ul.nav.nav-pills.nav-stacked li a').on('click', function(){
		$('#annual-tab').velocity('scroll', { offset: offSetDist, duration: 200, easing: [ 0.17, 0.67, 0.83, 0.67 ]});
	});
};

searchTabsTop();


// Back to top button - returns to top of Leaders form
// ************************************************************************
var leadersSearchTop = function(){
	var winWidth = $( window ).width();
	var offSetDist = false;

	if( winWidth <= 752 ) {
		offSetDist = -55;
	} else {
		offSetDist = -10;
	}


	$("#bottom_index").on('click', function (){
		$('.lead-marks').velocity('scroll', { offset: offSetDist, duration: 500, easing: [ 0.17, 0.67, 0.83, 0.67 ]});
		return false;
	});
};

leadersSearchTop();


// Initiate FooTable function
/****************************************************************************/
(function() {
	jQuery(function($){
		$('table').footable();
	});
})();



// Highlight the active (selected) checkbox in main search form
/****************************************************************************/
(function() {
		
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

})();


// Submit 'Top Permormers form on home page'
/****************************************************************************/
(function(){
	$('#topPerformers :input').change(function() {
		this.form.submit("#topPerformers");
	}); 
})();


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


