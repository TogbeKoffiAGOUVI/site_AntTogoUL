@extends('layout.base')

@section('content')
    <div class="view-documents-container">
        <h1 class="page-title">Documents de la Catégorie : <span class="category-name-display">{{ $biblioCategory->name }}</span>
        </h1>

        <a href="{{ route('biblio.categories.index') }}" class="back-link">
            &larr; Retour à la liste des catégories
        </a>

        <hr class="separator">

        @if ($documents->isEmpty())
            <div class="empty-state-box">
                <p><strong>Aucun document trouvé</strong></p>
                <p>Il n'y a actuellement aucun document associé à cette catégorie.</p>
            </div>
        @else
            <div class="documents-list">
                @foreach ($documents as $document)
                    <div class="document-card">
                        <h2 class="document-title">{{ $document->title }}</h2>

                        <p class="document-description">
                            <span class="label">Description :</span>
                            {{ $document->description ?? 'Aucune description fournie.' }}
                        </p>

                        <p class="document-metadata">
                            <span class="label">Ajouté le:</span> {{ $document->created_at->format('d/m/Y') }}
                        </p>

                        <div class="document-actions">
                            <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank"
                                class="action-button primary-action">
                                Lire
                            </a>

                            <a href="{{ asset('storage/' . $document->file_path) }}"
                                download="{{ $document->title . '.' . pathinfo($document->file_path, PATHINFO_EXTENSION) }}"
                                class="action-button secondary-action">
                                Télécharger le Fichier
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
