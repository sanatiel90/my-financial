@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <p>
                        <strong>Todas as Despesas</strong>  
                        &nbsp;
                        <a href="{{ route('new_expense') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Nova Despesa</a> 
                    </p>   
                    

                    <div class="row" id="div-exp-filter-1" >
                        <div class="col-md">
                            <label>Filtros de pesquisa</label>
                            <form action="{{ route('search_expense') }}" method="GET" class="form form-inline">    
                                @csrf
                                <div class="form-group row">                               
                                <input type="text" name="filt_desc" value="{{ old('filt_desc') }}" placeholder="Descrição" class="form-control"> &nbsp;&nbsp;
                                <input type="date" name="filt_dat" class="form-control"> &nbsp;&nbsp;
                                <select name="filt_cat" class="form-control">
                                    <option value="0">--Selecione Categoria</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name_categ }}/{{ $category->name_sub_categ }}</option>
                                    @endforeach 
                                </select> &nbsp;&nbsp;
                                <button type="submit" class="btn btn-md btn-primary">Pesquisar</button>
                                </div>
                                <div class="form-group row" style="margin-top: 10px;">

                                <select name="filt_order" class="form-control">
                                            <option value="last">Últimas adicionadas</option>
                                            <option value="first" >Primeiras adicionadas</option>
                                            <option value="desc" >Descrição</option>
                                            <option value="cat" >Categoria</option>
                                            <option value="val_max" >Maior valor</option>
                                            <option value="val_min" >Menor valor</option>
                                            <option value="dat" >Data da despesa</option>
                                </select> &nbsp;&nbsp;
                                <label>Itens por página</label> &nbsp;
                                <select name="filt_itens_pag" class="form-control">
                                            <option>20</option>
                                            <option>10</option>
                                            <option>30</option>
                                            <option>50</option>
                                 </select>
                             </div>
                            </form>
                        </div>
                    </div>

                    
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

                     @if(isset($expenses))
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
                            <div class="row justify-content-center" style="margin-top: 10px;">
                                @if(isset($dataForm))
                                    {{ $expenses->appends($dataForm)->links() }}
                                @else
                                    {{ $expenses->links() }}
                                @endif
                                
                            </div> 
                     @else
                           <p>Você não possui despesas cadastradas</p>
                     @endif    
					
                </div>

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
