<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembrete de Contribuição</title>
</head>
<body>
    <h1>Olá, {{ $user->nome }}!</h1>
    <p>Este é um lembrete de que sua contribuição está agendada para amanhã ({{ now()->addDay()->format('d/m/Y') }}).</p>
    <p>Forma de pagamento escolhido: {{ $user->forma_pgto }}</p>
    <p>Obrigado por apoiar a Família Aziz!</p>
</body>
</html>
