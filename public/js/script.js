$(document).ready(function(){
	$('.bt-del-exp').on('click', function(){
		let id = $(this).val();
		$('#inp-del-exp').val(id); 
	});

	$('.bt-del-cat').on('click', function(){
		let id = $(this).val();
		$('#inp-del-cat').val(id); 
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

			for(var all in element['all']){
				var valor = element['all'][all].value.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
				expenses += '<div class="row" style="background-color: #90CAF9; margin-top: 3px;" >';
				expenses += '<div class="col-md" >'+element['all'][all].description+'</div>';
				expenses += '<div class="col-md" >'+valor+'</div>';
				expenses += '<div class="col-md" >'+formatMyDate(element['all'][all].data, '/')+'</div>';
				expenses += '<div class="col-md" >'+element['all'][all].name_categ+'/'+element['all'][all].name_sub_categ+'</div>'; 				
				expenses += '</div>';
			}

			for(var cat in element['categ']){
				var soma = element['categ'][cat].sumCateg.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
				categories += '<div class="row" style="background-color: #90CAF9; margin-top: 3px;" >';
				categories += '<div class="col-md" >'+element['categ'][cat].name_categ+'/'+element['categ'][cat].name_sub_categ+'</div>';
				categories += '<div class="col-md" >'+soma+'</div>'; 				
				categories += '</div>';	
			}	
		
		//gráfico do mês
		// Load the Visualization API and the piechart package.
   		google.charts.load('current', {'packages':['corechart']});
      
    	// Set a callback to run when the Google Visualization API is loaded.
    	google.charts.setOnLoadCallback(drawChart);

    	// Create our data table out of JSON data loaded from server.
      	function drawChart(){
      		var data = new google.visualization.DataTable(element['graf']);

      		var options = {'width':400,
            	           'height':150};

      		// Instantiate and draw our chart, passing in some options.
      		var chart = new google.visualization.ColumnChart(document.getElementById('chart-div-detail'));
      		chart.draw(data, options);
        }

		}); //dataJson.done


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