$(function() {
	$.wysiwyg.init(['team[description]']);
    
	$("[name='file']").preview(function(data){
		$("[data-image='preview']").fadeIn(1000).attr('src', data);
	});
});