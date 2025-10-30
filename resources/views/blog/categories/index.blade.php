@extends('layout.base')

@section('content')

    {{-- AFFICHE 1 : PAGE D'ACCUEIL DU BLOG (Style Maquette) --}}
    @if (!$is_admin_view)
        {{-- ... (Code de la vue publique inchangé) ... --}}
        <div class="hero-banner-container">
            <div class="hero-content">
                <h1 class="hero-title">Bienvenue sur notre Blog Ethnologique</h1>
                <p class="hero-subtitle">Explorez, apprenez , comprendre les dynamiques sociales</p>
            </div>
        </div>

        <div class="main-content-wrapper">

            <h2 class="section-title">Articles récents </h2>

            <div class="latest-articles-grid">

                @forelse ($articles as $article)
                    <a href="{{ route('blog.posts.show', $article->slug) }}" class="article-card">
                        <div class="article-image-container">
                            {{-- CORRECTION 1 : Utilisation de l'accesseur thumbnail_url du modèle Post, qui retourne déjà l'URL complète --}}
                            <img src="{{ $article->thumbnail_url }}" alt="{{ $article->title }}" class="article-image">
                            <div class="article-meta-tag">
                                <span class="category-tag">{{ $article->category->name ?? 'Non classé' }}</span>
                                <span class="views-count">| {{ $article->views_count ?? '0' }} vues</span>
                            </div>
                        </div>

                        <div class="article-body">
                            <h3 class="article-title">{{ $article->title }}</h3>
                            <p class="article-description">{{ Str::limit($article->excerpt, 100) }}</p>
                        </div>
                    </a>
                @empty
                    <p class="empty-list-message">Aucun article publié pour le moment.</p>
                @endforelse
            </div>

            <div class="pagination-links">
                {{ $articles->links() }}
            </div>

            <h2 class="section-title popular-categories-title">Rebrique populaire</h2>
            <div class="popular-categories-tags">
                @forelse ($categories as $category)
                    <a href="{{ route('blog.categories.show', $category->slug) }}"
                        class="category-tag-button">{{ $category->name }}</a>
                @empty
                    <p>Aucune rebrique populaire trouvée.</p>
                @endforelse
            </div>

        </div>

        {{-- AFFICHE 2 : LISTE DE GESTION DES CATÉGORIES (Admin) --}}
    @else
        <div class="admin-main-container">
            <h1 class="page-title">Gestion des Rebriques</h1>

            <div class="action-buttons-container">
                {{-- CRÉER UNE RUBRIQUE DE BLOG (Contrôleur CategoryBlogController) --}}
                <a href="{{ route('blog.categories.create') }}" class="primary-button create-category-button">Créer une
                    Rubrique</a>
            </div>
            <div class="action-buttons-container">
                <a href="{{ route('blog.posts.create') }}" class="primary-button create-category-button">Créer un
                    article</a>
            </div>

            {{-- BLOC D'AFFICHAGE DES MESSAGES FLASH --}}

            {{-- Message de succès (Déjà présent mais légèrement simplifié pour 'success') --}}
            @if (session('success'))
                <div class="success-message-box">
                    <p><strong>Succès!</strong></p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            {{-- Ajout du Message d'erreur --}}
            @if (session('error'))
                <div class="error-message-box">
                    <p><strong>Erreur!</strong></p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            {{-- FIN DU BLOC D'AFFICHAGE DES MESSAGES FLASH --}}

            <div class="categories-list">
                @forelse ($categories as $category)
                    <div class="category-item">
                        <div class="category-name-block">
                            <span class="category-label">Rubrique :</span>
                            <span class="category-name">{{ $category->name }}</span>
                        </div>
                        <div class="category-actions">
                            {{-- CORRECTION 2 : Utiliser le SLUG pour le Route Model Binding --}}
                            <a href="{{ route('blog.categories.show', $category->slug) }}"
                                class="action-link view-link">Voir les articles ({{ $category->posts->count() ?? 0 }})</a>

                            {{-- CORRECTION 2 : Utiliser le SLUG pour le Route Model Binding --}}
                            <a href="{{ route('blog.categories.edit', $category->slug) }}"
                                class="action-link edit-link">Modifier</a>

                            {{-- CORRECTION 2 : Utiliser le SLUG pour le Route Model Binding --}}
                            <form action="{{ route('blog.categories.destroy', $category->slug) }}" method="post"
                                onsubmit="return confirm('Êtes-vous sûr(e) de vouloir supprimer cette rubrique? Cette action sera irréversible !')"
                                class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-link delete-button">Supprimer</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="empty-list-message">
                        Aucune rubrique n'a encore été ajoutée. Veuillez en créer une pour commencer.
                    </p>
                @endforelse
                <div class="pagination-links">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    @endif
@endsection
