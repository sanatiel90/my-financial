$(document).ready(function(){
	$('.bt-del-exp').on('click', function(){
		let id = $(this).val();
		$('#inp-del-exp').val(id); 
	});


	$('.bt-detail-month').on('click', function(){
		let month = $(this).val();

		var dataJson = $.ajax({
			url: '/expenses/monthly/detail',
			data: {'month':month},
			dataType: "json",
          	async: false
		});
		
		var expenses = "";
		var categories = "";
		dataJson.always(function(element){
			
			for(var all in element['all']){
				expenses += '<div class="row" style="background-color: #90CAF9; margin-top: 3px;" >';
				expenses += '<div class="col-md" >'+element['all'][all].description+'</div>';
				expenses += '<div class="col-md" >'+element['all'][all].value+'</div>';
				expenses += '<div class="col-md" >'+element['all'][all].category_id+'</div>'; 				
				expenses += '</div>';
			}

			for(var cat in element['categ']){
				categories += '<div class="row" style="background-color: #90CAF9; margin-top: 3px;" >';
				categories += '<div class="col-md" >'+element['categ'][cat].name_categ+'/'+element['categ'][cat].name_sub_categ+'</div>';
				categories += '<div class="col-md" >'+element['categ'][cat].sumCateg+'</div>'; 				
				categories += '</div>';	
			}	
		});


		$('#detail-month-title').html(month);
		$('#detail-month-exp').html(expenses);
		$('#detail-month-categ').html(categories);
	});

});