{{-- Breadcrumbs --}}
<div class="row bg-white px-4 py-2 border-bottom mb-2 d-flex align-items-center">
    <div class="col-md-2 col-12 mb-md-0 mb-3">
        <button data-bs-toggle="modal" data-bs-target="#createFolderModal" class="btn btn-sm btn-light px-4 rounded-pill me-4 d-flex align-items-center"><span class="material-symbols-outlined symbol-filled text-aviso me-1">folder</span> Nova pasta</button>
    </div>
    <div class="col-lg-7 col-md-2 col-12 arquivos mb-md-0 mb-3">
        <form id="myForm" class="d-inline" action="{{ url('/file-manager/' . ($pasta ? $pasta . '/' : '')) }}" enctype="multipart/form-data" method="POST">
            @csrf
            <input type="hidden" name="url" id="url" value="{{url()->current()}}">
            <!-- Botão personalizado -->
            <label for="fileInput" class="btn btn-sm btn-light px-4 rounded-pill me-4 d-inline-flex align-items-center"><span class="material-symbols-outlined symbol-filled text-verde me-1">upload_file</span> Importar arquivos</label>
            <!-- Campo de arquivo oculto -->
            <input type="file" id="fileInput" name="arquivo[]" id="arquivo" multiple>
        </form>
    </div>
    <div class="col-lg-3 col-md-8 col-12 py-md-0 py-2">
        <form action="{{ route('file-manager.index') }}" method="get">
            <div class="input-group">
                <input type="text" class="form-control rounded-start-pill" name="busca" id="busca" required placeholder="Pesquisar...">
                <button class="btn btn-primary rounded-end-pill d-inline-flex justify-content-center align-items-center" type="submit">
                    <span class="material-symbols-outlined text-white me-1">search</span> <!-- Ícone de busca -->
                </button>
            </div>
        </form>
    </div>
</div>
@if (!empty($breadcrumb))
<div class="row bg-white px-4 py-2 border-bottom mb-2">
    <div class="col-12 d-flex align-items-center justify-content-start py-md-0 py-2">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb d-flex align-items-center my-0 py-0">
                    <div class="breadcrumb-item d-flex align-items-center"><span class="material-symbols-outlined symbol-filled text-aviso me-1">folder_open</span></div>
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
