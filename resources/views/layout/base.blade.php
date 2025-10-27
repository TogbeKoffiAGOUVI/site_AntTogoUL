<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/53db158c10.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loginRegistration.css') }}">
    <link rel="stylesheet" href="{{ asset('css/biblio/category/create.css') }}">
    <link rel="stylesheet" href="{{ asset('css/biblio/category/edit.css') }}">
    <link rel="stylesheet" href="{{ asset('css/biblio/category/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/biblio/category/show.css') }}">
    <link rel="stylesheet" href="{{ asset('css/biblio/document/create.css') }}">
    <link rel="stylesheet" href="{{ asset('css/biblio/document/edit.css') }}">
    <link rel="stylesheet" href="{{ asset('css/biblio/document/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/biblio/document/show.css') }}">
  

    <link
        href="https://fonts.googleapis.com/css2?family=Bonheur+Royale&family=Dancing+Script:wght@400..700&family=Fleur+De+Leah&family=Great+Vibes&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Playwrite+AU+QLD:wght@100..400&family=Playwrite+PE+Guides&family=Playwrite+RO:wght@100..400&family=Romanesco&family=Winky+Rough:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">

    <title>Onde Anthropologique du Togo</title>
</head>

<body>
    {{-- Top bar --}}
    <header>
        <div class="Icon">
            <span class="TopBarIcon"><i class="fa-solid fa-phone"></i> &nbsp; +228 22 22 00 00</span>
            <span class="TopBarIcon"><i class="fa-solid fa-envelope"></i>&nbsp; youremail@gmail.com</span>
        </div>

        <div class="social-links">
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
    </header>

    {{-- Main menu --}}

    <nav>
        <div class="logo">
            <img src="{{ URL::asset('images/ONDE ANTHROPOLOGIQUE DU TOGO blanc.png') }}" alt=" logo">
        </div>

        @if (Auth::check())
            @php
                // Récupérer l'utilisateur pour un accès facile
                $user = Auth::user();

            @endphp

            <div class="MainMenu">
                <div>
                    <ul>
                        <li><a href="{{ route('home') }}">Accueil</a></li>
                    </ul>
                </div>
                <div>
                    <ul>
                        <li><a href="">Ethnologie</a></li>
                    </ul>
                </div>

                <div>
                    <ul>
                        <li><a href="">Blog</a></li>
                    </ul>
                </div>

                <div>
                    <ul>
                        <li><a href="{{ route('researchers.index') }}">Chercheurs</a></li>
                    </ul>
                </div>

                <div>
                    <ul>
                        <li><a href="{{ route('formerStudents.index') }}">Etudiant </a></li>
                    </ul>
                </div>
                <div>
                    <ul>
                        <li><a href="{{ route('categories.index') }}"> Bibliothèque</a></li>
                    </ul>
                </div>
                <div>
                    <ul>
                        <li><a href="{{ route('documents.create') }}"> Ajouter un document</a></li>
                    </ul>
                </div>

                {{-- SECTION: AFFICHAGE DE LA PHOTO ET LIEN DE PROFIL --}}

                <div style="display: flex; align-items: center; margin-left: 10px;">

                    {{-- 1. Afficher l'image de profil ou l'avatar par défaut --}}
                    <a href="{{ route('profiles.edit', $user->id) }}" title="Mettre à jour le profil">
                        @if ($user->profile_photo_path)
                            {{-- Image stockée --}}
                            <img src="{{ Storage::url($user->profile_photo_path) }}" alt="{{ $user->name }}"
                                style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 2px solid white;">
                        @else
                            {{-- Avatar par défaut (ex: première lettre du nom) --}}
                            <div
                                style="width: 35px; height: 35px; background: #6c757d; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: bold;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </a>

                    {{-- 2. Le bouton de Déconnexion --}}
                    <form action="{{ route('logout') }}" method="post" style="margin-left: 10px;">
                        @csrf
                        <button type="submit" class="btn" style="white-space: nowrap;">
                            Logout ({{ $user->name }})
                        </button>
                    </form>
                </div>

            </div>
        @else
            <div class="MainMenu">
                <div>
                    <ul>
                        <li><a href="{{ route('home') }}">Accueil</a></li>
                    </ul>
                </div>
                <div>
                    <ul>
                        <li><a href="">Ethnologie</a></li>
                    </ul>
                </div>

                <div>
                    <ul>
                        <li><a href="{{ route('categories.index') }}">Blog</a></li>
                    </ul>
                </div>

                <div>
                    <ul>
                        <li><a href="{{ route('researchers.index') }}">Chercheurs</a></li>
                    </ul>
                </div>

                <div>
                    <ul>
                        <li><a href="{{ route('formerStudents.index') }}">Etudiant </a></li>
                    </ul>
                </div>
                <div>
                    <ul>
                        <li><a href="{{ route('documents.index') }}"> Bibliothèque</a></li>
                    </ul>
                </div>
                <div>
                    <ul>
                        <li><a href="{{ route('documents.create') }}"> Ajouter un ouvrage</a></li>
                    </ul>
                </div>

                <button type="submit" class="btn"><a href="{{ route('login') }}">Se connecter</a></button>
                <button type="submit" class="btn"><a href="{{ route('registration') }}">S'inscrire</a></button>
            </div>
        @endif


    </nav>
    <main>
        @yield('content')
    </main>

</body>

<footer>

    <div class="logo">
        <img src="{{ URL::asset('images/ONDE ANTHROPOLOGIQUE DU TOGO blanc.png') }}" alt=" logo">

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
    </div>

    <div class="contact">
        <h3>Contact</h3><br>
        <ul>
            <li> | Département d'Anthropologie et Etudes africaines, Université de Lomé, Togo</li>
            <li><span class="TopBarIcon"><i class="fa-solid fa-envelope"></i>&nbsp; youremail@gmail.com</span></li>
            <li><span class="TopBarIcon"><i class="fa-solid fa-phone"></i> &nbsp; +228 22 22 00 00</span></li>
        </ul>
        <div>
            &copy; 2025 Onde Anthropologie du Togo, Tous droits réservé
        </div>
    </div>

</footer>


</html>
