<?php
    include '../php/service/DTO/UsuarioDTO.php';
    session_start();
    // error_reporting(0);
    $sesion  = $_SESSION['usuario'];
    $usuario = unserialize($sesion);
    if (!isset($sesion)) {
        header("Location:../index.php");
        die();
    }else if(isset($sesion)){
        if(!($usuario->getTipoUsuario()->getNombreRol()=='Administrador')){
            header("Location:accesoDenegado.html");
        }
    }
?>
<!DOCTYPE html>
<html>

<head>
    <title>JuegoHot</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        .btn-purple {
            background-color: purple;
            color: white;
        }

        .navbar {
            background-color: purple;
        }

        
        body {
            background-color: #F2D5F8;
            /* Cambiar el color de fondo aquí */
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" style="margin-left: 5px;" href="adminJugar.php">JuegoHot</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="adminJugar.php">Jugar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adminJugadores.php">Jugadores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adminNiveles.php">Niveles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adminJuegos.php">Desafios</a>
                    </li>
                    <li class="nav-item float-end">
                        <a class="nav-link" href="../php/service/CtrlLogout.php">salir</a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>

    <div id="contenedor" class="d-flex justify-content-center align-items-center " style="min-height: 100vh;">
        
        <a class="btn btn-purple" href="adminJuego.php">Jugar</a>
    </div>

    </body>
