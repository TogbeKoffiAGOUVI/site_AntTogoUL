@extends('layout.base')

@section('content')
    <h1>Liste des articles</h1>

    {{-- BLOC D'AFFICHAGE DES MESSAGES FLASH --}}
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

    <a href="{{ route('blog.posts.create') }}">Créer un nouvel article</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Catégorie</th>
                <th>Slug</th>
                <th>Status</th>
                <th>Vues</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->category->name ?? 'Aucune' }}</td>
                    <td>{{ $post->slug }}</td>
                    <td>{{ $post->status }}</td>
                    <td>{{ $post->views_count }}</td>
                    <td>
                        <a href="{{ route('blog.posts.show', $post) }}">Voir</a> |
                        <a href="{{ route('blog.posts.edit', $post) }}">Modifier</a> |
                        <form action="{{ route('blog.posts.destroy', $post) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Supprimer cet article ?')">
                                Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Aucun article trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $posts->links() }}
@endsection
