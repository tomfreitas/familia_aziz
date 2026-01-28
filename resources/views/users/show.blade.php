@extends('layout.modelo')

@section('content')

@php
    use Carbon\Carbon;
    $dataEnvio = Carbon::parse($usuario->comunicacao_enviada_em);
    $hoje = Carbon::now();
    $diferencaDias = $dataEnvio->diffInDays($hoje);
    $horaEnvio = $dataEnvio->format('H\hi'); // Formato 24 horas com "h"
@endphp

    <div class="w-100 d-block bg-light px-4 py-5 rounded-4 tela">
        <div class="d-flex justify-content-between mb-5">
            <h4 class="mb-0 text-primary">Mantenedor</h4>
            <div>
                @if (auth()->user()->type_user == 1)
                    <a class="btn btn-sm btn-outline-vermelho px-4 rounded-pill me-3" href="{{ route('users.edit', ['user' => $usuario->id]) }}">Editar</a>
                @endif
                <a class="btn btn-sm btn-outline-verde px-4 rounded-pill" href="{{ route('users.index') }}">Voltar</a>
            </div>

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


        @if($semContribuicao180 && $usuario->user_type == 1))
            <div class="alert bg-vermelho text-white alert-dismissible fade show py-1" role="alert">
                <div class=" d-flex justify-content-between align-items-center my-2">
                    <div class="d-flex">Essa pessoa não contribui há mais de 180 dias.</div>
                    <div class="d-flex">
                        @if(!$usuario->comunicacao_enviada)
                            <form action="{{ route('users.enviarComunicacao', $usuario->id) }}" method="POST" class="d-inline" id="sendCommunicationForm">
                                @csrf
                                <button type="submit" class="btn btn-light btn-sm ms-2" id="sendCommunicationButton">
                                    <span id="sendCommunicationText">Enviar comunicação</span>
                                    <div class="spinner-border spinner-border-sm ms-2 d-none" role="status" id="sendCommunicationLoader">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </button>
                            </form>
                        @else
                            @if ($usuario->comunicacao_enviada && $usuario->comunicacao_enviada_em)

                                <button type="button" class="btn btn-secondary btn-sm ms-2" disabled>
                                    Comunicação enviada
                                    @if ($diferencaDias === 0)
                                        hoje às {{ $horaEnvio }}
                                    @elseif ($diferencaDias === 1)
                                        ontem às {{ $horaEnvio }}
                                    @elseif ($diferencaDias === 2)
                                        anteontem às {{ $horaEnvio }}
                                    @else
                                        em {{ $dataEnvio->format('d/m/Y') }} às {{ $horaEnvio }}
                                    @endif
                                </button>
                            @endif
                        @endif
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <?php
            $data_p = $usuario->data_mantenedor;
            $data_a = $usuario->aniversário;
            if($data_p == null){
                $data_f = "00/00/0000";
            } else {
                $date     = str_replace('-', '/', $data_p);
                $data_f   = date('d/m/Y', strtotime($date));

                $ani      = str_replace('-', '/', $data_a);
                $data_ani = date('d/m/Y', strtotime($ani));
            }
            ?>


        <div class="row d-contents">
            <div class="col-12">
                <form action="{{ route('users.store') }}" method="POST" class="row">
                    @csrf
                    <input type="hidden" name="usuario" class="form-control border-0" id="usuario" value="{{ $usuario->id }}" />
                    <div class="col-12 bg-white p-4 rounded-4 border border-verde-lista">
                        <div class="row">
                            <div class="col-md-6 col-12 mb-3">
                                <label for="nome" class="form-label fw-bold">Nome</label>
                                <input type="text" disabled name="nome" class="form-control px-0" id="nome" value="{{ $usuario->nome }}">
                            </div>

                            <div class="col-md-6 mb-3 d-flex flex-column">
                                <label for="email" class="form-label fw-bold mb-3">E-mail</label>
                                <a href="mailto:{{ $usuario->email }}" target="_blank" class="link-primary">{{ $usuario->email }}</a>
                                <input type="hidden" disabled name="email" class="form-control px-0" id="email" value="{{ $usuario->email }}">
                            </div>

                            <div class="col-md-3 mb-3 d-flex flex-column">
                                <?php
                                    $car = array("+", " ");
                                    $telefone = str_replace($car, '', $usuario->celular);
                                ?>
                                <label for="telefone" class="form-label fw-bold mb-3">Celular</label>
                                <a href="https://wa.me/{{ $telefone }}" target="_blank" class="fw-bold text-success">{{ $usuario->celular }}</a>
                                <input type="hidden" disabled name="telefone" class="form-control px-0" id="telefone" value="{{ $usuario->celular }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="data" class="form-label fw-bold">Aniversário</label>
                                <input type="text" disabled name="aniversario" class="form-control px-0" id="aniversario" value="{{ $data_ani }}">
                            </div>


                            <div class="col-md-3 mb-3">
                                <label for="data" class="form-label fw-bold">Data de cadastro</label>
                                <input type="text" disabled name="aniversario" class="form-control px-0" id="aniversario" value="{{ $data_f }}">
                            </div>

                            <div class="col-12">
                                <hr class="opacity-25 border-success">
                            </div>

                            <div class="col-md-3">
                                <label for="pais" class="form-label fw-bold">País</label>
                                <input type="text" disabled name="pais" class="form-control px-0" id="pais" value="{{ $usuario->país }}">
                            </div>

                            <div class="est-br col-md-6">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="estado" class="form-label fw-bold">Estado</label>
                                        <input type="text" disabled name="estado" class="form-control px-0" id="estado" value="{{ $usuario->estado }}">
                                    </div>

                                    <div class="col-md-8 mb-3">
                                        <label for="cidade" class="form-label fw-bold">Cidade</label>
                                        <input type="text" disabled name="cidade" class="form-control px-0" id="cidade" value="{{ $usuario->cidade }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <hr class="opacity-25 border-success">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="categoria" class="form-label fw-bold">Categoria</label>
                                @foreach ($categoria as $cat => $val)
                                    @if ($usuario->categoria == $cat)
                                        <input type="text" disabled name="categoria" class="form-control px-0" id="categoria" value="{{ $val }}">
                                    @endif
                                @endforeach
                            </div>

                            <div class="col-md-3">
                                <label for="pais" class="form-label fw-bold">Melhor dia</label>
                                <input type="text" disabled name="melhor_dia_oferta" class="form-control px-0" id="melhor_dia_oferta" value="{{ $usuario->melhor_dia }}">
                            </div>


                            <div class="row justify-content-center">
                                <div class="col-md-9 col-12 text-center mt-4 d-flex align-items-center justify-content-evenly">
                                    @if ($usuario->user_type == 1)
                                        <a class="btn btn-vermelho px-5 rounded-pill" href="{{ route('users.edit', $usuario->id) }}">Editar mantenedor</a>
                                    @endif
                                    <a class="btn btn-verde px-5 rounded-pill" href="{{ route('contributions.create', $usuario->id) }}">Cadastrar contribuição</a>
                                </div>
                            </div>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>

@endsection
