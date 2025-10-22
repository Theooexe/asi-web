<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
    <body>
        <h1>Liste des outils</h1>

        <ul>
            @foreach ($tools as $tool)
                <li>
                    <a href="{{ route('tools.show', $tool->id) }}">
                        {{ $tool->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </body>
</html>
