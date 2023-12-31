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
        if(!($usuario->getTipoUsuario()->getNombreRol()=='Usuario')){
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

        .container-sm {
            /* Estilos para pantalla pequeña */
            margin-top: 40%;
        }

        .full-screen-container {
            height: 100vh;
            /* Asegura que el contenedor ocupe toda la altura de la pantalla */

        }

        body {
            background-color: #F2D5F8;
            /* Cambiar el color de fondo aquí */
        }

        .btn-grande {
            width: 100%;
            height: 50%;
            font-size: 1.5rem;
        }
        .play-grande{
            width: 1.5rem;
        }

        .custom-btn:hover {
            background-color: #800080;
            /* Cambiar a tu color deseado */
            color: #e692f7;
            /* Cambiar a tu color de texto deseado */
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark btn-grande">
    <div class="container">
            <a class="navbar-brand" style="margin-left: 5px;" href="userJugar.php">JuegoHot</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="userJugar.php">Jugar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="userJugadores.php">Jugadores</a>
                    </li>
                    <li class="nav-item float-end">
                        <a class="nav-link" href="../php/service/CtrlLogout.php">salir</a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>


    <div id="contenedor" class="d-flex justify-content-center align-items-center " style="min-height: 100vh;">

        <div>
            <div id="nivelContainer"></div>
            <div id="jugadorContainer"></div>
            <button class=" btn btn-purple float-end custom-btn" id="siguienteBtn">Siguiente</button>
        </div>

    </div>


    <input type="hidden" class="form-control form-control-lg" id="usuario_id" name="usuario_id"
                value="<?php echo $usuario->getUsuarioId()?>" disabled >
    <audio id="temporizador">
        <source src="../resources/audio/temporizador.mp3" type="audio/mpeg">
    </audio>
    <script>
        $(document).ready(function () {
            var juego;
            var usuario_id= $('#usuario_id').val();
            $.ajax({
                url: "../php/service/CtrlJuegoService.php",
                dataType: "json",
                type: 'get',
                data: {
                  user:usuario_id                  
                },
                success: function (data) {
                    juego = data;
                    var nivelIndex = 0;
                    var asignacionIndex = -1;

                    function mostrarNivel(nivel) {
                        var componentesHtml = '';
                        componentesHtml =
                            '<div class="card text-center ">' +
                            '<div id="cardNivel" class="card-body btn-purple">' +
                            '<h1 class="card-title h1">' + nivel.nivel_nombre + '</h1>' +
                            '<p class="card-text h3">' + nivel.adicional + '</p>' +
                            '</div>' +
                            '<div class="card-footer  btn-purple">' +
                            '<label class="h4" >Diviertanse!!!</label>' +
                            '</div>' +
                            '</div>';
                        $("#nivelContainer").html(componentesHtml);
                        $("#jugadorContainer").empty();
                    }

                    function mostrarAsignacion(asignacion) {
                        var jugador = JSON.parse(asignacion.jugador);
                        var desafio = JSON.parse(asignacion.desafio);
                        var componentesHtml = '';
                        componentesHtml =
                            '<div class="card">' +
                            '<div class="card-header btn-purple">' +
                            '<label  class="form-label h2">' + desafio.nivelNombre + '</label>' +
                            '<label class="h3">' + '-' + desafio.adicional + '</label>' +
                            '</div>' +
                            '<div class="card-body">' +
                            '<h5 id="jugadorNombre" class="card-title h2 font-weight-bold">' + jugador.jugadorNombre + '</h5>' +
                            '<p id="desafioDesc" class="card-text h3">' + desafio.desafioDesc +
                            '</div>' +
                            '</div>';


                        if (desafio.tiempoSegundos > 0) {
                            $("#siguienteBtn").prop("disabled", true);
                            componentesHtml += '<br><span class="h2" id="desafioSegundos">Durante: ' + desafio.tiempoSegundos +
                                ' Segundos</span><br/><button class="btn btn-purple float-end btn-lg btn-block" id="playBtn"' +
                                ' onclick="iniciaTemporizador(' + desafio.tiempoSegundos + ')"> <i class="fas fa-play k" ></i></button>';

                        }
                        $("#jugadorContainer").html(componentesHtml);
                        $("#nivelContainer").empty();
                    }

                    function mostrarDatos() {
                        if (asignacionIndex === -1) {
                            mostrarNivel(juego[nivelIndex]);
                        } else {
                            mostrarAsignacion(juego[nivelIndex].asignaciones[asignacionIndex]);
                        }
                    }

                    function siguiente() {
                        if (asignacionIndex === -1) {
                            asignacionIndex = 0;
                        } else {
                            asignacionIndex++;
                        }

                        if (asignacionIndex >= juego[nivelIndex].asignaciones.length) {
                            asignacionIndex = -1;
                            nivelIndex++;
                            if (nivelIndex >= juego.length) {
                                nivelIndex = 0;
                            }
                        }

                        mostrarDatos();
                    }

                    $("#siguienteBtn").click(function () {
                        siguiente();
                    });

                    mostrarDatos();
                },
                error: function (xhr, status, error) {
                    console.log("Error al cargar el archivo PHP:", error);
                }
            });


        });
        function iniciaTemporizador(segundos) {
            var segundosRestantes = segundos; // Número de segundos restantes
            $("#playBtn").prop("disabled", true);
            // Función que se ejecuta cada segundo
            var temporizador = setInterval(function () {
                // Actualizar el contador
                $("#desafioSegundos").text('Durante:  ' + segundosRestantes + ' Segundos');

                // Restar 1 segundo
                segundosRestantes--;

                // Validar si el temporizador ha terminado
                if (segundosRestantes < 0) {
                    clearInterval(temporizador); // Detener el temporizador
                    var audioElement = $('#temporizador')[0];

                    // Reproduce el audio
                    audioElement.play();
                    $("#siguienteBtn").prop("disabled", false);
                    // Aquí puedes agregar tu lógica adicional después de que el temporizador haya terminado
                }
            }, 1000);
        }
    </script>
    <script>
        $(document).ready(function () {
            // Función para validar el ancho de la pantalla y cambiar la clase del contenedor
            function validarAnchoPantalla() {
                var anchoPantalla = $(window).width();
                if (anchoPantalla < 1000) {
                    $('#contenedor').removeClass('d-flex').addClass('container-sm');
                    $('#contenedor').removeClass('justify-content-center');
                    $('#contenedor').removeClass('align-items-center ');
                    $('#contenedor').addClass('container-fluid full-screen-container');
                    $('#siguienteBtn').addClass('btn-grande');
                    $('#cardNivel').addClass('btn-grande');

                } else {
                    $('#contenedor').removeClass('container-sm').addClass('d-flex');
                    $('#contenedor').addClass('justify-content-center');
                    $('#contenedor').addClass('align-items-center');
                    $('#siguienteBtn').removeClass('btn-grande');
                }
            }

            // Ejecutar la validación al cargar la página
            validarAnchoPantalla();

            // Ejecutar la validación cuando la ventana se redimensione
            $(window).resize(function () {
                validarAnchoPantalla();
            });
        });
    </script>

</body>

</html>