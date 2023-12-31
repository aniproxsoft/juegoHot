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
    <title>Jugadores</title>
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

        .fondoCard {
            background-color: #e7a9f3;
            /* Cambiar el color de fondo aquí */
        }

        .fullscreen {
            margin-top: 5%;
        }

        .floating-button {
            position: fixed;
            right: 20px;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: purple;
            color: #ffffff;
            text-align: center;
            line-height: 80px;
            font-size: 24px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
            z-index: 9999;
            bottom: 35px;
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
    <div class="alert alert-success d-none" id="alertSuccess">
        <h2> Jugador Guardado correctamente. </h2>
    </div>

    <!-- Alerta de error -->
    <div class="alert alert-danger d-none" id="alertError">
        <h2> Error al guardar el jugador. Intentalo de nuevo.</h2>
    </div>
    <div class="list-group-item list-group-item-action  btn-purple">
        <h1>Guardar Jugador</h1>
    </div>

    <div class="container-fluid fullscreen">
        <div class="card  fondoCard">
            <div id="cardNivel" class="card-body ">
                <form id="guardarJugadorForm">
                    <div class="form-group">
                        <label class="h2" for="nombre">Nombre:</label>
                        <input type="text" id="nombre" class="form-control form-control-lg" required />
                        <div class="invalid-feedback h1">
                            <h2> El nombre debe tener entre 3 y 50 caracteres sin acentos o caracteres especiales.
                            </h2>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label style="margin-left: 20px;" class="h2" for="sexo">Sexo:</label>
                        <input class=" form-check-input form-control-lg" type="radio" id="sexoM" name="sexo" value="M"
                            required>
                        <label style="margin-left: 20px;" class="h2" for="sexoM">Masculino</label>
                        <input class="form-check-input form-control-lg" type="radio" id="sexoF" name="sexo" value="F"
                            required>
                        <label style="margin-left: 20px;" class="h2" for="sexoF">Femenino</label>
                    </div>


                    <br /><br /><br />
                    <button type="submit" class="btn btn-purple float-end h1 btn-lg custom-btn">Guardar</button>


                </form>
                <input id="jugador_id" type="hidden" value="">

            </div>
            <input type="hidden" class="form-control form-control-lg" id="usuario_id" name="usuario_id"
                value="<?php echo $usuario->getUsuarioId()?>" disabled >
            <script>
                $(document).ready(function () {
                    const urlParams = new URLSearchParams(window.location.search);

                    // Obtén el valor del parámetro "opc" si existe
                    const opc = urlParams.get("opc");
                    var opcion = opc;
                    if (opcion === 'editaJugador') {
                        const urlParams = new URLSearchParams(window.location.search);
                        const jugador_id = urlParams.get('jugadorId');
                        const nombre = urlParams.get('nombre');
                        const sexo = urlParams.get('sexo');

                        // Actualizar los campos del formulario con los valores de la URL
                        document.getElementById('jugador_id').value = jugador_id;
                        document.getElementById('nombre').value = nombre;

                        // Verificar el sexo y marcar el radio button correspondiente
                        if (sexo === 'M') {
                            document.getElementById('sexoM').checked = true;
                        } else if (sexo === 'F') {
                            document.getElementById('sexoF').checked = true;
                        }
                    }

                    $('#guardarJugadorForm').submit(function (e) {
                        const nombreInput = document.getElementById("nombre");
                        const userInput = document.getElementById("usuario_id");
                        const nombreValue = nombreInput.value.trim();
                        const nombrePattern = /^[a-zA-Z0-9 ]{3,50}$/;

                        if (!nombrePattern.test(nombreValue)) {
                            event.preventDefault();
                            nombreInput.classList.add("is-invalid");
                        } else {
                            e.preventDefault();
                            // Obtener los valores del formulario
                            var nombre = $('#nombre').val();
                            var jugador_id = $('#jugador_id').val();
                            var sexo = $('input[name="sexo"]:checked').val();
                            const urlParams = new URLSearchParams(window.location.search);

                            // Obtén el valor del parámetro "opc" si existe
                            const opc = urlParams.get("opc");
                            var opcion = opc;
                            var usuario_id = userInput.value;
                            var estatus = 1;
                            // Realizar la petición AJAX
                            $.ajax({
                                url: '../php/service/ServiceAdmin.php', // Reemplaza 'ruta_al_archivo_php.php' por la ruta correcta a tu archivo PHP
                                type: 'POST',
                                data: {
                                    usuario_id: usuario_id,
                                    jugador_sexo: sexo,
                                    jugador_nombre: nombre,
                                    estatus_jugador: estatus,
                                    jugador_id: desencriptar(jugador_id),
                                    opcion: opcion
                                },
                                success: function (response) {
                                    const resultadoSinSaltosDeLinea = response.replace(/(\r\n|\r|\n)/g, '');
                                    console.log(resultadoSinSaltosDeLinea);
                                    const respuesta = JSON.parse(resultadoSinSaltosDeLinea);;
                                    console.log(respuesta);
                                    // Respuesta exitosa
                                    //if (response.success) {
                                    if (respuesta.success) {
                                        // Muestra la alerta de éxito y oculta la alerta de error
                                        $("#alertSuccess").removeClass("d-none");
                                        $("#alertError").addClass("d-none");
                                        window.scrollTo({
                                            top: 0,
                                            behavior: 'smooth'
                                        });
                                        // Redirige al usuario al index después de 2 segundos
                                        setTimeout(function () {
                                            window.location.href = "adminJugadores.php";
                                        }, 800);
                                    } else {
                                        // Muestra la alerta de error y oculta la alerta de éxito
                                        $("#alertError").removeClass("d-none");
                                        $("#alertSuccess").addClass("d-none");
                                        window.scrollTo({
                                            top: 0,
                                            behavior: 'smooth'
                                        });
                                        setTimeout(function () {
                                            $("#alertError").addClass("d-none");
                                        }, 800);
                                    }
                                },
                                error: function () {

                                }

                            });
                            function desencriptar(textoEncriptado) {
                                // Utilizar el cifrado Base64 para desencriptar el ID
                                var id = atob(textoEncriptado); // atob() realiza la decodificación Base64
                                return id;
                            }
                        }
                    });
                });
            </script>
</body>

</html>