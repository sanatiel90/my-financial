 @extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header"><strong>Editar Despesa</strong></div>

                <div class="card-body">
                    <form  method="POST" action="{{ route('update_expense') }}">
                        @csrf

                         <div class="form-group row">
                            <label for="desc" class="col-sm-4 col-form-label text-sm-right">{{ __('Descrição') }}</label>

                            <div class="col-sm-6">
                                <input id="desc" type="text" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" value="{{ $expense->description }}" required autofocus>

                                @if ($errors->has('description'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="val" class="col-sm-4 col-form-label text-sm-right">{{ __('Valor') }}</label>

                            <div class="col-sm-6">
                                <input id="val" type="text" pattern="[0-9.]+" title="Apenas valores numéricos. Use ponto para separar casas decimais" class="form-control{{ $errors->has('value') ? ' is-invalid' : '' }}" name="value" value="{{ $expense->value }}" required >

                                @if ($errors->has('value'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('value') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cat" class="col-sm-4 col-form-label text-sm-right">{{ __('Categoria') }}</label>

                            <div class="col-sm-6">
                                <select name="category_id" class="form-control">
                                    @foreach($categories as $category)
                                        @if($category->id != $expense->category_id)
                                            <option value="{{ $category->id }}"> {{ $category->name_categ }}/{{ $category->name_sub_categ }} </option>
                                        @else
                                            <option selected value="{{ $category->id }}"> {{ $category->name_categ }}/{{ $category->name_sub_categ }} </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="dat" class="col-sm-4 col-form-label text-sm-right">{{ __('Data') }}</label>

                            <div class="col-sm-6">
                                <input id="dat" type="date" class="form-control{{ $errors->has('data') ? ' is-invalid' : '' }}" name="data" value="{{ $expense->data }}" required autofocus>
                                <input type="hidden" name="expense_id" value="{{ $expense->id }}">

                                @if ($errors->has('data'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('data') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-sm-6 offset-sm-4">
                                <button type="submit" class="btn btn-success">
                                    Atualizar
                                </button>
                                &nbsp;
                                <button type="reset" class="btn btn-default">
                                    Cancelar
                                </button>
                            </div>
                        </div>


                    </form>                    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

