@extends('layout.base')

@section('content')
    <div class="list-container">
        <h1 class="page-title">Liste des Catégories</h1>

        <div class="action-buttons-container">
            <a href="{{ route('categories.create') }}" class="primary-button create-category-button">
                Créer une Rubrique
            </a>
            <a href="{{ route('documents.create') }}" class="secondary-button add-document-button">
                Ajouter un document
            </a>
        </div>

        @if ($message = Session::get('success'))
            <div class="success-message-box">
                <p><strong>Succès!</strong></p>
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="categories-list">
            @forelse ($categories as $category)
                <div class="category-item">
                    <div class="category-name-block">
                        <span class="category-label">Rubrique :</span>
                        <span class="category-name">{{ $category->name }}</span>
                    </div>

                    <div class="category-actions">
                        <a href="{{ route('categories.show', $category->id) }}" class="action-link view-link">
                           lire
                        </a>

                        <a href="{{ route('categories.edit', $category->id) }}" class="action-link edit-link">
                            Modifier
                        </a>

                        <form action="{{ route('categories.destroy', $category->id) }}" method="post"
                            onsubmit="return confirm('Êtes-vous sûr(e) de vouloir supprimer cette rubrique? Cette action sera irréversible !')"
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
                    Aucune rubrique n'a encore été ajoutée. Veuillez en créer une pour commencer.
                </p>
            @endforelse
        </div>
    </div>
@endsection
