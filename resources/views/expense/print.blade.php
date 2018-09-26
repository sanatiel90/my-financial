<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Pdf MyFinancial</title>
</head>
<body>
<h3>Total de despesas por categoria</h3>	
<table>
	@foreach($expenses['categ'] as $k=>$v)
		<tr>
			<td>{{$v->name_categ}}/{{$v->name_sub_categ}}</td>
			<td>{{$v->sumCateg}}</td>
		</tr>
	@endforeach
</table>

<h3>Todas as despesas do mês</h3>	
<table>
	@foreach($expenses['all'] as $k=>$v)
		<tr>
			<td>{{$v->description}}</td>
			<td>{{$v->value}}</td>
			<td>{{$v->name_categ}}/{{$v->name_sub_categ}}</td>
		</tr>
	@endforeach
</table>

	


</body>
</html>
