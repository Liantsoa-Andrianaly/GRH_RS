<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - IDEA RH</title>
    <!-- Importation de Poppins pour un look pro -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #00d2ff;
            --secondary-color: #3a7bd5;
            --dark-bg: #050a18;
            --glass-bg: rgba(255, 255, 255, 0.05);
            --text-main: #ffffff;
            --text-dim: #b0b3b8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: var(--dark-bg);
            overflow-x: hidden;
        }

        .hero {
            width: 100%;
            min-height: 100vh;
            background: radial-gradient(circle at top right, #1e2a4a, var(--dark-bg));
            padding: 20px 8%;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        /* Navigation modernisée */
        nav {
            width: 100%;
            padding: 20px 0;
            display: flex;
            align-items: center;
            z-index: 10;
        }

        .logo {
            width: 120px;
            filter: brightness(0) invert(1); /* Rend le logo blanc si l'image est noire */
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        /* Contenu principal */
        .content {
            margin-top: 8%;
            max-width: 700px;
            z-index: 2;
        }

        .content h1 {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.2;
            color: var(--text-main);
            margin-bottom: 20px;
        }

        /* Animation au lieu du Marquee */
        .agency-name {
            font-size: 1.2rem;
            color: var(--primary-color);
            text-transform: uppercase;
            letter-spacing: 4px;
            margin-bottom: 10px;
            display: block;
            font-weight: 600;
            border-left: 3px solid var(--primary-color);
            padding-left: 15px;
        }

        .content p {
            margin-bottom: 40px;
            color: var(--text-dim);
            font-size: 1.1rem;
            max-width: 500px;
        }

        /* Lien URL stylisé */
        .site-link {
            display: inline-block;
            margin-bottom: 30px;
            color: var(--text-main);
            text-decoration: none;
            font-size: 0.9rem;
            opacity: 0.7;
            transition: 0.3s;
            border-bottom: 1px solid transparent;
        }

        .site-link:hover {
            opacity: 1;
            border-bottom: 1px solid var(--primary-color);
        }

        /* Bouton modernisé */
        .btn {
            background: linear-gradient(45deg, var(--secondary-color), var(--primary-color));
            padding: 16px 45px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 20px rgba(0, 210, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .btn a {
            text-decoration: none;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            display: block;
        }

        .btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 210, 255, 0.4);
        }

        /* Image d'illustration avec effet flottant */
        .feature-img {
            width: 45%;
            max-width: 550px;
            position: absolute;
            bottom: 10%;
            right: 5%;
            z-index: 1;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-30px); }
        }

        /* Animations d'entrée */
        .anim {
            opacity: 0;
            transform: translateY(40px);
            animation: fadeInUp 0.8s ease forwards;
        }

        .delay-1 { animation-delay: 0.2s; }
        .delay-2 { animation-delay: 0.4s; }
        .delay-3 { animation-delay: 0.6s; }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        

        /* Responsive */
        @media (max-width: 992px) {
            .feature-img { width: 40%; bottom: 15%; }
            .content h1 { font-size: 2.5rem; }
        }

        @media (max-width: 768px) {
            .feature-img { display: none; }
            .content { text-align: center; margin: 20% auto; }
            .hero { padding: 20px 5%; }
            .agency-name { border-left: none; padding-left: 0; }
        }
    </style>
</head>
<body>
    <div class="hero">
        <nav class="anim">
        </nav>

        <div class="content">
            <span class="agency-name anim delay-1">RAPIDE SERVICE MADAGASCAR</span>
            <h1 class="anim delay-1">Optimisez votre GRH</h1>
            <p class="anim delay-2">Accédez à votre espace collaborateur pour gérer vos congés, vos documents et vos performances en toute simplicité.</p>
            
            <a href="https://srapideservice.rf.gd/?i=1" class="site-link anim delay-2">Site rapide service</a>
            <br>
            
            <div class="anim delay-3">
                <button class="btn">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}">Accéder au Dashboard</a>
                        @else
                            <a href="{{ route('login') }}">Se connecter au Portail</a>
                        @endauth
                    @endif
                </button>
            </div>
        </div>

        <img src="{{ asset('img/service.png') }}" class="feature-img anim delay-3" alt="Illustration RH">
    </div>
</body>
</html>