<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Reset de Senha</title>
    <style>
        /* Estilos básicos para o e-mail */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin-top: 20px;
            padding: 0;
            height: auto;
            display: flex;
            justify-content: center; /* Centraliza horizontalmente */
        }

        .email-container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            max-width: 700px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: left; /* Mantém o texto alinhado à esquerda */
        }

        .btn {
            background-color: #2d6dd5;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            font-size: 14px;
            text-align: center;
            margin-bottom: 20px;
        }
        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: bold;
            color: #2d6dd5
        }

        p {
            font-size: 16px;
        }

        .footer {
            margin-top:20px;
            text-align: center;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <img src="{{ asset('img/logo_bella_digital.svg') }}" style="width: 240px; text-align:center; margin-bottom:50px" alt="">
        <h2>Redefinição de Senha</h2>
        <p>Recebemos uma solicitação para redefinir sua senha. Para continuar, clique no botão abaixo:</p>

        <a href="{{ $url }}" class="btn">Redefinir Senha</a>

        <p>Este link de reset de senha irá expirar em 60 minutos.</p>
        <p class="footer">Se você não solicitou esse reset, por favor, ignore este e-mail.</p>
    </div>
</body>
</html>
