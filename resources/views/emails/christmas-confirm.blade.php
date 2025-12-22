@extends('layout.modelo')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">🎄 Envio de E-mails de Natal</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h5><i class="fas fa-info-circle"></i> Informações do Envio</h5>
                        <ul class="mb-0">
                            <li><strong>Total de usuários:</strong> {{ $totalUsers }}</li>
                        </ul>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Atenção:</strong> Ao clicar em "Enviar", todos os e-mails serão enviados imediatamente.
                        Aguarde o processo ser concluído.
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('home') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                        <button id="btnEnviar" class="btn btn-success">
                            <i class="fas fa-paper-plane"></i> Enviar E-mails de Natal
                        </button>
                    </div>

                    <div id="resultado" class="mt-4" style="display: none;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('btnEnviar').addEventListener('click', function() {
    const btn = this;
    const resultado = document.getElementById('resultado');

    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando... Aguarde';

    fetch('{{ route("christmas.send") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        resultado.style.display = 'block';
        if (data.success) {
            let errosHtml = '';
            if (data.erros > 0) {
                errosHtml = `<li><strong>E-mails com erro:</strong> ${data.emails_com_erro.join(', ')}</li>`;
            }
            resultado.innerHTML = `
                <div class="alert alert-success">
                    <h5><i class="fas fa-check-circle"></i> ${data.message}</h5>
                    <hr>
                    <ul class="mb-0">
                        <li><strong>Total de usuários:</strong> ${data.total_usuarios}</li>
                        <li><strong>Enviados com sucesso:</strong> ${data.enviados}</li>
                        <li><strong>Erros:</strong> ${data.erros}</li>
                        ${errosHtml}
                    </ul>
                </div>
            `;
            btn.innerHTML = '<i class="fas fa-check"></i> E-mails Enviados!';
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-success');
        } else {
            resultado.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-times-circle"></i> ${data.message}
                </div>
            `;
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-paper-plane"></i> Enviar E-mails de Natal';
        }
    })
    .catch(error => {
        resultado.style.display = 'block';
        resultado.innerHTML = `
            <div class="alert alert-danger">
                <i class="fas fa-times-circle"></i> Erro ao processar a requisição: ${error.message}
            </div>
        `;
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-paper-plane"></i> Enviar E-mails de Natal';
    });
});
</script>
@endsection
