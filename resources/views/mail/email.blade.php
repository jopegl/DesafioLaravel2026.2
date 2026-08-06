<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
</head>

<body>
    <h2>Olá!</h2>

    <p>Você recebeu uma nova mensagem de contato através do site.</p>

    <p><strong>Nome:</strong> {{ $fromName }}</p>
    <p><strong>Email:</strong> {{ $fromEmail }}</p>
    <p><strong>Assunto:</strong> {{ $fromSubject }}</p>

    <p><strong>Mensagem:</strong></p>
    <p>{{ $fromMessage }}</p>
</body>

</html>