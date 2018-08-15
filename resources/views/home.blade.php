@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                        Bem vindo, {{ Auth::user()->name }} 
                        &nbsp;
                        <a href="{{ route('new_expense') }}" class="btn btn-primary btn-sm"><span>+</span> Nova Despesa</a>
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
                        @if(isset($expenses))
                            <p>Suas últimas despesas</p>
                                <div class="row">
                                    <div class="col-md-5"><strong>Descrição</strong> </div>
                                    <div class="col-md-2"><strong>Valor</strong> </div>
                                    <div class="col-md-3"><strong>Categoria</strong> </div>
                                    <div class="col-md-2"><strong>Data</strong> </div>                           
                                </div>
                            @foreach($expenses as $expense) 
                                <div class="row" style="background-color: #90CAF9; margin-top: 3px;">
                                    <div class="col-md-5">{{ $expense->description }}</div>
                                    <div class="col-md-2">{{ number_format($expense->value, 2, ',', '.')  }}</div>
                                    <div class="col-md-3">{{ $expense->category->name_categ }}/{{ $expense->category->name_sub_categ }}</div>
                                    <div class="col-md-2">{{ date('d/m/Y', strtotime($expense->data)) }}</div>                           
                                </div>
                            @endforeach
                                <div class="row justify-content-end" style="margin-top: 15px;"><a href="" class="btn btn-sm btn-success">Ver todas as despesas</a></div>
                        @else
                            <p>Você não possui despesas cadastradas</p>
                        @endif    
                        </div>
                    </div> <!-- fim card -->

                    <div class="card">
                        <div class="card-body">
                        @if(isset($expenses))
                            <p>Total de gastos por mês (mês atual: Agosto)</p>                                
                            @foreach($expenses as $expense) 
                                <div class="row" style="background-color: #90CAF9; margin-top: 3px;">
                                    <div class="col-md-2">Agosto</div>
                                    <div class="col-md-2">320,00</div>                           
                                </div>                               
                            @endforeach
                                <div class="row justify-content-end" style="margin-top: 15px;"><a href="" class="btn btn-sm btn-success">Ver todas as despesas</a></div>
                        @else
                            <p>Você não possui cadastradas em nenhum mês</p>
                        @endif    
                        </div>
                    </div> <!-- fim card -->
                    

                </div> <!-- fim card-body main -->
            </div>
        </div>
    </div>
</div>
@endsection