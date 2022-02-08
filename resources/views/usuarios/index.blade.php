@extends('layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Usuarios</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('usuarios.create') }}"> Criar novo Usuario</a>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <script>toastr.success('{{ $message }}')</script>
    @endif

    <hr>

    <table id="table" name="table" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Perfil</th>
                <th>Criador</th>
                <th width="280px">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->id }}</td>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ $usuario->perfil }}</td>
                    <td>{{ $usuario->criador }}</td>
                    <td>
                        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST">

                            <a class="btn btn-info"
                                href="{{ route('usuarios.show', $usuario->id) }}">Mostrar</a>

                            <a class="btn btn-primary"
                                href="{{ route('usuarios.edit', $usuario->id) }}">Editar</a>

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">Apagar</button>
                        </form>
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
                <th>Criador</th>
                <th width="280px">Action</th>
            </tr>
        </tfoot>
    </table>

    {{-- {!! $registros->links() !!} --}}

@endsection
