@extends('layout.base')

@section('content')

    <div>
        <div class="log">

            <div class="authentication ">
                <div class="image">

                    <img src="{{ asset('images/ONDE ANTHROPOLOGIQUE DU TOGO.png') }}" alt="Illustration d'inscription"
                        class="illustration">
                </div>


                <div class="form">
                    <div class="login-container">
                        <h1 class="title">Se connecter</h1>

                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <h3>{{ $message }}</h3>
                            </div>
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

                        <form action="{{ route('login') }}" method="post" class="login-form">
                            @csrf

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

                            <button type="submit" class="btn btn-primary">
                                Se connecter
                            </button>
                        </form>

                        <p class="registration-link">New here? <a href="{{ route('registration') }}">Create an Account</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    @endsection
