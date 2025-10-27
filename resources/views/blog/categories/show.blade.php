@extends('layout.base')
@section('content')
    <header>
        <h1>Catégorie : {{ $category->name }}</h1>
        @if ($category->description)
            <p>{{ $category->description }}</p>
        @endif
        <a href="{{ route('categories.edit', $category) }}">
            Modifier la Catégorie
        </a>
    </header>

    <h2>Articles Récents ({{ $posts->total() }} trouvés)</h2>

    @if ($posts->isEmpty())
        <div>
            <p>Aucun article n'a encore été publié dans la catégorie "{{ $category->name }}".</p>
        </div>
    @else
        @foreach ($posts as $post)
            <article>

                {{-- Affichage de la miniature (Thumbnail) --}}
                @if ($post->thumbnail_url)
                    {{-- Assurez-vous d'avoir configuré le lien symbolique 'storage' --}}
                    <img src="{{ asset('storage/' . $post->thumbnail_url) }}"
                        alt="Miniature de l'article : {{ $post->title }}">
                @else
                    {{-- Placeholder si aucune image n'est disponible --}}
                    <div>
                        [Image non disponible]
                    </div>
                @endif

                <div>
                    {{-- Titre et lien vers l'article --}}
                    <h2>
                        <a href="{{ route('posts.show', $post) }}">
                            {{ $post->title }}
                        </a>
                    </h2>

                    {{-- Résumé / Extrait --}}
                    <p>
                        {{ $post->excerpt ?? Str::limit($post->content, 150) }}
                    </p>

                    {{-- Métadonnées --}}
                    <small>
                        Publié le {{ $post->created_at->format('d/m/Y') }}
                        @if ($post->category)
                            dans <strong>{{ $post->category->name }}</strong>
                        @endif
                    </small>
                </div>
            </article>
        @endforeach

        {{-- Liens de pagination --}}
        <div>
            {{ $posts->links() }}
        </div>
    @endif

    <div>
        <a href="{{ route('categories.index') }}">
            ← Retour à la liste des catégories
        </a>
    </div>

@endsection
