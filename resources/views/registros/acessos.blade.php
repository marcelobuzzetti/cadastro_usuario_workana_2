@extends('layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Usuários que ainda não acessaram</h2>
            </div>
        </div>
    </div>

    <hr>

    <table id="table" name="table" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>ID Usuário</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Enviar Email</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($acessos))
            @foreach ($acessos as $acesso)
                <tr>
                    <td>{{ $acesso->ID_usuario }}</td>
                    <td>{{ $acesso->Nome }}</td>
                    <td>{{ $acesso->Email }}</td>
                    <td><a class="btn btn-warning"><i class="fa-sharp fa-solid fa-paper-plane"></i></a></td>
                </tr>
            @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <th>ID Usuário</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Enviar Email</th>
            </tr>
        </tfoot>
    </table>

@endsection
