
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.118.2">
    <title>Redefinição de senha</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Font awesome -->
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    <script src="{{ asset('js/all.js') }}" type="text/javascript"></script>
</head>

<body class="bg-login">

<div class="container d-flex align-content-center vh-100">
    <main class="form-signin w-100 m-auto bg-light rounded-3 shadow border py-4">

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="w-100 d-block text-center mb-4">
                <img src="{{ asset('img/logo_bella_digital.svg') }}" class="img-fluid text-center" style="width: 240px;" alt="">
            </div>
            <div class="w-100 d-block text-center mb-4">
                <h6 class="text-primary mb-4 fw-normal text-center">Redefinição de senha</h6>
            </div>

            @if ( session()->has('success'))
                <div class="alert alert-warning bg-success text-white alert-dismissible fade show pe-0" role="alert">
                    <strong>tudo certo!</strong>  {!! session('success') !!}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ( session()->has('error'))
                <div class="alert alert-warning mt-4 bg-vermelho text-white alert-dismissible fade show" role="alert">
                    <strong>Erro!</strong>  {{ session()->get('error') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="form-group mb-3">
                <input id="email" type="email" name="email" class="form-control rounded-2" value="{{ old('email') }}" placeholder="Digite o e-mail" required autofocus>
            </div>

            <button class="btn btn-primary w-100 py-2" type="submit">Enviar Link de Redefinição de Senha</button>

            <div class="w-100 text-start mt-3 small">
                <a class="text-primary" href="{{ route('login.index') }}">Voltar para login</a>
            </div>
        </form>
    </main>
</div>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/scripts.js') }}" type="text/javascript"></script>
</body>

</html>
