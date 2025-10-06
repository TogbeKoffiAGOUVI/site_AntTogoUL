<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/53db158c10.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">

    {{-- <link rel="stylesheet" href="css/home.css"> --}}
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
                        <li><a href=""> Bibliothèque</a></li>
                    </ul>
                </div>

                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="btn">Logout ({{ Auth::user()->name }})</button>
                </form>



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
                        <li><a href=""> Bibliothèque</a></li>
                    </ul>
                </div>

                <button type="submit" class="btn"><a href="{{ route('login') }}">Se connecter</a></button>
                <button type="submit" class="btn"><a href="{{ route('registration') }}">S'inscrire</a></button>
            </div>
        @endif


    </nav>
    @yield('content')

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
