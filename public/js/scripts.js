document.addEventListener('DOMContentLoaded', () => {

    const route = currentRoute;

    // Carregar scripts específicos com base na rota
    switch (route) {
        case 'users.index':
            console.log('Scripts da página de users.index carregados.');
            initUsersPage(); // Função específica para users.index
            break;

        case 'users.show':
            console.log('Scripts da página users.show carregados.');
            initUsersShowPage(); // Função específica para users.show
            break;

        case 'users.create':
            console.log('Scripts da página users.create carregados.');
            initUsersCreatePage(); // Função específica para users.show
            break;

        case 'users.edit':
            console.log('Scripts da página users.edit carregados.');
            initUsersEditPage(); // Função específica para users.show
            break;

        case 'contributions.create':
            console.log('Scripts da página contributions.create carregados.');
            initContributionsPage(); // Função específica para contributions.create
            break;

        case 'contributions.edit':
            console.log('Scripts da página contributions.edit carregados.');
            initContributionsPage(); // Função específica para contributions.create
            break;

        case 'file-manager.index':
            console.log('Scripts da página de arquivos carregados.');
            initFileManagerPage(); // Função específica para contributions.create
            break;

        default:
            console.log('Nenhum script específico para esta rota.');
            break;
    }

    // Carregar scripts comuns (se necessário para todas as páginas)
    console.log('Scripts comuns carregados.');
    initCommonScripts();

});

// Funções específicas por página
function initUsersPage() {
    document.addEventListener('DOMContentLoaded', () => {
        const usersTableBody = document.getElementById('usersTableBody');

        // Botões de ordenação
        const sortName = document.getElementById('sortName');
        const sortCreated = document.getElementById('sortCreated');

        let nameOrder = 'asc'; // Estado inicial da ordenação por nome

        // Função para buscar e atualizar os usuários
        function fetchUsers(sort) {
            fetch(`/users/filter?sort=${sort}`)
                .then(response => response.json())
                .then(data => {
                    usersTableBody.innerHTML = ''; // Limpa a tabela
                    data.forEach(user => {
                        const telefone = user.celular.replace(/\+|\s/g, '');
                        const row = `
                            <div class="row row-cols-12 mb-md-0 mb-4 bg-linha">
                                <div class="col-md-4 py-2 col-12 border-bottom d-flex align-items-center text-uppercase small fw-bold">
                                    <a class="text-primary" href="/users/${user.id}">${user.nome}</a>
                                    &nbsp;<span class="material-symbols-outlined text-vermelho symbol-filled h6 m-0">error</span>
                                </div>
                                <div class="col-md-3 py-2 col-12 border-bottom d-flex align-items-center small">
                                    <a class="text-primary" target="_blank" href="https://wa.me/${telefone}">${user.celular}</a>
                                </div>
                                <div class="col-md-3 py-2 col-12 border-bottom d-flex align-items-center small">
                                    <a class="text-primary" href="mailto:${user.email}">${user.email}</a>
                                </div>
                                <div class="col-md-2 py-2 col-12 border-bottom d-flex align-items-center small justify-content-center">
                                    <a href="/contributions/create/${user.id}" class="text-secondary px-3 border-end">Contribuições</a>
                                    <a href="/users/${user.id}/edit" class="text-secondary px-3">Editar</a>
                                </div>
                            </div>
                        `;
                        usersTableBody.innerHTML += row;
                    });
                })
                .catch(error => console.error('Erro ao buscar usuários:', error));
        }

        // Event Listener para ordenação por nome
        sortName.addEventListener('click', () => {
            nameOrder = nameOrder === 'asc' ? 'desc' : 'asc';
            fetchUsers(`name_${nameOrder}`);
        });

        // Event Listener para ordenação por cadastro
        sortCreated.addEventListener('click', () => {
            fetchUsers('created_at');
        });
    });
}

function initUsersShowPage() {
    document.getElementById('sendCommunicationForm').addEventListener('submit', function(event) {
        const button = document.getElementById('sendCommunicationButton');
        const text = document.getElementById('sendCommunicationText');
        const loader = document.getElementById('sendCommunicationLoader');

        // Atualiza o texto para "Enviando comunicação..."
        text.textContent = "Enviando comunicação...";

        // Mostra o spinner
        loader.classList.remove('d-none');

        // Desabilita o botão para evitar múltiplos cliques
        button.setAttribute('disabled', 'true');
    });
}

function initUsersCreatePage() {

    $(function() {
        //document.addEventListener("DOMContentLoaded", function () {
        // Mapeamento das máscaras por país
        const phoneMasks = {
            "CA": "+1 000 000 0000", // Canadá
            "US": "+1 000 000 0000", // Estados Unidos
            "MX": "+52 1 000 000 0000", // México
            "GT": "+502 5000 0000", // Guatemala
            "HN": "+504 9000 0000", // Honduras
            "CR": "+506 8000 0000", // Costa Rica
            "PA": "+507 6000 0000", // Panamá
            "DO": "+1 809 000 0000", // República Dominicana
            "CU": "+53 500 0000", // Cuba
            "JM": "+1 876 000 0000", // Jamaica
            "HT": "+509 4000 0000", // Haiti
            "NI": "+505 8000 0000", // Nicarágua
            "TT": "+1 868 000 0000", // Trinidad e Tobago
            "BZ": "+501 600 0000", // Belize
            "BS": "+1 242 000 0000", // Bahamas

            // América do Sul
            "BR": "+55 00 00000 0000", // Brasil
            "AR": "+54 9 11 000 0000", // Argentina
            "CL": "+56 9 000 0000", // Chile
            "CO": "+57 30 000 0000", // Colômbia
            "PE": "+51 90 000 0000", // Peru
            "VE": "+58 400 000 0000", // Venezuela
            "UY": "+598 90 000 000", // Uruguai
            "BO": "+591 60 000 000", // Bolívia
            "EC": "+593 99 000 0000", // Equador
            "PY": "+595 90 000 000", // Paraguai
            "SR": "+597 700 0000", // Suriname
            "GF": "+594 690 000 000", // Guiana Francesa
            "GY": "+592 600 0000", // Guiana
            "FK": "+500 500 0000", // Ilhas Malvinas
            "AW": "+297 560 0000", // Aruba

            // Europa
            "DE": "+49 150 000 00000", // Alemanha
            "FR": "+33 6 00 00 00 00", // França
            "IT": "+39 350 000 0000", // Itália
            "ES": "+34 600 000 000", // Espanha
            "GB": "+44 7400 000000", // Reino Unido
            "NL": "+31 60 000 0000", // Países Baixos
            "RU": "+7 900 000 0000", // Rússia
            "CH": "+41 70 000 0000", // Suíça
            "PT": "+351 900 000 000", // Portugal
            "PL": "+48 600 000 000", // Polônia
            "SE": "+46 70 000 0000", // Suécia
            "NO": "+47 400 00 000", // Noruega
            "DK": "+45 50 00 00 00", // Dinamarca
            "FI": "+358 40 000 0000", // Finlândia
            "GR": "+30 690 000 0000", // Grécia

            // África
            "ZA": "+27 60 000 0000", // África do Sul
            "EG": "+20 10 000 0000", // Egito
            "NG": "+234 700 000 0000", // Nigéria
            "KE": "+254 700 000 000", // Quênia
            "MA": "+212 600 000 000", // Marrocos
            "DZ": "+213 50 00 00 00", // Argélia
            "UG": "+256 700 000 000", // Uganda
            "GH": "+233 200 000 000", // Gana
            "ET": "+251 90 000 0000", // Etiópia
            "CI": "+225 70 000 0000", // Costa do Marfim
            "CM": "+237 600 000 000", // Camarões
            "TZ": "+255 620 000 000", // Tanzânia
            "AO": "+244 920 000 000", // Angola
            "SD": "+249 90 000 0000", // Sudão
            "SN": "+221 70 000 0000", // Senegal

            // Ásia
            "CN": "+86 130 0000 0000", // China
            "IN": "+91 90000 00000", // Índia
            "JP": "+81 70 0000 0000", // Japão
            "KR": "+82 10 0000 0000", // Coreia do Sul
            "PH": "+63 900 000 0000", // Filipinas
            "VN": "+84 90 000 0000", // Vietnã
            "SA": "+966 50 000 0000", // Arábia Saudita
            "JO": "+962 7 0000 0000", // Jordânia
            "SG": "+65 9000 0000", // Singapura
            "TH": "+66 90 000 0000", // Tailândia
            "MY": "+60 10 000 0000", // Malásia
            "IR": "+98 910 000 0000", // Irã
            "PK": "+92 300 000 0000", // Paquistão
            "BD": "+880 170 000 0000", // Bangladesh
            "AE": "+971 50 000 0000", // Emirados Árabes Unidos

            // Oceania
            "AU": "+61 40 000 0000", // Austrália
            "NZ": "+64 20 000 0000", // Nova Zelândia
            "FJ": "+679 900 0000", // Fiji
            "PG": "+675 7000 0000", // Papua Nova Guiné
            "WS": "+685 750 0000", // Samoa
            "TO": "+676 700 0000", // Tonga
            "SB": "+677 8000 0000", // Ilhas Salomão
            "VU": "+678 500 0000", // Vanuatu
            "NR": "+674 555 0000", // Nauru
            "TV": "+688 900 0000", // Tuvalu
            "KI": "+686 600 0000", // Kiribati
            "NC": "+687 700 000", // Nova Caledônia
            "PF": "+689 870 0000", // Polinésia Francesa
            "CK": "+682 500 0000", // Ilhas Cook
            "MH": "+692 700 0000", // Ilhas Marshall
        };


        // Elementos do formulário
        const countrySelect = document.getElementById('pais');
        const phoneInput = document.getElementById('telefone');

        // Inicializar máscara com valor padrão
        const phoneMask = IMask(phoneInput, {
            mask: phoneMasks[countrySelect.value] || ''
        });

        // Alterar máscara ao mudar o país
        countrySelect.addEventListener('change', function () {
            const selectedCountry = countrySelect.value;
            const newMask = phoneMasks[selectedCountry] || '';
            phoneMask.updateOptions({ mask: newMask });
            phoneInput.value = ''; // Limpar campo ao trocar o país
        });
    //});
    });

    $(function() {
        const element = document.getElementById('data');
        const element2 = document.getElementById('data_mante');
        const maskOptions = {
            mask: '00/00/0000',
            mask2: '00/00/0000'
        };
        const mask = IMask(element, maskOptions);
        const mask2 = IMask(element2, maskOptions);
    });

    function mostrarSenhaReset(){
        var inputPass = document.getElementById('password')
        var btnShowPass = document.getElementById('ico-senha');

        if(inputPass.type === 'password'){
            inputPass.setAttribute('type', 'text');
            btnShowPass.classList.replace('fa-eye', 'fa-eye-slash')
        } else {
            inputPass.setAttribute('type', 'password');
            btnShowPass.classList.replace('fa-eye-slash', 'fa-eye')
        }
    }

    function mostrarRepSenhaReset(){
        var inputRepPass = document.getElementById('password_confirmation')
        var btnRepShowPass = document.getElementById('ico-rep-senha');

        if (inputRepPass.type === 'password') {
            inputRepPass.setAttribute('type', 'text');
            btnRepShowPass.classList.replace('fa-eye', 'fa-eye-slash')
        } else {
            inputRepPass.setAttribute('type', 'password');
            btnRepShowPass.classList.replace('fa-eye-slash', 'fa-eye')
        }
    }
}

function initUsersEditPage() {
    /* $(document).ready(function() {
        $("#abrir_comentarios").click(function() {
            $(this).text($(this).text() ===
                $(this).data("texto-inicial") ?
                $(this).data("texto-alternativo") :
            $(this).data("texto-inicial"));

            $("html, body").animate({
                scrollTop: $(document).height()
            }, "slow");
            $("#caixa_observacao").slideToggle();
        });
    }); */
            const botao = document.getElementById('abrir_comentarios');

            botao.addEventListener('click', function () {
                $("html, body").animate({
                    scrollTop: $(document).height()
                }, "slow");
                const textoInicial = botao.getAttribute('data-texto-inicial');
                const textoAlternativo = botao.getAttribute('data-texto-alternativo');
                $("#caixa_observacao").slideToggle();
                // Troca o texto com base no texto atual do botão
                botao.textContent = botao.textContent.trim() === textoInicial ? textoAlternativo : textoInicial;
            });

    $(document).ready(function() {
        // Delegar o evento de clique para todos os botões com a classe 'bot_resposta'
        $(document).on('click', '.bot_resposta', function() {
            var targetDiv = $(this).data('target');
            $("html, body").animate({
                scrollTop: $('html, body').height()
            }, "slow");
            $(targetDiv).slideToggle();
        });
    });
}

function initContributionsPage() {
    /* $(document).ready(function() {
        //document.addEventListener('DOMContentLoaded', function () {
            const melhorDiaInput = document.getElementById('melhor_dia_oferta');
            const dataPgtoInput = document.getElementById('data_pgto');

            function updateDataPgto() {
                const melhorDia = parseInt(melhorDiaInput.value, 10);
                if (!melhorDia || melhorDia < 1 || melhorDia > 31) {
                    dataPgtoInput.value = '';
                    return;
                }

                const today = new Date();
                const currentYear = today.getFullYear();
                const currentMonth = today.getMonth(); // Janeiro é 0
                const todayDate = today.getDate();

                // Calcula o mês do pagamento
                let paymentMonth = currentMonth;
                let paymentYear = currentYear;

                if (melhorDia < todayDate) {
                    // Caso o melhor dia já tenha passado neste mês
                    paymentMonth += 1;
                    if (paymentMonth > 11) {
                        paymentMonth = 0; // Janeiro do próximo ano
                        paymentYear += 1;
                    }
                }

                // Ajusta o formato da data
                const formattedDate = new Date(paymentYear, paymentMonth, melhorDia)
                    .toISOString()
                    .split('T')[0];

                dataPgtoInput.value = formattedDate;
            }

            // Atualiza o campo data_pgto ao alterar o melhor dia
            melhorDiaInput.addEventListener('input', updateDataPgto);


                const valorInput = document.getElementById('valor');

                valorInput.addEventListener('input', function (e) {
                    let value = e.target.value;

                    // Remove todos os caracteres não numéricos
                    value = value.replace(/[^\d]/g, '');

                    // Converte para número e divide por 100 para considerar os centavos
                    const numericValue = parseFloat(value) / 100;

                    // Define o locale e o formato de moeda
                    const formattedValue = new Intl.NumberFormat('pt-BR', {
                        style: 'currency',
                        currency: 'BRL',
                    }).format(numericValue);

                    // Atualiza o valor formatado no campo
                    e.target.value = formattedValue;
                });

                // Evita enviar a formatação no envio do formulário
                valorInput.closest('form').addEventListener('submit', function () {
                    valorInput.value = valorInput.value
                        .replace(/\D/g, '') // Remove tudo que não for número
                        .replace(/(\d+)(\d{2})$/, '$1.$2'); // Ajusta os centavos
                });

                //return updateDataPgto();
        //});
    }); */

    $(document).ready(function () {
        const melhorDiaInput = document.getElementById('melhor_dia_oferta');
        const dataPgtoInput = document.getElementById('data_pgto');
        const valorInput = document.getElementById('valor');

        // Função para atualizar o campo de data de pagamento
        /* function updateDataPgto() {
            const melhorDia = parseInt(melhorDiaInput.value, 10);
            if (!melhorDia || melhorDia < 1 || melhorDia > 31) {
                dataPgtoInput.value = '';
                return;
            }

            const today = new Date();
            const currentYear = today.getFullYear();
            const currentMonth = today.getMonth(); // Janeiro é 0
            const todayDate = today.getDate();

            let paymentMonth = currentMonth;
            let paymentYear = currentYear;

            if (melhorDia < todayDate) {
                // Se o melhor dia já passou, avança para o próximo mês
                paymentMonth += 1;
                if (paymentMonth > 11) {
                    paymentMonth = 0; // Janeiro do próximo ano
                    paymentYear += 1;
                }
            }

            const formattedDate = new Date(paymentYear, paymentMonth, melhorDia)
                .toISOString()
                .split('T')[0];

            dataPgtoInput.value = formattedDate;
        } */

        // Formatação inicial do campo de valor
        function formatValorInput() {
            let value = valorInput.value;

            // Remove todos os caracteres não numéricos
            value = value.replace(/[^\d]/g, '');

            // Converte para número e divide por 100 para centavos
            const numericValue = parseFloat(value) / 100 || 0;

            // Formata no padrão BRL
            const formattedValue = new Intl.NumberFormat('pt-BR', {
                style: 'currency',
                currency: 'BRL',
            }).format(numericValue);

            valorInput.value = formattedValue;
        }

        // Formata o valor ao digitar no campo
        valorInput.addEventListener('input', function (e) {
            formatValorInput();
        });

        // Evita enviar a formatação no envio do formulário
        valorInput.closest('form').addEventListener('submit', function () {
            valorInput.value = valorInput.value
                .replace(/\D/g, '') // Remove tudo que não for número
                .replace(/(\d+)(\d{2})$/, '$1.$2'); // Ajusta os centavos
        });

        // Formata automaticamente ao carregar a página
        formatValorInput();

        // Atualiza o campo data_pgto ao alterar o melhor dia
        melhorDiaInput.addEventListener('input', updateDataPgto);

        // Atualiza a data de pagamento ao carregar a página (caso necessário)
        updateDataPgto();
    });

}

function initFileManagerPage(){
    const updatesElement = document.getElementById('updates');
    const eventSource = new EventSource('/file-manager');

    eventSource.onmessage = function(event) {
        const newUpdate = document.createElement('div');
        newUpdate.textContent = event.data;
        updatesElement.prepend(newUpdate);
    };

    $(function(){
        $(".fa-pen").click( function(){
            $('.modal').removeClass('lista-arquivos');
        });
    });


    document.getElementById('fileInput').addEventListener('change', function () {
        var fileInput = document.getElementById('fileInput');
        var overlay = document.getElementById('overlay');
        var progressBar = document.getElementById('progressBar');

        if (fileInput.files.length > 0) {
            var file = fileInput.files[0];
            var xhr = new XMLHttpRequest();

            // Evento de progresso
            xhr.upload.addEventListener('progress', function (e) {
                if (e.lengthComputable) {
                    var percentComplete = (e.loaded / e.total) * 100;
                    progressBar.style.width = percentComplete + '%';
                    progressBar.textContent = percentComplete.toFixed(0) + '%';
                }
            });

            // Evento de conclusão
            xhr.addEventListener('load', function () {
                // Aqui você pode realizar ações adicionais após o carregamento do arquivo
                //alert('Arquivo carregado com sucesso!');
                overlay.style.display = 'none';
            });

            // Evento de erro
            xhr.addEventListener('error', function () {
                alert('Erro ao carregar o arquivo.');
                overlay.style.display = 'none';
            });

            // Configuração da requisição
            xhr.open('POST', 'sua_url_de_upload');
            var formData = new FormData();
            formData.append('file', file);
            xhr.send(formData);

            // Exibir o overlay
            overlay.style.display = 'block';
        }
    });

    document.getElementById('fileInput').addEventListener('change', function() {
        document.getElementById('myForm').submit();
    });





    $(function() {
        // Default export is a4 paper, portrait, using millimeters for units
        $('#exportar').click(function() {
            // Obtém o HTML a ser exportado
            var html = $('#total').html();

            // Cria um novo objeto jsPDF
            var pdf = new jsPDF('p', 'mm', 'a4');

            // Função para renderizar o HTML em PDF
            function exportarParaPDF() {
                html2pdf().from(html).set({
                    margin: 10,
                    filename: 'seu-arquivo.pdf',
                    html2canvas: { scale: 1 },
                    jsPDF: { orientation: 'landscape', unit: 'mm', format: 'a4' }
                }).save();
            }
            // Chama a função para exportar o PDF
            exportarParaPDF();
        });
    });

}

// Função comum (opcional para todas as páginas)
function initCommonScripts() {
    $(function() {
        $('#redirecionar').on('click', function() {
            history.go(-2);
        });
    });

    $(function() {
        $('#voltar').on('click', function() {
            history.go(-1);
        });
    });


    function verificarComprimento(valor) {
        var iconeContainer = document.getElementById('iconeContainer');
        // Remove o ícone se houver menos de seis caracteres
        if (valor.length < 6) {
            iconeContainer.innerHTML = '';
            return;
        }
        // Adiciona o ícone se houver seis ou mais caracteres
        iconeContainer.innerHTML = '<i class="fas fa-check"></i>';
    }
}


function generateUsername() {
    // Obtém o valor do campo "nome"
    let nome = document.getElementById('nome').value.trim().toLowerCase();

    // Divide o nome completo em partes (separadas por espaços)
    let nomeParts = nome.split(' ');

    // Se existirem várias partes do nome, gera o username
    if (nomeParts.length > 1) {
        let primeiroNome = nomeParts[0]; // Primeiro nome
        let ultimoNome = nomeParts[nomeParts.length - 1]; // Último nome

        // Cria o username no formato "primeironome.ultimonome"
        let username = `${primeiroNome}.${ultimoNome}`;

        // Define o valor do campo "username"
        document.getElementById('usuario').value = username;
    }
}
