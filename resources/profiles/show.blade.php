@extends('layout.base')
@section('content')

    {{-- Utiliser Auth::user() pour récupérer l'utilisateur connecté --}}
    @php
        $user = Auth::user();
        
        // Accéder au chemin via la relation 'profilePhoto' et la colonne 'path'
        // 'optional()' gère le cas où la photo n'existe pas (est null)
        $photoPath = optional($user->profilePhoto)->path;
        
        // Déterminer l'URL : si un chemin existe, utiliser Storage::url, sinon utiliser l'image par défaut
        $photoUrl = $photoPath ? Storage::url($photoPath) : URL::asset('images/diplome.png');
    @endphp
    
    <h1>Photo de profil de {{ $user->name }}</h1>

    <div class="photo-display">
        <b>Photo :</b> 
        <img src="{{ $photoUrl }}" alt="Photo de profil actuelle" width="50"> 
    </div>
    
    {{-- Lien vers la page d'édition pour pouvoir modifier la photo --}}
    <a href="{{ route('profiles.edit') }}">Modifier la photo</a>

    <div class="CurseurNavigation">
        <button class="LeftCursor">
            <a href="{{ route('profiles.index') }}">← Retour à la liste</a>
        </button>
    </div>
@endsection