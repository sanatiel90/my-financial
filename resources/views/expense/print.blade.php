<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Pdf MyFinancial</title>
</head>
<body>
<table>



	<br><br><br>
	<tr>
		<td>PHP</td>
		<td>Java</td>
		<td>JS</td>
	</tr>
	<tr>
		<td>Laravel</td>
		<td>Spring</td>
		<td>React</td>
	</tr>
</table>

	@foreach($expenses as $k)
		<p>{{$k->description}}</p>

	@endforeach



</body>
</html>
