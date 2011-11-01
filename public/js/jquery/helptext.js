$(function(){
// Dialog			
	$('.helptext').dialog({
		autoOpen: false,
		width: 400
	});
	
	// Dialog Link
	$('.helplink').click(function(e){
		e.preventDefault();
		var id = $(this).attr('id'); 
		$('#' + id + '-text').dialog('open');
	});

});