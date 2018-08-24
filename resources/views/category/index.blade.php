@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <p>
                        <strong>Todas as Categorias</strong>  
                        &nbsp;
                        <a href="{{ route('new_category') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Nova Categoria</a> 
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

                     @if(count($categories) > 0)
                                <div class="row">
                                    <div class="col-md-3"><strong>Nome</strong> </div>
                                    <div class="col-md-2"><strong>Sub-nome</strong> </div>
                                    <div class="col-md-3"><strong>Descrição</strong> </div>
                                    <div class="col-md-2"><strong>Ações</strong> </div>                           
                                </div>
                            @foreach($categories as $category) 
                                <div class="row" style="background-color: #90CAF9; margin-top: 3px;">
                                    <div class="col-md-3">{{ $category->name_categ }}</div>
                                    <div class="col-md-2">{{ $category->name_sub_categ  }}</div>
                                    <div class="col-md-3">{{ $category->description }}</div>
                                    <div class="col-md-2"> 
                                        <button  value="{{ $category->id }}" class="btn btn-sm btn-danger bt-del-cat" data-toggle="modal" data-target="#exampleModal"><i class="far fa-trash-alt"></i></button>
                                    </div>                           
                                </div>
                            @endforeach
                             
                     @else
                           <p>Não foram encontradas categorias</p>
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
        <h5 class="modal-title text-center" id="exampleModalLabel">Confirma a exclusão da categoria (Ela só poderá ser excluída se não estiver sendo usada)?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
             
      <div class="modal-footer">
        <form action="{{ route('delete_category' ) }}" method="POST">
            @csrf          
            <input type="hidden" name="id"  id="inp-del-cat">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-success">Excluir</button>
        </form>       
      </div>
    </div>
  </div>
</div>



@endsection
