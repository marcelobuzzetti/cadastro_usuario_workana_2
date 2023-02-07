@extends('layout')

@section('content')
@if (isset($error))
<script>toastr.error('{{ $error }}')</script>
@endif
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left d-flex justify-content-center">
                    <h2>Criar Email de Ativação</h2>
                </div>
            </div>
        </div>
        <form action="{{ route('configs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                    <div class="form-group">
                        <strong>Email para Notificação de Novo Cadastro</strong>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Digite o Email para Notificação" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <p>Para que sejam exbidas informações do banco de dados favor inserir conforme abaixo:</p>
                    <p>[cpf] = Exibe o CPF do usuário - [nome] = Exibe o Nome do usuário</p>
                    <p>[login] = Exibe o Login do usuário - [data_inicial] = Exibe a Data Inicial do usuário</p>
                    <p>[data_limite] = Exibe a Data Limite do usuário - [data_ult_ent] = Exibe a Data da última entrada do usuário</p>
                    <p>Exemplo: Nome do Usuário [nome], irá aparecer Nome de Usuário 1234567</p>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                    <div class="form-group">
                        <strong>Corpo do Email</strong>
                        {{-- <textarea name="corpo_email" class="form-control @error('corpo_email') is-invalid @enderror" rows="10">{{ old('corpo_email') }}</textarea> --}}
                        <textarea name="corpo_email" id="corpo_email" rows="10" cols="80">{{ old('corpo_email') }}</textarea>
                        @error('corpo_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </form>
            <div class="col-xs-12 col-sm-12 col-md-12 mb-2 text-center d-flex justify-content-center">
                <button type="submit" class="btn btn-primary d-flex-inline"><i class="icofont-save"></i>
                    Cadastrar</button>
            </div>
        </div>
    </div>
    <script>$(document).ready(function() {
            CKEDITOR.replace( 'corpo_email', {
                    filebrowserUploadUrl: "{{route('ckeditor.image-upload', ['_token' => csrf_token() ])}}",
                    filebrowserUploadMethod: 'form'
                });
        });
    </script>
@endsection
