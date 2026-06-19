<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/email.css') }}">
    <title>Freeads — Vérification Email</title>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-sm-8 col-11">

                <div class="card">
                    <div class="card-body text-center">

                        <div class="logo">Freeads</div>

                        <div class="icon-mail">📧</div>

                        <h4 style="font-weight: 700; color: #333;">
                            Vérifiez votre email !
                        </h4>

                        <p style="color: #888; font-size: 0.95rem; margin: 1rem 0 2rem;">
                            Un email de confirmation a été envoyé à votre adresse.
                            Cliquez sur le lien dans l'email pour activer votre compte.
                        </p>

                        {{-- Message succès --}}
                        @if(session('message'))
                            <div class="alert alert-success mb-3">
                                ✅ {{ session('message') }}
                            </div>
                        @endif

                        <form method="POST" action="/email/resend">
                            @csrf
                            <button type="submit" class="btn-resend">
                                Renvoyer l'email
                            </button>
                        </form>

                        <p style="margin-top: 1.5rem; font-size: 0.85rem; color: #aaa;">
                            Vous n'avez pas reçu l'email ?
                            Vérifiez vos spams !
                        </p>

                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
