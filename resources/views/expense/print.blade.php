
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>PDF MyFinancial</title>
</head>
<style type="text/css">
	.tab-style{
		border-collapse: collapse;
    	width: 100%;
	}

	.tab-style td, {
    border: 1px solid #ddd;
    padding: 8px;
	}
	.tab-style tr:nth-child(even){background-color: #f2f2f2;}

</style>
<body>
<h2 style="text-align: center;">MyFinancial - Relatório de despesas do mês</h2>
<h3 style="text-align: center;">
	<strong >Usuário:</strong> {{$expenses['user']}} &nbsp; &nbsp; &nbsp;
	<strong >Mês de referência:</strong> {{$expenses['month']}}
</h3>

<h4><strong>Total de despesas por categoria</strong></h4>
<table class="tab-style">
	@foreach($expenses['categ'] as $k => $v)
		<tr>
			<td>{{$v->name_categ}}/{{$v->name_sub_categ}}</td>
			<td>{{number_format($v->sumCateg, 2, ',', '.')}}</td>
		</tr>
	@endforeach
</table>
<h4><strong>Gasto Total: {{number_format($expenses['total'], 2, ',', '.')}}</strong></h4>

<h4><strong>Todas as despesas do mês</strong></h4>
<table class="tab-style">
	@foreach($expenses['all'] as $k => $v)
		<tr>
			<td>{{$v->description}}</td>
			<td>{{number_format($v->value, 2, ',', '.')}}</td>
			<td>{{ date('d/m/Y', strtotime($v->data)) }}</td>
			<td>{{$v->name_categ}}/{{$v->name_sub_categ}}</td>
		</tr>
	@endforeach

</table>

</body>
</html>


