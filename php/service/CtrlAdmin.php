<?php
header("Cache-Control: no-cache");
require_once "ClassConnection.php";
Class CtrlAdmin{

    function getDesafios($user) {
        
        $db       = new connectionDB();
        $conexion = $db->get_connection();
        $user=1;
        // Configuración de la conexión a la base de datos
        $statement = $conexion->prepare("Call obtener_desafios_por_usuario(?)");
		$statement->bindParam(1,$user);
		$statement->execute();

		$respuesta = array();

		while($row=$statement->fetch(PDO::FETCH_ASSOC)){
		    $respuesta[] = $row;
        }
        return $respuesta;
    }

    function insertarDesafio($nivel_id, $usuario_id, $desafio_desc, $tiempo_segundos, $status) {
        $db = new connectionDB();
        $conexion = $db->get_connection();
    
        // Configuración de la conexión a la base de datos
        $statement = $conexion->prepare("CALL insertar_desafio(?, ?, ?, ?, ?)");
        $statement->bindParam(1, $nivel_id, PDO::PARAM_INT);
        $statement->bindParam(2, $usuario_id, PDO::PARAM_INT);
        $statement->bindParam(3, $desafio_desc, PDO::PARAM_STR);
        $tipo_dato = gettype($tiempo_segundos);
        if ($tiempo_segundos > 10) {
            $statement->bindParam(4, $tiempo_segundos);
        }else{
            $statement->bindParam(4, $tiempo_segundos, PDO::PARAM_NULL);
        }
        $statement->bindParam(5, $status, PDO::PARAM_INT);
        $statement->execute();
    
        $resultado = $statement->fetch(PDO::FETCH_ASSOC);
    
        return $resultado;
    }
    function actualizarDesafio($desafio_id,$nivel_id, $usuario_id, $desafio_desc, $tiempo_segundos, $status) {
        $db = new connectionDB();
        $conexion = $db->get_connection();

        $statement = $conexion->prepare("CALL actualizar_desafio(?, ?, ?, ?, ?, ?)");
        $statement->bindParam(1, $desafio_id, PDO::PARAM_INT);
        $statement->bindParam(2, $nivel_id, PDO::PARAM_INT);
        $statement->bindParam(3, $usuario_id, PDO::PARAM_INT);
        $statement->bindParam(4, $desafio_desc, PDO::PARAM_STR);
        
        if ($tiempo_segundos > 10) {
            $statement->bindParam(5, $tiempo_segundos);
        }else{
            $statement->bindParam(5, $tiempo_segundos, PDO::PARAM_NULL);
        }
        $statement->bindParam(6, $status, PDO::PARAM_INT);
        $statement->execute();
        $resultado = $statement->fetch(PDO::FETCH_ASSOC);
    
        return $resultado;
    }
    function actualizaEstausDesafio($desafio_id,$status) {
        $db = new connectionDB();
        $conexion = $db->get_connection();

        $statement = $conexion->prepare("CALL actualizar_estatus_desafio(?, ?)");
        $statement->bindParam(1, $desafio_id, PDO::PARAM_INT);
        $statement->bindParam(2, $status, PDO::PARAM_INT);
        $statement->execute();
        $resultado = $statement->fetch(PDO::FETCH_ASSOC);
    
        return $resultado;
    }

    function actualizaEstausJugador($jugadorId, $status) {
        $db = new connectionDB();
        $conexion = $db->get_connection();

        $statement = $conexion->prepare("CALL actualizar_estatus_jugador(?, ?)");
        $statement->bindParam(1, $jugadorId, PDO::PARAM_INT);
        $statement->bindParam(2, $status, PDO::PARAM_INT);
        $statement->execute();
        $resultado = $statement->fetch(PDO::FETCH_ASSOC);
    
        return $resultado;
    }
    function insertarJugador($usuario_id, $jugador_nombre, $jugador_sexo, $estatus_jugador) {
        $db = new connectionDB();
        $conexion = $db->get_connection();
    
        // Configuración de la conexión a la base de datos
        $statement = $conexion->prepare("CALL insertar_jugador(?, ?, ?, ?)");
        $statement->bindParam(1, $usuario_id, PDO::PARAM_INT);
        $statement->bindParam(2, $jugador_nombre, PDO::PARAM_STR);
        $statement->bindParam(3, $jugador_sexo, PDO::PARAM_STR);
        $statement->bindParam(4, $estatus_jugador, PDO::PARAM_INT);
        $statement->execute();
    
        $resultado = $statement->fetch(PDO::FETCH_ASSOC);
    
        return $resultado;
    }
    function actualizarJugador($jugador_id, $jugador_nombre, $jugador_sexo) {
        $db = new connectionDB();
        $conexion = $db->get_connection();
    
        // Configuración de la conexión a la base de datos
        $statement = $conexion->prepare("CALL actualizar_jugador(?, ?, ?)");
        $statement->bindParam(1, $jugador_id, PDO::PARAM_INT);
        $statement->bindParam(2, $jugador_nombre, PDO::PARAM_STR);
        $statement->bindParam(3, $jugador_sexo, PDO::PARAM_STR);
        $statement->execute();
    
        $resultado = $statement->fetch(PDO::FETCH_ASSOC);
    
        return $resultado;
    }
    function actualizaEstausNivel($nivelId, $status) {
        $db = new connectionDB();
        $conexion = $db->get_connection();

        $statement = $conexion->prepare("CALL actualizar_estatus_nivel(?, ?)");
        $statement->bindParam(1, $nivelId, PDO::PARAM_INT);
        $statement->bindParam(2, $status, PDO::PARAM_INT);
        $statement->execute();
        $resultado = $statement->fetch(PDO::FETCH_ASSOC);
    
        return $resultado;
    }
    function actualizarNivel($nivel_id, $nivel_nombre, $nivel_desc, $adicional,$numero_desafios) {
        $db = new connectionDB();
        $conexion = $db->get_connection();
    
        // Configuración de la conexión a la base de datos
        $statement = $conexion->prepare("CALL actualizar_nivel(?, ?, ?, ?,?)");
        $statement->bindParam(1, $nivel_id, PDO::PARAM_INT);
        $statement->bindParam(2, $nivel_nombre, PDO::PARAM_STR);
        $statement->bindParam(3, $nivel_desc, PDO::PARAM_STR);
        $statement->bindParam(4, $adicional, PDO::PARAM_STR);
        $statement->bindParam(5, $numero_desafios, PDO::PARAM_INT);
        $statement->execute();
    
        $resultado = $statement->fetch(PDO::FETCH_ASSOC);
    
        return $resultado;
    }
    function insertarNivel($nivel_id, $nivel_nombre, $nivel_desc, $adicional, $estatus_nivel,$numero_desafios) {
        $db = new connectionDB();
        $conexion = $db->get_connection();
    
        // Configuración de la conexión a la base de datos
        $statement = $conexion->prepare("CALL insertar_nivel(?, ?, ?, ?, ?,?)");
        $statement->bindParam(1, $nivel_id, PDO::PARAM_INT);
        $statement->bindParam(2, $nivel_nombre, PDO::PARAM_STR);
        $statement->bindParam(3, $nivel_desc, PDO::PARAM_STR);
        $statement->bindParam(4, $adicional, PDO::PARAM_STR);
        $statement->bindParam(5, $estatus_nivel, PDO::PARAM_INT);
        $statement->bindParam(6, $numero_desafios, PDO::PARAM_INT);
        $statement->execute();
    
        $resultado = $statement->fetch(PDO::FETCH_ASSOC);
    
        return $resultado;
    }
}

?>

