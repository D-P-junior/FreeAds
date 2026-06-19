<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Freeads — Déposer une annonce</title>
    <link rel="stylesheet" href="{{ asset('css/ads.css') }}">
</head>
<body class="bg-slate-100 min-h-screen flex flex-col">

    {{-- ===== HEADER ===== --}}
    <header class="bg-white shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 py-3">
            <div class="flex items-center justify-between gap-6">

                <a href="/" class="text-2xl font-extrabold text-blue-600 tracking-tight shrink-0">
                    Free<span class="text-gray-800">ads</span>
                </a>

                <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-gray-600">
                    <a href="/ads/create" class="text-blue-600 font-bold">Déposer</a>
                    <a href="/" class="hover:text-blue-600 transition">Accueil</a>
                </nav>

                <div class="hidden md:flex items-center gap-3 shrink-0">
                    @auth
                        <a href="/profile" class="flex items-center gap-2 hover:opacity-80 transition">
                            <div class="w-9 h-9 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                {{ strtoupper(substr(Auth::user()->login, 0, 1)) }}
                            </div>
                            <span class="text-sm font-semibold text-gray-700">{{ Auth::user()->login }}</span>
                        </a>
                        <form method="POST" action="/logout">
                            @csrf
                            <button class="text-sm text-red-500 font-semibold border border-red-200 px-3 py-1.5 rounded-full hover:border-red-400 hover:bg-red-50 transition">
                                Déconnexion
                            </button>
                        </form>
                    @else
                        <a href="/login" class="text-sm font-semibold text-blue-600 hover:underline">Connexion</a>
                        <a href="/register" class="bg-blue-600 text-white text-sm font-semibold px-4 py-2 rounded-full hover:bg-blue-700 transition">S'inscrire</a>
                    @endauth
                </div>

                {{-- Burger mobile --}}
            <div class="md:hidden relative" id="burger-wrap">
                <label id="burger-label" class="cursor-pointer p-2 rounded-lg hover:bg-gray-100 transition flex flex-col gap-1.5">
                    <span class="block w-6 h-0.5 bg-gray-700"></span>
                    <span class="block w-6 h-0.5 bg-gray-700"></span>
                    <span class="block w-6 h-0.5 bg-gray-700"></span>
                </label>

                {{-- Menu mobile --}}
                <div id="mobile-menu"
                    class="absolute right-0 top-full w-56 bg-white rounded-xl shadow-lg border border-gray-100 p-3 flex flex-col gap-2 text-sm font-medium text-gray-600"
                    style="display:none;">
                    <a href="/" class="hover:text-blue-600 py-1.5 px-3 rounded-lg hover:bg-blue-50 transition">🏠 Accueil</a>
                    <a href="/ads/create" class="hover:text-blue-600 py-1.5 px-3 rounded-lg hover:bg-blue-50 transition">📝 Déposer</a>
                    @auth
                        <a href="/profile" class="hover:text-blue-600 py-1.5 px-3 rounded-lg hover:bg-blue-50 transition">
                            👤 {{ Auth::user()->login }}
                        </a>
                        <form method="POST" action="/logout">
                            @csrf
                            <button class="text-red-500 font-semibold py-1.5 px-3 w-full text-left rounded-lg hover:bg-red-50 transition">
                                ↪ Déconnexion
                            </button>
                        </form>
                    @else
                        <a href="/login" class="hover:text-blue-600 py-1.5 px-3 rounded-lg hover:bg-blue-50 transition">🔑 Connexion</a>
                        <a href="/register" class="hover:text-blue-600 py-1.5 px-3 rounded-lg hover:bg-blue-50 transition">✨ S'inscrire</a>
                    @endauth
                </div>
            </div>

            </div>

            <div id="mobile-menu" class="md:hidden border-t border-gray-100 mt-3 pt-3 pb-2" style="display:none;">
                <nav class="flex flex-col gap-3 text-sm font-medium text-gray-600">
                    <a href="/" class="hover:text-blue-600 py-1 border-b border-gray-50">🏠 Accueil</a>
                    <a href="/ads/create" class="text-blue-600 font-bold py-1 border-b border-gray-50">📝 Déposer</a>
                    <a href="#" class="hover:text-blue-600 py-1 border-b border-gray-50">📂 Catégories</a>
                    @auth
                        <a href="/profile" class="hover:text-blue-600 py-1 border-b border-gray-50">👤 {{ Auth::user()->login }}</a>
                        <form method="POST" action="/logout">
                            @csrf
                            <button class="text-red-500 font-semibold py-1 w-full text-left">↪ Déconnexion</button>
                        </form>
                    @else
                        <a href="/login" class="hover:text-blue-600 py-1">🔑 Connexion</a>
                        <a href="/register" class="hover:text-blue-600 py-1">✨ S'inscrire</a>
                    @endauth
                </nav>
            </div>

        </div>
    </header>

    {{-- ===== CONTENU ===== --}}
    <main class="max-w-3xl mx-auto w-full px-4 py-8 flex-1">

        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-gray-800">📝 Déposer une annonce</h1>
            <p class="text-sm text-gray-500 mt-1">Remplissez les informations ci-dessous pour publier votre annonce.</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                @foreach($errors->all() as $error)
                    <p class="text-sm text-red-600">• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="/ads" enctype="multipart/form-data"
              class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 flex flex-col gap-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Titre <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" value="{{ old('title') }}"
                       placeholder="Ex: Nintendo Switch comme neuve"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition bg-gray-50">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Catégorie <span class="text-red-500">*</span>
                </label>
                <select name="category_id"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition bg-gray-50">
                    <option value="">Choisir une catégorie</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Description <span class="text-red-500">*</span>
                </label>
                <textarea name="description" rows="4"
                          placeholder="Décrivez votre article en détail..."
                          class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition resize-none bg-gray-50">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Prix (€) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="price" value="{{ old('price') }}"
                           placeholder="0" min="0"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition bg-gray-50">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Localisation <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="localisation" value="{{ old('localisation') }}"
                           placeholder="Paris, Lyon..."
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition bg-gray-50">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    État <span class="text-red-500">*</span>
                </label>
                <div class="flex gap-3">
                    <label class="flex-1 border-2 rounded-xl px-3 py-2.5 text-sm font-semibold text-center cursor-pointer transition hover:border-blue-400 hover:bg-blue-50">
                        <input type="radio" name="condition" value="neuf" {{ old('condition') == 'neuf' ? 'checked' : '' }}>
                        ✨ Neuf
                    </label>
                    <label class="flex-1 border-2 rounded-xl px-3 py-2.5 text-sm font-semibold text-center cursor-pointer transition hover:border-blue-400 hover:bg-blue-50">
                        <input type="radio" name="condition" value="bon etat" {{ old('condition') == 'bon etat' ? 'checked' : '' }}>
                        👍 Bon état
                    </label>
                    <label class="flex-1 border-2 rounded-xl px-3 py-2.5 text-sm font-semibold text-center cursor-pointer transition hover:border-blue-400 hover:bg-blue-50">
                        <input type="radio" name="condition" value="abimé" {{ old('condition') == 'abimé' ? 'checked' : '' }}>
                        🔧 Abimé
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Photos <span class="text-red-500">*</span>
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-blue-400 transition bg-gray-50">
                    <div class="text-3xl mb-2">📷</div>
                    <p class="text-sm text-gray-500 mb-3">Cliquez pour ajouter des photos</p>
                    <input type="file" name="photos[]" multiple accept="image/*"
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-xs text-gray-400 mt-2">JPEG, PNG, JPG — Max 2MB</p>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 transition text-sm">
                    📤 Publier l'annonce
                </button>
                <a href="/" class="flex-1 border-2 border-gray-200 text-gray-600 font-bold py-3 rounded-xl hover:border-gray-400 transition text-sm text-center">
                    ✕ Annuler
                </a>
            </div>

        </form>

    </main>

    {{-- ===== FOOTER ===== --}}
    <footer class="bg-gray-900 text-white mt-10">
        <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="md:col-span-2">
                <a href="/" class="text-2xl font-extrabold tracking-tight">Free<span class="text-blue-400">ads</span></a>
                <p class="text-gray-400 text-sm mt-2 leading-relaxed max-w-xs">
                    La plateforme de petites annonces gratuite.
                </p>
            </div>
            <div>
                <h4 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">Navigation</h4>
                <ul class="flex flex-col gap-2">
                    <li><a href="/" class="text-gray-400 text-sm hover:text-blue-400 transition">Accueil</a></li>
                    <li><a href="/ads/create" class="text-gray-400 text-sm hover:text-blue-400 transition">Déposer</a></li>
                    <li><a href="/profile" class="text-gray-400 text-sm hover:text-blue-400 transition">Mon profil</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">Compte</h4>
                <ul class="flex flex-col gap-2">
                    <li><a href="/login" class="text-gray-400 text-sm hover:text-blue-400 transition">Connexion</a></li>
                    <li><a href="/register" class="text-gray.400 text-sm hover:text-blue-400 transition">Inscription</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-800 py-4 text-center text-xs text-gray-600">
            © 2026 Freeads — DIEU ne joue pas aux dés!
        </div>
    </footer>

</body>
</html>
