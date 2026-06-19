<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Créer une catégorie</title>
  <link rel="stylesheet" href="{{ asset('css/cat.css') }}">
</head>
<body>
@if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
        @foreach($errors->all() as $error)
            <p class="text-sm text-red-600">• {{ $error }}</p>
        @endforeach
    </div>
@endif

<section class="Adding">
  <form action="/cat" method="POST" class="form">
    @csrf
    <h2>Ajouter une catégorie</h2>

    <div class="champ">
      <label for="name">Nom de la catégorie</label>
      <input type="text" name="name" id="name" placeholder="Nom de la catégorie" class="enter" value="{{ old('name') }}">
    </div>

    <div class="champ">
        <label for="parent_id">Catégorie parente (optionnel)</label>
            <select name="parent_id" class="enter">
                <option value="">-- Aucune (catégorie principale) --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
    </div>

    <div>
      <button type="submit" class="add">Ajouter</button>
    </div>

  </form>
  <p><a href="/admin/users">retour</a></p>
</section>
</body>
</html>
