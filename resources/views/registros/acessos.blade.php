@extends('layout')

@section('content')
<style>
    .loader_email{
        position:fixed;
        left:0;right:0;top:0;bottom:0;
        background-color: rgba(255,255,255,0.7);
        z-index:9999;
        display:none;
    }
</style>
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
<lottie-player class="loader_email" id="loader_email" src="https://assets1.lottiefiles.com/datafiles/OisWNdtMtC7TR1b/data.json"  background="transparent"  speed="1"  style="width: 100vw; height: 100vh;"  loop  autoplay></lottie-player>
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
            @if (isset($acessos))
                @foreach ($acessos as $acesso)
                    <tr>
                        <td>{{ $acesso->ID_usuario }}</td>
                        <td>{{ $acesso->Nome }}</td>
                        <td>{{ $acesso->Email }}</td>
                        <td><button type="button" class="btn btn-success flex-inline flex-grow-1" data-toggle="modal"
                                data-target="#exampleModal" data-nome="{{ $acesso->Nome }}"
                                data-id="{{ $acesso->ID_usuario }}" data-email="{{ $acesso->Email }}"><i
                                    class="icofont-ui-delete"></i>
                                <i class="fa-sharp fa-solid fa-paper-plane"></i></button>
                            {{-- <a class="btn btn-warning" href="{{ route('email', $acesso->ID_usuario) }}"><i class="fa-sharp fa-solid fa-paper-plane"></i></a> --}}
                        </td>
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
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary d-flex-inline" data-bs-dismiss="modal"><i class="icofont-close"></i>
            Fechar</button>
        <button type="submit" class="btn btn-danger d-flex-inline"><i class="icofont-ui-delete"></i>
            Apagar</button>
        </form>
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
                                <label for="message-text" class="col-form-label">Menssagem:</label>
                                <textarea class="form-control" id="message-text"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="submit">Enviar</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
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
                })

                $('#submit').on('click', function(e) {
                    e.preventDefault();
                    $('#loader_email').show()

                    let id = $('#recipient-id').val();
                    let mensagem = $('#message-text').val();

                    $.ajax({
                        url: "/email",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id: id,
                            mensagem: mensagem,
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
    @endsection
