@extends('layout.base')

@section('content')
    <div>

        <h1>{{ $post->title }}</h1>

        <div>
            <p>
                <strong>Rebrique :</strong>
                <a href="{{ route('blog.categories.show', $post->category) }}">
                    {{ $post->category->name ?? 'Aucune' }}
                </a>
            </p>
            <span>|</span>
            <p><strong>Status :</strong> {{ $post->status }}</p>
            <span>|</span>
            <p><strong>Vues :</strong> {{ $post->views_count }}</p>
        </div>

        {{-- Affichage de l'Image Miniature --}}
        @if ($post->thumbnail_url)
            <div>
                <img src="{{ $post->thumbnail_url }}" alt="Thumbnail">
            </div>
        @endif

        {{-- Affichage du Média Principal (Image ou Vidéo) --}}
        @if ($post->main_media_url)
            <div>
                @if ($post->main_media_type === 'image')
                    <img src="{{ $post->main_media_url }}" alt="Image principale">
                @elseif ($post->main_media_type === 'video')
                    <video controls>
                        <source src="{{ $post->main_media_url }}">
                        Votre navigateur ne supporte pas la vidéo.
                    </video>
                @endif
            </div>
        @endif

        <div>
            <h3>Contenu :</h3>
            <p>{!! nl2br(e($post->content)) !!}</p>

            @if ($post->excerpt)
                <h3>Extrait :</h3>
                <p>{{ $post->excerpt }}</p>
            @endif
        </div>

        {{-- --- BOUTON DE LIKE AJAX --- --}}
        <div>
            @auth
                @php
                    // Vérifie si l'utilisateur actuellement connecté a aimé cet article
$isLiked = $post->likes->contains('user_id', Auth::id());
                    $likeCount = $post->likes->count();
                @endphp

                {{-- Le style sera géré par les navigateurs par défaut --}}
                <button id="like-button" data-post-id="{{ $post->slug }}" {{-- On utilise le slug pour la route --}}
                    data-liked="{{ $isLiked ? 'true' : 'false' }}">
                    {{-- Nous utilisons un simple texte ou emoji à la place de l'icône Font Awesome --}}
                    <span id="like-icon" style="color: {{ $isLiked ? 'red' : 'grey' }};">
                        {{ $isLiked ? '♥' : '♡' }}
                    </span>
                    <span id="like-count">
                        {{ $likeCount }}
                    </span>
                </button>
                <span>J'aime</span>
            @else
                <span>
                    <span>♡</span>
                    <span>{{ $post->likes->count() }}</span>
                </span>
                <span>({{ $post->likes->count() }} J'aime) - <a href="{{ route('login') }}">Connectez-vous pour
                        aimer.</a></span>
            @endauth
        </div>

        {{-- --- SCRIPT DE GESTION DU LIKE (AJAX) --- --}}
        {{-- Utilisation de JQuery pour la simplicité, assurez-vous qu'il est chargé dans votre layout.base --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            // Correction : Définir l'état d'authentification en variable JS propre pour éviter les erreurs de syntaxe Blade/JS.
            const isAuthenticated = {{ Auth::check() ? 'true' : 'false' }};

            $(document).ready(function() {
                // L'événement click est lié au bouton de like
                $('#like-button').on('click', function(e) {
                    e.preventDefault();

                    // Utilisation de la variable JS pour vérifier l'authentification
                    if (!isAuthenticated) {
                        console.error('Vous devez être connecté pour aimer cet article.');
                        return;
                    }

                    const postId = $(this).data('post-id');
                    const isLiked = $(this).data('liked') === 'true';

                    // Récupération du token CSRF (assurez-vous d'avoir <meta name="csrf-token" content="{{ csrf_token() }}"> dans votre layout)
                    // Nous utilisons l'attribut du tag <meta> ou le cookie XSRF
                    const csrfToken = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        // Route: /posts/{slug}/like/toggle
                        url: "{{ route('blog.posts.like.toggle', ['post' => $post->slug]) }}",
                        type: 'POST',
                        data: {
                            _token: csrfToken // Ajout du token CSRF
                        },
                        success: function(response) {
                            const iconSpan = $('#like-icon');
                            const countSpan = $('#like-count');

                            if (response.action === 'liked') {
                                // Changement vers l'état 'aimé' (coeur plein)
                                iconSpan.text('♥').css('color', 'red');
                                $('#like-button').data('liked', 'true');
                            } else {
                                // Changement vers l'état 'non aimé' (coeur vide)
                                iconSpan.text('♡').css('color', 'grey');
                                $('#like-button').data('liked', 'false');
                            }

                            // Mise à jour du compteur
                            countSpan.text(response.new_count);
                        },
                        error: function(xhr) {
                            if (xhr.status === 401) {
                                // Remplacement de alert() par console.error()
                                console.error(
                                    'Veuillez vous connecter pour effectuer cette action.');
                            } else {
                                console.error("Erreur lors du traitement du like:", xhr
                                    .responseText);
                            }
                        }
                    });
                });
            });
        </script>

        {{-- --- SECTION COMMENTAIRES --- --}}
        <div>
            <h3>
                Commentaires ({{ $post->comments->count() }})
            </h3>

            {{-- FORMULAIRE D'AJOUT DE COMMENTAIRE --}}
            <div>
                <h4>Ajouter un Commentaire</h4>

                @auth
                    {{-- La route utilise le slug: /posts/{slug}/comments --}}
                    <form action="{{ route('blog.posts.comments.store', $post->slug) }}" method="POST">
                        @csrf

                        <div>
                            <label for="content">Votre commentaire</label>
                            <textarea name="content" id="content" rows="4" placeholder="Écrivez votre commentaire ici...">{{ old('content') }}</textarea>

                            @error('content')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit">
                            Publier le Commentaire
                        </button>
                    </form>
                @else
                    <p>
                        Veuillez <a href="{{ route('login') }}">vous connecter</a> pour laisser un commentaire.
                    </p>
                @endauth
            </div>


            {{-- LISTE DES COMMENTAIRES --}}
            <div>
                @forelse ($post->comments->sortByDesc('created_at') as $comment)
                    <div>
                        <div>
                            <div>
                                {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p>{{ $comment->user->name }}</p>
                                <p>
                                    {{ $comment->created_at->diffForHumans() }}
                                </p>
                                <p>
                                    {{ $comment->content }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>Soyez le premier à laisser un commentaire !</p>
                @endforelse
            </div>
        </div>

        <p>
            <a href="{{ route('blog.posts.edit', $post) }}">Modifier l'article</a> |
            <a href="{{ route('blog.posts.index') }}">Retour à la liste</a>
        </p>

    </div>

@endsection
