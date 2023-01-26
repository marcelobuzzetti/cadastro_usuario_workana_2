@extends('layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Registros</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('registros.create') }}"> Criar novo Registro</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <script>toastr.success('{{ $message }}')</script>
    @endif
    @if ($message = Session::get('error'))
        <script>toastr.error('{{ $message }}')</script>
    @endif

    <hr>

    <table id="table" name="table" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>ID Usuário</th>
                <th>CPF</th>
                <th>Nome</th>
                <th>Login</th>
                <th>Data Inicial</th>
                <th>Data Limite</th>
                <th>Data Ultima Entrada</th>
                <th>Contador</th>
                <th>Origem Registro</th>
                <th>Cod Admin</th>
                <th>Email</th>
                <th>Telefone</th>
                {{-- <th>IP</th>
                <th>Usuário que cadastrou</th> --}}
                <th width="280px">Action</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($registros))
            @foreach ($registros as $registro)
                <tr>
                    <td>{{ $registro->ID_usuario }}</td>
                    <td>{{ $registro->CPF }}</td>
                    <td>{{ $registro->Nome }}</td>
                    <td>{{ $registro->Login }}</td>
                    <td>{{ $registro->Data_inicial }}</td>
                    <td>{{ $registro->Data_limite }}</td>
                    <td>{{ $registro->Data_ult_ent }}</td>
                    <td>{{ $registro->Contador }}</td>
                    <td>{{ $registro->Origem_registro }}</td>
                    <td>{{ $registro->Cod_admin }}</td>
                    <td>{{ $registro->Email }}</td>
                    <td>{{ $registro->Telefone }}</td>
                    {{-- <td>{{ $registro->IP }}</td>
                    <td>{{ $registro->name }}</td> --}}
                    <td>
                        <form action="{{ route('registros.destroy', $registro->ID_usuario) }}" method="POST">

                            <a class="btn btn-info"
                                href="{{ route('registros.show', $registro->ID_usuario) }}">Mostrar</a>

                            <a class="btn btn-primary"
                                href="{{ route('registros.edit', $registro->ID_usuario) }}">Editar</a>

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">Apagar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <th>ID Usuário</th>
                <th>CPF</th>
                <th>Nome</th>
                <th>Login</th>
                <th>Data Inicial</th>
                <th>Data Limite</th>
                <th>Data Ultima Entrada</th>
                <th>Contador</th>
                <th>Origem Registro</th>
                <th>Cod Admin</th>
                <th>Email</th>
                <th>Telefone</th>
                {{-- <th>IP</th>
                <th>Usuário que cadastrou</th> --}}
                <th width="280px">Action</th>
            </tr>
        </tfoot>
    </table>

    {{-- {!! $registros->links() !!} --}}

@endsection
