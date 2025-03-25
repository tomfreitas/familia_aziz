@extends('layout.modelo')

@section('content')
    @php
    if(auth()->check()){
        $user = auth()->user()->type_user;
    } else {
        $user = null;
    }
    @endphp

    @include('components.loading')

    <div class="w-100 d-block bg-light px-4 py-5 rounded-4 tela">
        <div class="row">
            <div class="col-md-6 col-12">
                <h4 class="mb-4 text-roxo">Busca de arquivos</h4>
            </div>

            {{--  @if ( session()->has('success'))
                <div class="alert alert-warning bg-success text-white alert-dismissible fade show" role="alert">
                    <strong>Ok!</strong>  {{ session()->get('success') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif --}}

            @if ( session()->has('error'))
                <div class="alert alert-warning mt-4 bg-vermelho rounded-pill text-white alert-dismissible fade show" role="alert">
                    <strong>Erro!</strong>  {{ session()->get('error') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Modal para criar uma nova pasta -->
            <div class="modal fade" id="createFolderModal" tabindex="-1" role="dialog" aria-labelledby="createFolderModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createFolderModalLabel">Criar Nova Pasta</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('file-manager.create') }}">
                                @csrf
                                <input type="hidden" name="url" id="url" value="{{url()->current()}}">
                                <label for="folder_name">Nome da Pasta:</label>
                                <input type="text" name="folder_name" class="form-control mb-3" required>
                                <button type="submit" class="btn btn-sm px-5 btn-verde rounded-pill">Criar Pasta</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-12 p-4 h-100 d-flex flex-column">
                <div class="gerenciador flex-1 overflow-scroll">
                    <div id="updates">
                        @include('components.breadcrumbs_busca')
                    </div>
                    <div class="row bg-cinza text-white py-1 px-3">
                        <div class="col-md-4 col-12 fw-bold">Nome</div>
                        <div class="col-md-3 col-12 fw-bold px-0">Caminho</div>
                        <div class="col-md-1 col-12 fw-bold px-0">Tipo</div>
                        <div class="col-md-1 col-12 fw-bold px-0">Data</div>
                        <div class="col-md-1 col-12 fw-bold px-0">Tamanho</div>
                        <div class="col-md-2 col-12 fw-bold text-center">Ação</div>
                    </div>

                    @foreach ($filteredDirectories as $dir)
                        <form action="{{ route('file-manager.deldir', ['folder' => $dir['id']]) }}" method="POST" class="row lista-arquivos">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="caminho" id="caminho" value="{{ $initialDirectoryPath.$dir['caminho'].'/'.$dir['pasta'] }}">
                            <div class="row py-1 px-4">
                                <div class="col-md-4 col-12">
                                    <a class="text-cinza text-decoration-none d-flex align-items-center" href="{{ url()->current().$dir['caminho'] }}">
                                        <span class="material-symbols-outlined symbol-filled text-aviso">folder</span>&nbsp;{{ $dir['pasta'] }}
                                    </a>
                                </div>
                                <div class="col-md-3 col-12 small d-flex align-items-center">
                                    <a class="text-cinza" href="{{url()->current()}}{{ $dir['caminho'] }}">{{$dir['caminho']}}</a>
                                </div>
                                <div class="col-md-1 col-12 small d-flex align-items-center">Pasta</div>
                                <div class="col-md-1 col-12"></div>
                                <div class="col-md-1 col-12"></div>
                                <div class="col-md-2 col-12 d-flex align-items-center justify-content-end">
                                    <button type="button" class="d-inline-flex align-items-center justify-content-center border-0 bg-transparent mx-1" data-bs-toggle="modal" data-bs-target="#edit{{$dir['id']}}">
                                        <span class="material-symbols-outlined text-primary me-1">stylus</span>
                                    </button>
                                    <a href="{{ route('file-manager.zipfile', ['id' => $dir['id'], 'folder' => $dir['caminho'] ]) }}" class="d-inline-flex align-items-center justify-content-center mx-1">
                                        <span class="material-symbols-outlined text-azul me-1">download</span>
                                    </a>
                                    <button type="button" class="d-inline-flex align-items-center justify-content-center border-0 bg-transparent mx-1" data-bs-toggle="modal" data-bs-target="#Alert{{$dir['id']}}">
                                        <span class="material-symbols-outlined text-vermelho me-1">delete</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Modal Pasta -->
                            <div class="modal fade text-start" id="Alert{{$dir['id']}}" tabindex="-1" aria-labelledby="AlertLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="AlertLabel"><i class="fa-solid fa-triangle-exclamation h4 m-0 text-aviso"></i>&nbsp; Aviso!</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="m-0">Deseja mesmo remover a pasta <strong>{{$dir['pasta']}}</strong> e todos os arquivos que contém nela?</p>
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <button type="submit" class="btn btn-sm btn-verde px-5 rounded-pill mx-2">Sim</button>
                                            <button type="button" class="btn btn-sm btn-vermelho px-5 rounded-pill mx-2" data-bs-dismiss="modal">Não</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                        <!-- Modal para renomear uma nova pasta -->
                        <div class="modal fade lista-arquivos" id="edit{{$dir['id']}}" tabindex="-1" role="dialog" aria-labelledby="edit{{$dir['id']}}ModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="edit{{$dir['id']}}ModalLabel">Renomear Pasta</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="{{ route('file-manager.rename', ['folder' => $dir['id']]) }}">
                                            @csrf
                                            <input type="hidden" name="_method" value="PUT">
                                            <input type="hidden" name="url" id="url" value="{{ url()->current().$dir['caminho'] }}">
                                            <input type="hidden" name="pasta_antiga" id="pasta_antiga" value="{{ $dir['pasta'] }}">
                                            <label for="nova_pasta">Nome da pasta atual:</label>
                                            <input type="text" name="nova_pasta" class="form-control mb-3" value="{{$dir['pasta']}}" required>
                                            <button type="submit" class="btn btn-sm w-100 px-5 btn-verde rounded-pill">Renomear</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @foreach ($filteredFiles  as $file )
                        <form action="{{ route('file-manager.destroy', ['file' => $file['id']]) }}" method="POST" class="row lista-arquivos">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="caminho" id="caminho" value="{{ $initialDirectoryPath.$file['caminho'].'/'.$file['arquivo'] }}">
                            <div class="row py-1 px-4">
                                <div class="col-md-4 col-12">
                                    <a href="#!" class="text-black text-decoration-none info d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#Pic{{$file['id']}}"><span class="material-symbols-outlined symbol-filled text-primary me-1">draft</span> {{$file['arquivo']}}</a>
                                </div>
                                <div class="col-md-3 col-12 small d-flex align-items-center">
                                    <a class="text-cinza" href="{{url()->current()}}{{ $file['caminho'] }}">{{ $file['caminho'] }}</a></div>
                                <div class="col-md-1 col-12 small d-flex align-items-center">Arquivo</div>
                                <div class="col-md-1 col-12 small d-flex align-items-center justify-content-start">{{$file['data']}}</div>
                                <div class="col-md-1 col-12 small d-flex align-items-center justify-content-end">{{$file['tamanho']}}</div>
                                <div class="col-md-2 col-12 d-flex align-items-center justify-content-end">
                                    <button type="button" class="d-inline-flex align-items-center justify-content-center border-0 bg-transparent mx-1" data-bs-toggle="modal" data-bs-target="#editFile{{$file['id']}}">
                                        <span class="material-symbols-outlined text-primary me-1">stylus</span>
                                    </button>
                                    <a href="{{ url('/')}}{{$initialDirectory.$file['caminho'].'/'.$file['arquivo'] }}" download="{{$file['arquivo']}}" class="d-inline-flex align-items-center justify-content-center mx-1">
                                        <span class="material-symbols-outlined text-azul me-1">download</span>
                                    </a>
                                    <button type="button" class="d-inline-flex align-items-center justify-content-center border-0 bg-transparent mx-1" data-bs-toggle="modal" data-bs-target="#Alert{{$file['id']}}">
                                        <span class="material-symbols-outlined text-vermelho me-1">delete</span>
                                    </button>
                                    {{-- <a href="/delete?token={{$token}}&caminho={{$directoryPath.$file}}" name="teste"><i class=""></i></a> --}}
                                </div>
                            </div>
                            <!-- Modal Mostrar Arquivo -->
                                <div class="modal fade text-start" id="Pic{{$file['id']}}" tabindex="-1" aria-labelledby="AlertLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header position-relative p-0">
                                                <button type="button" class="btn-close btn-close-white position-absolute me-2 mt-2 end-0 z-1" style="top: -40px;" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-0 bg-roxo">
                                                @if ($file['tipo'] == 'image/png' || $file['tipo'] == 'image/jpeg')
                                                    <img src="{{ url('/')}}{{$initialDirectory.'/'.$file['arquivo'] }}" class="img-fluid" alt="">
                                                @elseif ($file['tipo'] == 'audio/mpeg')
                                                    <audio controls class="w-100 d-block" id="myAudio{{$file['id']}}">
                                                        <source src="{{ url('/')}}{{$initialDirectory.'/'.$file['arquivo'] }}" type="audio/mp3">
                                                        Seu navegador não suporta o elemento de áudio.
                                                    </audio>
                                                @elseif ($file['tipo'] == 'video/x-matroska' || $file['tipo'] == 'video/mp4' || $file['tipo'] == 'video/mpeg' || $file['tipo'] == 'video/quicktime')
                                                    <video width="100%" height="450"  id="myVideo{{$file['id']}}" controls>
                                                        <source src="{{ url('/')}}{{$initialDirectory.'/'.$file['arquivo'] }}">
                                                        Seu navegador não suporta o elemento de vídeo.
                                                    </video>
                                                @endif

                                            </div>
                                            <div class="modal-footer justify-content-center">
                                                <a href="{{ url('/')}}{{$initialDirectory.$file['arquivo'] }}" download="{{$file['arquivo']}}" class="btn btn-sm btn-verde px-3 rounded-pill mx-2"><i class="fa-solid fa-cloud-arrow-down h5 my-0 mx-3"></i> Fazer download</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <!-- Modal Excluir Arquivo -->
                                <div class="modal fade text-start" id="Alert{{$file['id']}}" tabindex="-1" aria-labelledby="AlertLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="AlertLabel"><i class="fa-solid fa-triangle-exclamation h4 m-0 text-aviso"></i>&nbsp; Aviso!</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="m-0">Deseja mesmo remover o arquivo: <br /><i>{{$file['arquivo']}}</i>?</p>
                                            </div>
                                            <div class="modal-footer justify-content-center">
                                                <button type="submit" class="btn btn-sm btn-verde px-5 rounded-pill mx-2">Sim</button>
                                                <button type="button" class="btn btn-sm btn-vermelho px-5 rounded-pill mx-2" data-bs-dismiss="modal">Não</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                        </form>
                        <!-- Modal para renomear um arquivo -->
                        <div class="modal fade" id="editFile{{$file['id']}}" tabindex="-1" role="dialog" aria-labelledby="editFile{{$file['id']}}ModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editFile{{$file['id']}}ModalLabel">Renomear Arquivo</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="{{ route('file-manager.renamefile', ['file' => $file['id']]) }}">
                                            @csrf
                                            <input type="hidden" name="_method" value="PUT">
                                            <input type="hidden" name="url" id="url" value="{{$file['caminho'] }}">
                                            <input type="hidden" name="arquivo_antigo" id="arquivo_antigo" value="{{ $file['arquivo'] }}">
                                            <label for="nova_pasta">Nome da arquivo atual:</label>
                                            <input type="text" name="arquivo_novo" class="form-control mb-3" value="{{$file['arquivo']}}" required>
                                            <button type="submit" class="btn btn-sm w-100 px-5 btn-verde rounded-pill">Renomear aquivo</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- {{ $filteredFiles }} --}}

                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.info').click(function() {
                // Obter o ID do modal associado ao botão clicado
                var modalId = $(this).data('bs-target');
                // Obter o ID do áudio dentro do modal
                var musId = $(modalId).find('.modal-body audio').attr('id');
                var vidId = $(modalId).find('.modal-body video').attr('id');
                if(musId){
                    $(modalId).on('hidden.bs.modal', function () {
                        var audio = document.getElementById(musId);
                        audio.pause();
                    });
                }
                if(vidId){
                     $(modalId).on('hidden.bs.modal', function () {
                        var video = document.getElementById(vidId);
                        video.pause();
                    });
                }
            });
        });
    </script>
@endsection
