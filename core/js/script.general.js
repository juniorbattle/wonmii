$(document).ready(function () {

	$('.slideLeftEffect').animate({"marginLeft": '0'},2000);
	$('.slideRightEffect').animate({"marginRight": '0'},2000);
	$('.slideTopEffect').animate({"marginTop": '0'},2000);
	$('.slideBottomEffect').animate({"marginBottom": '0'},2000);
	$('.fadeInEffect').animate({"opacity": 1},2000);


	$('.showContentMenus').click(function(){
		$('.contentMenus').show();
		$('.contentMenus').animate({"right": '0'},1000);
	});

	$('.hideContentMenus').click(function(){
		$('.contentMenus').animate({"right": '-500'},1000,function(){ $('.contentMenus').hide(); });
	});


	if($.urlParam('valid')) {
		$('.alert.alert-success').fadeIn('slow').delay(2000).slideUp();
	}

	if($.urlParam('error')) {
		$('.alert.alert-failed').fadeIn('slow').delay(2000).slideUp();
	}

});

$.urlParam = function(name){
	var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
	return(results)? results[1] : 0;
}
