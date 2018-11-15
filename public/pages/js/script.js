var editor = new MediumEditor('.editable', {
    buttonLabels: 'fontawesome',
    elementsContainer: document.getElementById('containerPreviewPage')
});

$(document).ready(function () {
  $('.showCode').click(function(){
    $('textarea.code').html($('.previewHTML').html());
    $('.codePreviewPage').show();
  });

  $('.removeCodePreview').click(function(){
    $('.codePreviewPage').hide();
  });

  $('.savePreviewDesign').click(function(){
    $('textarea.code').html($('.previewHTML').html());
    $('form[name="PreviewPageForm"]').submit();
  });

  $('.showPop').click(function(){
    $('.popUpPage').show();
  });

  $('.removePopUp').click(function(){
    $('.popUpPage').hide();
  });

  $('.actvLangContent').click(function(){
    lang = $(this).attr('data-value');
    $('.blogTextContent').addClass('hide');
    $('.actvLangContent').removeClass('active');
    $(this).addClass('active');
    $('.blogTextContent.' + lang).removeClass('hide');
  });

  if($.urlParam('idGallery') || $.urlParam('idBlog')) {
		$('.showPop').click();
	}

});
