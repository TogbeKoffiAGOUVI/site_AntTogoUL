@extends('layout.base')

@section('content')
    <h1>Créer un article</h1>

    {{-- BLOC D'AFFICHAGE DES MESSAGES FLASH (Succès et Erreur) --}}
    @if (session('success'))
        <div style="color: green; border: 1px solid green; padding: 10px; margin-bottom: 15px;">
            <strong>Succès :</strong> {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 15px;">
            <strong>Erreur :</strong> {{ session('error') }}
        </div>
    @endif
    {{-- FIN DU BLOC D'AFFICHAGE DES MESSAGES FLASH --}}

    @if ($errors->any())
        <div style="color: red; margin-bottom: 15px;">
            <strong>Erreur de validation :</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('blog.posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label>Titre :</label><br>
        <input type="text" name="title" value="{{ old('title') }}"><br><br>

        <label>Slug :</label><br>
        <input type="text" name="slug" value="{{ old('slug') }}"><br>
        <small>Laissez vide pour générer automatiquement (recommandé).</small><br><br>

        <label>Catégorie :</label><br>
        <select name="category_id">
            <option value="">-- Choisir une Rebrique --</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select><br><br>

        <label>Contenu :</label><br>
        <textarea name="content" rows="6">{{ old('content') }}</textarea><br><br>

        <label>Extrait :</label><br>
        <textarea name="excerpt" rows="3">{{ old('excerpt') }}</textarea><br><br>

        {{-- 2. CHAMPS DE TÉLÉCHARGEMENT DE FICHIER --}}

        <label>Image miniature :</label><br>
        <input type="file" name="thumbnail" accept="image/*"><br><br>

        <label>Média principal :</label><br>
        <input type="file" name="main_media" accept="image/*,video/*"><br><br>

        <label>Type de média principal :</label><br>
        <select name="main_media_type">
            <option value="">-- Sélectionner --</option>
            <option value="image" {{ old('main_media_type') == 'image' ? 'selected' : '' }}>Image</option>
            <option value="video" {{ old('main_media_type') == 'video' ? 'selected' : '' }}>Vidéo</option>
        </select><br><br>

        <label>Status :</label><br>
        <select name="status">
            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Brouillon</option>
            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publié</option>
            <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archivé</option>
        </select><br><br>

        <button type="submit"> Enregistrer</button>
        <a href="{{ route('blog.posts.index') }}">Annuler</a>
    </form>
@endsection
