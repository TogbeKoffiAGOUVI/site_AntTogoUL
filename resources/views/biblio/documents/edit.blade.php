@extends('layout.base')

@section('content')
    <div class="form-container">
        <h1 class="form-title">Modifier un document</h1>

        <!-- Messages de succès/erreur -->
        @if (session('success'))
            <div class="success-message-box">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="error-message-box">
                <p>Veuillez corriger les erreurs suivantes :</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- Fin Messages -->

        <form action="{{ route('biblio.documents.update', $document->id) }}" method="POST" enctype="multipart/form-data"
            class="post-form">
            @csrf
            @method('PUT')

            <!-- Champ Titre -->
            <div class="form-group">
                <label for="title" class="form-label">Titre</label>
                <input type="text" name="title" id="title" value="{{ old('title', $document->title) }}" required
                    class="form-input">
            </div>

            <!-- Champ Description -->
            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-textarea">{{ old('description', $document->description) }}</textarea>
            </div>

            <!-- Champ Catégorie (Select) -->
            <div class="form-group">
                <label for="biblioCategory_id" class="form-label">Catégorie</label>
                <select name="biblioCategory_id" id="biblioCategory_id" required class="form-select">
                    @forelse ($biblioCategories as $biblioCategory)
                        <option value="{{ $biblioCategory->id }}"
                            {{ old('category_id', $document->biblioCategory_id) == $biblioCategory->id ? 'selected' : '' }}>
                            {{ $biblioCategory->name }}
                        </option>
                    @empty
                        <option value="">Pas de Catégorie.</option>
                    @endforelse
                </select>
            </div>

            <!-- Champ Remplacer Fichier -->
            <div class="form-group">
                <label for="file" class="form-label">Remplacer le fichier </label>
                <input type="file" name="file" id="file" class="form-input-file">
            </div>

            <!-- Fichier actuel -->
            @if ($document->file_path)
                <p class="current-file-info">
                    Fichier actuel :
                    <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="file-link">
                        Voir le document
                    </a>
                </p>
            @endif

            <div class="action-buttons-group">
                <button type="submit" class="submit-button primary-button update-button">
                    Mettre à jour le Document
                </button>
            </div>
        </form>
    </div>
@endsection
