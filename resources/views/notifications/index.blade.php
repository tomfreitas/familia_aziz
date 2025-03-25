@extends('layout.modelo')

@section('content')
    <div class="w-100 d-block bg-light px-4 py-5 rounded-4 tela">
        <div class="row">
            <div class="col-12">
                <h4 class="mb-5 text-primary">Notificações</h4>
            </div>
            {{-- <div class="col-md-6 col-12 text-end">
                <a href="{{ route('users.create')}}" class="btn btn-sm btn-verde px-4 rounded-pill d-inline-block">Novo mantenedor</a>
            </div> --}}
        </div>

        @if ( session()->has('success'))
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

        @if ($notifications->isEmpty())
            <p>Nenhuma notificação encontrada.</p>
        @else
            <div class="row">
                <div class="col-12 px-4">
                    <div class="row row-cols-12 bg-primary text-white">
                        <div class="col-md-9 col-12 fw-bold py-2">Mantenedor</div>
                        <div class="col-md-1 col-12 fw-bold py-2 text-center">Tipo</div>
                        <div class="col-md-1 col-12 fw-bold py-2 text-center">Status</div>
                        <div class="col-md-1 col-12 fw-bold py-2 text-center">Data</div>
                    </div>

                    @foreach($notifications as $notification)
                        <div class="row row-cols-12 mb-md-0 mb-4 bg-white">
                            <div class="col-md-9 py-2 col-12 border-bottom d-flex align-items-center text-uppercase small fw-bold">{{ $notification->user->nome }}</div>
                            <div class="col-md-1 py-2 col-12 border-bottom d-flex align-items-center justify-content-center small text-capitalize fw-bold">{{ $notification->tipo }}</div>
                            <div class="col-md-1 py-2 col-12 border-bottom d-flex align-items-center justify-content-center small text-capitalize">{{ $notification->status }}</div>
                            <div class="col-md-1 py-2 col-12 border-bottom d-flex align-items-center justify-content-center small">{{ $notification->created_at->format('d/m/Y') }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
