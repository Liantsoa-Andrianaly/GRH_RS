<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - RS</title>
    <link rel="stylesheet" href="{{asset('css/welcome.css')}}">
</head>
<style>
    *{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins', sans-serif;
}

.hero{
    width:100%;
    min-height:100vh;
    /*background-color:#0d0b20;*/
    background: linear-gradient(#051033ff,#3c4244ff, #303135ff );
    background-position:center ;
    background-size: cover;
    padding: 10px 10%;
    overflow: hidden;
    position:relative;  

}
nav{
    padding: 10px 0;
    display: flex;
}

.logo{
    width: 140px;
    
}


.content{
    margin-top:10%;
    max-width:600px;
}
.content h1{
    font-size:45px;
    /*color:#b8860b;*/
    color:#f1f2ff;
}
.content p{
    margin:10px 0 30px;
    color:#fff;
    font-size:30px;
    animation-delay:0.5s

}

.content p a{
    margin:10px 0 30px;
    /*color:#b8860b;*/
    color:#040404;
    font-size:20px;
    /*margin-left:200px;*/
    text-decoration:none;
    animation-delay:1s

}
.content p a:hover{
    color:#fff;
    text-decoration:underline;
}

.btn{
   /* background-image:linear-gradient(45deg, #b8860b, #c430d7);*/
   background: #03032eff ;
    font-size:14px;
    border-radius: 30px;
    border-top-right-radius:0;
    transition:0.5s;
}

.btn a{
    text-decoration:none;
    display:inline-block;
    color:#fff;

}

.btn a:hover{
    color:#040404;
    text-decoration:underline;
}

.content .btn{
    padding:15px 80px;
    font-size:16px; 
    animation-delay:1.5s

}

.btn:hover{
    border-top-right-radius:30px;
}
.feature-img {
    width: 50%; /* Largeur par défaut */
    max-width: 600px; /* Taille maximale */
    height: auto; /* Conserver le ratio d'aspect */
    position: absolute;
    bottom: 20%; /* Ajustez la position en fonction du design */
    right: 5%; /* Alignez l'image à droite */
    transition: all 0.3s ease-in-out; /* Animation douce */
}

.feature-img.anim{
    animation-delay:2s
}
@media (max-width: 570px) {
    .feature-img {
        display:none;
    }
}

@media (max-width: 480px) {
    .feature-img {
        display:none;
    }
}
.anim{
    opacity:0;
    transform:translateY(30px);
    animation:moveup 0.5s linear forwards;
}
@keyframes moveup {
    100%{
        opacity: 1;
        transform: translateY(0px);
    }
}
</style>
<body>
    <div class="hero">
        <nav>
            <img src="{{asset('img/Idea noir.png')}}" class="logo">
        </nav>

        <div class="content">
            <h1 class="anim">Bienvenue sur le portail de gestion des ressources humaines</h1>
            <br>
            <marquee behavior="scroll" direction="left"><p class="anim">Impulse Digital Entreprise Agency - IDEA </p></marquee>

                <b><a  href="https://e-ideagency.com" style="text-decoration:none; color:#040404"><h3>e-ideagency.com</h3></a></b> <br><br>  
         
           
            <button class="btn anim">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" >Dashboard</a></li>
                @else
                    <a href="{{ route('login') }}">Connexion</a></li>
                    
                @endauth
            @endif

        </div>


        <img src="{{ asset('img/service.png') }}" class="feature-img anim" alt="Image description">


    </div>

    
    </script>
</body>
</html>