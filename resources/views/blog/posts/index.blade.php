@extends('layout.base')

@section('content')
    <h1>Liste des articles</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <a href="{{ route('posts.create') }}">Créer un nouvel article</a>

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
                        <a href="{{ route('posts.show', $post) }}">Voir</a> |
                        <a href="{{ route('posts.edit', $post) }}">Modifier</a> |
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline;">
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
