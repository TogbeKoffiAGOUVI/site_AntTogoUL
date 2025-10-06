@extends('layout.base')
@section('content')
    <h1>Ajouter un(e) étudiant(e)</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('formerStudents.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div>
            <label for="photo"><b>Photo :</b></label>
            <input type="file" placeholder="Ajouter une photo..." id="photo" name="photo" accept="image/*">
        </div>

        <div>
            <label for="firstname"><b>Prenom(s) :</b></label>
            <input type="string" placeholder="Veuillez saisir vos prénoms..." id="firstname" name="firstname" />

            <label for="lastname"><b>Nom :</b></label>
            <input type="string" placeholder="Veuillez saisir votre nom..." id="lastname" name="lastname" />

            <label for="telephone"><b>numéro de téléphone :</b></label>
            <input type="string" placeholder="Veuillez saisir votre numéro de téléphone..." id="telephone"
                name="telephone" />

            <label for="email"><b>E-mail :</b></label>
            <input type="string" placeholder="Veuillez saisir votre email..." id="email" name="email" />

            <label for="field_of_student"><b>Parcours :</b></label>
            <input type="string" placeholder="Veuillez saisir votre parcours..." id="field_of_student"
                name="field_of_student" required />

            <label for="speciality"><b>Spécialité :</b></label>
            <input type="string" placeholder="Veuillez saisir votre spécialité..." id="speciality" name="speciality" />

            <label for="graduate"><b>Grade :</b></label>
            <input type="string" placeholder="Veuillez saisir votre grade..." id="graduate" name="graduate" />

            <label for="promotion"><b>Promotion :</b></label>
            <input type="string" placeholder="Veuillez saisir votre année promotion ..." id="promotion" name="promotion" />


            <label for="social_media"><b>Résaux sociaux :</b></label>
            <input type="string" placeholder="Veuillez ajouter vos adresses médias..." id="social_media"
                name="social_media" />

            <label for="biography"><b>Biographie de l'étudiant :</b></label>
            <input type="text" placeholder="Veuillez saisir votre biographie..." id="biography" name="biography" />

        </div>

        <button type="submit">
            Ajouter un(e) étudiant(e)
        </button>
    </form>

@endsection
