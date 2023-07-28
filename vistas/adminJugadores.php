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

    <a href="guardarJugador.php?opc=insertaJugador" id="botonAgregar" class="floating-button"><i
            class="fas fa-plus"></i></a>
    <div id="alertContainer" style="margin-top: 20px;" class="h2"></div>

    <div class="container-fluid fullscreen">
        <h3>Maximo dos jugadores</h3>
        <ul class="list-group"></ul>
        <div id="listView" class="list-group">
        </div>
    </div>
    <input type="hidden" class="form-control form-control-lg" id="usuario_id" name="usuario_id"
                value="<?php echo $usuario->getUsuarioId()?>" disabled >
    <script>
        $(document).ready(function () {


            // Función para cargar los jugadores filtrados por AJAX
            function cargarJugadoresFiltrados() {
                var listView = $('#listView');
                var html = '<div class="list-group-item list-group-item-action  btn-purple">' +
                    '<h1>Jugadores</h1>' +
                    '</div>';
                var usuario_id= $('#usuario_id').val();
                console.log(usuario_id);
                $.ajax({
                    url: '../php/service/ServiceAdmin.php?opcion=jug', // Reemplaza 'ruta_al_archivo_php.php' por la ruta correcta a tu archivo PHP para obtener los jugadores
                    dataType: 'json',
                    type: 'get',
                    data: { user: usuario_id },
                    success: function (data) {
                        listView.empty(); // Limpiar el contenedor antes de mostrar los resultados filtrados
                        if (data.length === 2) {
                            // Deshabilitar el botón con el id "miBoton"
                            $("#botonAgregar").addClass("disabled");
                            $("#botonAgregar").removeAttr("href");
                            $("#botonAgregar").hide();
                        } else {
                            $("#botonAgregar").removeClass("disabled");
                            $("#botonAgregar").attr("href", "guardarJugador.php?opc=insertaJugador");
                            $("#botonAgregar").show();
                        }
                        $.each(data, function (index, jugador) {
                            var listItem = $('<div>').addClass('list-group-item list-group-item-action h3');

                            // Aquí creamos la estructura HTML para mostrar los jugadores
                            html +=
                                '<div class="card fondoCard">' +
                                '<div class="card-body">' +
                                '<h1 class="card-title">' + jugador.jugadorNombre + '</h1>' +
                                '</div>' +
                                '<div class="card-footer">' +
                                '<label>' + (jugador.jugadorSexo === 'M' ? 'Masculino' : 'Femenino') + '</label>' +
                                '<button style="margin-right:70px" class="btn btn-danger float-end" onclick="eliminarJugador(' + jugador.jugadorId + ')"><i class="fa fa-trash"></i></button>' +
                                '<button class="btn btn-purple float-end" onclick="editarJugador(' + jugador.jugadorId + ', \'' + jugador.jugadorNombre + '\', \'' + jugador.jugadorSexo + '\')"><i class="fa fa-edit"></i></button>' +
                                '</div>' +
                                '</div>';

                            listItem.html(html);

                            listItem.html(html);
                            html = '';
                            // Agregar el jugador al contenedor
                            listView.append(listItem);
                        });
                    },
                    error: function () {
                        console.log('Error al obtener los jugadores.');
                    }
                });
            }

            // Llamada inicial para cargar todos los jugadores al cargar la página
            cargarJugadoresFiltrados();
        });
        // Función para eliminar un jugador mediante AJAX
        function cargarJugadoresFiltrados() {
            var listView = $('#listView');
            var html = '<div class="list-group-item list-group-item-action  btn-purple">' +
                '<h1>Jugadores</h1>' +
                '</div>';
            var usuario_id= $('#usuario_id').val();
            $.ajax({
                url: '../php/service/ServiceAdmin.php?opcion=jug', // Reemplaza 'ruta_al_archivo_php.php' por la ruta correcta a tu archivo PHP para obtener los jugadores
                dataType: 'json',
                type: 'get',
                data: { user: usuario_id },
                success: function (data) {
                    listView.empty(); // Limpiar el contenedor antes de mostrar los resultados filtrados
                    if (data.length === 2) {
                        // Deshabilitar el botón con el id "miBoton"
                        $("#botonAgregar").addClass("disabled");
                        $("#botonAgregar").removeAttr("href");
                        $("#botonAgregar").hide();
                    } else {
                        $("#botonAgregar").removeClass("disabled");
                        $("#botonAgregar").attr("href", "guardarJugador.php?opc=insertaJugador");
                        $("#botonAgregar").show();
                    }
                    $.each(data, function (index, jugador) {
                        var listItem = $('<div>').addClass('list-group-item list-group-item-action h3');

                        // Aquí creamos la estructura HTML para mostrar los jugadores
                        html +=
                            '<div class="card fondoCard">' +
                            '<div class="card-body">' +
                            '<h1 class="card-title">' + jugador.jugadorNombre + '</h1>' +
                            '</div>' +
                            '<div class="card-footer">' +
                            '<label>' + (jugador.jugadorSexo === 'M' ? 'Masculino' : 'Femenino') + '</label>' +
                            '<button class="btn btn-danger float-end" onclick="eliminarJugador(' + jugador.jugadorId + ')"><i class="fa fa-trash"></i></button>' +
                            '<button class="btn btn-purple float-end" onclick="editarJugador(' + jugador.jugadorId + ',' + jugador.jugadorNombre + ',' + jugador.jugadorSexo + ')"><i class="fa fa-edit"></button>' +
                            '</div>' +
                            '</div>';

                        listItem.html(html);

                        listItem.html(html);
                        html = '';
                        // Agregar el jugador al contenedor
                        listView.append(listItem);
                    });
                },
                error: function () {
                    console.log('Error al obtener los jugadores.');
                }
            });
        }
        function eliminarJugador(jugadorId) {
            $.ajax({
                url: '../php/service/ServiceAdmin.php',
                type: 'get',
                data: {
                    opcion: 'actualizaJugador',
                    id: jugadorId,
                    estatus: 0
                },
                dataType: 'json',
                success: function (data) {
                    // Muestra el alert de éxito si la respuesta es true, de lo contrario, muestra el alert de error
                    var mensaje = data.success ? 'Jugador eliminado exitosamente.' : 'Ocurrió un error al eliminar el jugador.';
                    var alertClass = data.success ? 'alert-success' : 'alert-danger';
                    showAlert(mensaje, alertClass);
                    scrollToTop();
                    // Eliminar el jugador de la lista en el front-end si se eliminó exitosamente en el backend
                    if (data.success) {
                        $('#listView').empty();
                        cargarJugadoresFiltrados();
                    }
                },
                error: function () {
                    showAlert('Error al eliminar el jugador.', 'alert-danger');
                    scrollToTop();
                }
            });
        }
        // Función para editar un jugador
        function editarJugador(jugadorId, nombre, sexo) {
            // Redireccionar a la página de edición del jugador con el ID correspondiente
            window.location.href = 'guardarJugador.php?opc=editaJugador&nombre=' + nombre + '&sexo=' + sexo + '&jugadorId=' + encriptar(jugadorId);
        }
        function encriptar(id) {
            // Utilizar el cifrado Base64 para encriptar el ID
            var textoEncriptado = btoa(id); // btoa() realiza el cifrado Base64
            return textoEncriptado;
        }
        // Función para mostrar el alert
        function showAlert(mensaje, alertClass) {
            var alertContainer = $('<div>').addClass('alert ' + alertClass).text(mensaje);
            $('#alertContainer').append(alertContainer);

            // Ocultar el alert después de 3 segundos
            setTimeout(function () {
                alertContainer.fadeOut(function () {
                    $(this).remove();
                });
            }, 2000);
        }

        // Función para scroll hasta la parte superior de la página
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    </script>
</body>

</html>