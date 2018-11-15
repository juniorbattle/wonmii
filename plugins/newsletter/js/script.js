$( document ).ready(function() {

	$('.closeNewsletter').click(function(){
		 $('.newsletter').animate({"right": '-300'});
		 $(this).hide();
		 $('.openNewsletter').show();
	});
	
	$('.openNewsletter').click(function(){
		 $('.newsletter').animate({"right": '0'});
		 $(this).hide();
		  $('.closeNewsletter').show();
	});
	
	$('#form_newsletter').validate({
		rules: {
			"nom": {required: true},
			"email": {email: true, required: true},
			"message": {required: true},
		},
		messages: {
			"nom": {required: "Veuillez compléter ce champ."},
			"email": {email: "Veuillez compléter correctement ce champ.", required: "Veuillez compléter ce champ."},
			"message": {required: "Veuillez compléter ce champ."},
		},
		highlight: function (element) {
			$(element).removeClass('valid').addClass('error');
		},
		success: function (element) {
			element.text('').addClass('valid').closest('.control-group').removeClass('error').addClass('success');
		},
		errorPlacement: function (error, element) {
			error.insertAfter(element);
		},
		submitHandler: function() { 
					
			var $form = $("#form_newsletter");
			var formdata = (window.FormData) ? new FormData($form[0]) : null;
			var data = (formdata !== null) ? formdata : $form.serialize();
			
			$.ajax({
                url: $form.attr('action'),
				type: $form.attr('method'),
				contentType: false, 
				processData: false,
				dataType: 'html', 
				data: data,
                success: function(html) {
					$("#form_newsletter").hide();					
                    $('.validation-newsletter').fadeIn();
					$('.closeNewsletter').click();
                }
            });
		}
	});  
	
});