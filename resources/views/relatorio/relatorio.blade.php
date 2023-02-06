@extends('layout')

@section('content')
    <div class="card-glass">
        <div class="text-center">
            @if (isset($dataInicio))
                <h2>Balanço do período de {{ $dataInicio }} a {{ $dataFim }}</h2>
            @else
                <h2>Balanço de todo o Período</h2>
            @endif
            <h4 class="text-success">Recebido R${{ sprintf('%0.2f', $totalOrcamentosGerado) }} <i class="icofont-arrow-up"></i></h4>
            <h4 class="text-danger">Despesas R${{ sprintf('%0.2f', $totalPecasGerado) }} <i class="icofont-arrow-down"></i></h4>
            <h4 class="text-success">Total</h4>
            <h3 class="text-success"><i class="icofont-bank"></i> R${{ sprintf('%0.2f', $balancoGerado) }} <i class="icofont-bank"></i></h3>
        </div>
        <div class="row mt-2">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right d-flex">
                    <a class="btn btn-primary d-flex-inline" href="{{ route('balanco.index') }}"><i
                            class="icofont-arrow-left"></i> Voltar</a>
                </div>
            </div>
        </div>
    </div>
@endsection
