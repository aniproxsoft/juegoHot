<?php
require_once 'CtrlJuego.php';
require_once 'CtrlAdmin.php';
class ServiceAdmin {
    public function procesarOpcion($opcion,$status,$id) {
        $ctrlJuego = new CtrlJuego();
        $ctrlAdmin = new CtrlAdmin();
        switch ($opcion) {
            case 'gtn':
                $niveles = $ctrlJuego->getNiveles();
                echo $this->convertirNivelesAJSON($niveles);
                break;
            case 'jug':
                $user = $_GET['user'];
                $jugadores = $ctrlJuego->getJugadores($user);
                foreach ($jugadores as $jugador) {
                    $jugadores_json[] = json_decode($jugador->toJson(), true);
                }
                
                // Imprimir el arreglo JSON completo
                echo json_encode($jugadores_json, JSON_PRETTY_PRINT);
                break;
             case 'estatus':
                $ctrlAdmin = new CtrlAdmin();
                $resultado = $ctrlAdmin->actualizaEstausDesafio($id, $status);
            
                // Prepara la respuesta en formato JSON
                $response = array();
                if ($resultado) {
                    // Respuesta exitosa
                    $response['success'] = true;
                } else {
                    // Error al insertar el desafío
                    $response['success'] = false;
                }
            
                // Devuelve la respuesta en formato JSON
                header('Content-Type: application/json');
                echo json_encode($response);
                break;
            case 'actualizaJugador':
                $ctrlAdmin = new CtrlAdmin();
                $resultado = $ctrlAdmin->actualizaEstausJugador($id, $status);
                echo $status;
                // Prepara la respuesta en formato JSON
                $response = array();
                if ($resultado) {
                    // Respuesta exitosa
                    $response['success'] = true;
                } else {
                    // Error al insertar el desafío
                    $response['success'] = false;
                }
            
                // Devuelve la respuesta en formato JSON
                header('Content-Type: application/json');
                echo json_encode($response);
                break;
            case 'actualizaNivel':
                $ctrlAdmin = new CtrlAdmin();
                $resultado = $ctrlAdmin->actualizaEstausNivel($id, $status);
                echo $status;
                // Prepara la respuesta en formato JSON
                $response = array();
                if ($resultado) {
                    // Respuesta exitosa
                    $response['success'] = true;
                } else {
                    // Error al insertar el desafío
                    $response['success'] = false;
                }
            
                // Devuelve la respuesta en formato JSON
                header('Content-Type: application/json');
                echo json_encode($response);
                break;
            default:
                echo "Opcion invalida";
                break;
        }
    }

    function convertirNivelesAJSON($niveles) {
        $nivelesJSON = array();
    
        foreach ($niveles as $nivel) {
            $nivelJSON = array(
                'nivelId' => $nivel->getNivelId(),
                'nivelNombre' => $nivel->getNivelNombre(),
                'nivelDesc' => $nivel->getNivelDesc(),
                'adicional' => $nivel->getAdicional(),
                'numeroDesafios' => $nivel->getNumeroDesafios()
            );
    
            $nivelesJSON[] = $nivelJSON;
        }
    
        return json_encode($nivelesJSON);
    }

}

// Crear una instancia de la clase y llamar al método procesarOpcion con el parámetro deseado
$serviceAdmin = new ServiceAdmin();
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id=0;
    $estatus='';
    $opcionGet = $_GET['opcion']; // Obtener el valor de la opción desde el parámetro GET

    // Verificar si el parámetro "estatus" está presente y no está vacío
    if (isset($_GET['estatus']) && !empty($_GET['estatus'])) {
        $estatus = $_GET['estatus'];
       
    } 

    // Verificar si el parámetro "desafioID" está presente y no está vacío
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];
        
    } 
    $serviceAdmin->procesarOpcion($opcionGet,$estatus,$id);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera los valores enviados por POST
    // Verificar si 'nivel_id' está definido y no es nulo
    if (isset($_POST['nivel_id'])) {
        $nivel_id = $_POST['nivel_id'];
    }

    // Verificar si 'usuario_id' está definido y no es nulo
    if (isset($_POST['usuario_id'])) {
        $usuario_id = $_POST['usuario_id'];
    }

    // Verificar si 'desafio_desc' está definido y no es nulo
    if (isset($_POST['desafio_desc'])) {
        $desafio_desc = $_POST['desafio_desc'];
    }

    // Verificar si 'tiempo_segundos' está definido y no es nulo
    if (isset($_POST['tiempo_segundos'])) {
        $tiempo_segundos = $_POST['tiempo_segundos'];
    }

    // Verificar si 'status' está definido y no es nulo
    if (isset($_POST['status'])) {
        $status = $_POST['status'];
    }

    // Verificar si 'opcion' está definido y no es nulo
    if (isset($_POST['opcion'])) {
        $opcionPost = $_POST['opcion'];
    }

    // Verificar si 'desafio_id' está definido y no es nulo
    if (isset($_POST['desafio_id'])) {
        $desafioId = $_POST['desafio_id'];
    } 

    if (isset($_POST['usuario_id'])) {
        $usuario_id = $_POST['usuario_id'];
    }

    if (isset($_POST['jugador_nombre'])) {
        $jugador_nombre = $_POST['jugador_nombre'];
    }

    if (isset($_POST['jugador_sexo'])) {
        $jugador_sexo = $_POST['jugador_sexo'];
    } 
    if (isset($_POST['estatus_jugador'])) {
        $estatus_jugador = $_POST['estatus_jugador'];
    } 
    if (isset($_POST['jugador_id'])) {
        $jugador_id = $_POST['jugador_id'];
    } 
    if (isset($_POST['nivel_id'])) {
        $nivel_id = $_POST['nivel_id'];
    }
    
    if (isset($_POST['nivel_nombre'])) {
        $nivel_nombre = $_POST['nivel_nombre'];
    }
    
    if (isset($_POST['nivel_desc'])) {
        $nivel_desc = $_POST['nivel_desc'];
    }
    
    if (isset($_POST['adicional'])) {
        $adicional = $_POST['adicional'];
    }
    
    if (isset($_POST['estatus_nivel'])) {
        $estatus_nivel = $_POST['estatus_nivel'];
    }
    if (isset($_POST['numero_desafios'])) {
        $numero_desafios = $_POST['numero_desafios'];
    }
    
    switch ($opcionPost) {
        case 'save':
            $ctrlAdmin = new CtrlAdmin();
            $resultado = $ctrlAdmin->insertarDesafio($nivel_id, $usuario_id, $desafio_desc, $tiempo_segundos, $status);
        
            // Prepara la respuesta en formato JSON
            $response = array();
            if ($resultado) {
                // Respuesta exitosa
                $response['success'] = true;
            } else {
                // Error al insertar el desafío
                $response['success'] = false;
            }
        
            // Devuelve la respuesta en formato JSON
            header('Content-Type: application/json');
            echo json_encode($response);
            $contenido = ob_get_clean();


            $contenido = str_replace(PHP_EOL, '', $contenido);
            echo $contenido;
            break;
        case 'update':
            $ctrlAdmin = new CtrlAdmin();
            $resultado = $ctrlAdmin->actualizarDesafio($desafioId,$nivel_id, $usuario_id, $desafio_desc, $tiempo_segundos, $status);
        
            // Prepara la respuesta en formato JSON
            $response = array();
            if ($resultado) {
                // Respuesta exitosa
                $response['success'] = true;
            } else {
                // Error al insertar el desafío
                $response['success'] = false;
            }
        
            // Devuelve la respuesta en formato JSON
            header('Content-Type: application/json');
            echo json_encode($response);
            $contenido = ob_get_clean();


            $contenido = str_replace(PHP_EOL, '', $contenido);
            echo $contenido;
            break;
        case 'insertaJugador':
            $ctrlAdmin = new CtrlAdmin();
            $resultado = $ctrlAdmin->insertarJugador($usuario_id, $jugador_nombre, $jugador_sexo, $estatus_jugador);
            
            // Prepara la respuesta en formato JSON
            $response = array();
            if ($resultado) {
                // Respuesta exitosa
                $response['success'] = true;
            } else {
                // Error al insertar el desafío
                $response['success'] = false;
            }
        
            // Devuelve la respuesta en formato JSON
            header('Content-Type: application/json');
            echo json_encode($response);
            $contenido = ob_get_clean();


            $contenido = str_replace(PHP_EOL, '', $contenido);
            echo $contenido;
            break;
         case 'editaJugador':
            $ctrlAdmin = new CtrlAdmin();
            $resultado = $ctrlAdmin->actualizarJugador($jugador_id, $jugador_nombre, $jugador_sexo);
            
            // Prepara la respuesta en formato JSON
            $response = array();
            if ($resultado) {
                // Respuesta exitosa
                $response['success'] = true;
            } else {
                // Error al insertar el desafío
                $response['success'] = false;
            }
        
            // Devuelve la respuesta en formato JSON
            header('Content-Type: application/json');
            echo json_encode($response);
            $contenido = ob_get_clean();


            $contenido = str_replace(PHP_EOL, '', $contenido);
            echo $contenido;
            break;
         case 'agregaNivel':
            $ctrlAdmin = new CtrlAdmin();
            $resultado = $ctrlAdmin->insertarNivel($nivel_id, $nivel_nombre, $nivel_desc, $adicional, $estatus_nivel,$numero_desafios);
            
            // Prepara la respuesta en formato JSON
            $response = array();
            if ($resultado) {
                // Respuesta exitosa
                $response['success'] = true;
            } else {
                // Error al insertar el desafío
                $response['success'] = false;
            }
        
            // Devuelve la respuesta en formato JSON
            header('Content-Type: application/json');
            echo json_encode($response);
            $contenido = ob_get_clean();


            $contenido = str_replace(PHP_EOL, '', $contenido);
            echo $contenido;
            break;
         case 'editaNivel':
            $ctrlAdmin = new CtrlAdmin();
            $resultado = $ctrlAdmin->actualizarNivel($nivel_id, $nivel_nombre, $nivel_desc, $adicional,$numero_desafios);
            
            // Prepara la respuesta en formato JSON
            $response = array();
            if ($resultado) {
                // Respuesta exitosa
                $response['success'] = true;
            } else {
                // Error al insertar el desafío
                $response['success'] = false;
            }
        
            // Devuelve la respuesta en formato JSON
            header('Content-Type: application/json');
            echo json_encode($response);
            $contenido = ob_get_clean();


            $contenido = str_replace(PHP_EOL, '', $contenido);
            echo $contenido;
            break;
        default:
            echo "Opcion invalida";
            break;
        
    }
    // Llama a la función insertarDesafio con los parámetros recibidos

}