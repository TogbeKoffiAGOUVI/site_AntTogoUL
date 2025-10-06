@extends('layout.base')
@section('content')
    <h1>Détail de l'étudiant(e)</h1>


    <b>Photo :</b> <img
        src="{{ $student->photo == null ? URL::asset('images/diplome.png') : Storage::url($student->photo) }}"
        alt="{{ $student->lastname }} - {{ $student->firstname }}" width="50"> <br>
    <b>Prénom(s) :</b>{{ $student->firstname }} <br>
    <b>Nom :</b>{{ $student->lastname }} <br>
    <b>Téléphone :</b>{{ $student->telephone }} <br>
    <b>Email :</b>{{ $student->email }} <br>
    <b>Parcours :</b>{{ $student->field_of_student }} <br>
    <b>Spécialité :</b>{{ $student->speciality }} <br>
    <b>Graduate :</b>{{ $student->graduate }} <br>
    <b>Promotion :</b>{{ $student->promotion }} <br>
    <b>Réseaux sociaux :</b>{{ $student->social_media }} <br>
    <b>Biographie :</b>{{ $student->biography }} <br>


    <div class="CurseurNavigation">
        <button class="LeftCursor"><a href="{{ route('formerStudents.index') }}">←</a></button>
    </div>
@endsection
