@extends('layout.modelo')

@section('content')
    <div class="w-100 d-block bg-light px-4 py-5 rounded-4 tela">
        <div class="d-flex justify-content-between mb-5">
            <h4 class="mb-0 text-primary">Contribuições</h4>
            <a class="btn btn-sm btn-outline-verde px-4 rounded-pill" href="{{ route('users.index') }}">Voltar</a>
        </div>

        @if ( session()->has('message'))
            <div class="alert alert-warning bg-success text-white alert-dismissible fade show" role="alert">
                <strong>Sucesso!</strong>  {{ session()->get('message') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ( session()->has('error'))
            <div class="alert alert-warning bg-vermelho text-white alert-dismissible fade show" role="alert">
                <strong>Erro!</strong>  {{ session()->get('error') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <form action="{{ route('contributions.index') }}" method="GET" class="mb-4">
                    <div class="d-flex justify-content-between align-items-end">

                        <div class="d-flex flex-column justify-content-end">
                            @if(request('mes') == 0 && request('forma_pagamento') == 0)
                                <div class=""></div>
                            @elseif(request('mes') == 0 && request('forma_pagamento') != '')
                                <div class=""></div>
                            @elseif(request('mes')  || request('ano'))
                                <div class="">
                                    <strong>Total Contribuído:</strong> R$ {{ number_format($totalContribuido, 2, ',', '.') }}
                                </div>

                            @endif
                        </div>
                        <div class="d-flex">
                            <!-- Filtro: Forma de Pagamento -->
                            <div class="mx-2">
                                <label for="forma_pagamento" class="form-label fw-bold small">Forma de Pagamento</label>
                                <select name="forma_pagamento" id="forma_pagamento" class="form-control form-select form-select-sm rounded-pill" onchange="this.form.submit()">
                                    <option value="0">Todos</option>
                                    <option value="Transferência Bancária" {{ request('forma_pagamento') == 'Transferência Bancária' ? 'selected' : '' }}>Transferência Bancária</option>
                                    <option value="Boleto Bancário" {{ request('forma_pagamento') == 'Boleto Bancário' ? 'selected' : '' }}>Boleto Bancário</option>
                                    <option value="Cartão de Crédito" {{ request('forma_pagamento') == 'Cartão de Crédito' ? 'selected' : '' }}>Cartão de Crédito</option>
                                    <option value="Pix" {{ request('forma_pagamento') == 'Pix' ? 'selected' : '' }}>Pix</option>
                                </select>
                            </div>

                            <!-- Filtro: Mês -->
                            @php
                                $meses = [
                                    '01' => 'Janeiro',
                                    '02' => 'Fevereiro',
                                    '03' => 'Março',
                                    '04' => 'Abril',
                                    '05' => 'Maio',
                                    '06' => 'Junho',
                                    '07' => 'Julho',
                                    '08' => 'Agosto',
                                    '09' => 'Setembro',
                                    '10' => 'Outubro',
                                    '11' => 'Novembro',
                                    '12' => 'Dezembro',
                                ];
                            @endphp
                            <div class="mx-2">
                                <label for="mes" class="form-label fw-bold small">Mês</label>
                                <select name="mes" id="mes" class="form-control form-select form-select-sm rounded-pill" onchange="this.form.submit()">
                                    <option value="0" selected>Selecione o mês</option>
                                    @foreach($meses as $numero => $nome)
                                            <option value="{{ $numero }}" {{ request('mes', date('m')) == $numero ? 'selected' : '' }}>{{ $nome }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Filtro: Ano -->
                            <div class="mx-2">
                                <label for="ano" class="form-label fw-bold small">Ano</label>
                                <select name="ano" id="ano" class="form-control form-select form-select-sm rounded-pill" onchange="this.form.submit()">
                                    @foreach(range(date('Y'), date('Y') - 4) as $y)
                                        <option value="{{ $y }}" {{ request('ano', date('Y')) == $y ? 'selected' : '' }}>
                                            {{ $y }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <a href="{{ route('contributions.index') }}" class="px-2 text-verde d-flex align-items-end border-verde" id="sortCreated"><span class="material-symbols-outlined" title="Limpar filtros">filter_alt_off</span></a>
                        </div>
                    </div>
                </form>

                <!-- Total Contribuído -->

            </div>
        </div>

        @if ($contributions->isEmpty())
            <hr class="mt-0 mb-3">
            <p>Nenhuma contribuição encontrada.</p>
        @else
            <div class="row">
                <div class="col-12 px-4">
                    <div class="row row-cols-12 bg-primary text-white">
                        <div class="col-md-6 col-12 fw-bold py-2">Mantenedor</div>
                        <div class="col-md-2 col-12 fw-bold py-2">Forma pgto.</div>
                        <div class="col-md-2 col-12 fw-bold py-2 text-center">Data pgto.</div>
                        <div class="col-md-1 col-12 fw-bold py-2 text-center">Valor</div>
                        <div class="col-md-1 col-12 fw-bold py-2 text-center">Editar</div>
                    </div>

                    @foreach($contributions as $contribution)
                    <?php
                            $data_p = $contribution->data_pgto;
                            $date = str_replace('-', '/', $data_p);
                            $data_f = date('d/m/Y', strtotime($date));
                            $valor = number_format($contribution->valor,2,",",".");
                            $valor = number_format($contribution->valor,2,",",".");
                        ?>
                        <div class="row row-cols-12 mb-md-0 mb-4 bg-white">
                            <div class="col-md-6 col-12 border-bottom d-flex align-items-center text-uppercase small fw-bold">
                                <a class="link-verde" href="{{ route('contributions.create', $contribution->user->id) }}">{{ $contribution->user->nome }}</a>
                            </div>
                            <div class="col-md-2 col-12 border-bottom d-flex align-items-center small">{{ $contribution->forma_pgto }}</div>
                            <div class="col-md-2 col-12 border-bottom d-flex align-items-center justify-content-center small">{{ $data_f }}</div>
                            <div class="col-md-1 col-12 border-bottom d-flex align-items-center justify-content-center small">R$ {{ $valor }}</div>
                            <div class="col-md-1 col-12 border-bottom d-flex align-items-center justify-content-center gap-2 small">
                                <a href="{{ route('contributions.edit', $contribution->id)}}">
                                    <span class="material-symbols-outlined text-cinza symbol-filled">manage_accounts</span>
                                </a>
                                <form action="{{ route('contributions.destroy', [$contribution->id, $contribution->user_id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="material-symbols-outlined text-vermelho border-0 bg-transparent" onclick="return confirm('Tem certeza que deseja remover esta contribuição?')">
                                        delete
                                    </button>
                                </form>
                                {{-- <a href="{{ route('contributions.destroy', [$contribution->id]) }}" class="material-symbols-outlined text-vermelho">
                                    delete
                                </a> --}}
                            </div>

                        </div>
                    @endforeach
                </div>

            </div>
            <div class="row mt-5 d-flex align-self-center mt-auto justify-content-center">
                <div class="col-12 mt-xl-4 mt-lg-3 d-flex align-items-center justify-content-center">
                    {{ $contributions->appends([
                        'forma_pagamento' => request('forma_pagamento'),
                        'mes' => request('mes'),
                        'ano' => request('ano'),
                    ])->links() }}
                </div>
            </div>
        @endif
    </div>

@endsection
