@extends('layout')

@section('content')
    <style>
        .loader_email {
            position: fixed;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            background-color: rgba(255, 255, 255, 0.7);
            z-index: 9999;
            display: none;
        }
    </style>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Email Marketing</h2>
            </div>
        </div>
    </div>

    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>
    <hr>
    <form action="{{ route('emailMarketing.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="emails">Emails</label>
                    <select name="emails[]" id="emails" class="form-control selectpicker" multiple data-actions-box="true" data-live-search="true"  data-width="100%" data-none-selected-text="Clique aqui para selecionar os emails" data-select-all-text="Selecionar tudo" data-deselect-all-text="Deselecionar tudo">
                        @if (isset($registros))
                                @foreach ($registros as $registro)
                                    <option value="{{ $registro->Email }}">{{ $registro->Email }}</option>
                                @endforeach
                            @endif
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="assunto">Assunto</label>
                    <input type="text" class="form-control" id="assunto" name="assunto" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="mensagem">Mensagem</label>
                    <textarea name="mensagem" id="mensagem" rows="10" cols="80"></textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
        </div>
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
            $('#emails').selectpicker()
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

            CKEDITOR.replace( 'mensagem', {
                filebrowserUploadUrl: "{{route('ckeditor.image-upload', ['_token' => csrf_token() ])}}",
                filebrowserUploadMethod: 'form'
            });
        })
    </script>

@endsection
