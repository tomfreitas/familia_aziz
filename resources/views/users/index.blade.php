@extends('layout.modelo')

@section('content')
    <div class="w-100 d-flex flex-column bg-light px-4 py-5 rounded-4 tela">
        <div class="row">
            <div class="col-md-6 col-12">
                <h4 class="mb-5 text-primary">Lista de mantenedores</h4>
            </div>
            @if (auth()->user()->type_user == 1)
                <div class="col-md-6 col-12 text-end">
                    <a href="{{ route('users.create')}}" class="btn btn-sm btn-verde px-4 rounded-pill d-inline-block">Novo mantenedor</a>
                </div>
            @endif
        </div>

        @if($notificacoesAniversario->isNotEmpty())
            <div class="alert alert-warning bg-verde text-white alert-dismissible fade show pb-0 pt-1" role="alert">
                @foreach($notificacoesAniversario as $notificacao)
                    <div class=" d-flex justify-content-between my-2">
                        <div class="d-flex">{!! $notificacao->mensagem !!}</div>
                        <div class="d-flex"><a href="{{ route('notifications.markAsViewed', $notificacao->id) }}" class="btn btn-sm text-white ms-2">Não mostrar mais</a></div>
                    </div>
                    <hr class="m-0">
                @endforeach
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


        @if ( session()->has('success'))
            <div class="alert alert-warning bg-success text-white alert-dismissible fade show" role="alert">
                <strong>Sucesso!</strong>  {{ session()->get('success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ( session()->has('error'))
            <div class="alert alert-warning bg-vermelho text-white alert-dismissible fade show" role="alert">
                <strong>Erro!</strong>  {{ session()->get('error') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row d-flex align-items-end justify-content-end">
            <div class="col-xl-4 col-lg-3 col-md-2 col-12 mb-3 d-flex align-items-center">
                <p class="m-0">Total de pessoas: <span class="fw-bold">{{ $cont }}</span></p>
            </div>
            <div class="col-xl-8 col-lg-9 col-md-10 col-12 mb-3 d-flex align-items-center justify-content-end">
                <form method="GET" action="{{ route('users.index') }}" class="d-flex align-items-center justify-content-end flex-grow-1">
                    <div class="input-group me-4">
                        <input type="text" name="search" value="{{ request('search')}}" class="form-control form-control-sm rounded-start-pill" placeholder="Busca por nome, celular ou e-mail" aria-label="Busca por nome, celular ou e-mail" aria-describedby="button-addon2">
                        <button class="btn btn-sm btn-verde rounded-end-pill px-3 py-0" type="submit" id="button-addon2">
                            <span class="material-symbols-outlined text-white mt-1">search</span>
                        </button>
                    </div>
                    <select name="categoria" id="categoria" class="form-control form-select form-select-sm rounded-start-pill rounded-end-pill me-4 w-75" onchange="this.form.submit()">
                        <option value="0" {{ $categoria == 0 ? 'selected' : '' }}>Selecione a categoria</option>
                        @foreach ($grupos as $cat => $val)
                            @if ($categoria == $cat)
                                <option value="{{ $cat }}" selected>{{ $val }}</option>
                            @else
                                <option value="{{ $cat }}">{{$val}}</option>
                            @endif
                        @endforeach
                    </select>
                </form>
                <span>Filtros:</span>
                <a href="{{ route('users.index', ['search' => $search, 'orderBy' => 'nome', 'sort' => $sort === 'asc' ? 'desc' : 'asc','categoria' => $categoria, 'sem_contribuicao_45' => $sem_contribuicao_45 ]) }}" class="border-end px-2 text-verde d-flex align-items-center" id="sortName" data-sort="asc"><span class="material-symbols-outlined" title="Ordenar por nome">sort_by_alpha</span></a>
                <a href="{{ route('users.index', ['search' => $search, 'orderBy' => 'id', 'sort' => $sort === 'asc' ? 'desc' : 'asc','categoria' => $categoria, 'sem_contribuicao_45' => $sem_contribuicao_45 ]) }}" class="px-2 text-verde d-flex align-items-center" id="sortCreated"><span class="material-symbols-outlined" title="Ordenar por entrada">history</span></a>
                <a href="{{ route('users.index', [ 'search' => $search, 'orderBy' => 'created_at', 'categoria' => $categoria, 'sem_contribuicao_45' => request('sem_contribuicao_45')=== '1' ? '2' : '1' ]) }}" class="px-2 text-verde d-flex align-items-center" id="sortCreated"><span class="material-symbols-outlined" title="Ordenar por tempo sem contribuição">timer_off</span></a>
                <a href="{{ route('users.index') }}" class="px-2 text-verde d-flex align-items-center border-start border-verde" id="sortCreated"><span class="material-symbols-outlined" title="Limpar filtros">filter_alt_off</span></a>
            </div>
        </div>

        <div class="row">
            <div class="col-12 px-4" id="usersTable">
                <div class="row row-cols-12 bg-primary text-white">
                    <div class="col-md-4 col-12 fw-bold py-2">Nome</div>
                    <div class="col-md-2 col-12 fw-bold py-2">Celular</div>
                    <div class="col-md-3 col-12 fw-bold py-2">E-mail</div>
                    <div class="col-md-2 col-12 fw-bold py-2">Categoria</div>
                    <div class="col-md-1 col-12 fw-bold py-2 text-center">Ações</div>
                </div>

                @foreach($usuarios as $usuario)
                    <?php
                        $car = array("+", " ");
                        $telefone = str_replace($car, '', $usuario->celular);
                        $date = str_replace('-', '/', $usuario->aniversário);
                        $data_f = date('d/m/Y', strtotime($date));
                    ?>
                    <div class="row row-cols-12 mb-md-0 mb-4 bg-linha" id="tbody">
                        <div class="col-md-4 py-1 col-12 border-bottom d-flex align-items-center text-uppercase small fw-bold">
                            <a class="link-verde" href="{{ route('users.show', $usuario->id) }}">{{ $usuario->nome }}</a>
                            @if($usuario->showErrorIcon)
                                &nbsp;<span class="material-symbols-outlined text-vermelho symbol-filled h6 m-0">error</span>
                            @endif
                        </div>
                        <div class="col-md-2 py-1 col-12 border-bottom d-flex align-items-center small"><a class="fw-bold text-success" target="_blank" href="https://wa.me/{{ $telefone }}">{{ $usuario->celular }}</a></div>
                        <div class="col-md-3 py-1 col-12 border-bottom d-flex align-items-center small"><a class="text-primary" href="mailto:{{ $usuario->email }}">{{ $usuario->email }}</a></div>
                        @foreach ($grupos as $cat => $val)
                            @if ($usuario->categoria == $cat)
                                <div class="col-md-2 py-1 col-12 border-bottom d-flex align-items-center small"><a class="text-primary">{{ $val }}</a></div>
                            @endif
                        @endforeach
                        <div class="col-md-1 py-1 col-12 border-bottom d-flex align-items-center small justify-content-center">
                            @if ($usuario->user_type == 1)
                            <a href="{{ route('contributions.create', $usuario->id) }}" class="text-secondary px-3 border-end d-flex align-items-center">
                                <span class="material-symbols-outlined text-verde">payments</span>
                            </a>
                            @endif
                            <a href="{{ route('users.edit', ['user' => $usuario->id]) }}" class="text-secondary px-3 d-flex align-items-center">
                                <span class="material-symbols-outlined text-cinza symbol-filled">manage_accounts</span>
                            </a>
                            {{-- <span>{{ $data_f ? $data_f : 'N/A' }}</span> --}}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="row mt-5 d-flex align-self-center mt-auto justify-content-center">
            <div class="col-12 mt-xl-0 mt-lg-3">
                {{ $usuarios->appends([
                    'orderBy' => request('orderBy'),
                    'sort' => request('sort'),
                    'categoria' => request('categoria'),
                    'search' => request('search'),
                    'sem_contribuicao_45' => request('sem_contribuicao_45'),
                ])->links() }}
            </div>
        </div>
    </div>
@endsection
