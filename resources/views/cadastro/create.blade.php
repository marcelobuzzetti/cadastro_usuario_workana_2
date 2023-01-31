<!DOCTYPE html>
<html>

<head>
    <title>Registros</title>
    {{--  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css"
        rel="stylesheet"> --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('img/ico.jpg') }}">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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

    <title>Cadastro</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,400;0,700;1,400;1,700&family=Roboto+Slab:wght@400;700&display=swap');

        html {
            height: 100%;
            min-height: 800px;
        }

        body {
            /* background: url("{{ asset('img/ico.jpg') }}")repeat center center fixed; */
            -webkit-background-size: 40vw;
            -moz-background-size: 40vw;
            -o-background-size: 40vw;
            background-size: 40vw;
            /* text-align: center; */
            font-family: 'Noto Sans', sans-serif;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .butoes,
        .title {
            text-align: center;
        }

        h1 {
            font-weight: 400;
            padding-top: 0;
            margin-top: 0;
            font-family: 'Roboto Slab', serif;
        }

        #svg_form_time {
            height: 15px;
            max-width: 80%;
            margin: 40px auto 20px;
            display: block;
        }

        #svg_form_time circle,
        #svg_form_time rect {
            fill: white;
        }

        .button {
            background: rgb(38, 135, 184);
            border-radius: 5px;
            padding: 15px 25px;
            display: inline-block;
            margin: 10px;
            font-weight: bold;
            color: white;
            cursor: pointer;
            box-shadow: 0px 2px 5px rgb(0, 0, 0, 0.5);
        }

        .disabled {
            display: none;
        }

        section {
            padding: 50px;
            max-width: 80vw;
            margin: 30px auto;
            background: white;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.3);
            border-radius: 5px;
            transition: transform 0.2s ease-in-out;
        }


        input {
            width: 100%;
            margin: 7px 0px;
            display: inline-block;
            padding: 12px 25px;
            box-sizing: border-box;
            border-radius: 5px;
            border: 1px solid lightgrey;
            font-size: 1em;
            font-family: inherit;
            background: white;
        }

        p {
            text-align: justify;
            margin-top: 0;
        }
    </style>
</head>

<body>
    @if ($message = Session::get('message'))
        @if ($message['type'] == 'success')
            <script>
                toastr.success("<?php echo $message['message']; ?>");
            </script>
        @else
            <script>
                toastr.error("<?php echo $message['message']; ?>");
            </script>
        @endif
    @endif
    <div style="text-align: center; position: absolute; margin-left: 10px;">
        <img style="width: 100px; border-radius:50px;" src="{{ asset('img/ico.jpg') }}" alt="">
    </div>
    <div class="container">
        <div style="z-index:1; background-color:rgba(255, 255, 255, 0.5); width: fit-content; margin: 0 auto; border-radius: 20px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; margin-top:10px;">
            <p style="font-weight: 800; text-align: center; font-size: 4rem; color:rgb(38, 135, 184); padding: 0 10px;">Cadastro Online</p>
        </div>
        <div id="svg_wrap"></div>
        <form action="{{ route('cadastros.store') }}" method="POST" id="cadastro">
            @csrf
            <section>
                <p class="title">Informações Pessoais</p>
                <div class="form-group">
                    <strong>Nome Completo:</strong>
                    <input class="form-control" type="text" name="nome_completo" id="nome_completo" placeholder="Nome Completo" />
                </div>
                <div class="form-group">
                    <strong>Email:</strong>
                    <input class="form-control" type="text" name="email" id="email" placeholder="Email" />
                </div>
                <div class="form-group">
                    <strong>Telefone:</strong>
                    <input class="form-control" type="text" name="telefone" id="telefone" placeholder="Telefone com WhatsApp" />
                </div>
            </section>

            <section>
                <p class="title">Corretora</p>
                <div class="form-group">
                    <strong>Tem corretora:</strong>
                    <select class="form-control" name="has_corretora" id="has_corretora">
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                </div>
                <div class="form-group">
                    <strong>Nome da Corretora:</strong>
                    <input class="form-control" type="text" name="nome_corretora" id="nome_corretora" placeholder="Nome Corretora" />
                </div>
                <div class="form-group">
                    <strong>Número da conta na corretora:</strong>
                    <input class="form-control" type="text" name="nr_conta_corretora" id="nr_conta_corretora" placeholder="Número da Conta na corretora" />
                </div>
            </section>

            <section>
                <p class="title">METATRADER</p>
                <div class="form-group">
                    <strong>Utiliza a plataforma METATRADER 5?</strong>
                    <select class="form-control" name="use_metatrader" id="use_metatrader">
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                </div>
                <div class="form-group">
                    <strong>Está com autorização da corretora para rotear pelo METATRADER 5?</strong>
                    <select class="form-control" name="has_auth_use_metatrader" id="has_auth_use_metatrader">
                    <option value="1">Sim</option>
                    <option value="0">Não</option>
                </select>
                <div class="form-group">
                    <strong>Tem interesse em qual mercado para o RADAR?</strong>
                    <select class="form-control" name="mercado" id="mercado">
                        <option value="Nacional">Nacional</option>
                        <option value="Internacional">Internacional</option>
                        <option value="Ambos, mas Nacional por enquanto">Ambos, mas Nacional por enquanto</option>
                        <option value="Ambos, mas apenas Internacional, quando possível">Ambos, mas apenas Internacional,
                            quando possível</option>
                    </select>
                </div>
            </section>

            <section>
                <p class="title">Informações Complementares</p>
                <p>Você receberá uma email com informações assim que sua conta for ativada</p>
            </section>

            <div class="butoes">
                <div class="button" id="prev">&larr; Anterior</div>
                <div class="button" id="next">Próximo &rarr;</div>
                <div class="button" id="submit">Concordo e enviar dados</div>
            </div>
        </form>


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
            var base_color = "grey";
            var active_color = "rgb(237, 40, 70)";



            var child = 1;
            var length = $("section").length - 1;
            $("#prev").addClass("disabled");
            $("#submit").addClass("disabled");

            $("section").not("section:nth-of-type(1)").hide();
            $("section").not("section:nth-of-type(1)").css('transform', 'translateX(100px)');

            var svgWidth = length * 200 + 24;
            $("#svg_wrap").html(
                '<svg version="1.1" id="svg_form_time" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 ' +
                svgWidth +
                ' 24" xml:space="preserve"></svg>'
            );

            function makeSVG(tag, attrs) {
                var el = document.createElementNS("http://www.w3.org/2000/svg", tag);
                for (var k in attrs) el.setAttribute(k, attrs[k]);
                return el;
            }

            for (i = 0; i < length; i++) {
                var positionX = 12 + i * 200;
                var rect = makeSVG("rect", {
                    x: positionX,
                    y: 9,
                    width: 200,
                    height: 6
                });
                document.getElementById("svg_form_time").appendChild(rect);
                // <g><rect x="12" y="9" width="200" height="6"></rect></g>'
                var circle = makeSVG("circle", {
                    cx: positionX,
                    cy: 12,
                    r: 12,
                    width: positionX,
                    height: 6
                });
                document.getElementById("svg_form_time").appendChild(circle);
            }

            var circle = makeSVG("circle", {
                cx: positionX + 200,
                cy: 12,
                r: 12,
                width: positionX,
                height: 6
            });
            document.getElementById("svg_form_time").appendChild(circle);

            $('#svg_form_time rect').css('fill', base_color);
            $('#svg_form_time circle').css('fill', base_color);
            $("circle:nth-of-type(1)").css("fill", active_color);


            $(".button").click(function() {
                $("#svg_form_time rect").css("fill", active_color);
                $("#svg_form_time circle").css("fill", active_color);
                var id = $(this).attr("id");
                if (id == "next") {
                    $("#prev").removeClass("disabled");
                    if (child >= length) {
                        $(this).addClass("disabled");
                        $('#submit').removeClass("disabled");
                    }
                    if (child <= length) {
                        child++;
                    }
                } else if (id == "prev") {
                    $("#next").removeClass("disabled");
                    $('#submit').addClass("disabled");
                    if (child <= 2) {
                        $(this).addClass("disabled");
                    }
                    if (child > 1) {
                        child--;
                    }
                }
                var circle_child = child + 1;
                $("#svg_form_time rect:nth-of-type(n + " + child + ")").css(
                    "fill",
                    base_color
                );
                $("#svg_form_time circle:nth-of-type(n + " + circle_child + ")").css(
                    "fill",
                    base_color
                );
                var currentSection = $("section:nth-of-type(" + child + ")");
                currentSection.fadeIn();
                currentSection.css('transform', 'translateX(0)');
                currentSection.prevAll('section').css('transform', 'translateX(-100px)');
                currentSection.nextAll('section').css('transform', 'translateX(100px)');
                $('section').not(currentSection).hide();
            });

            $('#submit').on('click', function(e) {
                e.preventDefault();

                $.ajax({
                    url: "/cadastros",
                    type: "POST",
                    data: $('#cadastro').serialize(),
                    success: function(response) {
                        toastr.success(response.success)
                        console.log(response);
                        $('#loader_email').hide()
                        $("#cadastro")[0].reset();
                    },
                    error: function(response) {
                        toastr.error(response.error)
                        console.log(response);
                        $('#loader_email').hide()
                        $("#cadastro")[0].reset();
                    },
                });
            })
        })
    </script>
</body>

</html>
