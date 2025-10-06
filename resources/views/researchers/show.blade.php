@extends('layout.base')
@section('content')
    <h1>Détail du chercheur</h1>


    <b>Photo :</b> <img
        src="{{ $researcher->photo == null ? URL::asset('images/diplome.png') : Storage::url($researcher->photo) }}"
        alt="{{ $researcher->lastname }} - {{ $researcher->firstname }}" width="50"> <br>
    <b>Prénom(s) :</b>{{ $researcher->firstname }} <br>
    <b>Nom :</b>{{ $researcher->lastname }} <br>
    <b>Grade :</b>{{ $researcher->graduate }} <br>
    <b>Domaine de recherche :</b>{{ $researcher->searcherprofil }} <br>
    <b>Téléphone :</b>{{ $researcher->telephone }} <br>
    <b>Email :</b>{{ $researcher->email }} <br>

    <div class="CurseurNavigation">
        <button class="LeftCursor"><a href="{{ route('researchers.index') }}">←</a></button>
    </div>
@endsection
