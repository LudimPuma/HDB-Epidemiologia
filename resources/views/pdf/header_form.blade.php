<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            position: relative;
        }

        .header h1, h3 {
            color: rgb(21, 83, 6);
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header h2 {
            margin: 0;
            padding: 0;
        }

        .line-left {
            width: 29%;
            height: 5px;
            background-color: rgb(196, 27, 27); /* Línea roja */
            position: absolute;
            top: 70%; /* Ajusta este valor para moverlo más abajo */
            left: 0;
            transform: translateY(-50%);
        }

        .line-right {
            width: 29%;
            height: 5px;
            background-color: rgb(196, 27, 27);
            position: absolute;
            top: 70%; /* Ajusta este valor para moverlo más abajo */
            right: 0;
            transform: translateY(-50%);
        }
        .line-left_2 {
            width: 33%;
            height: 5px;
            background-color: rgb(27, 102, 8); /* Línea roja */
            position: absolute;
            top: 55%; /* Ajusta este valor para moverlo más abajo */
            left: 0;
            transform: translateY(-50%);
        }

        .line-right_2 {
            width: 33%;
            height: 5px;
            background-color: rgb(27, 102, 8); /* Línea verde */
            position: absolute;
            top: 55%; /* Ajusta este valor para moverlo más abajo */
            right: 0;
            transform: translateY(-50%);
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="line-left"></div>
        <div class="line-left_2"></div>
        <h1>HDB</h1>
        <h3>Hospital Daniel Bracamonte</h3>
        <h3>Comité de Vigilancia Epidemiologica</h3>
        <div class="line-right"></div>
        <div class="line-right_2"></div>
    </div>
</body>
</html>
