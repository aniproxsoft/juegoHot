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
            <a class="navbar-brand" style="margin-left: 5px;" href="#">JuegoHot</a>
        </div>
    </nav>

    <div id="contenedor" class="d-flex justify-content-center align-items-center " style="min-height: 100vh;">
        <div class="container-fluid fullscreen">
            <div class="card  fondoCard">
                <div id="cardLogin" class="card-body ">
                    <form id="iniciarSesion" method="post" action="./php/service/CtrlLogin.php">
                        <div class="form-group">
                            <label class="h2" for="usuario">Usuario/email:</label>
                            <input type="text" name="usuario" id="usuario" class="form-control form-control-lg" minlength="8" maxlength="50" required  />
                            <div class="invalid-feedback h1">
                                <h2> El usuario debe tener entre 3 y 50 caracteres sin acentos o caracteres especiales.
                                </h2>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label class="h2" for="pass">Password:</label>
                            <input type="password" id="pass" name="pass" class="form-control form-control-lg" minlength="8" maxlength="50" required />
                            <div class="invalid-feedback h1">
                                <h2> El password debe tener entre 3 y 50 caracteres sin acentos o caracteres especiales.
                                </h2>
                            </div>
                        </div>


                        <br /><br /><br />
                        <button type="submit" class="btn btn-purple float-end h1 btn-lg custom-btn">Aceptar</button>


                    </form>

                </div>
            </div>


</body>