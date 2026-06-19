<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Modifier — {{ $ad->title }}</title>
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
                <a href="/ads/{{ $ad->id }}" class="text-sm text-gray-500 hover:text-blue-600 transition">
                    ← Retour à l'annonce
                </a>
                @auth
                    <a href="/profile" class="flex items-center gap-2 hover:opacity-80 transition">
                            <div class="w-9 h-9 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                {{ strtoupper(substr(Auth::user()->login, 0, 1)) }}
                            </div>
                            <span class="text-sm font-semibold text-gray-700">{{ Auth::user()->login }}</span>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    {{-- ===== CONTENU ===== --}}
    <main class="max-w-3xl mx-auto w-full px-4 py-8 flex-1">

        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-gray-800">✏️ Modifier l'annonce</h1>
            <p class="text-sm text-gray-500 mt-1">Modifiez les informations de votre annonce.</p>
        </div>

        {{-- Erreurs --}}
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                @foreach($errors->all() as $error)
                    <p class="text-sm text-red-600">• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="/ads/{{ $ad->id }}" enctype="multipart/form-data"
              class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 flex flex-col gap-5">
            @csrf
            @method('PUT')

            {{-- Titre --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Titre <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title"
                       value="{{ old('title', $ad->title) }}"
                       placeholder="Ex: Nintendo Switch comme neuve"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition bg-gray-50">
            </div>

            {{-- Catégorie --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Catégorie <span class="text-red-500">*</span>
                </label>
                <select name="category_id"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition bg-gray-50">
                    <option value="">Choisir une catégorie</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $ad->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Description <span class="text-red-500">*</span>
                </label>
                <textarea name="description" rows="4"
                          placeholder="Décrivez votre article..."
                          class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition resize-none bg-gray-50">{{ old('description', $ad->description) }}</textarea>
            </div>

            {{-- Prix + Localisation --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Prix (€) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="price"
                           value="{{ old('price', $ad->price) }}"
                           placeholder="0" min="0"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition bg-gray-50">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Localisation <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="localisation"
                           value="{{ old('localisation', $ad->localisation) }}"
                           placeholder="Paris, Lyon..."
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition bg-gray-50">
                </div>
            </div>

            {{-- Condition --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    État <span class="text-red-500">*</span>
                </label>
                <div class="flex gap-3">
                    <label class="flex-1 border-2 rounded-xl px-3 py-2.5 text-sm font-semibold text-center cursor-pointer transition hover:border-blue-400 hover:bg-blue-50
                        {{ old('condition', $ad->condition) == 'neuf' ? 'border-blue-500 bg-blue-50 text-blue-600' : 'border-gray-200' }}">
                        <input type="radio" name="condition" value="neuf"
                               {{ old('condition', $ad->condition) == 'neuf' ? 'checked' : '' }}>
                        ✨ Neuf
                    </label>
                    <label class="flex-1 border-2 rounded-xl px-3 py-2.5 text-sm font-semibold text-center cursor-pointer transition hover:border-blue-400 hover:bg-blue-50
                        {{ old('condition', $ad->condition) == 'bon etat' ? 'border-blue-500 bg-blue-50 text-blue-600' : 'border-gray-200' }}">
                        <input type="radio" name="condition" value="bon etat"
                               {{ old('condition', $ad->condition) == 'bon etat' ? 'checked' : '' }}>
                        👍 Bon état
                    </label>
                    <label class="flex-1 border-2 rounded-xl px-3 py-2.5 text-sm font-semibold text-center cursor-pointer transition hover:border-blue-400 hover:bg-blue-50
                        {{ old('condition', $ad->condition) == 'abimé' ? 'border-blue-500 bg-blue-50 text-blue-600' : 'border-gray-200' }}">
                        <input type="radio" name="condition" value="abimé"
                               {{ old('condition', $ad->condition) == 'abimé' ? 'checked' : '' }}>
                        🔧 Abimé
                    </label>
                </div>
            </div>

            {{-- Photo actuelle --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Photo actuelle
                </label>
                @if($ad->photos->count() > 0)
                    <div class="w-32 h-24 rounded-xl overflow-hidden border border-gray-200 mb-3">
                        <img src="{{ asset('storage/' . $ad->photos->first()->path) }}"
                             alt="{{ $ad->title }}"
                             class="w-full h-full object-cover">
                    </div>
                @else
                    <p class="text-sm text-gray-400 mb-3">Aucune photo</p>
                @endif

                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Changer la photo
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-5 text-center hover:border-blue-400 transition bg-gray-50">
                    <div class="text-2xl mb-2">📷</div>
                    <input type="file" name="photos[]" accept="image/*"
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-xs text-gray-400 mt-2">Laisser vide pour garder la photo actuelle</p>
                </div>
            </div>

            {{-- Boutons --}}
            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="flex-1 bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 transition text-sm">
                    💾 Sauvegarder
                </button>
                <a href="/ads/{{ $ad->id }}"
                   class="flex-1 border-2 border-gray-200 text-gray-600 font-bold py-3 rounded-xl hover:border-gray-400 transition text-sm text-center">
                    ✕ Annuler
                </a>
            </div>

        </form>

    </main>

</body>
</html>
