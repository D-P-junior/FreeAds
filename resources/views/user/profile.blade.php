<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <title>Freeads — Mon Profil</title>
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="/">Freeads</a>
            <a href="/" class="btn-logout">
                    ← Retour aux annonces
            </a>
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="btn-logout">
                    Se déconnecter
                </button>
            </form>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-7 col-11">

                {{-- Card profil --}}
                <div class="profile-card">

                    {{-- Header --}}
                    <div class="profile-header">
                        <div class="avatar">
                            {{ strtoupper(substr($user->login, 0, 2)) }}
                        </div>
                        <h3 class="profile-name">{{ $user->login }}</h3>
                        <p class="profile-email">{{ $user->email }}</p>
                    </div>

                    {{-- Infos --}}
                    <div class="profile-body">

                        <div class="info-item">
                            <span class="info-label">Pseudo</span>
                            <span class="info-value">{{ $user->login }}</span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Email</span>
                            <span class="info-value">{{ $user->email }}</span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Téléphone</span>
                            <span class="info-value">{{ $user->phone }}</span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Membre depuis</span>
                            <span class="info-value">{{ $user->created_at->format('d/m/Y') }}</span>
                        </div>

                    </div>

                    {{-- Actions --}}
                    <div class="profile-footer">
                        <a href="/profile/edit" class="btn-edit">
                            ✏️ Modifier mon profil
                        </a>

                        <form method="POST" action="/profile">
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="btn-delete"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ?')">
                                🗑️ Supprimer mon compte
                            </button>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>

</body>
</html>
