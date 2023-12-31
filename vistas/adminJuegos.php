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
            bottom: 30px;
        }

        /* Segundo botón con margen superior para separación */
        .floating-button:nth-child(2) {
            bottom: 120px;
            right: 20px;
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
                    
                    <div class="nav-item float-end">
                        <a class="nav-link" href="../php/service/CtrlLogout.php">salir</a>
                    </div>
                    
                </ul>
            </div>
        </div>
        <div style="width: 100%">
            <div class="float-end">
                <div class="row">
                    <div class="col">
                        <select title="Niveles" id="nivel_id" class="form-control form-control-lg" required>
                            <option value="all">Nivel</option>
                            <option value="all">Todos los niveles</option>
                        </select>
                    </div>
                    <div class="col">
                        <input title="Descripcion o tiempo" type="text" id="inputDescripcion"
                            class="form-control form-control-lg" placeholder="Desc o tiempo">
                    </div>
                    <div class="col">
                        <select title="estatus" id="estatus" class="form-control form-control-lg" required>
                            <option value="all">Estatus</option>
                            <option value="all">Todos los estatus</option>
                            <option value="1">Activo</option>
                            <option value="0">No Activo</option>
                        </select>
                    </div>
                    <div class="col">
                        <button title="buscar" class="btn btn-purple btn-lg float-end" id="btnBuscar">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </nav>

    <a class="floating-button" onclick="scrollToTop()"><i class="fas fa-chevron-up"></i></a>
    <a href="guardarDesafio.php?opc=save" class="floating-button"><i class="fas fa-plus"></i></a>

    <div id="alertContainer" style="margin-top: 20px;" class="h2"></div>
    <div class="container-fluid fullscreen">

        <ul class="list-group"></ul>
        <div id="listView" class="list-group">

        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <input type="hidden" class="form-control form-control-lg" id="usuario_id" name="usuario_id"
                value="<?php echo $usuario->getUsuarioId()?>" disabled >
</body>
<script>
    $(document).ready(function () {
        var listView = $('#listView');
        $.ajax({
            url: '../php/service/ServiceAdmin.php?opcion=gtn', // Reemplaza 'ruta_al_archivo_php.php' por la ruta correcta a tu archivo PHP
            dataType: 'json',
            success: function (response) {
                var select = $('#nivel_id');

                // Iterar sobre los niveles y agregar opciones al select
                $.each(response, function (index, nivel) {
                    var option = $('<option>').val(nivel.nivelId).text(nivel.nivelNombre);
                    select.append(option);
                });
            }
        });
        // Función para cargar los desafíos filtrados por AJAX
        function cargarDesafiosFiltrados(nivel, descripcion, estatus) {
            var componentesHtml = '<div class="list-group-item list-group-item-action  btn-purple">' +
                '<h1>Desafios</h1>' +
                '</div>';
            var usuario_id= $('#usuario_id').val();
            $.ajax({
                url: '../php/service/CtrlDesafiosService.php',
                dataType: 'json',
                type: 'get',
                data: {
                  user:usuario_id                  
                },
                success: function (data) {
                    var filteredDesafios = data.filter(function (desafio) {
                        return (nivel === 'all' || desafio.nivel_id === nivel) &&
                            (descripcion === '' || desafio.desafio_desc.toLowerCase().includes(descripcion.toLowerCase()) ||
                                (desafio.tiempo_segundos ? desafio.tiempo_segundos : '').includes(descripcion.toLowerCase())) &&
                            (estatus === 'all' || desafio.status === estatus);
                    });

                    listView.empty(); // Limpiar el contenedor antes de mostrar los resultados filtrados

                    $.each(filteredDesafios, function (index, desafio) {

                        var tiempoSegundos = desafio.tiempo_segundos ? desafio.tiempo_segundos : '';
                        listItem = $('<div>').addClass('list-group-item list-group-item-action h3');
                        listItem.data('desafio', desafio);
                        componentesHtml +=
                            '<div class="card  fondoCard">' +
                            '<div id="cardNivel" class="card-body ">' +
                            '<h1 class="card-title">' + desafio.desafio_desc + '</h1>';
                        if (tiempoSegundos > 0) {
                            componentesHtml +=
                                '<p class="card-text h3">Durante: ' + tiempoSegundos + ' Segundos</p>';

                        }
                        componentesHtml +=
                            '<button class="btn float-end btn-danger h2">' +
                            '<i class="fa fa-trash"></i>' +
                            '</button>' +
                            '<button style="margin-right:20px"  id="editar" class=" btnEditar btn float-end btn-purple h2">' +
                            '<i class="fa fa-edit"></i>' +
                            '</button>';

                        if (desafio.status === '1') {
                            componentesHtml += '<div class="form-check float-end">' +
                                '<label style="margin-right:20px" class="form-check-label h4" for="flexCheckDisabled">' +
                                'Activo' +
                                '<input class="form-check-input" type="checkbox" value="" id="flexCheckDisabled" checked >' +
                                '</label>' +
                                '</div>' +
                                '</div>';
                        } else {
                            componentesHtml += '<div class="form-check float-end">' +
                                '<label style="margin-right:20px" class="form-check-label h4" for="flexCheckDisabled">' +
                                'Activo' +
                                '<input class="form-check-input" type="checkbox" value="" id="flexCheckDisabled" >' +
                                '</label>' +
                                '</div>' +
                                '</div>';
                        }


                        componentesHtml += '<div class="card-footer  ">' +
                            '<label >' + desafio.nivel_nombre + '</label>' +
                            '</div>' +
                            '</div>';


                        listItem.html(componentesHtml);
                        listItem.find('.form-check-input').change(function () {
                            var checkbox = $(this);
                            var desafioId = desafio.desafio_id;
                            var status = checkbox.prop('checked') ? 1 : 0;
                            console.log(desafioId);
                            console.log(status);
                            // Realiza la llamada AJAX para actualizar el estado del desafío
                            $.ajax({
                                url: '../php/service/ServiceAdmin.php',
                                type: 'get',
                                data: {
                                    opcion: 'estatus',
                                    id: desafioId,
                                    estatus: status
                                },
                                dataType: 'json',
                                success: function (data) {
                                    console.log(data);
                                    // Muestra el alert de éxito si la respuesta es true, de lo contrario, muestra el alert de error
                                    var mensaje = data.success ? 'Estatus actualizado' : 'Error al actualizar estatus';
                                    var alertClass = data.success ? 'alert-success' : 'alert-danger';
                                    showAlert(mensaje, alertClass);
                                    scrollToTop();
                                },
                                error: function () {
                                    showAlert('Error al actualizar el desafio.', 'alert-danger');
                                    scrollToTop();
                                }
                            });
                        });
                        // Agrega el evento click al botón "Eliminar" generado para este desafío
                        listItem.find('.btn-danger').click(function () {
                            var desafioId = desafio.desafio_id;

                            // Realiza la llamada AJAX para actualizar el estado del desafío a 2 (eliminado)
                            $.ajax({
                                url: '../php/service/ServiceAdmin.php',
                                type: 'get',
                                data: {
                                    opcion: 'estatus',
                                    id: desafioId,
                                    estatus: 2
                                },
                                dataType: 'json',
                                success: function (data) {
                                    // Muestra el alert de éxito si la respuesta es true, de lo contrario, muestra el alert de error
                                    var mensaje = data.success ? 'Desafio eliminado exitosamente.' : 'Ocurrio un error al eliminar el desafio.';
                                    var alertClass = data.success ? 'alert-success' : 'alert-danger';
                                    showAlert(mensaje, alertClass);
                                    scrollToTop();
                                    // Eliminar el desafío de la lista en el front-end si se eliminó exitosamente en el backend
                                    if (data.resultado) {
                                        listItem.remove();
                                    }
                                },
                                error: function () {
                                    showAlert('Error al eliminar el desafio.', 'alert-danger');
                                    scrollToTop();
                                }
                            });
                        });
                        componentesHtml = '';
                        // Agregar el desafío al contenedor
                        listView.append(listItem);
                        // Botón "Editar" para redireccionar a guardarDesafio.html
                        var btnEditar = $('<button>').addClass('btn float-end btn-purple h2 btnEditar').attr('id', 'editar');
                        var iconEditar = $('<i>').addClass('fa fa-edit');
                        btnEditar.append(iconEditar);


                    });
                },
                error: function () {
                    console.log('Error al obtener los desafíos.');
                }
            });
        }
        function showAlert(mensaje, alertClass) {
            var alertContainer = $('<div>').addClass('alert ' + alertClass).text(mensaje);
            $('#alertContainer').append(alertContainer);

            // Ocultar el alert después de 3 segundos
            setTimeout(function () {
                alertContainer.fadeOut(function () {
                    $(this).remove();
                    cargarDesafiosFiltrados('all', '', 'all');
                });
            }, 2000);
        }
        $(document).on('click', '.btnEditar', function () {
            // Obtener el desafío asociado al botón "Editar" en la misma fila
            var desafio = $(this).closest('.list-group-item').data('desafio');
            console.log("desafio: " + desafio);
            // Crear un formulario oculto para enviar los parámetros mediante POST
            var form = $('<form>').attr({
                method: 'get',
                action: 'guardarDesafio.php'
            });

            // Agregar los campos ocultos con los parámetros necesarios
            form.append($('<input>').attr({
                type: 'hidden',
                name: 'tiempo_segundos',
                value: desafio.tiempo_segundos
            }));
            form.append($('<input>').attr({
                type: 'hidden',
                name: 'descripcion_desafio',
                value: desafio.desafio_desc
            }));
            form.append($('<input>').attr({
                type: 'hidden',
                name: 'opc',
                value: 'update'
            }));

            form.append($('<input>').attr({
                type: 'hidden',
                name: 'desafio_id',
                value: encriptar(desafio.desafio_id)
            }));
            form.append($('<input>').attr({
                type: 'hidden',
                name: 'nivel_id',
                value: desafio.nivel_id
            }));
            form.append($('<input>').attr({
                type: 'hidden',
                name: 'status',
                value: desafio.status
            }));

            // Agregar el formulario al DOM y enviarlo
            $('body').append(form);
            form.submit();
        });
        function encriptar(id) {
            // Utilizar el cifrado Base64 para encriptar el ID
            var textoEncriptado = btoa(id); // btoa() realiza el cifrado Base64
            return textoEncriptado;
        }
        // Llamada inicial para cargar todos los desafíos al cargar la página
        cargarDesafiosFiltrados('all', '', 'all');
        $('#btnBuscar').off('click').on('click', function () {
            var nivelSeleccionado = $('#nivel_id').val();
            var descripcionBusqueda = $('#inputDescripcion').val();
            var estatus = $('#estatus').val();
            cargarDesafiosFiltrados(nivelSeleccionado, descripcionBusqueda, estatus);
        });
    });
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
</script>

</html>