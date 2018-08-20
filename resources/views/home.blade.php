@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bt" >
                        Bem vindo, <strong> {{ Auth::user()->name }} </strong> 
                        &nbsp;
                        <a href="{{ route('new_expense') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Nova Despesa</a>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
                                <span aria-hidden="true">&times;   </span> 
                            </button>
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-body">    
                        @if(count($expenses) > 0)
                            <p><strong>Suas últimas despesas</strong></p>
                                <div class="row">
                                    <div class="col-md-3"><strong>Descrição</strong> </div>
                                    <div class="col-md-2"><strong>Valor</strong> </div>
                                    <div class="col-md-3"><strong>Categoria</strong> </div>
                                    <div class="col-md-2"><strong>Data</strong> </div>
                                    <div class="col-md-2"><strong>Ações</strong> </div>                           
                                </div>
                            @foreach($expenses as $expense) 
                                <div class="row" style="background-color: #90CAF9; margin-top: 3px;">
                                    <div class="col-md-3">{{ $expense->description }}</div>
                                    <div class="col-md-2">{{ number_format($expense->value, 2, ',', '.')  }}</div>
                                    <div class="col-md-3">{{ $expense->category->name_categ }}/{{ $expense->category->name_sub_categ }}</div>
                                    <div class="col-md-2">{{ date('d/m/Y', strtotime($expense->data)) }}</div>
                                    <div class="col-md-2">
                                        <a href="{{ route('show_expense.expense', $expense) }}" class="btn btn-sm btn-primary"><i class="far fa-edit"></i></a> 
                                        <button  value="{{ $expense->id }}" class="btn btn-sm btn-danger bt-del-exp" data-toggle="modal" data-target="#exampleModal"><i class="far fa-trash-alt"></i></button>
                                    </div>                           
                                </div>
                            @endforeach
                                <div class="row justify-content-end" style="margin-top: 15px;"><a href="{{ route('expenses') }}" class="btn btn-sm btn-success">Ver todas as despesas</a></div>
                        @else
                            <p>Você não possui despesas cadastradas</p>
                        @endif    
                        </div>
                    </div> <!-- fim card -->

               
                    <div class="row">                     
                        <div class="col-md">
                    
                            <div class="card">
                                <div class="card-body">
                                    @if(count($expenses) > 0)
                                        <p>Total de gastos {{$lastExpenses['limit']}}  </p>                       
                                        @foreach($lastExpenses['sum'] as $k => $v) 
                                                <div class="row" style="background-color: #90CAF9; margin-top: 3px;">
                                                <div class="col-md-6">{{$v->month}}</div>
                                                <div class="col-md-6">{{number_format($v->sumExp, 2, ',', '.')}}</div>                  
                                                </div>       
                                        @endforeach
                                            <div class="row" style="background-color: #40C4FF; margin-top: 3px;">
                                                <div class="col-md-6">Média</div>
                                                <div class="col-md-6">{{$lastExpenses['avg']}}</div>   
                                            </div>
                                            <div class="row justify-content-start" style="margin-top: 15px;"><a href="" class="btn btn-sm btn-success">Ver todos os meses</a></div>
                                    @else
                                        <p>Você não possui despesas cadastradas em nenhum mês</p>
                                    @endif    
                                </div>
                            </div> <!-- fim card -->

                        </div> <!--fim col-md -->

                        <div class="col-md">
                            <div class="card">
                                <div class="card-body">
                                    @if(count($expenses) > 0)
                                        <p>Categorias com mais despesas</p>                                
                                        <!--Div that will hold the pie chart-->
                                        <!--Div that will hold the pie chart-->
                                        <div id="chart_div"></div>

                                        <div class="row justify-content-end" style="margin-top: 15px;"><a href="" class="btn btn-sm btn-success">Ver detalhes</a></div>                                      
                                    @endif    

                                </div>
                            </div> <!-- fim card -->

                        </div> <!--fim col-md -->
                    
                    </div> <!-- fim row -->

                </div> <!-- fim card-body main -->

            </div>
        </div>
    </div>

</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Confirma a exclusão da despesa?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
             
      <div class="modal-footer">
        <form action="{{ route('delete_expense' ) }}" method="POST">
            @csrf          
            <input type="hidden" name="id"  id="inp-del-exp">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-success">Excluir</button>
        </form>       
      </div>
    </div>
  </div>

</div>


@endsection

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      
 // Load the Visualization API and the piechart package.
    google.charts.load('current', {'packages':['corechart']});
      
    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart);
      
    function drawChart() {
      var jsonData = $.ajax({
          url: "/expenses/jsonChart",
          dataType: "json",
          async: false
          }).responseText;
          
      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(jsonData);

      var options = {'title':'Gastos por Categoria',
                       'width':400,
                       'height':300};

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
    </script>

<!-- [
          ['Alimentação', 3],
          ['Onions', 1],
          ['Olives', 1],
          ['Zucchini', 1],
          ['Pepperoni', 2]
        ]-->