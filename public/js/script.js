$(document).ready(function(){
	$('.bt-del-exp').on('click', function(){
		var id = $(this).val();
		$('#inp-del-exp').val(id); 
	});

});