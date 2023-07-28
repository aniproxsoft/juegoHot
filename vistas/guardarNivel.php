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
    <title>Niveles</title>
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
        }

        .fondoCard {
            background-color: #e7a9f3;
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
        <h2> Nivel Guardado correctamente. </h2>
    </div>

    <!-- Alerta de error -->
    <div class="alert alert-danger d-none" id="alertError">
        <h2> Error al guardar el nivel. Intentalo de nuevo.</h2>
    </div>


    <div class="container-fluid fullscreen">
        <div class="list-group-item list-group-item-action  btn-purple">
            <h1>Guardar Nivel</h1>
        </div>
        <div class="card  fondoCard">
            <div id="cardNivel" class="card-body ">
                <form id="guardarNivelForm">
                    <div class="form-group">
                        <label class="h2" for="nivelNombre">Nombre:</label>
                        <input type="text" id="nivelNombre" class="form-control form-control-lg" required />
                        <div class="invalid-feedback h1">
                            <h2> El nombre debe tener entre 3 y 50 caracteres sin acentos o caracteres especiales.
                            </h2>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="h2" for="nivelDesc">Descripcion:</label>
                        <input type="text" id="nivelDesc" class="form-control form-control-lg" required />
                        <div class="invalid-feedback h1">
                            <h2> La descripcion debe tener entre 3 y 100 caracteres sin acentos o caracteres
                                especiales. </h2>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="h2" for="adicional">Adicional:</label>
                        <input type="text" id="adicional" class="form-control form-control-lg" />
                        <div class="invalid-feedback h1">
                            <h2> El campo adicional debe tener entre 3 y 100 caracteres sin acentos o caracteres
                                especiales. </h2>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="h2" for="numeroDesafios">Numero de Desafios:</label>
                        <input type="number" id="numeroDesafios" class="form-control form-control-lg" required />
                        <div class="invalid-feedback h1">
                            <h2> El numero de desafios debe ser un valor numerico entero. </h2>
                        </div>
                    </div>

                    <br /><br /><br />
                    <button type="submit" class="btn btn-purple float-end h1 btn-lg custom-btn">Guardar</button>
                </form>
                <input id="nivel_id" type="hidden" value="">

            </div>
            <script>
                $(document).ready(function () {
                    const urlParams = new URLSearchParams(window.location.search);

                    // Obtén el valor del parámetro "opc" si existe
                    const opc = urlParams.get("opc");
                    var opcion = opc;
                    if (opcion === 'editaNivel') {
                        const urlParams = new URLSearchParams(window.location.search);
                        const nivel_id = urlParams.get('nivelId');
                        const nivelNombre = urlParams.get('nivelNombre');
                        const nivelDesc = urlParams.get('nivelDesc');
                        const adicional = urlParams.get('adicional');
                        const numeroDesafios = urlParams.get('numeroDesafios');

                        // Actualizar los campos del formulario con los valores de la URL
                        document.getElementById('nivel_id').value = nivel_id;
                        document.getElementById('nivelNombre').value = nivelNombre;
                        document.getElementById('nivelDesc').value = nivelDesc;
                        document.getElementById('adicional').value = adicional;
                        document.getElementById('numeroDesafios').value = numeroDesafios;
                    }

                    $('#guardarNivelForm').submit(function (e) {
                        const nivelNombreInput = document.getElementById("nivelNombre");
                        const nivelDescInput = document.getElementById("nivelDesc");
                        const adicionalInput = document.getElementById("adicional");
                        const numeroDesafiosInput = document.getElementById("numeroDesafios");

                        const nivelNombreValue = nivelNombreInput.value.trim();
                        const nivelDescValue = nivelDescInput.value.trim();
                        const adicionalValue = adicionalInput.value.trim();
                        const numeroDesafiosValue = numeroDesafiosInput.value.trim();

                        const textoPattern = /^[a-zA-Z 0-9.]{3,100}$/;
                        const textoPatternDos = /^[a-zA-Z0-9 .]*$/;

                        const numeroPattern = /^\d+$/;

                        if (!textoPattern.test(nivelNombreValue)) {
                            event.preventDefault();
                            nivelNombreInput.classList.add("is-invalid");
                        } else if (!textoPattern.test(nivelDescValue)) {
                            event.preventDefault();
                            nivelDescInput.classList.add("is-invalid");
                        } else if (!textoPatternDos.test(adicionalValue)) {
                            event.preventDefault();
                            adicionalInput.classList.add("is-invalid");
                        } else if (!numeroPattern.test(numeroDesafiosValue)) {
                            event.preventDefault();
                            numeroDesafiosInput.classList.add("is-invalid");
                        } else {
                            e.preventDefault();
                            // Obtener los valores del formulario
                            var nivelNombre = $('#nivelNombre').val();
                            var nivelDesc = $('#nivelDesc').val();
                            var adicional = $('#adicional').val();
                            var numeroDesafios = $('#numeroDesafios').val();
                            var nivel_id = $('#nivel_id').val();
                            var estatus = 1;
                            // Realizar la petición AJAX
                            $.ajax({
                                url: '../php/service/ServiceAdmin.php',
                                type: 'POST',
                                data: {
                                    nivel_id: desencriptar(nivel_id),
                                    nivel_nombre: nivelNombre,
                                    nivel_desc: nivelDesc,
                                    adicional: adicional,
                                    numero_desafios: numeroDesafios,
                                    estatus_nivel: estatus,
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
                                            window.location.href = "adminNiveles.php";
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
                                        }, 2000);
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