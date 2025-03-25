@extends('layout.modelo')

@section('content')

<div class="w-100 d-block bg-light px-4 py-5 rounded-4">
    <div class="row">
        <div class="d-flex justify-content-between mb-5">
            <h4 class="mb-0 text-primary">Registrar Contribuição</h4>
            <a class="btn btn-sm btn-outline-verde px-4 rounded-pill" id="voltar">Voltar</a>
        </div>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

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

    <div class="row d-contents">
        <div class="col-12">
            <form action="{{ route('contributions.store') }}" method="POST" class="row">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id ?? '' }}">
                <div class="col-12 bg-white p-4 rounded-4 border border-verde-lista">
                    <div class="row">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Mantenedor(a)</label>
                            <input type="text" class="form-control border" id="nome" value="{{ $user->nome }}" disabled>
                        </div>

                        <div class="mb-3 col-md-3 col-12">
                            <label for="melhor_dia_oferta" class="form-label">Melhor dia</label>
                            <select class="form-control form-select" name="melhor_dia_oferta" id="melhor_dia_oferta">
                                <option value="0">Selecione</option>
                                @for ($i = 1; $i <= 31; $i++)
                                    @if ($i == $user->melhor_dia) <!-- Verifica se o dia atual do loop é igual ao valor em 'melhor_dia' do usuário -->
                                        <option selected value="{{ $i }}">{{ $i }}</option>
                                    @else
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endif
                                @endfor
                            </select>
                        </div>

                        <div class="mb-3 col-md-3 col-12">
                            <label for="forma_pgto" class="form-label">Forma de Pagamento</label>
                            <select name="forma_pgto" id="forma_pgto" class="form-control form-select" required>
                                <option value="" selected>Selecione</option>
                                <option value="Transferência Bancária" {{ old('forma_pgto', $dados['forma_pgto']) == 'Transferência Bancária' ? 'selected' : '' }}>Transferência Bancária</option>
                                <option value="Boleto Bancário" {{ old('forma_pgto', $dados['forma_pgto']) == 'Boleto Bancário' ? 'selected' : '' }}>Boleto Bancário</option>
                                <option value="Cartão de Crédito" {{ old('forma_pgto', $dados['forma_pgto']) == 'Cartão de Crédito' ? 'selected' : '' }}>Cartão de Crédito</option>
                                <option value="Pix" {{ old('forma_pgto', $dados['forma_pgto']) == 'Pix' ? 'selected' : '' }}>Pix</option>
                            </select>
                        </div>

                        <div class="mb-3 col-md-3 col-12">
                            <label for="data_pgto" class="form-label">Data do Pagamento</label>
                            <input type="date" class="form-control" id="data_pgto" name="data_pgto" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="mb-3 col-md-3 col-12">
                            <label for="valor" class="form-label">Valor</label>
                            <input type="text" name="valor" id="valor" class="form-control"  value="{{ old('valor', $dados['valor']) }}" placeholder="Digite o valor..." required />
                        </div>

                        <div class="mb-3 col-12 text-center mt-4">
                            <button type="submit" class="btn btn-primary px-5 rounded-pill">Registrar Contribuição</button>
                        </div>
                    </div>
                </div>
            </form>

        @if(isset($user) && $user->contributions->isNotEmpty())

            <h4 class="my-4">Contribuições de {{ $user->nome }}</h4>
            <div class="row">
                <div class="col-12 px-4">
                    <div class="row row-cols-12 bg-primary text-white">
                        <div class="col-md-7 col-12 fw-bold py-2">Data de pagamento</div>
                        <div class="col-md-2 col-12 fw-bold py-2 text-center">Valor</div>
                        <div class="col-md-2 col-12 fw-bold py-2 text-center">Forma de pagamento</div>
                        <div class="col-md-1 col-12 fw-bold py-2 text-center">Editar</div>
                    </div>

                    @foreach($user->contributions as $contribution)
                        <?php
                            $data_p = $contribution->data_pgto;
                            $date = str_replace('-', '/', $data_p);
                            $data_f = date('d/m/Y', strtotime($date));
                            $valor = number_format($contribution->valor,2,",",".");
                        ?>
                        <div class="row row-cols-12 mb-md-0 mb-4 bg-white">
                            <div class="col-md-7 py-1 col-12 border-bottom d-flex align-items-center">{{ $data_f }}</div>
                            <div class="col-md-2 py-1 col-12 border-bottom d-flex align-items-center justify-content-center">R$ {{ $valor }}</div>
                            <div class="col-md-2 py-1 col-12 border-bottom d-flex align-items-center justify-content-center">{{ $contribution->forma_pgto }}</div>
                            <div class="col-md-1 py-1 col-12 border-bottom d-flex align-items-center justify-content-center"">
                                <a href="{{ route('contributions.edit', $contribution->id)}}">
                                    <span class="material-symbols-outlined text-cinza symbol-filled">manage_accounts</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        @else
            <p class="mt-4">Nenhuma contribuição registrada.</p>
        @endif

        </div>
    </div>
</div>

@endsection
