@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left d-flex justify-content-center">
                    <h2>Criar Email de Ativação</h2>
                </div>
            </div>
        </div>
        <form action="{{ route('configs.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                    <div class="form-group">
                        <strong>Email para Notificação</strong>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Digite o Email para Notificação" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                    <div class="form-group">
                        <strong>Corpo do Email</strong>
                        <textarea name="corpo_email" class="form-control @error('corpo_email') is-invalid @enderror" rows="10">{{ old('corpo_email') }}</textarea>
                        @error('corpo_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                    <div class="form-group">
                        <strong>Link do Arquivo de Instruções</strong>
                        <input type="url" name="link" class="form-control @error('link') is-invalid @enderror"
                            placeholder="Digite o Link do Arquivo de Instruções" value="{{ old('link') }}">
                        @error('link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
        </form>
        <div class="col-xs-12 col-sm-12 col-md-12 mb-2 text-center d-flex justify-content-center">
            <button type="submit" class="btn btn-primary d-flex-inline"><i class="icofont-save"></i>
                Atualizar</button>
        </div>
    </div>
@endsection