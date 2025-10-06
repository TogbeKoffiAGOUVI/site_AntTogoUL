@extends('layout.base')
@section('content')
    <h1>Liste des ancien(e)s étudiant(e) du Département d'Anthropologie et études africaines</h1>

    <a href="{{ route('formerStudents.create') }}">
        <b>Ajouter un(e) étudiant(e)</b>
    </a>

    @if ($message = Session::get('success'))
        <p>
            {{ $message }}
        </p>
    @endif


    <table>
        <thead>
            <tr>
                <th><b>Photo :</b></th>
                <th><b>Prénom(s) :</b></th>
                <th><b>Nom :</b></th>
                <th><b>téléphone :</b></th>
                <th><b>E-mail :</b></th>
                <th><b>Parcours :</b></th>
                <th><b>Spécialité :</b></th>
                <th><b>Grade :</b></th>
                <th><b>Promotion :</b></th>
                <th><b>Réseaux sociaux :</b></th>
                <th><b>Biographie :</b></th>

            </tr>
        </thead>

        <tbody>
            @forelse ($students as $student)
                <tr>
                    <td>
                        <img src="{{ $student->photo == null ? URL::asset('images/diplome.png') : Storage::url($student->photo) }}"
                            alt="{{ $student->lastname }} - {{ $student->firstname }}" width="50">

                    </td>
                    <td>{{ $student->firstname }}</td>
                    <td>{{ $student->lastname }}</td>
                    <td>{{ $student->telephone }}</td>
                    <td>{{ $student->email }} </td>
                    <td>{{ $student->field_of_student }}</td>
                    <td>{{ $student->speciality }}</td>
                    <td>{{ $student->graduate }}</td>
                    <td>{{ $student->promotion }}</td>
                    <td>{{ $student->social_media }} </td>
                    <td>{{ $student->biography }} </td>

                    <td>
                        <a href="{{ route('formerStudents.show', $student->id) }}">
                            Détails
                        </a>|
                        <a href="{{ route('formerStudents.edit', $student->id) }}">
                            Modifier
                        </a>|
                        <form action="{{ route('formerStudents.destroy', $student->id) }}" method="post"
                            onsubmit="return confirm('Êtes-vous sur(e) de vouloir suprimer cet étudiant ou cette étudiante ? cette action sera irréversible !')">
                            @csrf

                            @method('DELETE')
                            <button type="submit">
                                Supprimer
                            </button>

                    </td>

                </tr>
            @empty
                <p>Aucun Etudiant n'a ete ajouter</p>
            @endforelse
        </tbody>

    </table>
   
@endsection
