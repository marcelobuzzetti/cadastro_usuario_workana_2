<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .ico_site{
                width: 60px;
                height: 60px;
                border-radius: 50%;
                margin-right: 10px;
            }
        .header{
            background-color: rgba(0, 109, 255, 0.3)
        }
        .footer{
            background-color: rgba(0, 109, 255, 0.3)
        }
        .body{
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
        <tr class="body">
            <td>
                {!! $mensagem !!}
            </td>
        </tr>
        <hr>
        <tr class="footer">
            <td style="text-align: center;">
                <a href="https://www.instagram.com/radar_zenite/">
                    <img style="width: 50px; height: 50px;" src="{{ $message->embed(public_path() . '/img/instagram.png') }}" />
                </a>
            </td>
        </tr>
    </table>
</body>
</html>
