@extends('layout.base')

@section('content')

    <h1>Mettre à jour la photo de profil</h1>

    {{-- Affichage des messages de session (succès) --}}
    @if (session('success'))
        <p class="alert alert-success">
            {{ session('success') }}
        </p>
    @endif
    
    {{-- Affichage des erreurs de validation --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Utilise la route 'update' et la méthode 'PUT' pour l'approche CRUD --}}
    <form action="{{ route('profiles.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT') 
        
        {{-- Champ 'name' caché (requis par la validation du contrôleur) --}}
        {{-- Nous devons envoyer le nom de l'utilisateur même si on ne l'affiche pas --}}
        <input type="hidden" name="name" value="{{ Auth::user()->name }}">

        <div>
            <label for="profile_photo"><b>Photo :</b></label>
            {{-- Le nom du champ DOIT être 'profile_photo' pour correspondre au contrôleur --}}
            <input type="file" placeholder="Ajouter une photo..." id="profile_photo" name="profile_photo" accept="image/*" required>
            
            {{-- Affichage de la photo actuelle via la relation profilePhoto --}}
            @php
                $user = Auth::user();
                $currentPhotoPath = optional($user->profilePhoto)->path;
                // Si une photo existe dans la BD, utilisez son chemin. Sinon, utilisez l'image par défaut.
                $photoUrl = $currentPhotoPath ? Storage::url($currentPhotoPath) : URL::asset('images/default_avatar.png'); 
            @endphp
            
            <img src="{{ $photoUrl }}" alt="Photo de profil actuelle" width="50">
        </div>

        <button type="submit">Mettre à jour la photo</button>

        <div class="CurseurNavigation">
            <button class="LeftCursor"><a href="{{ route('profiles.edit') }}">← Retour</a></button>
        </div>

    </form>

@endsection