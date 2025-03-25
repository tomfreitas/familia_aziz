
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.118.2">
    <title>Redefina sua senha</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Font awesome -->
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    <script src="{{ asset('js/all.js') }}" type="text/javascript"></script>
</head>

<body class="bg-login">

<div class="container d-flex align-content-center vh-100">
    <main class="form-signin w-100 m-auto bg-light rounded-3 shadow border py-4">

        <form method="POST" action="{{ route('password.update', ['token' => $token]) }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="_method" value="PUT">
            <div class="w-100 d-block text-center mb-4">
                <img src="{{ asset('img/logo_bella_digital.svg') }}" class="img-fluid text-center" style="width: 240px;" alt="">
            </div>
            <div class="w-100 d-block text-center">
                <h6 class="text-primary mb-4 fw-normal text-center">Redefina sua senha</h6>
            </div>

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
            @if ($errors->any())
                <div class="alert alert-warning mt-4 bg-vermelho text-white alert-dismissible fade show" role="alert">
                    <strong>Erro!</strong>
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br />
                        @endforeach
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <input placeholder="E-mail" id="email" type="email" class="form-control mb-2 rounded-2" name="email" value="{{ $email ?? old('email') }}" required autofocus>
            <input placeholder="Senha" id="password" type="password" class="form-control mb-2 rounded-2" name="password" oninput="verificarComprimento(this.value)" required>
            <p class="small fst-italic d-inline-block">Min. de 6 caracteres</p> <div id="iconeContainer" class="d-inline-block text-primary"></div>
            <input placeholder="Repetir senha" id="password_confirmation" type="password" class="form-control mb-2 rounded-2" name="password_confirmation"  required>

            <button type="submit"  class="btn btn-primary w-100 my-3">Redefinir Senha</button>


        </form>
    </main>
</div>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/scripts.js') }}" type="text/javascript"></script>
</body>

</html>
