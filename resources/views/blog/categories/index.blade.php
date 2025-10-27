@extends('layout.base')

@section('content')
    <main>
        <div>
            <h1>Gestion des Catégories</h1>
            <a href="{{ route('categories.create') }}">Nouvelle Catégorie</a>
            <a href="{{ route('posts.create') }}">Créer un nouvel article</a>
        </div>

        <!-- Message de succès/erreur (Laravel session flash) -->
        @if (session('success'))
            <div role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div>
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Slug</th>
                        <th>Posts</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td>
                                <a href="{{ route('categories.show', $category) }}">{{ $category->name }}</a>
                            </td>
                            <td>{{ $category->slug }}</td>
                            <td>{{ $category->posts_count }}</td>
                            <td>{{ Str::limit($category->description, 80) }}</td>
                            <td>
                                <!-- Lien Edit -->
                                <a href="{{ route('categories.edit', $category) }}" title="Modifier"></a>

                                <!-- Formulaire Delete (Doit être une requête POST/DELETE) -->
                                <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Supprimer">
                                        Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Aucune catégorie n'a encore été créée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Liens de pagination -->
        <div>
            {{ $categories->links() }}
        </div>
    </main>
@endsection
