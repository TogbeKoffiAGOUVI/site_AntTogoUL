@extends('layout.base')

@section('content')
    <div>
        <div class="log">
            <div class="authentication">
                <div class="image">

                    <img src="{{ asset('images/ONDE ANTHROPOLOGIQUE DU TOGO.png') }}" alt="Illustration d'inscription"
                        class="illustration">
                </div>

                <div class="form">
                    <div class="login-container">

                        <h1 class="title">Inscription</h1>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('registration') }}" method="post"class="login-form">
                            @csrf

                            <div class="form-group">
                                <label for="name">Nom de l'utilisateur</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    placeholder="Saisir le nom ici ..." required class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="text" name="email" id="email" value="{{ old('email') }}"
                                    placeholder="Saisir l'e-mail ici ..." required class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="password">Mot de passe</label>
                                <input type="password" name="password" id="password"
                                    placeholder="Saisir le mot de passe ici ..." required class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirmer le mot de passe</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    placeholder="Confirmez le mot de passe ici ..." required class="form-control">
                            </div>

                            <button type="submit"class="btn btn-primary">
                                S'inscrire
                            </button>
                        </form>
                        <p class="registration-link">Already have an Account? <a href="{{ route('login') }}">Se
                                connecter</a></p>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection