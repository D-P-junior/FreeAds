<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Admin — Modifier utilisateur</title>
    <link rel="stylesheet" href="{{ asset('css/ads.css') }}">
</head>
<body class="bg-gray-100 min-h-screen">

    {{-- Topbar mobile --}}
    <div class="md:hidden bg-gray-900 text-white px-4 py-3 flex items-center justify-between sticky top-0 z-50">
        <a href="/" class="text-lg font-extrabold">Free<span class="text-blue-400">ads</span></a>
        <div class="flex items-center gap-4">
            <a href="/admin/users" class="text-xs font-bold text-blue-400">👥 Users</a>
            <a href="/admin/ads" class="text-xs text-gray-400">📋 Annonces</a>
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
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-semibold">
                    👥 Utilisateurs
                </a>
                <a href="/admin/ads"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-gray-400 hover:bg-gray-800 hover:text-white text-sm font-semibold transition">
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
                <a href="/admin/users" class="text-sm text-gray-500 hover:text-blue-600 transition">
                    ← Retour
                </a>
                <h1 class="text-xl md:text-2xl font-extrabold text-gray-800 mt-2">
                    ✏️ Modifier l'utilisateur
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
                <form method="POST" action="/admin/users/{{ $user->id }}"
                      class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 flex flex-col gap-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Pseudo</label>
                        <input type="text" name="login"
                               value="{{ old('login', $user->login) }}"
                               class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 bg-gray-50">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                        <input type="email" name="email"
                               value="{{ old('email', $user->email) }}"
                               class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 bg-gray-50">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Téléphone</label>
                        <input type="text" name="phone"
                               value="{{ old('phone', $user->phone) }}"
                               class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 bg-gray-50">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Rôle</label>
                        <select name="role"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 bg-gray-50">
                            <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>
                                👤 Utilisateur
                            </option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                👑 Administrateur
                            </option>
                        </select>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 pt-2">
                        <button type="submit"
                                class="flex-1 bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 transition text-sm">
                            💾 Sauvegarder
                        </button>
                        <a href="/admin/users"
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
