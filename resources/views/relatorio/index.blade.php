@extends('layout')

@section('content')
    <div class="card-glass">
        <div class="text-center">
            <h2>Acessos ao Radar</h2>
        </div>
        <hr>
        <form action="{{ route('search') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 mb-2">
                    <div class="form-group">
                        <strong>Data de Início</strong>
                        <input type="date" id="start_date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}">
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-text">Formato da data dd/mm/aaaa, ex. 01/01/2023</div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 mb-2">
                    <div class="form-group">
                        <strong>Data Fim</strong>
                        <input type="date" id="end_date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}">
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-text">Formato da data dd/mm/aaaa, ex. 01/01/2023</div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mb-2 text-center d-flex justify-content-center">
                <button type="submit" class="btn btn-primary d-flex-inline"><i class="icofont-ui-calendar"></i> Gerar</button>
            </div>
        </form>
        <hr>
        <h2 style="text-align: center;">Relatório de usuários que ainda não acessaram</h2>
        <form action="{{ route('naoacessou') }}" method="POST">
            @csrf
            <div class="col-xs-12 col-sm-12 col-md-12 mb-2 text-center d-flex justify-content-center">
                <button type="submit" class="btn btn-primary d-flex-inline"><i class="icofont-ui-calendar"></i> Gerar</button>
            </div>
        </form>
    </div>
@endsection
