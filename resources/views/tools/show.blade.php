<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>{{ $tool->name }}</h1>
<p>{{ $tool->description }}</p>
<p><strong>Prix :</strong> {{ $tool->price }} €</p>

<a href="{{ route('tools.index') }}">Retour à la liste</a>
</body>
</html>
