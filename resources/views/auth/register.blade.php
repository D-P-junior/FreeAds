<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <title>Freeads — Inscription</title>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-9 col-11">

                <div class="card">
                    <div class="card-body">

                        <div class="logo">Freeads</div>
                        <p class="subtitle">Créez votre compte gratuitement</p>

                        {{-- Erreurs --}}
                        @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <p class="mb-0">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="/register">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Pseudo</label>
                                <input
                                    type="text"
                                    name="login"
                                    class="form-control"
                                    placeholder="Votre pseudo"
                                    value="{{ old('login') }}"
                                >
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    placeholder="exemple@gmail.com"
                                    value="{{ old('email') }}"
                                >
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Téléphone</label>
                                <input
                                    type="text"
                                    name="phone"
                                    class="form-control"
                                    placeholder="0612345678"
                                    value="{{ old('phone') }}"
                                >
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Mot de passe</label>
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control"
                                    placeholder="••••••••"
                                >
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Confirmer le mot de passe</label>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    class="form-control"
                                    placeholder="••••••••"
                                >
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Créer mon compte
                            </button>

                        </form>

                        <div class="divider">ou</div>

                        <p class="register-link">
                            Déjà un compte ?
                            <a href="/login">Se connecter</a>
                        </p>

                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
