@extends('layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Usuarios</h2>
            </div>
        </div>
    </div>
    <hr>

    <table id="table" name="table" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Perfil</th>
                <th>Cadastro Web</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->id }}</td>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ $usuario->perfil }}</td>
                    <td>{{ $usuario->is_web ? 'Sim' : 'Não' }}</td>
                    <td>
                        <form action="{{ route('ativar') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="{{ $usuario->id }}">
                            <button type="submit" class="btn btn-info">Ativar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Perfil</th>
                <th>Cadastro Web</th>
                <th>Action</th>
            </tr>
        </tfoot>
    </table>

    {{-- {!! $registros->links() !!} --}}

@endsection
