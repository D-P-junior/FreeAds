<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <title>Freeads — Connexion</title>

</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-sm-8 col-11">

                <div class="card">
                    <div class="card-body">

                        <div class="logo">Freeads</div>
                        <p class="subtitle">Connectez-vous à votre compte</p>

                        {{-- Erreurs --}}
                        @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <p class="mb-0">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="/login">
                            @csrf

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

                            <div class="mb-4">
                                <label class="form-label">Mot de passe</label>
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control"
                                    placeholder="••••••••"
                                >
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Se connecter
                            </button>

                        </form>

                        <div class="divider">ou</div>

                        <p class="register-link">
                            Pas encore de compte ?
                            <a href="/register">S'inscrire</a>
                        </p>

                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
