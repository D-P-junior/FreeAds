<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>{{ $ad->title }} — Freeads</title>
    <link rel="stylesheet" href="{{ asset('css/ads.css') }}">
</head>
<body class="bg-slate-100 min-h-screen flex flex-col">

    {{-- ===== HEADER SIMPLE ===== --}}
    <header class="bg-white shadow-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="/" class="text-2xl font-extrabold text-blue-600 tracking-tight">
                Free<span class="text-gray-800">ads</span>
            </a>
            <div class="flex items-center gap-3">
                <a href="/" class="text-sm text-gray-500 hover:text-blue-600 transition">
                    ← Retour aux annonces
                </a>
                @auth
                    <a href="/profile" class="flex items-center gap-2 hover:opacity-80 transition">
                            <div class="w-9 h-9 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                {{ strtoupper(substr(Auth::user()->login, 0, 1)) }}
                            </div>
                            <span class="text-sm font-semibold text-gray-700">{{ Auth::user()->login }}</span>
                    </a>
                @else
                    <a href="/login" class="text-sm font-semibold text-blue-600 hover:underline">Connexion</a>
                @endauth
            </div>
        </div>
    </header>

    {{-- ===== CONTENU ===== --}}
    <main class="max-w-5xl mx-auto w-full px-4 py-8 flex-1">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- COLONNE GAUCHE --}}
            <div class="md:col-span-2 flex flex-col gap-5">

                {{-- Photo unique --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    @if($ad->photos->count() > 0)
                        <div class="w-full h-80 overflow-hidden bg-gray-100">
                            <img src="{{ asset('storage/' . $ad->photos->first()->path) }}"
                                 alt="{{ $ad->title }}"
                                 class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="w-full h-80 flex items-center justify-center bg-gray-50 text-5xl text-gray-300">
                            📷
                        </div>
                    @endif
                </div>

                {{-- Description --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                    <h2 class="text-base font-bold text-gray-700 mb-3">
                        📄 Description
                    </h2>
                    <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">
                        {{ $ad->description }}
                    </p>
                </div>

            </div>

            {{-- COLONNE DROITE --}}
            <div class="flex flex-col gap-4">

                {{-- Titre + Prix --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">

                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">
                            {{ $ad->category->name }}
                        </span>
                        <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded-full">
                            {{ $ad->condition }}
                        </span>
                    </div>

                    <h1 class="text-xl font-extrabold text-gray-800 mb-3">
                        {{ $ad->title }}
                    </h1>

                    <div class="text-3xl font-extrabold text-blue-600 mb-4">
                        {{ number_format($ad->price, 0, ',', ' ') }} €
                    </div>

                    <div class="flex flex-col gap-2 text-sm text-gray-500 border-t border-gray-100 pt-4">
                        <div class="flex items-center gap-2">
                            <span>📍</span>
                            <span>{{ $ad->localisation }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span>🕐</span>
                            <span>{{ $ad->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                </div>

                {{-- Vendeur --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">
                        Vendeur
                    </h3>
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-base">
                            {{ strtoupper(substr($ad->user->login, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 text-sm">{{ $ad->user->login }}</p>
                            <p class="text-xs text-gray-400">
                                Membre depuis {{ $ad->user->created_at->format('M Y') }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <p class="text-xs text-gray-400">📞 Contacter le vendeur</p>
                        <p class="text-sm font-semibold text-gray-700 mt-1">
                            {{ $ad->user->phone }}
                        </p>
                    </div>
                </div>

                {{-- Actions si c'est son annonce --}}
                @auth
                    @if(Auth::id() === $ad->user_id)
                        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 flex flex-col gap-3">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                                Mes actions
                            </h3>
                            <a href="/ads/{{ $ad->id }}/edit"
                               class="w-full bg-blue-600 text-white font-bold py-2.5 rounded-xl hover:bg-blue-700 transition text-sm text-center">
                                ✏️ Modifier l'annonce
                            </a>
                            <form method="POST" action="/ads/{{ $ad->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Supprimer cette annonce ?')"
                                        class="w-full border-2 border-red-200 text-red-500 font-bold py-2.5 rounded-xl hover:bg-red-50 hover:border-red-400 transition text-sm">
                                    🗑️ Supprimer
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth

            </div>

        </div>

    </main>

</body>
</html>
