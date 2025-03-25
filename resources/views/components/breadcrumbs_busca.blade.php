{{-- Breadcrumbs --}}
<div class="row bg-white px-4 py-2 border-bottom mb-2 justify-content-end">
    <div class="col-lg-3 col-md-4 col-12 py-md-0 py-2 d-flex align-items-center">{{ $totalItens }}</div>
    <div class="col-lg-6 col-md-4 col-12 py-md-0 py-2 d-flex align-items-center">
        <a class="btn btn-sm btn-light px-4 rounded-pill" href="{{ route('file-manager.index')}}">Página inicial</a>
    </div>
    <div class="col-lg-3 col-md-4 col-12 py-md-0 py-2">
        <form action="{{ route('file-manager.index') }}" method="get">
            <div class="input-group">
                <input type="text" class="form-control rounded-start-pill" name="busca" id="busca" placeholder="Pesquisar...">
                <button class="btn btn-primary rounded-end-pill" type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i> <!-- Ícone de busca -->
                </button>
            </div>
        </form>
    </div>
</div>
@if (!empty($breadcrumb))
<div class="row bg-white px-4 py-2 border-bottom mb-2">
    <div class="col-12 d-flex align-items-center justify-content-start py-md-0 py-2">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb  my-0 py-0">
                    <div class="breadcrumb-item"><i class="fa-regular fa-folder-open text-aviso"></i></div>
                    <li class="breadcrumb-item" aria-current="page"><a class="text-primary text-decoration-none" href="{{ route('file-manager.index') }}">Início</a></li>
                    @foreach ($breadcrumb as $key => $item)
                        @if ($key < count($breadcrumb) - 1)
                            <li class="breadcrumb-item"><a class="text-primary text-decoration-none" href="{{ $item['url'] }}">{{ $item['name'] }}</a></li>
                        @else
                            <li class="breadcrumb-item active" aria-current="page">{{ $item['name'] }}</li>
                        @endif
                    @endforeach
                </ol>
            </nav>

    </div>
</div>
@endif
