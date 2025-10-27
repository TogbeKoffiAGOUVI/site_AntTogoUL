@extends('layout.base')

@section('content')
    <h1>Créer un article</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 1. CHANGER L'ENCODAGE DU FORMULAIRE : Ajouter enctype="multipart/form-data" --}}
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label>Titre :</label><br>
        <input type="text" name="title" value="{{ old('title') }}"><br><br>

        <label>Slug :</label><br>
        <input type="text" name="slug" value="{{ old('slug') }}"><br><br>

        <label>Catégorie :</label><br>
        <select name="category_id">
            <option value="">-- Choisir une catégorie --</option>
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
        {{-- Remplacé 'thumbnail_url' par 'thumbnail' et type="url" par type="file" --}}

        <label>Média principal :</label><br>
        <input type="file" name="main_media" accept="image/*,video/*"><br><br>
        {{-- Remplacé 'main_media_url' par 'main_media' et type="url" par type="file" --}}
        
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
        <a href="{{ route('posts.index') }}">Annuler</a>
    </form>
@endsection
