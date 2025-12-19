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
                            <li><strong>Taxa de envio:</strong> 5 e-mails por minuto</li>
                            <li><strong>Tempo estimado:</strong> {{ ceil($totalUsers / 5) }} minuto(s)</li>
                        </ul>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Atenção:</strong> Ao clicar em "Enviar", os e-mails serão enfileirados e enviados automaticamente.
                        Certifique-se de que o <code>queue:work</code> está rodando.
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
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processando...';

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
            resultado.innerHTML = `
                <div class="alert alert-success">
                    <h5><i class="fas fa-check-circle"></i> ${data.message}</h5>
                    <hr>
                    <ul class="mb-0">
                        <li><strong>Total de e-mails:</strong> ${data.total_usuarios}</li>
                        <li><strong>E-mails por minuto:</strong> ${data.emails_por_minuto}</li>
                        <li><strong>Tempo estimado:</strong> ${data.tempo_estimado}</li>
                        <li><strong>Total de lotes:</strong> ${data.total_batches}</li>
                    </ul>
                </div>
            `;
            btn.innerHTML = '<i class="fas fa-check"></i> E-mails Enfileirados!';
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
