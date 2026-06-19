<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Freeads</title>
    <link rel="stylesheet" href="{{ asset('css/ads.css') }}">
</head>
<body class="bg-slate-100 min-h-screen flex flex-col">

    {{-- ===== HEADER ===== --}}
    <header class="bg-white shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 py-3">

            <div class="flex items-center justify-between gap-6">

                {{-- Logo --}}
                <a href="/" class="text-2xl font-extrabold text-blue-600 tracking-tight shrink-0">
                    Free<span class="text-gray-800">ads</span>
                </a>

                {{-- Nav desktop --}}
                <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-gray-600">
                    <a href="/" class="text-blue-600 font-bold">Accueil</a>
                    <a href="/ads/create" class="hover:text-blue-600 transition">+ Publier</a>
                    <a href="/admin/users" class="hover:text-blue-600 transition">Panel administrateur</a>
                </nav>

                {{-- Droite desktop --}}
                <div class="hidden md:flex items-center gap-3 shrink-0">
                    @auth
                        <a href="/ads/create" class="flex items-center gap-1 bg-blue-600 text-white text-sm font-semibold px-4 py-2 rounded-full hover:bg-blue-700 transition">
                            + Publier
                        </a>
                        <a href="/profile" class="flex items-center gap-2 hover:opacity-80 transition">
                            <div class="w-9 h-9 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                {{ strtoupper(substr(Auth::user()->login, 0, 1)) }}
                            </div>
                            <span class="text-sm font-semibold text-gray-700">{{ Auth::user()->login }}</span>
                        </a>
                        <a href="/profile" class="text-sm font-semibold text-blue-600 border border-blue-200 px-3 py-1.5 rounded-full">
                            👤 Voir mon profil
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
                        <a href="/admin/users" class="hover:text-blue-600 py-1.5 px-3 rounded-lg hover:bg-blue-50 transition">Panel administrateur</a>
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

            {{-- Menu mobile --}}
            <div id="mobile-menu" class="md:hidden border-t border-gray-100 mt-3 pt-3 pb-2" style="display:none;">
                <nav class="flex flex-col gap-3 text-sm font-medium text-gray-600">
                    <a href="/" class="hover:text-blue-600 transition py-1 border-b border-gray-50">🏠 Accueil</a>
                    <a href="/ads/create" class="hover:text-blue-600 transition py-1 border-b border-gray-50">📝 Déposer</a>
                    <a href="/admin/users" class="hover:text-blue-600 transition py-1 border-b border-gray-50">Panel administrateur</a>
                    @auth
                        <a href="/profile" class="hover:text-blue-600 transition py-1 border-b border-gray-50">
                            👤 {{ Auth::user()->login }}
                        </a>
                        <form method="POST" action="/logout">
                            @csrf
                            <button class="text-red-500 font-semibold py-1 w-full text-left">↪ Déconnexion</button>
                        </form>
                    @else
                        <a href="/login" class="hover:text-blue-600 transition py-1">🔑 Connexion</a>
                        <a href="/register" class="hover:text-blue-600 transition py-1">✨ S'inscrire</a>
                    @endauth
                </nav>
            </div>

        </div>
    </header>

    {{-- Barre de recherche --}}
    <div class="bg-white border-b border-gray-100 py-3 shadow-sm">
        <div class="max-w-3xl mx-auto px-4">
            <form method="GET" action="/">
                <div class="flex items-center bg-slate-50 border-2 border-blue-500 rounded-full px-5 py-2.5 gap-3 shadow-sm">
                    <svg class="w-5 h-5 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Rechercher une annonce, une catégorie..."
                           class="flex-1 text-sm outline-none bg-transparent text-gray-700 placeholder-gray-400">
                    <button type="submit" class="bg-blue-600 text-white text-sm font-semibold px-5 py-1.5 rounded-full hover:bg-blue-700 transition shrink-0">
                        Rechercher
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ===== MAIN ===== --}}
    <main class="max-w-7xl mx-auto w-full px-4 py-6 flex gap-6 flex-1">

        {{-- FILTRES --}}
        <aside class="w-64 shrink-0 hidden md:block">
            <form method="GET" action="/">
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 sticky top-32">

                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">
                        🔧 Filtrer par
                    </h3>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-600 mb-1.5">Catégorie</label>
                        <select name="category" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500 bg-gray-50">
                            <option value="">Toutes</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-600 mb-1.5">Localisation</label>
                        <input type="text" name="localisation" placeholder="Paris, Lyon..."
                               value="{{ request('localisation') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500 bg-gray-50">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-600 mb-1.5">Prix (€)</label>
                        <div class="flex gap-2">
                            <input type="number" name="min_price" placeholder="Min"
                                   value="{{ request('min_price') }}"
                                   class="w-1/2 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500 bg-gray-50">
                            <input type="number" name="max_price" placeholder="Max"
                                   value="{{ request('max_price') }}"
                                   class="w-1/2 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500 bg-gray-50">
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-600 mb-1.5">État</label>
                        <div class="flex flex-col gap-2">
                            @foreach([['neuf','✨ Neuf'],['bon etat','👍 Bon état'],['abimé','🔧 Abimé']] as [$val,$label])
                                <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                                    <input type="checkbox" name="condition[]" value="{{ $val }}"
                                           {{ in_array($val, request('condition', [])) ? 'checked' : '' }}
                                           class="accent-blue-600 w-4 h-4">
                                    {{ $label }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2.5 rounded-xl hover:bg-blue-700 transition text-sm">
                        Appliquer
                    </button>
                    <a href="/" class="block text-center text-xs text-gray-400 mt-2 hover:text-red-500 transition">
                        Réinitialiser
                    </a>

                </div>
            </form>
        </aside>

        {{-- ANNONCES --}}
        <section class="flex-1 min-w-0">

            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-gray-800">Toutes les annonces</h2>
                <span class="bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full">
                    {{ $ads->total() }} résultat(s)
                </span>
            </div>

            <div class="flex flex-col gap-4">
                @forelse($ads as $ad)
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden flex card-hover fade-in">

                        <div class="w-48 h-36 shrink-0 overflow-hidden bg-gray-100">
                            @if($ad->photos->count() > 0)
                                <img src="{{ asset('storage/' . $ad->photos->first()->path) }}"
                                     alt="{{ $ad->title }}"
                                     class="w-full h-full object-cover hover:scale-105 transition duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-3xl text-gray-300">📷</div>
                            @endif
                        </div>

                        <div class="flex-1 p-4 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">
                                        {{ $ad->category->name }}
                                    </span>
                                    <span class="text-xs text-gray-400">{{ $ad->created_at->diffForHumans() }}</span>
                                </div>
                                <h3 class="font-bold text-gray-800 text-base mt-1">{{ $ad->title }}</h3>
                                <p class="text-sm text-gray-500 mt-1">{{ Str::limit($ad->description, 100) }}</p>
                            </div>

                            <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-100 flex-wrap gap-2">
                                <div class="flex items-center gap-3">
                                    <span class="text-blue-600 font-extrabold text-lg">
                                        {{ number_format($ad->price, 0, ',', ' ') }} €
                                    </span>
                                    <span class="text-xs text-gray-400">📍 {{ $ad->localisation }}</span>
                                    <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded-full">
                                        {{ $ad->condition }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-xs text-gray-400">Publié par <span class="font-semibold">{{ $ad->user->login }}</span></span>
                                    <a href="/ads/{{ $ad->id }}" class="bg-blue-600 text-white text-xs font-bold px-4 py-1.5 rounded-full hover:bg-blue-700 transition">
                                        Voir →
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="bg-white rounded-2xl border border-dashed border-gray-300 p-12 text-center">
                        <div class="text-5xl mb-4">😕</div>
                        <h3 class="font-bold text-gray-700 text-lg mb-1">Aucune annonce trouvée</h3>
                        <p class="text-sm text-gray-400 mb-4">Essayez d'autres filtres</p>
                        <a href="/" class="bg-blue-600 text-white text-sm font-bold px-6 py-2 rounded-full hover:bg-blue-700 transition">
                            Voir toutes les annonces
                        </a>
                    </div>
                @endforelse
            </div>

            <div class="mt-6 flex justify-center">
                {{ $ads->appends(request()->query())->links() }}
            </div>

        </section>

    </main>

    {{-- ===== FOOTER ===== --}}
    <footer class="bg-gray-900 text-white mt-10">
        <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="md:col-span-2">
                <a href="/" class="text-2xl font-extrabold tracking-tight">Free<span class="text-blue-400">ads</span></a>
                <p class="text-gray-400 text-sm mt-2 leading-relaxed max-w-xs">
                    La plateforme de petites annonces gratuite. Achetez, vendez, échangez facilement.
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
                    <li><a href="/register" class="text-gray-400 text-sm hover:text-blue-400 transition">Inscription</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-800 py-4 text-center text-xs text-gray-600">
            © 2026 Freeads — DIEU ne joue pas aux dés!
        </div>
    </footer>

</body>
</html>
