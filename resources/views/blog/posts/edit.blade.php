@extends('layout.base')

@section('content')
    <h1>Modifier l'article : {{ $post->title }}</h1>

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


    <form action="{{ route('blog.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label>Titre :</label><br>
        <input type="text" name="title" value="{{ old('title', $post->title) }}"><br><br>

        <label>Slug :</label><br>
        <input type="text" name="slug" value="{{ old('slug', $post->slug) }}"><br><br>

        <label>Rebrique :</label><br>
        <select name="category_id">

            @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select><br><br>

        <label>Contenu :</label><br>
        <textarea name="content" rows="6">{{ old('content', $post->content) }}</textarea><br><br>

        <label>Extrait :</label><br>
        <textarea name="excerpt" rows="3">{{ old('excerpt', $post->excerpt) }}</textarea><br><br>

        {{-- 2. GESTION DE L'IMAGE MINIATURE (THUMBNAIL) --}}
        <label>Image miniature :</label><br>
        @if ($post->thumbnail_url)
            <p>Fichier actuel : **{{ basename($post->thumbnail_url) }}**</p>
            {{-- Vous pouvez ajouter ici l'affichage de l'image si vous le souhaitez --}}
        @endif
        <input type="file" name="thumbnail" accept="image/*"><br>
        <small>Laissez vide pour conserver l'image actuelle.</small>
        <br><br>

        {{-- 3. GESTION DU MÉDIA PRINCIPAL --}}
        <label>Média principal :</label><br>
        @if ($post->main_media_url)
            <p>Fichier actuel : **{{ basename($post->main_media_url) }}**</p>
            {{-- Vous pouvez ajouter ici l'affichage du média si vous le souhaitez --}}
        @endif
        <input type="file" name="main_media" accept="image/*,video/*"><br>
        <small>Laissez vide pour conserver le média actuel.</small>
        <br><br>

        <label>Type de média principal :</label><br>
        <select name="main_media_type">
            <option value="image" {{ old('main_media_type', $post->main_media_type) == 'image' ? 'selected' : '' }}>Image
            </option>
            <option value="video" {{ old('main_media_type', $post->main_media_type) == 'video' ? 'selected' : '' }}>Vidéo
            </option>
        </select><br><br>

        <label>Status :</label><br>
        <select name="status">
            <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Brouillon</option>
            <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Publié</option>
            <option value="archived" {{ old('status', $post->status) == 'archived' ? 'selected' : '' }}>Archivé</option>
        </select><br><br>

        <button type="submit"> Mettre à jour</button>
        <a href="{{ route('blog.posts.index') }}">Annuler</a>
    </form>
@endsection
