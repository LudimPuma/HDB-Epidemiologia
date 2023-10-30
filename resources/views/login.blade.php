<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}" />

    <title>Login</title>
    <style>
    .fondo {
        background-image: url('img/Fondo/p3.jpg'); /* Ruta relativa a la carpeta del CSS */
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center; /* Centra la imagen en la pantalla */
    }
    /* Cambiar el color del texto "Iniciar Sesión" */
    .text-center {
        color: #000000; /* Cambia el color del texto a rojo (#FF0000) */
    }
    .iconos{
    background-color: rgb(165, 21, 21);
    }
    .btn{
        background-color: rgb(21, 116, 12);
    }
    .btn:hover {
    background-color: rgba(21, 116, 12, 0.9); /* Cambiar el color en hover a uno semi-transparente */
    }
    </style>
</head>
<body class="bg-dark d-flex justify-content-center align-items-center vh-100 fondo">
    <img src="./img/logo_HDB.png" alt="logo_icono" class="logo">
    <form method='POST' action="{{route('iniciar-sesion')}}">
        <div class="contenedor  p-5 rounded-5 text-secondary shadow">
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error:</strong> {{ $errors->first('error') }}
                </div>
            @endif
            <div class="d-flex justify-content-center">

            </div>
            <div class="text-center fs-1 fw-bold titulo">
                Iniciar Sesión
            </div>
            <div class="input-group mt-4">
                <div class="input-group-text iconos">
                    <img src="./img/username-icon.svg" alt="username_icon" class="username">
                </div>
                <input type="text" name='email' placeholder="Usuario" class="form-control bg-light">
            </div>
            <div class="input-group mt-1">
                <div class="input-group-text iconos">
                    <img src="./img/password-icon.svg" alt="password_icon" class="password">
                </div>
                <input type="password" name='password' placeholder="Contraseña" class="form-control bg-light">
            </div>
            <button class="btn text-white w-100 mt-4 shadow-sm" type='submit'>Ingresar</button>

            {{-- <div class="d-flex justify-content-around mt-1">
                <div class="d-flex align-items-center gap-1">
                    <input class="form-check-input" type="checkbox" name="" id="" value="1">
                    <div class="recordar pt-1">Recordar</div>

                </div>
                <div class="pt-1">
                    <a class="olvidaste text-decoration-none text-primary fw-semibold fst-italic" href="#">¿Olvidaste tu Contraseña?</a>
                </div>
            </div> --}}

        </div>
    </form>

</body>
</html>
