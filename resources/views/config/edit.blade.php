@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left d-flex justify-content-center">
                    <h2>Editar Email de Ativação</h2>
                </div>
            </div>
        </div>
        <form action="{{ route('configs.update', $config->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 mb-2">
                    <div class="form-group">
                        <strong>Email para Notificação</strong>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Digite o Email para Notificação"
                            value="{{ old('email') ? old('email') : $config->email }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 mb-2">
                    <div class="form-group">
                        <strong>Corpo do Email</strong>
                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Digite a mensagem central do email de Ativação"
                            value="{{ old('corpo_email') ? old('corpo_email') : $config->corpo_email }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 mb-2">
                    <div class="form-group">
                        <strong>Link do Arquivo de Instruções</strong>
                        <input type="url" name="link" class="form-control @error('link') is-invalid @enderror"
                            placeholder="Digite o Link do Arquivo de Instruções"
                            value="{{ old('link') ? old('link') : $config->link }}">
                        @error('link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mb-2 text-center d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary d-flex-inline"><i class="icofont-save"></i>
                        Atualizar</button>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-right d-flex">
                        <a class="btn btn-primary d-flex-inline" href="{{ route('configs.show', $config->id) }}"><i
                                class="icofont-arrow-left"></i> Voltar</a>
                    </div>
                </div>
            </div>
@endsection
