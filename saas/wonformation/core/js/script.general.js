var urlMonsite = 'http://localhost/monsite/';

$(document).ready(function () {

	$('button.backTop').click(function(){
		$('body,html').animate({
			scrollTop: 0 ,
		 });
	});


	$('a[href^="#"]').click(function(e) {
		e.preventDefault();
		var target = $(this).attr('href');
		var stop = $(target).offset().top - 10;
		var delay = 500;
		$('body').animate({scrollTop: stop + 'px'}, delay);
		$('.contentMenuResponsive').slideUp();
	  });

	$('body').click(function(){
		$('.menuLangues').hide();
		$('.contentMenuResponsive').slideUp();
	});

	$('.mainLang').click(function(e){
		e.stopPropagation();
		$('.menuLangues').toggle();
	});

	$('.menuLangues').click(function(e){
		e.stopPropagation();
	});

	$('.buttonMenuResponsive').click(function(e){
		e.stopPropagation();
		if($('.contentMenuResponsive').css('display') == 'none')
		{
			$('.contentMenuResponsive').slideDown();
		}
		else
		{
			$('.contentMenuResponsive').slideUp();
		}

	});

	$('.contentMenuResponsive').click(function(e){
		e.stopPropagation();
	});

});
