@extends('layout.modelo')

@section('content')
    <style>
        .info {
            padding: 6px 8px;
            font: 14px/16px Arial, Helvetica, sans-serif;
            background: white;
            background: rgba(255,255,255,0.8);
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            border-radius: 5px;
        }
        .info h4 {
            margin: 0 0 5px;
            color: #777;
        }
    </style>
    <div class="w-100 d-flex flex-column bg-light px-4 py-5 rounded-4 mb-5">
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="mb-0 text-primary">
                    <span class="material-symbols-outlined align-middle">dashboard</span>
                    Dashboard
                </h4>
                <p class="text-muted mb-0">Visão geral do sistema</p>
            </div>
        </div>

        {{-- Cards principais --}}
        <div class="row g-3 mb-4">
            {{-- Total de Mantenedores --}}
            <div class="col-xl-3 col-md-6 col-12">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1 small">Mantenedores Ativos</p>
                                <h2 class="fw-bold text-primary mb-0">{{ number_format($totalMantenedores, 0, ',', '.') }}</h2>
                            </div>
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <span class="material-symbols-outlined text-primary">group</span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <a href="{{ route('users.index', ['categoria' => 1]) }}" class="small text-decoration-none">Ver lista →</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contribuições do Mês --}}
            <div class="col-xl-3 col-md-6 col-12">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1 small">Contribuições do Mês</p>
                                <h2 class="fw-bold text-success mb-0">R$ {{ number_format($contribuicoesMes, 2, ',', '.') }}</h2>
                                <span class="badge bg-success bg-opacity-10 text-success">{{ $qtdContribuicoesMes }} contribuições</span>
                            </div>
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <span class="material-symbols-outlined text-success">payments</span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <a href="{{ route('contributions.index') }}" class="small text-decoration-none">Ver todas →</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contribuições do Ano --}}
            <div class="col-xl-3 col-md-6 col-12">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1 small">Contribuições do Ano</p>
                                <h2 class="fw-bold text-info mb-0">R$ {{ number_format($contribuicoesAno, 2, ',', '.') }}</h2>
                                <span class="badge bg-info bg-opacity-10 text-info">Ticket médio: R$ {{ number_format($ticketMedio, 2, ',', '.') }}</span>
                            </div>
                            <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                <span class="material-symbols-outlined text-info">account_balance_wallet</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Novos Mantenedores --}}
            <div class="col-xl-3 col-md-6 col-12">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1 small">Novos Mantenedores (Mês)</p>
                                <h2 class="fw-bold text-verde mb-0">{{ $novosMantenedoresMes }}</h2>
                            </div>
                            <div class="bg-verde bg-opacity-10 rounded-circle p-3">
                                <span class="material-symbols-outlined text-verde">person_add</span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <a href="{{ route('users.create') }}" class="small text-decoration-none">Cadastrar novo →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Cards de alerta --}}
        <div class="row g-3 mb-4">
            {{-- Sem contribuição 45 dias --}}
            <div class="col-xl-3 col-md-6 col-12">
                <div class="card border-start border-warning border-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Sem contribuição +45 dias</p>
                                <h3 class="fw-bold text-warning mb-0">{{ $semContribuicao45 }}</h3>
                            </div>
                            <span class="material-symbols-outlined text-warning fs-1">schedule</span>
                        </div>
                        <a href="{{ route('users.index', ['sem_contribuicao_45' => 2]) }}" class="small text-decoration-none">Ver lista →</a>
                    </div>
                </div>
            </div>

            {{-- Sem contribuição 180 dias --}}
            <div class="col-xl-3 col-md-6 col-12">
                <div class="card border-start border-danger border-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Sem contribuição +180 dias</p>
                                <h3 class="fw-bold text-danger mb-0">{{ $semContribuicao180 }}</h3>
                            </div>
                            <span class="material-symbols-outlined text-danger fs-1">warning</span>
                        </div>
                        <a href="{{ route('users.index', ['sem_contribuicao_180' => 1]) }}" class="small text-decoration-none">Ver lista →</a>
                    </div>
                </div>
            </div>

            {{-- Inativos --}}
            <div class="col-xl-3 col-md-6 col-12">
                <div class="card border-start border-secondary border-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Mantenedores Inativos</p>
                                <h3 class="fw-bold text-secondary mb-0">{{ $totalInativos }}</h3>
                            </div>
                            <span class="material-symbols-outlined text-secondary fs-1">person_off</span>
                        </div>
                        <a href="{{ route('users.index', ['categoria' => 11]) }}" class="small text-decoration-none">Ver lista →</a>
                    </div>
                </div>
            </div>

            {{-- Aniversariantes do mês --}}
            <div class="col-xl-3 col-md-6 col-12">
                <div class="card border-start border-pink border-4 shadow-sm h-100" style="border-left-color: #e91e8c !important;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Aniversariantes do Mês</p>
                                <h3 class="fw-bold mb-0" style="color: #e91e8c;">{{ $aniversariantesMes }}</h3>
                            </div>
                            <span class="material-symbols-outlined fs-1" style="color: #e91e8c;">cake</span>
                        </div>
                        <a href="{{ route('users.index', ['aniversariantes_mes' => 1]) }}" class="small text-decoration-none">Ver lista →</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Gráficos e tabelas --}}
        <div class="row g-3 mb-4">
            {{-- Gráfico de contribuições --}}
            <div class="col-xl-8 col-12">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <h6 class="mb-0 fw-bold text-primary">
                            <span class="material-symbols-outlined align-middle">trending_up</span>
                            Contribuições dos Últimos 6 Meses
                        </h6>
                    </div>
                    <div class="card-body">
                        <canvas id="chartContribuicoes" height="120"></canvas>
                    </div>
                </div>
            </div>

            {{-- Últimas contribuições --}}
            <div class="col-xl-4 col-12">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <h6 class="mb-0 fw-bold text-primary">
                            <span class="material-symbols-outlined align-middle">receipt_long</span>
                            Últimas Contribuições
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($ultimasContribuicoes as $contribuicao)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fw-bold small text-truncate d-block" style="max-width: 150px;">
                                            {{ $contribuicao->user->nome ?? 'N/A' }}
                                        </span>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($contribuicao->data_pgto)->format('d/m/Y') }}</small>
                                    </div>
                                    <span class="badge bg-success rounded-pill">R$ {{ number_format($contribuicao->valor, 2, ',', '.') }}</span>
                                </li>
                            @empty
                                <li class="list-group-item text-center text-muted">Nenhuma contribuição encontrada</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Distribuições --}}
        <div class="row g-3">
            {{-- Por Estado (Mapa) --}}
            <div class="col-xl-6 col-12">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <h6 class="mb-0 fw-bold text-primary">
                            <span class="material-symbols-outlined align-middle">map</span>
                            Distribuição por Estado (Mapa do Brasil)
                        </h6>
                    </div>
                    <div class="card-body">
                        <div id="brasilMapa" style="width: 100%; height: 550px; border-radius: 8px; background: #6c757d;"></div>
                        <div class="small text-muted mt-2">* Estados sem cadastro ficam em cinza claro. Passe o mouse para ver os detalhes.</div>
                    </div>
                </div>
            </div>

            {{-- Por Categoria --}}
            <div class="col-xl-6 col-12">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <h6 class="mb-0 fw-bold text-primary">
                            <span class="material-symbols-outlined align-middle">category</span>
                            Usúarios por Categoria
                        </h6>
                    </div>
                    <div class="card-body">
                        <canvas id="chartCategorias" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Resumo total --}}
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 bg-verde text-white shadow">
                    <div class="card-body py-4">
                        <div class="row text-center">
                            <div class="col-md-4 col-12 border-end border-white border-opacity-25">
                                <h3 class="mb-0 fw-bold">{{ number_format($totalPessoas, 0, ',', '.') }}</h3>
                                <small class="opacity-75">Total de Pessoas Cadastradas</small>
                            </div>
                            <div class="col-md-4 col-12 border-end border-white border-opacity-25">
                                <h3 class="mb-0 fw-bold">{{ number_format($totalMantenedores, 0, ',', '.') }}</h3>
                                <small class="opacity-75">Mantenedores Ativos</small>
                            </div>
                            <div class="col-md-4 col-12">
                                <h3 class="mb-0 fw-bold">R$ {{ number_format($contribuicoesAno, 2, ',', '.') }}</h3>
                                <small class="opacity-75">Arrecadado no Ano</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- Leaflet para o mapa --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    {{-- Gráfico de Contribuições --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mapa do Brasil com Leaflet
            const mapContainer = document.getElementById('brasilMapa');
            if (mapContainer && typeof L !== 'undefined') {
                // Ajusta zoom para mobile
                const isMobile = window.innerWidth < 768;
                const zoomLevel = isMobile ? 5 : 4;

                const map = L.map(mapContainer, {
                    zoomControl: false,
                    scrollWheelZoom: false,
                    doubleClickZoom: false
                }).setView([-14, -55], zoomLevel);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                const estadosData = @json($porEstado->mapWithKeys(fn($e) => [strtoupper($e->estado) => $e->total]));
                const maxValue = Math.max(...Object.values(estadosData)) || 1;

                // Carrega GeoJSON do Brasil
                fetch('https://raw.githubusercontent.com/codeforamerica/click_that_hood/main/public/data/brazil-states.geojson')
                    .then(response => response.json())
                    .then(geojson => {
                        // Control que mostra informações
                        const info = L.control();

                        info.onAdd = function (map) {
                            this._div = L.DomUtil.create('div', 'info');
                            this.update();
                            return this._div;
                        };

                        info.update = function (props) {
                            this._div.innerHTML = '<h5>Usuários por Estado</h5>' +  (props ?
                                '<b>' + props.sigla + '</b><br />' + (estadosData[props.sigla] || 0) + ' usuário(s)'
                                : 'Passe o mouse sobre um estado');
                        };

                        info.addTo(map);

                        // Função para destacar estado
                        function highlightFeature(e) {
                            const layer = e.target;

                            layer.setStyle({
                                weight: 3,
                                color: '#017836',
                                dashArray: '',
                                fillOpacity: 0.3
                            });

                            layer.bringToFront();
                            info.update(layer.feature.properties);
                        }

                        // Função para resetar destaque
                        function resetHighlight(e) {
                            layer.resetStyle(e.target);
                            info.update();
                        }

                        // Função para zoom no estado clicado
                        function zoomToFeature(e) {
                            map.fitBounds(e.target.getBounds());
                        }

                        const layer = L.geoJSON(geojson, {
                            style: function(feature) {
                                const uf = feature.properties.sigla || feature.properties.UF || '';
                                const value = estadosData[uf] || 0;
                                return {
                                    fillColor: value === 0 ? '#fff' : `rgb(40, ${Math.floor(40 + 215 * (value / maxValue))}, 4)`,
                                    weight: 2,
                                    opacity: 1,
                                    color: '#666',
                                    fillOpacity: 0.5
                                };
                            },
                            onEachFeature: function(feature, layer) {
                                layer.on({
                                    mouseover: highlightFeature,
                                    mouseout: resetHighlight,
                                    click: zoomToFeature
                                });
                            }
                        }).addTo(map);

                        // Ajusta o mapa para mostrar apenas o Brasil
                        map.fitBounds(layer.getBounds());
                    })
                    .catch(e => console.error('Erro ao carregar GeoJSON:', e));
            }

            // Gráfico de Contribuições
            const ctxContribuicoes = document.getElementById('chartContribuicoes');
            if (ctxContribuicoes && typeof Chart !== 'undefined') {
                new Chart(ctxContribuicoes.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode(array_column($contribuicoesPorMes, 'mes')) !!},
                        datasets: [{
                            label: 'Contribuições (R$)',
                            data: {!! json_encode(array_column($contribuicoesPorMes, 'valor')) !!},
                            backgroundColor: 'rgba(40, 167, 69, 0.7)',
                            borderColor: 'rgba(40, 167, 69, 1)',
                            borderWidth: 1,
                            borderRadius: 5
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'R$ ' + value.toLocaleString('pt-BR');
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Gráfico de Categorias
            const ctxCategorias = document.getElementById('chartCategorias');
            if (ctxCategorias && typeof Chart !== 'undefined') {
                new Chart(ctxCategorias.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($porCategoria->pluck('nome')) !!},
                        datasets: [{
                            data: {!! json_encode($porCategoria->pluck('total')) !!},
                            backgroundColor: [
                                '#28a745',
                                '#007bff',
                                '#ffc107',
                                '#17a2b8',
                                '#e91e8c',
                                '#6f42c1',
                                '#fd7e14',
                                '#6c757d'
                            ],
                            borderWidth: 2,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    boxWidth: 12,
                                    padding: 10,
                                    font: {
                                        size: 11
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endsection
