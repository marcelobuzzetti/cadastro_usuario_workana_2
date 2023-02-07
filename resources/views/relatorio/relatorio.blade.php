@extends('layout')

@section('content')
    <div class="card-glass">
        <div class="text-center">
            @if (isset($dataInicio))
                <h2>Relatótio do período de {{ $dataInicio }} a {{ $dataFim }}</h2>
            @else
                <h2>Relatótio de todo o Período</h2>
            @endif
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
                        <th>Enviar Email</th>
                        {{-- <th>IP</th>
                        <th>Usuário que cadastrou</th> --}}
                        <th width="280px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($registros))
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
                                <td><button type="button" class="btn btn-success flex-inline flex-grow-1" data-toggle="modal"
                                        data-target="#exampleModal" data-nome="{{ $registro->Nome }}"
                                        data-id="{{ $registro->ID_usuario }}" data-email="{{ $registro->Email }}"><i
                                            class="icofont-ui-delete"></i>
                                        <i class="fa-sharp fa-solid fa-paper-plane"></i></button></td>
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
                        <th>Enviar Email</th>
                        {{-- <th>IP</th>
                        <th>Usuário que cadastrou</th> --}}
                        <th width="280px">Action</th>
                    </tr>
                </tfoot>
            </table>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Novo Email</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="email_acesso">
                                <input type="hidden" name="" id="recipient-id">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Para:</label>
                                    <input type="text" class="form-control" id="recipient-nome">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Assunto:</label>
                                    <input type="text" class="form-control" id="recipient-assunto">
                                </div>
                                <div class="form-group">
                                    <label for="message-text" class="col-form-label">Menssagem:</label>
                                    <textarea class="form-control" id="message-text"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary" id="submit">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function() {
                    $('#loader_email').hide()
                    $('#exampleModal').on('show.bs.modal', function(event) {
                        var button = $(event.relatedTarget) // Button that triggered the modal
                        var nome = button.data('nome') // Extract info from data-* attributes
                        var email = button.data('email') // Extract info from data-* attributes
                        var id = button.data('id') // Extract info from data-* attributes
                        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                        var modal = $(this)
                        modal.find('.modal-title').text('Email para ' + nome)
                        modal.find('.modal-body #recipient-nome').val(email)
                        modal.find('.modal-body #recipient-id').val(id)
                        modal.find('.modal-body #recipient-assunto').val("Contato")
                    })

                    $('#submit').on('click', function(e) {
                        e.preventDefault();
                        $('#loader_email').show()

                        let id = $('#recipient-id').val();
                        let mensagem = $('#message-text').val();
                        let assunto = $('#recipient-assunto').val();

                        $.ajax({
                            url: "/email",
                            type: "POST",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                id: id,
                                mensagem: mensagem,
                                assunto: assunto,
                            },
                            success: function(response) {
                                toastr.success(response.success)
                                console.log(response);
                                $('#exampleModal').modal('toggle');
                                $('#loader_email').hide()
                                $("#email_acesso")[0].reset();
                            },
                            error: function(response) {
                                toastr.error(response.error)
                                console.log(response);
                                $('#exampleModal').modal('toggle');
                                $('#loader_email').hide()
                                $("#email_acesso")[0].reset();
                            },
                        });
                    });
                })
            </script>
        </div>
        <div class="row mt-2">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right d-flex">
                    <a class="btn btn-primary d-flex-inline" href="{{ route('relatorio') }}"><i
                            class="icofont-arrow-left"></i> Voltar</a>
                </div>
            </div>
        </div>
    </div>
@endsection
