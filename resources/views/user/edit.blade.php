<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
    <title>Freeads — Modifier mon profil</title>
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

                <div class="edit-card">

                    {{-- Header --}}
                    <div class="edit-header">
                        <div class="avatar">
                            {{ strtoupper(substr($user->login, 0, 2)) }}
                        </div>
                        <h3 class="edit-title">Modifier mon profil</h3>
                        <p class="edit-email">{{ $user->email }}</p>
                    </div>

                    {{-- Formulaire --}}
                    <div class="edit-body">

                        {{-- Erreurs --}}
                        @if($errors->any())
                            <div class="alert-error mb-4">
                                @foreach($errors->all() as $error)
                                    <p class="mb-0">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="/profile">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label class="form-label">Pseudo</label>
                                <input
                                    type="text"
                                    name="login"
                                    class="form-input"
                                    placeholder="Votre pseudo"
                                    value="{{ old('login', $user->login) }}"
                                >
                            </div>

                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input
                                    type="email"
                                    name="email"
                                    class="form-input"
                                    placeholder="exemple@gmail.com"
                                    value="{{ old('email', $user->email) }}"
                                >
                            </div>

                            <div class="form-group">
                                <label class="form-label">Téléphone</label>
                                <input
                                    type="text"
                                    name="phone"
                                    class="form-input"
                                    placeholder="0612345678"
                                    value="{{ old('phone', $user->phone) }}"
                                >
                            </div>

                            <div class="edit-footer">
                                <button type="submit" class="btn-save">
                                    💾 Sauvegarder
                                </button>
                                <a href="/profile" class="btn-cancel">
                                    ❌ Annuler
                                </a>
                            </div>

                        </form>

                    </div>

                </div>

            </div>
        </div>
    </div>

</body>
</html>
