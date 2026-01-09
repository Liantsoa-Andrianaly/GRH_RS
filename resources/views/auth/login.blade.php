<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!--link rel="stylesheet" href="{{ asset('assets/boxicons/css/boxicons.min.css') }}"-->
    <link rel="stylesheet" href="{{asset('css/style.css' )}}">

    <title>Connexion - RS</title>
</head>
<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <form  method="POST" action="{{ route('login') }}" class="sign-in-form">
                    @csrf

                    <h2 class="title">Espace de connexion</h2>
                    <div class="input-field">
                        <i class="bx bxs-envelope"></i>
                        <input type="email" id="email" name="email"  placeholder=" Entrez votre email" required autofocus autocomplete="username">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" style="color: red" />                    
                    </div>

                    <div class="input-field">
                        <i class="bx bxs-lock"></i>
                        <input type="password" id="password" name="password"  placeholder="Entrez votre mot de passe" required autocomplete="current-password">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" style="color: red" />                    
                    </div>

                    <input type="submit" value="Se connecter" class="btn solid">
                    <div class="social-media">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">Mot de passe oublié?</a>
                        @endif
                    </div>
                </form>

                <form method="POST" action="{{ route('register') }}" class="sign-up-form">
                    @csrf
                    <h2 class="title">Registration</h2>
                    <div class="input-field">
                        <i class="bx bxs-user"></i>
                        <input type="text" id="name" name="name" placeholder="Entrez votre nom" required autofocus autocomplete="name">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" style="color: red" />                    
                    </div>

                    <div class="input-field">
                        <i class="bx bxs-envelope"></i>
                        <input type="email" id="email" name="email"  placeholder="Entrez votre email" required autofocus autocomplete="username">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" style="color: red" />                    
                    </div>

                    <div class="input-field">
                        <i class="bx bxs-lock"></i>
                        <input type="password" id="password" name="password"  placeholder=" Entrez votre mot de passe" required autocomplete="current-password">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" style="color: red" />
                    </div>

                    <div class="input-field">
                        <i class="bx bxs-lock"></i>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Comfirmer votre mot de passe" required autocomplete="new-password" >
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" style="color: red" />                    
                    </div>

                    <input type="submit" value="Enregistrer" class="btn solid">
                    
                </form> 
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <p>Bienvenue sur l'application des ressources humaines!!</p>
                    <h3>Vous n'avez pas de compte?</h3>
                    <button class="btn transparent" id="sign-up-btn">inscrivez-vous ici</button>
                </div><br><br>
                <img src="/img/service.png" class="image" alt="">

            </div>

            <div class="panel right-panel">
                <div class="content">
                <p>Bienvenue sur l'application des ressources humaines!!</p>
                <h3>Vous avez un compte?</h3>
                    <button class="btn transparent" id="sign-in-btn">Connectez-vous ici</button>
                </div>
                <img src="/img/service.png" class="image" alt="">
            </div>
        </div>
    </div>
<script src="{{asset('js/script.js')}}"></script>
</body>
</html>