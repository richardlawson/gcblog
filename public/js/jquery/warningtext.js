$(function(){
// Dialog			
	$('.warningtext').dialog({
		autoOpen: false,
		width: 400
	});
	
	// Dialog Link
	$('.warninglink').click(function(e){
		e.preventDefault();
		var id = $(this).attr('id'); 
		$('#' + id + '-text').dialog('open');
	});

});