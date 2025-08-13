
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Shalom Digital">
    <meta name="generator" content="Laravel 10">
    <title>Família Aziz</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
</head>

<body class="bg-login">

<div class="container d-flex align-content-center vh-100">


    <main class="form-signin w-100 m-auto bg-light rounded-3 shadow border py-4">
        @if ( session()->has('success'))
            <div class="alert alert-warning bg-success text-white alert-dismissible fade show" role="alert">
                <strong>Ok!</strong>  {{ session()->get('success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ( session()->has('error'))
            <div class="alert alert-warning mt-4 bg-vermelho rounded-pill text-white alert-dismissible fade show" role="alert">
                <strong>Erro!</strong>  {{ session()->get('error') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('login.store') }}" method="POST">
            @csrf
            <div class="w-100 d-block text-center mb-4">
                <img src="{{ asset('img/logo-familia-aziz.webp') }}" class="img-fluid text-center" style="width: 200px;mix-blend-mode: multiply;" alt="">
            </div>
            <div class="w-100 d-block text-center mb-4">
                <h6 class="text-primary mb-0 fw-normal text-center">Entrar no sistema</h6>
            </div>

            @error('error')
                <div class="small alert alert-vermelho bg-vermelho text-white alert-dismissible fade show" role="alert">
                    <strong >Alerta!</strong> {{ $message }}.
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @enderror
            @error('password')
                <div class="small alert alert-vermelho bg-vermelho text-white alert-dismissible fade show" role="alert">
                    <strong >Alerta!</strong> {{ $message }}.
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @enderror

            <div class="form-floating">
                <input type="text" name="username" value="" class="form-control" id="floatingInput" placeholder="name@example.com">
                <label for="floatingInput">Usuário</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password" value="" class="form-control" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Senha</label>
            </div>



            <button class="btn btn-primary w-100 py-2" type="submit">Login</button>

            <div class="w-100 text-start mt-3 small">
                <a class="text-primary" href="{{ route('password.request') }}">Esqueci minha senha</a>
            </div>

        </form>
    </main>
</div>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/scripts.js') }}" type="text/javascript"></script>
</body>

</html>
