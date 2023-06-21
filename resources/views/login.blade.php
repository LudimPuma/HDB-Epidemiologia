<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}" />
    
    <title>Login</title>
</head>
<body class="bg-dark d-flex justify-content-center align-items-center vh-100">
    <form method='POST' action="{{route('iniciar-sesion')}}">
    <div class="contenedor bg-white p-5 rounded-5 text-secondary shadow">
        @csrf    

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error:</strong> {{ $errors->first('error') }}
            </div>
        @endif
        <div class="d-flex justify-content-center">
            <img src="./img/logo_HDB.png" alt="logo_icono" class="logo">
        </div>
        <div class="text-center fs-1 fw-bold">
            Iniciar Sesión
        </div>
        <div class="input-group mt-4">
            <div class="input-group-text bg-secondary">
                <img src="./img/username-icon.svg" alt="username_icon" class="username">
            </div>
            <input type="text" name='email' placeholder="Usuario" class="form-control bg-light">
           </div>
        <div class="input-group mt-1">
            <div class="input-group-text bg-secondary">
                <img src="./img/password-icon.svg" alt="password_icon" class="password">
            </div>
            <input type="password" name='password' placeholder="Contraseña" class="form-control bg-light">
        </div>
        <button class="btn bg-secondary text-white w-100 mt-4 shadow-sm" type='submit'>Login</button>
        
        <div class="d-flex justify-content-around mt-1">
            <div class="d-flex align-items-center gap-1">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1">
                <div class="recordar pt-1">Recordar</div>

            </div>
            <div class="pt-1">
                <a class="olvidaste text-decoration-none text-primary fw-semibold fst-italic" href="#">¿Olvidaste tu Contraseña?</a>
            </div>
        </div>
        
    </div>
    </form>
    
</body>
</html>