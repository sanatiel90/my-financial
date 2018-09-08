@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header"><strong>Nova Categoria</strong></div>

                <div class="card-body">
					<form method="POST" action="{{ route('store_category') }}">
						@csrf

						 <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label text-sm-right">{{ __('Nome') }}</label>

                            <div class="col-sm-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name_categ') ? ' is-invalid' : '' }}" name="name_categ" value="{{ old('name_categ') }}" required autofocus>

                                @if ($errors->has('name_categ'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name_categ') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="sub" class="col-sm-4 col-form-label text-sm-right">{{ __('Sub-Categoria') }}</label>

                            <div class="col-sm-6">
                                <input id="sub" type="text" class="form-control{{ $errors->has('name_sub_categ') ? ' is-invalid' : '' }}" name="name_sub_categ" value="{{ old('name_sub_categ') }}" required >

                                @if ($errors->has('name_sub_categ'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name_sub_categ') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="desc" class="col-sm-4 col-form-label text-sm-right">{{ __('Descrição') }}</label>

                            <div class="col-sm-6">
                                <input id="desc" type="text" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" value="{{ old('description') }}" required >

                                @if ($errors->has('description'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>



                        <div class="form-group row mb-0">
                            <div class="col-sm-6 offset-sm-4">
                                <button type="submit" class="btn btn-success">
                                    Cadastrar
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
