@extends('layout.modelo')

@section('content')

<div class="w-100 d-block bg-light px-4 py-5 rounded-4">
    <div class="row">
        <div class="d-flex justify-content-between mb-5">
            <h4 class="mb-0 text-primary">Editar Contribuição</h4>
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

    @if (session()->has('message'))
        <div class="alert alert-warning bg-success text-white alert-dismissible fade show" role="alert">
            <strong>Sucesso!</strong> {{ session()->get('message') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-warning bg-vermelho text-white alert-dismissible fade show" role="alert">
            <strong>Erro!</strong> {{ session()->get('error') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row d-contents">
        <div class="col-12">
            <form action="{{ route('contributions.update', $contribution->id) }}" method="POST" class="row">
                @csrf
                @method('PUT')
                <input type="hidden" name="user_id" value="{{ $contribution->user_id }}">

                <div class="col-12 bg-white p-4 rounded-4 border border-verde-lista">
                    <div class="row">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Mantenedor(a)</label>
                            <input type="text" class="form-control border" id="nome"
                                   value="{{ $contribution->user->nome }}" disabled>
                        </div>

                        <div class="mb-3 col-md-3 col-12">
                            <label for="melhor_dia_oferta" class="form-label">Melhor dia</label>
                            <select class="form-control form-select" name="melhor_dia_oferta" id="melhor_dia_oferta">
                                <option value="0">Selecione</option>
                                @for ($i = 1; $i <= 31; $i++)
                                    <option value="{{ $i }}"
                                            {{ $contribution->melhor_dia_oferta == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="mb-3 col-md-3 col-12">
                            <label for="forma_pgto" class="form-label">Forma de Pagamento</label>
                            <select name="forma_pgto" id="forma_pgto" class="form-control form-select">
                                <option value="">Selecione</option>
                                <option value="Transferência Bancária"
                                        {{ $contribution->forma_pgto == 'Transferência Bancária' ? 'selected' : '' }}>
                                    Transferência Bancária
                                </option>
                                <option value="Boleto Bancário"
                                        {{ $contribution->forma_pgto == 'Boleto Bancário' ? 'selected' : '' }}>
                                    Boleto Bancário
                                </option>
                                <option value="Cartão de Crédito"
                                        {{ $contribution->forma_pgto == 'Cartão de Crédito' ? 'selected' : '' }}>
                                    Cartão de Crédito
                                </option>
                                <option value="Pix"
                                        {{ $contribution->forma_pgto == 'Pix' ? 'selected' : '' }}>
                                    Pix
                                </option>
                            </select>
                        </div>

                        <div class="mb-3 col-md-3 col-12">
                            <label for="data_pgto" class="form-label">Data do Pagamento</label>
                            <input type="date" class="form-control" id="data_pgto" name="data_pgto" value="{{ $contribution->data_pgto }}" required>
                        </div>

                        <div class="mb-3 col-md-3 col-12">
                            <label for="valor" class="form-label">Valor</label>
                            <input type="text" name="valor" id="valor" class="form-control"
                                   value="{{ number_format($contribution->valor, 2, '.', '') }}"
                                   placeholder="Digite o valor..." required>
                        </div>

                        <div class="mb-3 col-12 text-center mt-4">
                            <button type="submit" class="btn btn-primary px-5 rounded-pill">Atualizar Contribuição</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
