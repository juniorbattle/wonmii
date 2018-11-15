;(function () {

	'use strict';

	// Counter
	var counter = function() {
		$('.js-counter').countTo({
			 formatter: function (value, options) {
	      return value.toFixed(options.decimals);
	    },
		});
	};

	// Animate Counter
	var animateCounter = function() {
		if ( $('#counter-animate').length > 0 ) {
			$('#counter-animate .to-animate').each(function(k){

				var el = $(this);

				setTimeout ( function () {
					el.addClass('fadeInUp animated');
				},  k * 200, 'easeInOutExpo' );
			});
		}
	}

	var counterWayPoint = function() {
		if ($('#counter-animate').length > 0 ) {
			$('#counter-animate').waypoint( function( direction ) {

				if( direction === 'down' && !$('#counter-animate').hasClass('animated') ) {

					setTimeout( animateCounter , 200);
					setTimeout( counter , 400);

					$('#counter-animate').addClass('animated');

				}
			} , { offset: '90%' } );
		}
	};

	$(function(){
		counterWayPoint();
	});

}());
