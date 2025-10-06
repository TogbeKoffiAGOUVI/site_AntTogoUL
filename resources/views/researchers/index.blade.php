@extends('layout.base')
@section('content')

    <h1>Profil des Chercheurs</h1>

    <a href="{{ route('researchers.create') }}">
        <b>Ajouter un(e) chercheur(se)</b>
    </a> <br>

    @if ($message = Session::get('success'))
        <p>
            {{ $message }}
        </p>
    @endif

    @forelse ($researchers as $researcher)
        <b>Photo :</b> <img
            src="{{ $researcher->photo == null ? URL::asset('images/diplome.png') : Storage::url($researcher->photo) }}"
            alt="{{ $researcher->lastname }} - {{ $researcher->firstname }}" width="50"> <br>
        <b>Prénom(s) :</b>{{ $researcher->firstname }} <br>
        <b>Nom :</b>{{ $researcher->lastname }} <br>
        <b>Grade :</b>{{ $researcher->graduate }} <br>
        <b>Domaine de recherche :</b>{{ $researcher->searcherprofil }} <br>
        <b>Téléphone :</b>{{ $researcher->telephone }} <br>
        <b>Email :</b>{{ $researcher->email }} <br>

        <div>
            <a href="{{ route('researchers.show', $researcher->id) }}">
                Détails
            </a>|
            <a href="{{ route('researchers.edit', $researcher->id) }}">
                Modifier
            </a>|
            <form action="{{ route('researchers.destroy', $researcher->id) }}" method="post"
                onsubmit="return confirm('Êtes-vous sur(e) de vouloir suprimer ce chercheur ou chercheuse ? cette action sera irréversible !')">
                @csrf

                @method('DELETE')
                <button type="submit">
                    Supprimer
                </button>
            @empty
                <p>Aucun(e) chercheur(se) n'a ete ajouter</p>
        </div>
    @endforelse
@endsection
