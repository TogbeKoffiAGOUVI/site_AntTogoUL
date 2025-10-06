@extends('layout.base')
@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($message = Session::get('success'))
        <p>
            {{ $message }}
        </p>
    @endif

    <form action="{{ route('formerStudents.update', $student->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label for="photo"><b>Photo :</b></label>
            <input type="file" placeholder="Ajouter une photo..." id="photo" name="photo">

            <img src="{{ $student->photo == null ? URL::asset('images/diplome.png') : Storage::url($student->photo) }}"
                alt="{{ $student->lastname }} - {{ $student->firstname }}" width="50">

        </div>

        <div>
            <label for="firstname"><b>Prenom(s) :</b></label>
            <input type="string" placeholder="Veuillez saisir votre prénom..." id="firstname" name="firstname"
                value="{{ $student->firstname }}" />

            <label for="lastname"><b>Nom :</b></label>
            <input type="string" placeholder="Veuillez saisir votre nom..." id="lastname" name="lastname"
                value="{{ $student->lastname }}" />

            <label for="telephone"><b>Numéro de téléphone :</b></label>
            <input type="string" placeholder="Veuillez saisir votre numéro de téléphone..." id="telephone" name="telephone"
                value="{{ $student->telephone }}" />

            <label for="email"><b>E-mail :</b></label>
            <input type="string" placeholder="Veuillez saisir votre email..." id="email" name="email"
                value="{{ $student->email }}" />

            <label for="field_of_student"><b>Parcours :</b></label>
            <input type="string" placeholder="Veuillez saisir votre parcours ..." id="field_of_study" name="field_of_study"
                value="{{ $student->field_of_student }}" />

            <label for="speciality"><b>Spécialité :</b></label>
            <input type="string" placeholder="Veuillez saisir votre spécialité..." id="speciality" name="speciality"
                value="{{ $student->speciality }}" />

            <label for="graduate"><b>Grade :</b></label>
            <input type="string" placeholder="Veuillez saisir votre grade..." id="graduate" name="graduate"
                value="{{ $student->graduate }}" />

            <label for="promotion"><b>Promotion :</b></label>
            <input type="string" placeholder="Veuillez saisir votre promotion..." id="promotion" name="promotion"
                value="{{ $student->promotion }}" />

            <label for="social_media"><b>Résaux sociaux :</b></label>
            <input type="string" placeholder="Veuillez ajouter vos adresses médias..." id="social_media"
                name="social_media" value="{{ $student->social_media }}" />

            <label for="biography"><b>Biographie de l'étudiant(e) :</b></label>
            <input type="text" placeholder="Veuillez saisir votre biographie..." id="biography" name="biography"
                value="{{ $student->biography }}" />


        </div>

        <button type="submit">
            Mettre à Jour
        </button>

    </form>

    <div class="CurseurNavigation">
        <button class="LeftCursor"><a href="{{ route('formerStudents.index') }}">←</a></button>
    </div>

@endsection
