@extends('layout.base')

@section('content')
    <h1>{{ $post->title }}</h1>
    <p><strong>Catégorie :</strong> {{ $post->category->name ?? 'Aucune' }}</p>
    <p><strong>Slug :</strong> {{ $post->slug }}</p>
    <p><strong>Status :</strong> {{ $post->status }}</p>
    <p><strong>Vues :</strong> {{ $post->views_count }}</p>

    {{-- Affichage de l'Image Miniature --}}
    @if ($post->thumbnail_url)
        <p>
            {{-- Utiliser asset('storage/') pour générer l'URL publique --}}
            <img src="{{ asset('storage/' . $post->thumbnail_url) }}" alt="Thumbnail" width="200">
        </p>
    @endif

    {{-- Affichage du Média Principal (Image ou Vidéo) --}}
    @if ($post->main_media_url)
        @php
            // Préparer l'URL du média principal
            $mainMediaUrl = asset('storage/' . $post->main_media_url);
        @endphp
        
        @if ($post->main_media_type === 'image')
            <p>
                {{-- Afficher l'image --}}
                <img src="{{ $mainMediaUrl }}" alt="Image principale" width="400">
            </p>
        @elseif ($post->main_media_type === 'video')
            <p>
                {{-- Afficher la vidéo --}}
                <video controls width="400">
                    {{-- Assurez-vous que le type est bien défini pour le navigateur --}}
                    <source src="{{ $mainMediaUrl }}"> 
                    Votre navigateur ne supporte pas la vidéo.
                </video>
            </p>
        @endif
    @endif

    <h3>Contenu :</h3>
    <p>{!! nl2br(e($post->content)) !!}</p>

    @if ($post->excerpt)
        <h3>Extrait :</h3>
        <p>{{ $post->excerpt }}</p>
    @endif

    <p>
        <a href="{{ route('posts.edit', $post) }}"> Modifier</a> |
        <a href="{{ route('posts.index') }}"> Retour</a>
    </p>
@endsection