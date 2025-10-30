@extends('layout.base')

@section('content')
<div class="list-container">
    <h1 class="page-title">Liste de tous les documents</h1>
    
    <!-- Bouton d'action principal -->
    <div class="action-buttons-container">
        <a href="{{ route('biblio.documents.create') }}" class="primary-button create-document-button">
            Ajouter un document
        </a>
    </div>

    <!-- Message de succès -->
    @if ($message = Session::get('success'))
        <div class="success-message-box">
            {{ $message }}
        </div>
    @endif
    
    <!-- Liste des documents -->
    <div class="documents-list-view">
        @forelse ($documents as $document)
            <div class="document-item">
                <div class="document-info-block">
                    <!-- Titre -->
                    <h2 class="document-title">
                        <a href="{{ route('biblio.documents.show', $document->id) }}" class="title-link">{{ $document->title }}</a>
                    </h2>

                    <!-- Métadonnées -->
                    <div class="document-metadata">
                        <p class="meta-item"><span class="label">Catégorie :</span> {{ $document->biblioCategory->name ?? 'Non classé' }}</p>
                        <p class="meta-item"><span class="label">Description :</span> {{ $document->description }}</p>
                    </div>
                </div>

                <!-- Actions Fichier -->
                @if ($document->file_path)
                    <div class="file-actions">
                        <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="file-action-link view-file-link">
                            Lire
                        </a>
                        <a href="{{ asset('storage/' . $document->file_path) }}"
                            download="{{ $document->title . '.' . pathinfo($document->file_path, PATHINFO_EXTENSION) }}"
                            class="file-action-link download-file-link">
                            Télécharger
                        </a>
                    </div>
                @endif
                
                <!-- Actions Document (Détails, Modifier, Supprimer) -->
                <div class="document-crud-actions">
                    <a href="{{ route('biblio.documents.edit', $document->id) }}" class="action-link edit-link">
                        Modifier
                    </a>
                    
                    <a href="{{ route('biblio.documents.show', $document->id) }}" class="action-link detail-link">
                        Détails
                    </a>
                    
                    <form action="{{ route('biblio.documents.destroy', $document->id) }}" method="post"
                        onsubmit="return confirm('Êtes-vous sûr(e) de vouloir supprimer ce document? Cette action sera irréversible !')"
                        class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-link delete-button">
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="empty-list-message">
                Aucun document n'a été ajouté.
            </p>
        @endforelse
    </div>
</div>
@endsection
