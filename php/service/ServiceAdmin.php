<?php
require_once 'CtrlJuego.php';
require_once 'CtrlAdmin.php';
class ServiceAdmin {
    public function procesarOpcion($opcion) {
        $ctrlJuego = new CtrlJuego();
        $ctrlAdmin = new CtrlAdmin();
        switch ($opcion) {
            case 'gtn':
                $niveles = $ctrlJuego->getNiveles();
                echo $this->convertirNivelesAJSON($niveles);
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
    $opcionGet = $_GET['opcion']; // Obtener el valor de la opción desde el parámetro GET
    $serviceAdmin->procesarOpcion($opcionGet);
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