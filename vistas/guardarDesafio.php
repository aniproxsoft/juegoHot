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
    <title>Guardar Desafio</title>
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

        .custom-btn:hover {
            background-color: #800080;
            /* Cambiar a tu color deseado */
            color: #e692f7;
            /* Cambiar a tu color de texto deseado */
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
    <div class="container-fluid fullscreen">
        <!-- Alerta de éxito -->
        <div class="alert alert-success d-none" id="alertSuccess">
            <h2> Desafio Guardado correctamente. </h2>
        </div>

        <!-- Alerta de error -->
        <div class="alert alert-danger d-none" id="alertError">
            <h2> Error al guardar el desafio. Intentalo de nuevo.</h2>
        </div>
        <div class="list-group-item list-group-item-action  btn-purple">
            <h1>Guardar Desafio</h1>
        </div>
        <div class="card  fondoCard">
            <div id="cardNivel" class="card-body ">
                <form id="insertarDesafioForm">
                    <div class="form-group">
                        <label class="h2" for="nivel_id">Nivel:</label>
                        <select id="nivel_id" class="form-control form-control-lg" required>
                            <option value="">Seleccionar nivel</option>
                        </select>
                    </div>
                   
                    
                    
                    <div class="form-group">
                        <label class="h2" for="desafio_desc">Descripcion:</label>
                        <textarea class="form-control form-control-lg" id="desafio_desc" name="desafio_desc" required
                            pattern="^[a-zA-Z0-9 ]{3,255}$" maxlength="255"></textarea>
                        <div class="invalid-feedback h1">
                            <h2> La descripcion debe tener entre 3 y 255 caracteres sin acentos o caracteres especiales.
                            </h2>
                        </div>
                        <div class="form-group">
                            <label class="h2" for="tiempo_segundos">Tiempo en Segundos:</label>
                            <input type="number" class="form-control form-control-lg" id="tiempo_segundos"
                                name="tiempo_segundos" min="10" max="320">
                            <div class="invalid-feedback h2">
                                favor, ingresa un valor numerico entre 10 y 320.
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="h2" for="status">Activo:</label>
                            <input id="estado" class="form-check-input  form-control-lg" type="checkbox" value=""
                                id="flexCheckDisabled">
                        </div>
                        <br>
                        <h2>Ejemplo del desafio en el juego</h2>
                        <br>
                        <div id="jugadoresContainer"></div>
                        <br>
                        <div class="h2" id="ejemploDesafio"></div>
                        <br /><br /><br />
                        <button type="submit" class="btn btn-purple float-end h1 btn-lg custom-btn">Guardar</button>


                </form>
                <input id="desafioId" type="hidden" value="">
                <input type="hidden" class="form-control form-control-lg" id="usuario_id" name="usuario_id"
                value="<?php echo $usuario->getUsuarioId()?>" disabled >

            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function () {
            var jugadorSeleccionado;
            var usuario_id= $('#usuario_id').val();
            $.ajax({
                url: '../php/service/ServiceAdmin.php?opcion=jug', // Reemplaza 'ruta_a_tu_archivo_php.php' con la ruta correcta a tu archivo PHP
                type: 'get',
                data: { user: usuario_id }, // Puedes cambiar el valor de 'user' según tus necesidades
                dataType: 'json',
                success: function (data) {
                    if (data.length === 0) {
                        console.log('El arreglo esta vacio.');
                    } else {
                        jugadorSeleccionado = $('input[name="jugador"]:checked').val();
                        generarRadioButtonsJugadores(data);
                        console.log('El arreglo no esta vacio.');
                    }
                },
                error: function () {
                    console.log('Error al obtener los jugadores.');
                }
            });
            // Función para generar los radio buttons con los jugadores recibidos
            function generarRadioButtonsJugadores(jugadores) {
                var jugadoresContainer = $('#jugadoresContainer');
                var jugadorSeleccionado; // Variable para almacenar el radio button seleccionado

                // Recorrer los jugadores y generar los radio buttons
                $.each(jugadores, function (index, jugador) {
                    var jugadorId = jugador.jugadorId;
                    var jugadorNombre = jugador.jugadorNombre;

                    // Generar el radio button y etiqueta con el nombre del jugador utilizando Bootstrap
                    var radioOption = $('<input>').attr({
                        type: 'radio',
                        class: 'form-check-input form-control-lg',
                        name: 'jugador',
                        value: jugadorId,
                        id: 'jugador_' + jugadorId + '_' + jugador.jugadorSexo,
                    });

                    var labelOption = $('<label style="marging-left:20px">')
                        .addClass('form-check-label h2')
                        .attr('for', 'jugador_' + jugadorId)
                        .text(jugadorNombre)
                        .prepend(radioOption);

                    // Agregar el radio button y etiqueta al contenedor
                    jugadoresContainer.append(labelOption);

                    // Agregar evento change a los radio buttons generados
                    radioOption.change(function () {
                        generaEjemplo();
                    });

                    // Almacenar el valor del primer radio button seleccionado
                    if (index === 0) {
                        jugadorSeleccionado = jugadorId;
                        radioOption.prop('checked', true);
                    } else if (index > 0) {
                        generaEjemplo();
                    }
                    function generaEjemplo() {
                        const texto = $('#desafio_desc').val();
                        let cadena = texto;
                        let ultimaLetra = cadena.slice(-2).toLowerCase();
                        var textosChecked = [];
                        var textosNoChecked = [];
                        if ($('#jugadoresContainer input[name="jugador"]').length > 0) {
                            // Recorrer los radio buttons con el nombre 'jugador'
                            $('input[name="jugador"]').each(function () {
                                var id = $(this).attr('id');
                                var texto = $(this).parent().text().trim();

                                if ($(this).prop('checked')) {
                                    textosChecked.push({ id: id, texto: texto });
                                } else {
                                    textosNoChecked.push({ id: id, texto: texto });
                                }
                            });

                            var sexoJugadorSeleccionado = textosChecked[0].id.split("_")[2];
                            var nombreJugadorSeleccionado = textosChecked[0].texto;
                            var sexoJugadorNoSeleccionado = textosNoChecked[0].id.split("_")[2];
                            var nombreJugadorNoSeleccionado = textosNoChecked[0].texto;
                            var nuevoTexto = nombreJugadorSeleccionado + ' ' + texto;

                            console.log(sexoJugadorSeleccionado + nombreJugadorSeleccionado + sexoJugadorNoSeleccionado + nombreJugadorNoSeleccionado);
                            if (ultimaLetra === ' a' || ultimaLetra === 'de') {
                                nuevoTexto = nombreJugadorSeleccionado + ' ' + texto + ' ' + nombreJugadorNoSeleccionado;
                            }

                            let palabras = cadena.trim().toLowerCase().split(" ");
                            let primeraPalabra = palabras[0];

                            if (primeraPalabra === 'penetrar') {
                                console.log('entra')
                                switch (sexoJugadorSeleccionado) {
                                    case 'M':
                                        nuevoTexto = texto.toLowerCase().replace('penetrar', nombreJugadorSeleccionado + ' penetra a ' + nombreJugadorNoSeleccionado + ' ');

                                        break;
                                    case 'F':
                                        nuevoTexto = texto.toLowerCase().replace('penetrar', nombreJugadorSeleccionado + ' deja que ' + nombreJugadorNoSeleccionado + ' te penetre ');


                                        break;
                                }

                            } else if (primeraPalabra === 'penetra') {
                                console.log('entra')
                                switch (sexoJugadorSeleccionado) {
                                    case 'M':
                                        nuevoTexto = texto.toLowerCase().replace('penetra', nombreJugadorSeleccionado + ' penetra a ' + nombreJugadorNoSeleccionado + ' ');

                                        break;
                                    case 'F':
                                        nuevoTexto = texto.toLowerCase().replace('penetra', nombreJugadorSeleccionado + ' deja que ' + nombreJugadorNoSeleccionado + ' te penetre ');


                                        break;
                                }
                            }


                        }
                        // Actualizar el contenido del otro div con el texto ingresado
                        $('#ejemploDesafio').text(nuevoTexto);
                    }
                });
            }

            $('#desafio_desc').on('input', function () {
                // Obtener el texto ingresado en el textarea
                var texto = $(this).val();
                let cadena = texto;
                let ultimaLetra = cadena.slice(-2).toLowerCase();
                var textosChecked = [];
                var textosNoChecked = [];
                if ($('#jugadoresContainer input[name="jugador"]').length > 0) {
                    // Recorrer los radio buttons con el nombre 'jugador'
                    $('input[name="jugador"]').each(function () {
                        var id = $(this).attr('id');
                        var texto = $(this).parent().text().trim();

                        if ($(this).prop('checked')) {
                            textosChecked.push({ id: id, texto: texto });
                        } else {
                            textosNoChecked.push({ id: id, texto: texto });
                        }
                    });

                    var sexoJugadorSeleccionado = textosChecked[0].id.split("_")[3];
                    var nombreJugadorSeleccionado = textosChecked[0].texto;
                    var sexoJugadorNoSeleccionado = textosNoChecked[0].id.split("_")[3];
                    var nombreJugadorNoSeleccionado = textosNoChecked[0].texto;
                    var nuevoTexto = nombreJugadorSeleccionado + ' ' + texto;

                    console.log(sexoJugadorSeleccionado + nombreJugadorSeleccionado + sexoJugadorNoSeleccionado + nombreJugadorNoSeleccionado);
                    if (ultimaLetra === ' a' || ultimaLetra === 'de') {
                        nuevoTexto = nombreJugadorSeleccionado + ' ' + texto + ' ' + nombreJugadorNoSeleccionado;
                    }

                    let palabras = cadena.trim().toLowerCase().split(" ");
                    let primeraPalabra = palabras[0];

                    if (primeraPalabra === 'penetrar') {
                        console.log('entra')
                        switch (sexoJugadorSeleccionado) {
                            case 'M':
                                nuevoTexto = texto.toLowerCase().replace('penetrar', nombreJugadorSeleccionado + ' penetra a ' + nombreJugadorNoSeleccionado + ' ');

                                break;
                            case 'F':
                                nuevoTexto = texto.toLowerCase().replace('penetrar', nombreJugadorSeleccionado + ' deja que ' + nombreJugadorNoSeleccionado + ' te penetre ');


                                break;
                        }

                    } else if (primeraPalabra === 'penetra') {
                        console.log('entra')
                        switch (sexoJugadorSeleccionado) {
                            case 'M':
                                nuevoTexto = texto.toLowerCase().replace('penetra', nombreJugadorSeleccionado + ' penetra a ' + nombreJugadorNoSeleccionado + ' ');

                                break;
                            case 'F':
                                nuevoTexto = texto.toLowerCase().replace('penetra', nombreJugadorSeleccionado + ' deja que ' + nombreJugadorNoSeleccionado + ' te penetre ');


                                break;
                        }
                    }


                }
                // Actualizar el contenido del otro div con el texto ingresado
                $('#ejemploDesafio').text(nuevoTexto);
            });

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
                    var nivelId = obtenerParametroDeURL('nivel_id');
                    $("#nivel_id").val(nivelId);
                }
            });
            $('#insertarDesafioForm').submit(function (e) {
                const descripcionInput = document.getElementById("desafio_desc");
                const descripcionValue = descripcionInput.value.trim();
                const descripcionPattern = /^[a-zA-Z0-9() ]{3,255}$/;

                if (!descripcionPattern.test(descripcionValue)) {
                    event.preventDefault();
                    descripcionInput.classList.add("is-invalid");
                } else {
                    e.preventDefault(); // Evitar que se recargue la página

                    // Obtener los valores del formulario
                    var nivel_id = $('#nivel_id').val();
                    var usuario_id = $('#usuario_id').val();
                    var desafio_desc = $('#desafio_desc').val();
                    var tiempo_segundos = $('#tiempo_segundos').val();
                    var status = $('#estado').is(':checked') ? 1 : '';
                    // Obtén la URL actual
                    const urlParams = new URLSearchParams(window.location.search);

                    // Obtén el valor del parámetro "opc" si existe
                    const opc = urlParams.get("opc");
                    var opcion = opc;
                    var desafioId = desencriptar(urlParams.get("desafio_id"));

                    console.log("**" + opc);
                    console.log("**" + desafioId);
                    // Realizar la petición AJAX
                    $.ajax({
                        url: '../php/service/ServiceAdmin.php', // Reemplaza 'ruta_al_archivo_php.php' por la ruta correcta a tu archivo PHP
                        type: 'POST',
                        data: {
                            nivel_id: nivel_id,
                            usuario_id: usuario_id,
                            desafio_desc: desafio_desc,
                            tiempo_segundos: tiempo_segundos,
                            status: status,
                            desafio_id: desafioId,
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
                                    window.location.href = "adminJuegos.php";
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
                            // Error en la solicitud AJAX
                            alert("Error en la solicitud AJAX. Intentalo de nuevo.");
                        }
                    });
                    descripcionInput.classList.remove("is-invalid");
                }
                function obtenerParametroDeURL(nombreParametro) {
                    const parametrosURL = new URLSearchParams(window.location.search);
                    return parametrosURL.get(nombreParametro);
                }
                // Función para desencriptar el valor del ID
                function desencriptar(textoEncriptado) {
                    // Utilizar el cifrado Base64 para desencriptar el ID
                    var id = atob(textoEncriptado); // atob() realiza la decodificación Base64
                    return id;
                }

            });
        });
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
        function obtenerParametroDeURL(nombreParametro) {
            const parametrosURL = new URLSearchParams(window.location.search);
            return parametrosURL.get(nombreParametro);
        }
        //update 
        document.addEventListener('DOMContentLoaded', function () {
            // Obtener los valores de los parámetros enviados por POST
            var tiempoSegundos = obtenerParametroDeURL('tiempo_segundos');
            var descripcionDesafio = obtenerParametroDeURL('descripcion_desafio');
            var desafioId = obtenerParametroDeURL('desafio_id');
            var nivelId = obtenerParametroDeURL('nivel_id');
            var status = obtenerParametroDeURL('status');


            // Establecer el valor del select

            // Verificar si los parámetros están presentes antes de utilizarlos
            if (tiempoSegundos !== null) {
                console.log('Tiempo segundos:', tiempoSegundos);
                $("#tiempo_segundos").val(tiempoSegundos);

            }

            if (descripcionDesafio !== null) {
                console.log('Descripcion desafio:', descripcionDesafio);
                $("#desafio_desc").val(descripcionDesafio);
            }

            if (desafioId !== null) {

                console.log('Desafio ID:', desencriptar(desafioId));
                $("#desafioId").val(desencriptar(desafioId));
            }

            if (nivelId !== null) {
                console.log('Nivel ID:', nivelId);
                $("#nivel_id").val(nivelId);
            }
            

            if (status !== null) {
                console.log('Status:', status);
                if (status === '0') {
                    // Si el valor es 1, habilitar el checkbox
                    $("#estado").prop("checked", false);
                } else if (status === '1') {
                    // Si el valor es 0, deshabilitar el checkbox
                    $("#estado").prop("checked", true);
                }
            }
            // Función para desencriptar el valor del ID
            function desencriptar(textoEncriptado) {
                // Utilizar el cifrado Base64 para desencriptar el ID
                var id = atob(textoEncriptado); // atob() realiza la decodificación Base64
                return id;
            }
        });
    </script>

</body>

</html>