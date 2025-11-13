<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion par lien magique</title>
</head>
<body>
<h1>Connexion Magic Link</h1>

@if(session('message'))
    <p style="color: green;">{{ session('message') }}</p>
@endif

<form action="{{ route('login') }}" method="POST">
    @csrf
    <input type="email" name="email" placeholder="Votre email" required>
    <button type="submit">S’authentifier</button>
</form>
</body>
</html>
