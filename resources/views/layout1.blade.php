<!DOCTYPE html>
<html>

<head>
    <title>Registros</title>
   {{--  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css"
        rel="stylesheet"> --}}
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <!-- Compiled and minified CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script>
        toastr.options.closeButton = true;
        toastr.options.closeMethod = 'fadeOut';
        toastr.options.closeDuration = 300;
        toastr.options.closeEasing = 'swing';
        toastr.options.newestOnTop = true;
        toastr.options.progressBar = true;
    </script>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @auth
        <script>
            window.auth = "{{ Auth::user()->name }}";
            window.count = 0
        </script>
    @endauth

    <title>Registros</title>
    <style>
        /* Animacoes */
        .animated {
            animation-duration: 0.8s;
            animation-fill-mode: both;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .fadeIn {
            animation-name: fadeIn;
        }

        /*Autocomplete JqueryUI*/
        .ui-autocomplete {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            display: none;
            float: left;
            min-width: 160px;
            padding: 5px 0;
            margin: 2px 0 0;
            list-style: none;
            font-size: 14px;
            text-align: left;
            background-color: #ffffff;
            border: 1px solid #cccccc;
            border: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: 4px;
            -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
            background-clip: padding-box;
        }

        .ui-autocomplete>li>div {
            display: block;
            padding: 3px 20px;
            clear: both;
            font-weight: normal;
            line-height: 1.42857143;
            color: #333333;
            white-space: nowrap;
        }

        .ui-state-hover,
        .ui-state-active,
        .ui-state-focus {
            text-decoration: none;
            color: #262626;
            background-color: #f5f5f5;
            cursor: pointer;
        }

        .ui-helper-hidden-accessible {
            border: 0;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
        }

    </style>
</head>

<body>
    <div id="alertaUsuario"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="https://radarzenite.com.br/cadastro_usuario_workana/public/registros">Registros</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                @auth
                    @if (Auth::user()->perfil_id != 2)
                    <li
                        class="nav-item dropdown {{ Request::path() == 'https://radarzenite.com.br/cadastro_usuario_workana/public/usuarios/create' || Request::path() == 'usuarios' ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            Usuários
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="https://radarzenite.com.br/cadastro_usuario_workana/public/usuarios">Lista de Usuários Ativos</a>
                            <a class="dropdown-item" href="https://radarzenite.com.br/cadastro_usuario_workana/public/usuarios/inativos">Lista de Usuários Inativos</a>
                            <a class="dropdown-item" href="https://radarzenite.com.br/cadastro_usuario_workana/public/usuarios/create">Adicionar Usuário</a>
                        </div>
                    </li>
                    @endif
                    <li
                        class="nav-item dropdown {{ Request::path() == 'registros/create' || Request::path() == 'registros' ? 'active' : '' }} ">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Registros
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="https://radarzenite.com.br/cadastro_usuario_workana/public/registros">Lista de Registros</a>
                            <a class="dropdown-item" href="https://radarzenite.com.br/cadastro_usuario_workana/public/registros/create">Adicionar Registro</a>
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav ">
                    <li class="nav-item dropdown my-2 my-lg-0">
                        <a class="nav-link dropdown-toggle my-2 my-sm-0" href="#" id="navbarDropdown" data-toggle="dropdown"
                            role="button" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li>
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                </ul>
            @endauth
        </div>
    </nav>
    <div class="container">
        @yield('content')
    </div>

    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/dataTables.min.js') }}"></script>
    <script src="{{ asset('js/modernizr-custom.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            if (!Modernizr.inputtypes.date) {
                $("input[name='data_cautela']").datepicker({
                    dateFormat: 'yy-mm-dd'
                });
            }

            $('.js-example-responsive').select2();


            $('#table').DataTable({
                responsive: true,
                fixedHeader: true,
                autoFill: true,
                colReorder: true,
                keys: true,
                ordering: true,
                language: {
                    processing: "Aguarde enquanto os dados são carregados ...",
                    search: "Pesquisar",
                    lengthMenu: "Mostrar _MENU_ registros por pagina",
                    info: "Exibindo de _START_ a _END_ de _TOTAL_ registros",
                    infoEmpty: "Exibindo 0 a 0 de 0 registros",
                    infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                    infoPostFix: "",
                    loadingRecords: "Chargement en cours...",
                    zeroRecords: "Nenhum registro encontrado",
                    emptyTable: "Não há dados para exibir",
                    paginate: {
                        first: "Primeiro",
                        previous: "Anterior",
                        next: "Próximo",
                        last: "Último"
                    },
                    aria: {
                        sortAscending: ": Ative para classificar a coluna em ordem crescente",
                        sortDescending: ": Ative para classificar a coluna em ordem decrescente"
                    }
                },
                /* dom: 'flBrtip',
                buttons: [
                    'copy', 'excel', 'pdf'
                ] */
            });
        })
    </script>
</body>

</html>
