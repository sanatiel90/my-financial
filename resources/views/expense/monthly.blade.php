@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header">
                    <p>
                        <strong>Total de gastos por mês</strong>  
                    </p>                       

                </div> <!-- card-header -->

                <div class="card-body">
                     @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
                                <span aria-hidden="true">&times;   </span> 
                            </button>
                        </div>
                     @endif

                     @if(count($lastExpensesMonthly) > 0)
                                <div class="row">
                                    <div class="col-sm"><strong>Mês</strong> </div>
                                    <div class="col-sm"><strong>Total</strong> </div>
                                    <div class="col-sm"><strong></strong> </div>
                                </div>
                            @foreach($lastExpensesMonthly['sum'] as $k =>$v)  
                                <div class="row" style="background-color: #90CAF9; margin-top: 3px;">
                                    <div class="col-sm">{{ $v->month }}</div>
                                    <div class="col-sm">{{ number_format($v->sumExp, 2, ',', '.')  }}</div>
                                    <div class="col-sm"><strong><button value="{{ $v->month }}" data-toggle="modal" data-target="#exampleModalLong" class="btn btn-sm btn-success bt-detail-month">Detalhar</button></strong> </div>                           
                                </div>
                            @endforeach
                            	<div class="row" style="background-color: #40C4FF; margin-top: 3px;">
                                    <div class="col-sm">Média de gasto</div>
                                	<div class="col-sm">{{$lastExpensesMonthly['avg']}}</div>
                                	<div class="col-sm"><strong></strong> </div>   
                                </div>
                     @else
                           <p>Não foram encontradas despesas</p>
                     @endif    
					
                </div>

            </div>
        </div>
    </div>

<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong><p id="detail-month-title"></p></strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card">
        	<div class="card-header">
        		<label>Total de despesas por categoria</label>
        	</div>
        	<div class="card-body" id="detail-month-categ">
        	</div>
          <div>
            <div id="chart-div-detail"></div>
          </div>
        </div>
        <br>
        <div class="card">
        	<div class="card-header">
        		<label>Todas as despesas do mês</label>
        	</div>
        	<div class="card-body" id="detail-month-exp">
        	</div>
        </div>

      </div>
      <div class="modal-footer">
        <form action="{{route('monthly_print')}}" >
            @csrf
            <input type="hidden" name="month-print" id="inp-print-month">
            <button type="submit" class="btn btn-success" >Imprimir</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
