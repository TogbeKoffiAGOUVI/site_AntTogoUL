@extends('layout.base')
@section('content')
    
    @php
        // 1. Get the authenticated user
        $user = Auth::user();
        
        // 2. Safely get the photo path via the relation
        $photoPath = optional($user->profilePhoto)->path;
        $photoUrl = $photoPath ? Storage::url($photoPath) : URL::asset('images/diplome.png');
    @endphp

    <h1>Photo de profil de {{ $user->name }}</h1>

    <a href="{{ route('profiles.edit') }}" class="button-link">
        <b>Ajouter/Modifier la photo de profil</b>
    </a> <br>
    
    <hr>

    @if ($message = Session::get('success'))
        <p class="alert alert-success">{{ $message }}</p>
    @endif

    {{-- Affichage de la photo --}}
    @if ($photoPath)
        <b>Photo actuelle :</b> 
        <img src="{{ $photoUrl }}" alt="Photo de profil de {{ $user->name }}" width="100"> 
        
        {{-- Formulaire de suppression (optionnel) --}}
        <form action="{{ route('profiles.destroy', $user->id) }}" method="post"
            onsubmit="return confirm('Êtes-vous sûr(e) de vouloir supprimer votre photo de profile ?')" style="display: inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete-button">Supprimer la photo</button>
        </form>

    @else
        <p>Aucune photo n'a été ajoutée pour le moment.</p>
    @endif

@endsection