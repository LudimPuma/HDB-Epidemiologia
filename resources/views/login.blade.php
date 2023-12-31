<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}" />
    <link
      rel="shortcut icon"
      href="{{asset('img/logo.png')}}"
      type="image/x-icon"
    />
    <title>Login</title>
    <style>
        .fondo {
            /* background-image: url('img/Fondo/p3.jpg'); */
            background-image: url('img/p31.png');
            background-size: cover;
            background-repeat: no-repeat;
            /* background-position: center; */
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
    {{-- <img src="./img/logohdb.png" alt="logo_icono" class="logo" style="filter: brightness(95%) contrast(95%); height: 30%;"> --}}


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
        </div>
    </form>

</body>
</html>
