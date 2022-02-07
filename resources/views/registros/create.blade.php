@extends('layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Adicionar Novo Registro</h2>
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

    <form action="{{ route('registros.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>CPF:</strong>
                    <input type="text" name="CPF" class="form-control" placeholder="CPF" value="{{ old('CPF') }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Nome:</strong>
                    <input type="text" name="Nome" class="form-control" placeholder="Nome" value="{{ old('Nome') }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Login:</strong>
                    <input type="text" name="Login" class="form-control" placeholder="Login" value="{{ old('Login') }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Data Limite:</strong>
                    <input type="datetime-local" name="Data_limite" class="form-control" placeholder="Data Limite" value="{{ old('Data_limite') ? date('Y-m-d\TH:i', strtotime(old('Data_limite'))) : '' }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Data Última Entrada:</strong>
                    <input type="datetime-local" name="Data_ult_ent" class="form-control"
                        placeholder="Data Última Entrada" value="{{ old('Data_ult_ent') ? date('Y-m-d\TH:i', strtotime(old('Data_ult_ent'))) : ''  }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Cod Admin:</strong>
                    <input type="text" name="Cod_admin" class="form-control" placeholder="Cod Admin" value="{{ old('Cod_admin') }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Email:</strong>
                    <input type="email" name="Email" class="form-control" placeholder="Email" value="{{ old('Email') }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Telefone:</strong>
                    <input type="tel" name="Telefone" class="form-control" placeholder="Telefone" value="{{ old('Telefone') }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
        </div>

    </form>
@endsection
