@extends('layout')

@section('content')
    <div class="card-glass">
        <div class="row">
            <div class="pull-left">
                <h2>Configurações do Email</h2>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Email que será notificado sobre novo cadastro:</strong>
                    {{ $config->email }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Mensagem do Email de Ativação:</strong>
                    <div>{!! $config->corpo_email !!}</div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-right d-flex">
                        <a class="btn btn-primary d-flex-inline" href="{{ route('configs.edit', $config->id) }}"><i class="icofont-ui-edit"></i> Editar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
