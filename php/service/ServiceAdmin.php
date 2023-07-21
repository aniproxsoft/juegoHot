<?php
require_once 'CtrlJuego.php';
require_once 'CtrlAdmin.php';
class ServiceAdmin {
    public function procesarOpcion($opcion,$status,$desafioId) {
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
                $resultado = $ctrlAdmin->actualizaEstausDesafio($desafioId, $status);
            
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
    $desafioId=0;
    $estatus='';
    $opcionGet = $_GET['opcion']; // Obtener el valor de la opción desde el parámetro GET

    // Verificar si el parámetro "estatus" está presente y no está vacío
    if (isset($_GET['estatus']) && !empty($_GET['estatus'])) {
        $estatus = $_GET['estatus'];
       
    } 

    // Verificar si el parámetro "desafioID" está presente y no está vacío
    if (isset($_GET['desafioID']) && !empty($_GET['desafioID'])) {
        $desafioId = $_GET['desafioID'];
        
    } 
    $serviceAdmin->procesarOpcion($opcionGet,$estatus,$desafioId);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera los valores enviados por POST
    $nivel_id = $_POST['nivel_id'];
    $usuario_id = $_POST['usuario_id'];
    $desafio_desc = $_POST['desafio_desc'];
    $tiempo_segundos = $_POST['tiempo_segundos'];
    $status = $_POST['status'];
    $opcionPost = $_POST['opcion']; 
    $desafioId = $_POST['desafio_id']; 
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
            break;
        default:
            echo "Opcion invalida";
            break;
    }
    // Llama a la función insertarDesafio con los parámetros recibidos
    
}