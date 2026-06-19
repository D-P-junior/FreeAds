<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Admin — Annonces</title>
    <link rel="stylesheet" href="{{ asset('css/ads.css') }}">
</head>
<body class="bg-gray-100 min-h-screen">

    {{-- Topbar mobile --}}
    <div class="md:hidden bg-gray-900 text-white px-4 py-3 flex items-center justify-between sticky top-0 z-50">
        <a href="/" class="text-lg font-extrabold">Free<span class="text-blue-400">ads</span></a>
        <div class="flex items-center gap-4">
            <a href="/admin/users" class="text-xs text-gray-400">👥 Users</a>
            <a href="/admin/ads" class="text-xs font-bold text-blue-400">📋 Annonces</a>
            <a href="/cat" class="text-xs font-bold text-gray-400">+ Ajouter une categorie</a>
            <a href="/" class="text-xs font-bold text-gray-400">🏠 Accueil</a>
            <form method="POST" action="/logout">
                @csrf
                <button class="text-xs text-red-400">↪</button>
            </form>
        </div>
    </div>

    <div class="flex min-h-screen">

        {{-- Sidebar desktop --}}
        <aside class="hidden md:flex w-64 bg-gray-900 text-white flex-col shrink-0">
            <div class="p-6 border-b border-gray-700">
                <a href="/" class="text-xl font-extrabold">Free<span class="text-blue-400">ads</span></a>
                <p class="text-xs text-gray-400 mt-1">Panel Administrateur</p>
            </div>
            <nav class="flex flex-col gap-1 p-4 flex-1">
                <a href="/admin/users"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-gray-400 hover:bg-gray-800 hover:text-white text-sm font-semibold transition">
                    👥 Utilisateurs
                </a>
                <a href="/admin/ads"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-semibold">
                    📋 Annonces
                </a>
                <a href="/cat"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-gray-400 hover:bg-gray-800 hover:text-white text-sm font-semibold transition">
                    + Ajouter une categorie
                </a>
                <a href="/"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-gray-400 hover:bg-gray-800 hover:text-white text-sm font-semibold transition">
                    🏠 Accueil
                </a>
            </nav>
            <div class="p-4 border-t border-gray-700">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-xs font-bold">
                        {{ strtoupper(substr(Auth::user()->login, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold">{{ Auth::user()->login }}</p>
                        <p class="text-xs text-gray-400">Administrateur</p>
                    </div>
                </div>
                <form method="POST" action="/logout">
                    @csrf
                    <button class="text-xs text-red-400 hover:text-red-300">↪ Déconnexion</button>
                </form>
            </div>
        </aside>

        {{-- Contenu --}}
        <main class="flex-1 p-4 md:p-8 overflow-x-hidden">

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-xl md:text-2xl font-extrabold text-gray-800">📋 Annonces</h1>
                    <p class="text-sm text-gray-500 mt-1">{{ $ads->total() }} annonce(s)</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="text-left px-4 py-3 font-semibold text-gray-600">#</th>
                                <th class="text-left px-4 py-3 font-semibold text-gray-600 hidden md:table-cell">Photo</th>
                                <th class="text-left px-4 py-3 font-semibold text-gray-600">Titre</th>
                                <th class="text-left px-4 py-3 font-semibold text-gray-600 hidden md:table-cell">Catégorie</th>
                                <th class="text-left px-4 py-3 font-semibold text-gray-600">Prix</th>
                                <th class="text-left px-4 py-3 font-semibold text-gray-600 hidden md:table-cell">Auteur</th>
                                <th class="text-left px-4 py-3 font-semibold text-gray-600 hidden md:table-cell">État</th>
                                <th class="text-left px-4 py-3 font-semibold text-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ads as $ad)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 text-gray-400">{{ $ad->id }}</td>
                                    <td class="px-4 py-3 hidden md:table-cell">
                                        @if($ad->photos->count() > 0)
                                            <img src="{{ asset('storage/' . $ad->photos->first()->path) }}"
                                                 alt="{{ $ad->title }}"
                                                 class="w-12 h-10 object-cover rounded-lg">
                                        @else
                                            <div class="w-12 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-300">
                                                📷
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 font-semibold text-gray-800">
                                        {{ Str::limit($ad->title, 25) }}
                                    </td>
                                    <td class="px-4 py-3 hidden md:table-cell">
                                        <span class="bg-blue-50 text-blue-600 text-xs font-bold px-2 py-1 rounded-full">
                                            {{ $ad->category->name }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 font-bold text-blue-600">
                                        {{ number_format($ad->price, 0, ',', ' ') }} €
                                    </td>
                                    <td class="px-4 py-3 text-gray-600 hidden md:table-cell">
                                        {{ $ad->user->login }}
                                    </td>
                                    <td class="px-4 py-3 hidden md:table-cell">
                                        <span class="bg-green-50 text-green-600 text-xs font-bold px-2 py-1 rounded-full">
                                            {{ $ad->condition }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-1">
                                            <a href="/admin/ads/{{ $ad->id }}/edit"
                                               class="bg-blue-50 text-blue-600 text-xs font-bold px-2 py-1.5 rounded-lg hover:bg-blue-100 transition">
                                                ✏️
                                            </a>
                                            <form method="POST" action="/admin/ads/{{ $ad->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        onclick="return confirm('Supprimer ?')"
                                                        class="bg-red-50 text-red-500 text-xs font-bold px-2 py-1.5 rounded-lg hover:bg-red-100 transition">
                                                    🗑️
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-8 text-center text-gray-400">
                                        Aucune annonce
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                {{ $ads->links() }}
            </div>

        </main>
    </div>

</body>
</html>
