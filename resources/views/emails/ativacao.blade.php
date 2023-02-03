<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .ico_site {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .header {
            background-color: rgba(0, 109, 255, 0.3)
        }

        .footer {
            background-color: rgba(0, 109, 255, 0.3)
        }

        .body {
            font-size: 1.2rem;
        }
    </style>
</head>

<body>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr class="header">
            <td style="text-align: center;">
                <img class="ico_site" src="{{ $message->embed(public_path() . '/img/ico.jpg') }}" />
            </td>
        </tr>
        <hr>
        <tr>
            <td><div style="white-space: pre-wrap;">{{ $mensagem->corpo_email }}</div></td>
        </tr>
        {{-- <tr>
            <td>Liberamos acesso a conta {{ $registro->Login }}</td>
        </tr>
        <tr>
            <td>Acesso liberado até {{ date('d/m/Y - H:i:s', strtotime($registro->Data_limite)) }}. Poderemos renovar automaticamente.</td>
        </tr>
        <tr>
            <td>Uma vez logado no MT5 com sua conta (com dados de login e senha fornecidos pela corretora) siga o manual do Radar que consta no link abaixo.</td>
        </tr>
        <tr>
            <td>Qualquer dúvida nos avise.</td>
        </tr>
        <tr>
            <td>Link para download do manual e arquivo de instalação.</td>
        </tr>
        <tr>
            <td>Muitos relatos que a instalação .EXE tem acionado o antivírus. Então subimos também uma .RAR. Basta copiar esse .RAR no local indicado no manual e selecionar o arquivo com botão direito e mandar extrair aqui. Seguir o manual. Há vídeos (links) no manual. Há explicação das telas na parte final do manual.</td>
        </tr>
        <tr>
            <td>Uma vez instalado, o uso das telas está explicado no manual. Tendo dúvidas pode nos perguntar.</td>
        </tr>
        Liberamos acesso a conta [login]

Acesso liberado até [data]. Poderemos renovar automaticamente.
Uma vez logado no MT5 com sua conta (com dados de login e senha fornecidos pela corretora) siga o manual do Radar que consta no link abaixo.
Qualquer dúvida nos avise.

Link para download do manual e arquivo de instalação.
[link]

Muitos relatos que a instalação .EXE tem acionado o antivírus. Então subimos também uma .RAR. Basta copiar esse .RAR no local indicado no manual e selecionar o arquivo com botão direito e mandar extrair aqui. Seguir o manual. Há vídeos (links) no manual. Há explicação das telas na parte final do manual.
Uma vez instalado, o uso das telas está explicado no manual. Tendo dúvidas pode nos perguntar. --}}
        <tr>
            <td>{{ $mensagem->link }}</td>
        </tr>
        <tr>
            <td>Seguimos à disposição para dúvidas etc.</td>
        </tr>
        <tr>
            <td>Att.</td>
        </tr>
        <tr>
            <td>Radar Zênite.</td>
        </tr>
        <hr>
        <tr class="footer">
            <td style="text-align: center;">
                <a href="https://www.instagram.com/radar_zenite/">
                    <img style="width: 50px; height: 50px;"
                        src="{{ $message->embed(public_path() . '/img/instagram.png') }}" />
                </a>
            </td>
        </tr>
    </table>
</body>

</html>
