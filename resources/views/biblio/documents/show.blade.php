@extends('layout.base')

@section('content')
    <div class="document-detail-page">

        <!-- Section du titre et des actions principales -->
        <div class="header-section">
            <h1 class="document-main-title">{{ $document->title }}</h1>
            <div class="header-actions">
                <!-- Retour à la liste -->
                <a href="{{ route('documents.index') }}" class="back-link">
                    <span class="icon">←</span> Retour
                </a>
                <!-- Modifier -->
                <a href="{{ route('documents.edit', $document->id) }}" class="edit-link">
                    Modifier le document
                </a>
            </div>
        </div>

        <!-- Carte d'informations flottante (comme dans l'image) -->
        <div class="detail-card">

            <!-- Bloc d'informations -->
            <div class="info-block">
                <h2 class="block-title">Informations Générales</h2>
                <p class="detail-item">
                    <span class="label">Catégorie :</span>
                    <span class="value">{{ $document->category->name ?? 'Non classé' }}</span>
                </p>
                <p class="detail-item description">
                    <span class="label">Description :</span>
                    <span class="value">{{ $document->description ?? 'Aucune description fournie.' }}</span>
                </p>
                <p class="detail-item path">
                    <span class="label">Chemin du fichier :</span>
                    <code class="file-path-code">{{ $document->file_path }}</code>
                </p>
            </div>

            <!-- Bloc d'actions sur le fichier -->
            <div class="action-block">
                <h2 class="block-title">Actions Fichier</h2>
                @if ($document->file_path)
                    <div class="file-actions-group">
                        <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank"
                            class="file-action-button primary-action">
                            <span class="icon">📖</span> Lire le document
                        </a>
                        <a href="{{ asset('storage/' . $document->file_path) }}" download
                            class="file-action-button secondary-action">
                            <span class="icon">⬇️</span> Télécharger
                        </a>
                    </div>
                @else
                    <p class="no-file-message">Aucun fichier n'est associé à ce document.</p>
                @endif
            </div>

        </div>
    </div>
@endsection
