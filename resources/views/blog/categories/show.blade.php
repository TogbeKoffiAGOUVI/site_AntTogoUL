@extends('layout.base')

@section('content')
    {{-- Conteneur principal --}}
    <div class="max-w-4xl mx-auto px-4 py-8 md:py-12">

        {{-- En-tête de la Catégorie --}}
        <header class="text-center mb-10 border-b border-gray-200 pb-4">
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight leading-tight">
                Rebrique : <span class="text-indigo-600">{{ $category->name }}</span>
            </h1>

            @if ($category->description)
                <p class="mt-3 text-lg text-gray-500 max-w-2xl mx-auto">{{ $category->description }}</p>
            @endif

            {{-- Lien de retour --}}
            <a href="{{ route('blog.categories.index') }}"
                class="mt-6 inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800 transition duration-150 ease-in-out">
                &larr; Retour à la liste des rebriques
            </a>

            {{-- Lien Modifiable (si l'utilisateur est admin) --}}
            <a href="{{ route('blog.categories.edit', $category) }}"
                class="mt-6 ml-4 inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 transition duration-150 ease-in-out border-l pl-4">
                Modifier la rebrique
            </a>
        </header>

        {{-- Compteur d'Articles --}}
        <h2 class="text-2xl font-semibold text-gray-700 mb-6 border-b pb-2">
            Articles Récents ({{ $posts->total() }} trouvés)
        </h2>

        @if ($posts->isEmpty())
            {{-- État vide --}}
            <div class="bg-white p-8 rounded-lg shadow-lg text-center">
                <p class="text-xl font-medium text-gray-600">Aucun article n'a encore été publié dans la catégorie
                    "{{ $category->name }}".</p>

            </div>
        @else
            {{-- Liste des Articles --}}
            <div class="space-y-8">
                @foreach ($posts as $post)
                    <article
                        class="flex flex-col md:flex-row bg-white rounded-xl shadow-lg overflow-hidden transition-shadow hover:shadow-xl">

                        {{-- Affichage de la miniature (Thumbnail) --}}
                        <div class="md:w-1/3 flex-shrink-0">
                            @if ($post->thumbnail_url)
                                {{-- Simplification : Supposons que $post->thumbnail_url renvoie l'URL complète --}}
                                <img src="{{ $post->thumbnail_url }}" alt="Miniature de l'article : {{ $post->title }}"
                                    class="w-full h-48 object-cover md:h-full"
                                    onerror="this.onerror=null; this.src='https://placehold.co/400x300/e0e7ff/3f51b5?text=Image+Manquante'">
                            @else
                                {{-- Placeholder si aucune image n'est disponible --}}
                                <div
                                    class="w-full h-48 md:h-full bg-gray-200 flex items-center justify-center text-gray-500">
                                    [Image non disponible]
                                </div>
                            @endif
                        </div>

                        <div class="p-6 md:w-2/3 flex flex-col justify-between">
                            <div>
                                {{-- Titre et lien vers l'article --}}
                                <h2 class="text-2xl font-bold text-gray-900 mb-2 hover:text-indigo-600 transition-colors">
                                    <a href="{{ route('blog.posts.show', $post) }}">
                                        {{ $post->title }}
                                    </a>
                                </h2>

                                {{-- Résumé / Extrait --}}
                                <p class="text-gray-600 mb-4 leading-relaxed">
                                    {{ $post->excerpt ?? Str::limit($post->content, 150) }}
                                </p>
                            </div>

                            {{-- Métadonnées --}}
                            <div
                                class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center text-sm text-gray-500">
                                <small>
                                    Publié le {{ $post->created_at->format('d/m/Y') }}
                                </small>
                                <a href="{{ route('blog.posts.show', $post) }}"
                                    class="font-medium text-indigo-600 hover:text-indigo-800">
                                    Lire l'article &rarr;
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Liens de pagination --}}
            <div class="mt-10">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
@endsection
