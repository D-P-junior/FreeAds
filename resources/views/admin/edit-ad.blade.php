<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Admin — Modifier annonce</title>
    <link rel="stylesheet" href="{{ asset('css/ads.css') }}">
</head>
<body class="bg-gray-100 min-h-screen">

    {{-- Topbar mobile --}}
    <div class="md:hidden bg-gray-900 text-white px-4 py-3 flex items-center justify-between sticky top-0 z-50">
        <a href="/" class="text-lg font-extrabold">Free<span class="text-blue-400">ads</span></a>
        <div class="flex items-center gap-4">
            <a href="/admin/users" class="text-xs text-gray-400">👥 Users</a>
            <a href="/admin/ads" class="text-xs font-bold text-blue-400">📋 Annonces</a>
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
            </nav>
            <div class="p-4 border-t border-gray-700">
                <form method="POST" action="/logout">
                    @csrf
                    <button class="text-xs text-red-400 hover:text-red-300">↪ Déconnexion</button>
                </form>
            </div>
        </aside>

        {{-- Contenu --}}
        <main class="flex-1 p-4 md:p-8">

            <div class="mb-6">
                <a href="/admin/ads" class="text-sm text-gray-500 hover:text-blue-600 transition">
                    ← Retour aux annonces
                </a>
                <h1 class="text-xl md:text-2xl font-extrabold text-gray-800 mt-2">
                    ✏️ Modifier l'annonce
                </h1>
            </div>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                    @foreach($errors->all() as $error)
                        <p class="text-sm text-red-600">• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="max-w-2xl">
                <form method="POST" action="/admin/ads/{{ $ad->id }}"
                      enctype="multipart/form-data"
                      class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 flex flex-col gap-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Titre</label>
                        <input type="text" name="title"
                               value="{{ old('title', $ad->title) }}"
                               class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 bg-gray-50">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Catégorie</label>
                        <select name="category_id"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 bg-gray-50">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $ad->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Description</label>
                        <textarea name="description" rows="4"
                                  class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 resize-none bg-gray-50">{{ old('description', $ad->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Prix (€)</label>
                            <input type="number" name="price"
                                   value="{{ old('price', $ad->price) }}"
                                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 bg-gray-50">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Localisation</label>
                            <input type="text" name="localisation"
                                   value="{{ old('localisation', $ad->localisation) }}"
                                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 bg-gray-50">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">État</label>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <label class="flex-1 border-2 rounded-xl px-3 py-2.5 text-sm font-semibold text-center cursor-pointer transition hover:border-blue-400
                                {{ old('condition', $ad->condition) == 'neuf' ? 'border-blue-500 bg-blue-50 text-blue-600' : 'border-gray-200' }}">
                                <input type="radio" name="condition" value="neuf"
                                       {{ old('condition', $ad->condition) == 'neuf' ? 'checked' : '' }}>
                                ✨ Neuf
                            </label>
                            <label class="flex-1 border-2 rounded-xl px-3 py-2.5 text-sm font-semibold text-center cursor-pointer transition hover:border-blue-400
                                {{ old('condition', $ad->condition) == 'bon etat' ? 'border-blue-500 bg-blue-50 text-blue-600' : 'border-gray-200' }}">
                                <input type="radio" name="condition" value="bon etat"
                                       {{ old('condition', $ad->condition) == 'bon etat' ? 'checked' : '' }}>
                                👍 Bon état
                            </label>
                            <label class="flex-1 border-2 rounded-xl px-3 py-2.5 text-sm font-semibold text-center cursor-pointer transition hover:border-blue-400
                                {{ old('condition', $ad->condition) == 'abimé' ? 'border-blue-500 bg-blue-50 text-blue-600' : 'border-gray-200' }}">
                                <input type="radio" name="condition" value="abimé"
                                       {{ old('condition', $ad->condition) == 'abimé' ? 'checked' : '' }}>
                                🔧 Abimé
                            </label>
                        </div>
                    </div>

                    {{-- Photo actuelle --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Photo actuelle</label>
                        @if($ad->photos->count() > 0)
                            <div class="w-32 h-24 rounded-xl overflow-hidden border border-gray-200 mb-3">
                                <img src="{{ asset('storage/' . $ad->photos->first()->path) }}"
                                     alt="{{ $ad->title }}"
                                     class="w-full h-full object-cover">
                            </div>
                        @else
                            <p class="text-sm text-gray-400 mb-3">Aucune photo</p>
                        @endif

                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Changer la photo</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-5 text-center hover:border-blue-400 transition bg-gray-50">
                            <input type="file" name="photos[]" accept="image/*"
                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700">
                            <p class="text-xs text-gray-400 mt-2">Laisser vide pour garder la photo actuelle</p>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 pt-2">
                        <button type="submit"
                                class="flex-1 bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 transition text-sm">
                            💾 Sauvegarder
                        </button>
                        <a href="/admin/ads"
                           class="flex-1 border-2 border-gray-200 text-gray-600 font-bold py-3 rounded-xl hover:border-gray-400 transition text-sm text-center">
                            ✕ Annuler
                        </a>
                    </div>

                </form>
            </div>

        </main>
    </div>

</body>
</html>
