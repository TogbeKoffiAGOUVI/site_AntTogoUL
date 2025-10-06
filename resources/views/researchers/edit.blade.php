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


    <form action="{{ route('researchers.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div>
            <label for="photo"><b>Photo :</b></label>
            <input type="file" placeholder="Ajouter une photo..." id="photo" name="photo" accept="image/*">
            <img src="{{ $researcher->photo == null ? URL::asset('images/diplome.png') : Storage::url($researcher->photo) }}"
                alt="{{ $researcher->lastname }} - {{ $researcher->firstname }}" width="50">
        </div>

        <div>
            <div>
                <label for="firstname">Prénom(s) du chercheur</label>
                <input type="text" name="firstname" id="firstname" placeholder="Veuillez saisir votre prénom..."
                    value="{{ $researcher->firstname }}">
            </div>


            <div>
                <label for="lastname">Nom du chercheur</label>
                <input type="text" name="lastname" id="lastname"
                    placeholder="Veuillez saisir votre nom..."value="{{ $researcher->lastname }}">
            </div>
            <div>
                <label for="graduate">Grade du chercheur</label>
                <input type="text" name="graduate" id="graduate" placeholder="Veuillez saisir votre grade..."
                    value="{{ $researcher->graduate }}">
            </div>

        </div>

        <div class="icon">
            <a href="/">
                <i class="fa-brands fa-facebook-f"></i>
            </a>
            <a href="#">
                <i class="fa-brands fa-x-twitter"></i>
            </a>
            <a href="#">
                <i class="fa-brands fa-linkedin-in"></i>
            </a>
            <a href="#">
                <i class="fa-brands fa-whatsapp"></i>
            </a>
            <a href="#">
                <i class="fa-brands fa-youtube"></i>
            </a>

        </div>

        <div>
            <button><a href="">A propos</a></button>
        </div>

        <div>
            <h1>Domaine de recherche</h1><br><br>

            <div>
                <label for="searcherprofil">Domaine de recherche</label><br>
                <textarea name="searcherprofil" id="searcherprofil" placeholder="Veuillez saisir votre profil de chercheur..."cols="30"
                    rows="20" value="{{ $researcher->searcherprofil }}"></textarea>
            </div>

            <div>
                <h1>Informations de contact</h1><br>
                <h2>Département d'Anthropologie et études africaines</h2><br>

                <label for="telephone"><b>numéro de téléphone :</b></label>
                <input type="text" placeholder="Veuillez saisir votre numéro de téléphone..." id="telephone"
                    name="telephone" value="{{ $researcher->telephone }}"> <br>

                <label for="email"><b>E-mail :</b></label><br>
                <input type="email" placeholder="Veuillez saisir votre email..." id="email" name="email"
                    value="{{ $researcher->email }}">

                <div class="icon">
                    <a href="/">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="#">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>
                    <a href="#">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                    <a href="#">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                    <a href="#">
                        <i class="fa-brands fa-youtube"></i>
                    </a>

                </div> <br>

            </div>

        </div>

        <button type="submit">Mettre à jour un(e) chercheur(se)</button>

        <div class="CurseurNavigation">
            <button class="LeftCursor"><a href="{{ route('researchers.index') }}">←</a></button>
        </div>

    </form>

@endsection
