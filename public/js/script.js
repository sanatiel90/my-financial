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
		dataJson.done(function(element){
		console.log(dataJson);	
			for(var all in element['all']){
				expenses += '<div class="row" style="background-color: #90CAF9; margin-top: 3px;" >';
				expenses += '<div class="col-md" >'+element['all'][all].description+'</div>';
				expenses += '<div class="col-md" >'+element['all'][all].value.toLocaleString('pt-BR')+'</div>';
				expenses += '<div class="col-md" >'+formatMyDate(element['all'][all].data, '/')+'</div>';
				expenses += '<div class="col-md" >'+element['all'][all].name_categ+'/'+element['all'][all].name_sub_categ+'</div>'; 				
				expenses += '</div>';
			}

			for(var cat in element['categ']){
				categories += '<div class="row" style="background-color: #90CAF9; margin-top: 3px;" >';
				categories += '<div class="col-md" >'+element['categ'][cat].name_categ+'/'+element['categ'][cat].name_sub_categ+'</div>';
				categories += '<div class="col-md" >'+element['categ'][cat].sumCateg.toLocaleString('pt-BR')+'</div>'; 				
				categories += '</div>';	
			}	
		});


		$('#detail-month-title').html(month);
		$('#detail-month-exp').html(expenses);
		$('#detail-month-categ').html(categories);
	});


	function formatMyDate(date, separator){
		let year = date.substring(0, 4);
		let month = date.substring(5, 7);
		let day = date.substring(8, 10);
		let formattedDate = day+separator+month+separator+year;
		return formattedDate;
	}


});