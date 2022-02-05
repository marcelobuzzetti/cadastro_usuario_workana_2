@extends('layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Editar Registro</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('registros.index') }}">Voltar</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Tem alguma coisa errada com as entradas.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('registros.update',$registro->ID_usuario) }}" method="POST">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>CPF:</strong>
                    <input type="text" name="CPF" class="form-control" placeholder="CPF" value="{{ $registro->CPF }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Nome:</strong>
                    <input type="text" name="Nome" class="form-control" placeholder="Nome"  value="{{ $registro->Nome }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Login:</strong>
                    <input type="text" name="Login" class="form-control" placeholder="Login"  value="{{ $registro->Login }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Data Inicial:</strong>
                    <input type="datetime-local" name="Data_inicial" class="form-control" placeholder="Data Inicial" value="{{ date('Y-m-d\TH:i', strtotime($registro->Data_Inicial)) }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Data Limite:</strong>
                    <input type="datetime-local" name="Data_limite" class="form-control" placeholder="Data Limite" value="{{ date('Y-m-d\TH:i', strtotime($registro->Data_limite)) }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Data Última Entrada:</strong>
                    <input type="datetime-local" name="Data_ult_ent" class="form-control"
                        placeholder="Data Última Entrada" value="{{ date('Y-m-d\TH:i', strtotime($registro->Data_ult_ent)) }}">
                </div>
            </div>
           {{--  <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Contador:</strong>
                    <input type="number" name="Contador" class="form-control" placeholder="Contador" value="{{ $registro->Contador }}">
                </div>
            </div> --}}
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Origem Registro:</strong>
                    <input type="text" name="Origem_registro" class="form-control" placeholder="Origem Registro" value="{{ $registro->Origem_registro }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Cod Admin:</strong>
                    <input type="text" name="Cod_admin" class="form-control" placeholder="Cod Admin" value="{{ $registro->Cod_Admin }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Email:</strong>
                    <input type="email" name="Email" class="form-control" placeholder="Email" value="{{ $registro->Email }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Telefone:</strong>
                    <input type="tel" name="Telefone" class="form-control" placeholder="Telefone" value="{{ $registro->Telefone }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
        </div>

    </form>
@endsection
