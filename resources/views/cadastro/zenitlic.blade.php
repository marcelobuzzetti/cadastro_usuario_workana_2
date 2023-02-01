@extends('layout')

@section('content')
<div class="card-glass">
    <div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex justify-content-center">
            <div class="pull-left">
                <h2>Adicionando o {{ $cadastro->email }} na ZeniteLic</h2>
            </div>
        </div>
    </div>
    <div class="row">

    <form action="{{ route('cadastrozenitelic') }}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $cadastro->id }}">

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Nome:</strong>
                    <input class="form-control @error('Nome') is-invalid @enderror" name="Nome" id="Nome" type="text" value="{{ old('Nome') ? old('Nome') : $cadastro->nome_completo }}" placeholder="Digite o Nome ou o CPF do Cliente">
                    @error('Nome')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>CPF:</strong>
                    <input class="form-control @error('CPF') is-invalid @enderror" name="CPF" id="CPF" type="text" value="{{ old('CPF') ? old('CPF') : $cadastro->cpf }}" placeholder="Digite o Nome ou o CPF do Cliente">
                    @error('CPF')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Login:</strong>
                    <input class="form-control @error('Login') is-invalid @enderror" name="Login" id="Login" type="text" value="{{ old('Login') ? old('Login') : $cadastro->nr_conta_corretora }}" placeholder="Digite o Nome ou o CPF do Cliente">
                    @error('Login')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Data Limite:</strong>
                    <input type="datetime-local" name="Data_limite" class="form-control @error('Data_limite') is-invalid @enderror" placeholder="Data Limite" value="{{ old('Data_limite') ? date('Y-m-d\TH:i', strtotime(old('Data_limite'))) : '' }}">
                    @error('Data_limite')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Data Última Entrada:</strong>
                    <input type="datetime-local" name="Data_ult_ent" class="form-control @error('Data_ult_ent') is-invalid @enderror"
                        placeholder="Data Última Entrada" value="{{ old('Data_ult_ent') ? date('Y-m-d\TH:i', strtotime(old('Data_ult_ent'))) : ''  }}">
                    @error('Data_ult_ent')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Cod Admin:</strong>
                    <input type="text" name="Cod_admin" class="form-control @error('Cod_admin') is-invalid @enderror" placeholder="Cod Admin" value="{{ old('Cod_admin') ? old('Cod_admin') : 'Web' }}">
                    @error('Cod_admin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Email:</strong>
                    <input type="email" name="Email" class="form-control @error('Email') is-invalid @enderror" placeholder="Email" value="{{ old('Email') ? old('Email') : $cadastro->email }}">
                    @error('Email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Telefone:</strong>
                    <input type="tel" name="Telefone" class="form-control @error('Telefone') is-invalid @enderror" placeholder="Telefone" value="{{ old('Telefone') ? old('Telefone') : $cadastro->telefone }}">
                    @error('Telefone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
        </div>

    </form>
@endsection
