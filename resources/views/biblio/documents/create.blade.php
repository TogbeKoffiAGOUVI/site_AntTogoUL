@extends('layout.base')

@section('content')
    <div class="form-container">
        <h1 class="form-title">Ajouter un document</h1>

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

        <form action="{{ route('biblio.documents.store') }}" method="POST" enctype="multipart/form-data" class="post-form">
            @csrf

            <!-- Champ Titre -->
            <div class="form-group">
                <label for="title" class="form-label">Titre</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required class="form-input">
            </div>

            <!-- Champ Description -->
            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-textarea">{{ old('description') }}</textarea>
            </div>

            <!-- Champ Catégorie (Select) -->
            <div class="form-group">
                <label for="biblioCategory_id" class="form-label">Catégorie</label>
                <select name="biblioCategory_id" id="biblioCategory_id" required class="form-select">
                    @forelse ($biblioCategories as $biblioCategory)
                        <option value="{{ $biblioCategory->id }}"
                            {{ old('biblioCategory_id', $biblioCategory_id ?? null) == $biblioCategory->id ? 'selected' : '' }}>
                            {{ $biblioCategory->name }}
                        </option>
                    @empty
                        <option value="">Pas de Catégorie.</option>
                    @endforelse
                </select>
            </div>

            <!-- Champ Fichier (File Upload) -->
            <div class="form-group">
                <label for="file" class="form-label">Fichier</label>
                <input type="file" name="file" id="file" required class="form-input-file">
            </div>

            <div class="action-buttons-group">
                <button type="submit" class="submit-button primary-button">Ajouter le Document</button>
                <a href="{{ route('biblio.categories.create') }}" class="secondary-button create-category-link">
                    Créer une Rubrique
                </a>
            </div>
        </form>
    </div>
@endsection
