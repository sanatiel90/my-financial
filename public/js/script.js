$(document).ready(function(){
	$('.bt-del-exp').on('click', function(){
		var id = $(this).val();
		$('#inp-del-exp').val(id); 
	});

	$('#bt-exp-filter').on('click', function(){
		//$('#div-exp-filter-1').slideToggle();
		//$('#div-exp-filter-2').slideToggle();
	});
});