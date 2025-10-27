@extends('layout.base')

@section('content')

    <main>
        <div>
            <h1>Créer une Nouvelle Catégorie</h1>

            <!-- Affichage des erreurs de validation -->
            @if ($errors->any())
                <div>
                    <strong>Erreur de validation :</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('categories.store') }}" method="POST">
                @csrf

                <!-- Champ Nom -->
                <div>
                    <label for="name">Nom de la Catégorie</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           placeholder="Ex: Anthropologie Sociale">
                    @error('name')<p>{{ $message }}</p>@enderror
                </div>

                <!-- Champ Slug -->
                <div>
                    <label for="slug">Slug (URL)</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                           placeholder="Ex: anthropologie-sociale">
                    <p>Laisser vide pour générer automatiquement à partir du nom.</p>
                    @error('slug')<p>{{ $message }}</p>@enderror
                </div>

                <!-- Champ Description -->
                <div>
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="4"
                              placeholder="Une courte description de cette catégorie.">{{ old('description') }}</textarea>
                    @error('description')<p>{{ $message }}</p>@enderror
                </div>

                <!-- Boutons d'action -->
                <div>
                    <a href="{{ route('categories.index') }}">
                        Annuler
                    </a>
                    <button type="submit">
                        Enregistrer la Catégorie
                    </button>
                </div>
            </form>
        </div>
    </main>

@endsection
