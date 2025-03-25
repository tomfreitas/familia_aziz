@php header("Content-type: text/php charset=utf-8"); @endphp
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Shalom Digital">
    <meta name="generator" content="Laravel 10">

    <title>{{ isset($titulo) ? $titulo : config('custom.default_title') }} - Família Aziz</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>

    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
</head>

<body>
    @php
        if(auth()->check()){
            $user = auth()->user()->type_user;
        } else {
            $user = null;
        }
    @endphp
    <header class="navbar sticky-top bg-verde flex-md-nowrap p-0 shadow position-absolute w-100 topo" data-bs-theme="dark"></header>

    <div class="container-fluid">
        <div class="d-md-none d-block">
            <div class="row">
                <div class="col-12 d-flex justify-content-between mb-4">
                    <a href="/" class="m-0 p-0 d-flex">
                        <img src="{{ asset('img/logo-familia-aziz.webp') }}" class="img-fluid" style="width: 170px; mix-blend-mode: multiply;" alt="">
                    </a>
                    <a class="btn btn-outline-filtro my-3" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                        <i class="fa-solid fa-bars"></i>
                    </a>
                </div>
            </div>

            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <!-- Mobile -->
                <div class="offcanvas-body">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-2" aria-current="page" href="{{ route('home')}}">
                                <i class="fa-solid fa-list"></i> Menu 1
                            </a>
                            <a class="nav-link d-flex align-items-center gap-2" aria-current="page" href="{{ route('home')}}">
                                <i class="fa-solid fa-list"></i> Menu 2
                            </a>
                            <a class="nav-link d-flex align-items-center gap-2" aria-current="page" href="{{ route('home')}}">
                                <i class="fa-solid fa-list"></i> Menu 3
                            </a>
                        </li>
                        @if (auth()->check())
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2" aria-current="page" href="{{ route('users.edit',  ['user' => auth()->user()->id])}}">
                                    <i class="fa-solid fa-pen-clip"></i> Meus dados
                                </a>
                            </li>
                        @endif
                    </ul>

                    <hr class="my-3">

                    <ul class="nav flex-column mb-auto">
                        <li class="nav-item">
                            @if (auth()->check())
                                <a class="nav-link d-flex align-items-center gap-2" href="{{ route('login.destroy') }}">
                                    <i class="fa-solid fa-right-from-bracket"></i> Sair
                                </a>
                            @endif
                        </li>
                    </ul>
                </div>
                <!-- Fim Desktop -->
            </div>
        </div>
        <div class="row tela">

            <div class="sidebar border-right col-md-2 col-lg-2 p-0 bg-body-tertiary d-md-block d-none vh-100 position-fixed">
                <a class="navbar-brand d-block p-4 bg-light w-100 d-flex justify-content-center" style="height: 150px !important" href="{{ route('home')}}">
                    <img src="{{ asset('img/logo-familia-aziz.webp') }}" class="img-fluid" style="mix-blend-mode: multiply;" alt="">
                </a>
                <!-- Desktop -->
                <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
                    <div class="offcanvas-header">
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
                    </div>
                    <!-- itens menu -->
                    <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2" aria-current="page" href="{{ route('users.index')}}">
                                    <span class="material-symbols-outlined">group</span> Mantenedores
                                </a>
                            </li>
                            @if ($user == 1)
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2" aria-current="page" href="{{ route('users.create')}}">
                                    <span class="material-symbols-outlined">app_registration</span> Novo mantenedor
                                </a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2" aria-current="page" href="{{ route('contributions.index')}}">
                                    <span class="material-symbols-outlined">payments</span> Contribuições
                                </a>
                            </li>
                            @if (auth()->check())
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center gap-2" aria-current="page" href="{{ route('users.edit',  ['user' => auth()->user()->id])}}">
                                        <span class="material-symbols-outlined">person_edit</span> Meus dados
                                    </a>
                                </li>
                            @endif

                        </ul>

                        <hr class="my-3">
                        @if (auth()->check())
                            <ul class="nav flex-column mb-auto">
                                @if ($user == 1)
                                    <li class="nav-item">
                                        <a class="nav-link d-flex align-items-center gap-2" aria-current="page" href="{{ route('notifications.index')}}">
                                            <span class="material-symbols-outlined">notifications</span> Notificações
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link d-flex align-items-center gap-2" aria-current="page" href="{{ route('file-manager.index')}}">
                                            <span class="material-symbols-outlined">files</span> Arquivos
                                        </a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center gap-2" href="{{ route('login.destroy') }}">
                                        <span class="material-symbols-outlined">logout</span> Sair
                                    </a>
                                </li>
                            </ul>
                        @endif
                    </div>
                </div>
                <!-- Fim Desktop -->
            </div>

            <main class="col-md-10 ms-sm-auto col-lg-15 px-md-5 py-md-4" id="total">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-4">
                    @if ( auth()->check() )
                        <span class="text-white d-md-block d-none h5"> Olá, {{ auth()->user()->nome }}</span>
                        <span class="text-white h5 position-relative mb-md- mb-0 d-md-none d-block"> Olá, {{ auth()->user()->nome }}</span>
                    @endif
                </div>
                <div>
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    <script src="{{ asset('/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/imask.js') }}" type="text/javascript"></script>
    <script>
        // Passa o nome da rota atual para o JavaScript
        const currentRoute = "{{ Route::currentRouteName() }}";
    </script>
    <script src="{{ asset('js/scripts.js') }}"></script>



</body>

</html>
