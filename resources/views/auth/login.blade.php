@extends('layout.base')

@section('content')
    <h1>Connexion</h1>
    @if ($message = Session::get('success'))
        <h3>{{ $message }}</h3>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('login') }}" method="post">
        @csrf
        <b>Photo de profile :</b> <img
            src="{{ $user->profile_picture == null ? URL::asset('images/diplome.png') : Storage::url($user->profile_picture) }}"
            alt="{{ $user->profile_picture }} - {{ $user->name }}" width="50"> <br>

        <label for="email">E-mail</label>
        <input type="text" name="email" id="email" value="{{ old('email') }}" placeholder="Saisir l'e-mail ici ...">
        <br /><br />

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" placeholder="Saisir le mot de passe ici ...">
        <br /><br />

        <button type="submit">
            Se connecter
        </button>
    </form>
    <p>New here? <a href="{{ route('registration') }}">Create an Account</a></p>
@endsection
