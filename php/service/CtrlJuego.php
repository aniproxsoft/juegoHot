<?php
header("Cache-Control: no-cache");
require_once "ClassConnection.php";
require_once "./php/service/DTO/DesafioDTO.php";
require_once "./php/service/DTO/JugadorDTO.php";
require_once "./php/service/DTO/NivelDTO.php";
Class CtrlJuego {
    
    function getDesafios($nivel) {
        
        $db       = new connectionDB();
        $conexion = $db->get_connection();
        $user=1;
        // Configuración de la conexión a la base de datos
        $statement = $conexion->prepare("CALL sp_get_desafios(?,?)");
		$statement->bindParam(1,$nivel);
		$statement->bindParam(2,$user);
		$statement->execute();

		$desafios = array();

		while($row=$statement->fetch(PDO::FETCH_ASSOC)){
		  
		   
            $desafio = new DesafioDTO();

            $desafio->setDesafioId($row["desafio_id"]);
            $desafio->setNivelId($row["nivel_id"]);
            $desafio->setDesafioDesc($row["desafio_desc"]);
            $desafio->setUsuarioId($row["usuario_id"]);
            $desafio->setTiempoSegundos($row["tiempo_segundos"]);
            $desafio->setStatus($row["status"]);
            $desafio->setNivelNombre($row["nivel_nombre"]);
            $desafio->setNivelDesc($row["nivel_desc"]);
            $desafio->setAdicional($row["adicional"]);
            $desafio->setNumeroDesafios($row["numero_desafios"]);
            //echo '<br>'. $desafio->toString();
            $desafios[] = $desafio;
		 
		}
        
        
        return $desafios;
    }
    function getJugadores($user) {
        
        $db       = new connectionDB();
        $conexion = $db->get_connection();
        $user=1;
        // Configuración de la conexión a la base de datos
        $statement = $conexion->prepare("CALL  sp_jugadores(?)");
		$statement->bindParam(1,$user);
		$statement->execute();

		$jugadores = array();

		while($row=$statement->fetch(PDO::FETCH_ASSOC)){
		  
		    
            $jugador = new JugadorDTO();
            $jugador->setJugadorId($row["jugador_id"]);
            $jugador->setJugadorNombre($row["jugador_nombre"]);
            $jugador->setUsuarioId($row["usuario_id"]);
            $jugador->setJugadorSexo($row["jugador_sexo"]);
            //echo '<br>'. $jugador->toString();
            $jugadores[] = $jugador;
		 
		}
        
        
        return $jugadores;
    }

    function getNiveles() {
        
        $db       = new connectionDB();
        $conexion = $db->get_connection();
        $user=1;
        // Configuración de la conexión a la base de datos
        $statement = $conexion->prepare("CALL  sp_get_niveles()");
		
		$statement->execute();

		
        $niveles = array();
		while($row=$statement->fetch(PDO::FETCH_ASSOC)){
		  
		    
            $nivel = new NivelDTO();
            $nivel->setNivelId($row["nivel_id"]);
            $nivel->setNivelNombre($row["nivel_nombre"]);
            $nivel->setNivelDesc($row["nivel_desc"]);
            $nivel->setAdicional($row["adicional"]);
            $nivel->setNumeroDesafios($row["numero_desafios"]);
            //echo '<br>'.$nivel->toString();
            $niveles[] = $nivel;
		 
		}
        
        
        return $niveles;
    }

    function getJuego($user) {
        $juego = array();
        $juegos = array();
        $niveles = $this->getNiveles();
        
            foreach ($niveles as $nivel) {
                $desafios = $this->getDesafios($nivel->getNivelId());
                if (!empty($desafios)) {
                    $desafiosSeleccionados = array();
                    $asignaciones = array(); // Arreglo de asignaciones
                    if(count($desafios)<=$nivel->getNumeroDesafios()){
                        $desafiosSeleccionados=$desafios;
                    }else{
                        $indicesAleatorios = array_rand($desafios, $nivel->getNumeroDesafios());

                        // Arreglo nuevo con los desafíos seleccionados al azar
            
                        foreach ($indicesAleatorios as $indice) {
                            $desafiosSeleccionados[] = $desafios[$indice];
                        }
                    }
                    $jugadores = $this->getJugadores($user);
                

                    $jugadoresCount = count($jugadores); // Cantidad de jugadores
                    $desafiosCount = count($desafiosSeleccionados); // Cantidad de desafíos
                    
                    // Generar las asignaciones de desafíos a jugadores
                    for ($i = 0; $i < $desafiosCount; $i++) {
                        $jugadorIndex = $i % $jugadoresCount; // Índice del jugador actual
                        $jugador = $jugadores[$jugadorIndex]; // Jugador actual
                        $desafio = $desafiosSeleccionados[$i]; // Desafío actual
                        $cadena = $desafio->getDesafioDesc();
                        $ulimaLetra = substr($cadena, -2);
                        if(strtolower(trim($ulimaLetra)) == 'a' || strtolower(trim($ulimaLetra)) == 'de' ){
                            $jugadorEncontrado = null;
                                foreach ($jugadores as $jugadorActual) {
                                    if ($jugadorActual->getJugadorId() != $jugador->getJugadorId()) {
                                        $jugadorEncontrado = $jugadorActual;
                                        break; // Terminar el bucle al encontrar el primer objeto
                                    }
                                }
                                if ($jugadorEncontrado !== null) {
                                    $desafio->setDesafioDesc($desafio->getDesafioDesc().' '.$jugadorEncontrado->getJugadorNombre());
                            
                                }
                                
                            
                        }
                        $palabras = explode(" ", strtolower(trim($cadena)));
                        $primeraPalabra = $palabras[0];
                        if($primeraPalabra=='penetrar'){
                            $jugadorEncontrado = null;
                                foreach ($jugadores as $jugadorActual) {
                                    if ($jugadorActual->getJugadorId() != $jugador->getJugadorId()) {
                                        $jugadorEncontrado = $jugadorActual;
                                        break; // Terminar el bucle al encontrar el primer objeto
                                    }
                                }
                                
                            switch($jugador->getJugadorSexo()){
                                case 'M':
                                    if ($jugadorEncontrado !== null) {
                                        $nuevaCadena = str_replace("penetrar", "Penetra a ".$jugadorEncontrado->getJugadorNombre().' ', strtolower($cadena));
                                        $desafio->setDesafioDesc($nuevaCadena);
                                
                                    }
                                    break;
                                case 'F':
                                    if ($jugadorEncontrado !== null) {
                                        $nuevaCadena = str_replace("penetrar", "Deja que ".$jugadorEncontrado->getJugadorNombre().' te penetre ', strtolower($cadena));
                                        $desafio->setDesafioDesc($nuevaCadena);
                                
                                    }
                                    break;
                            }
                            
                        }
                        $jugadorAnterior = $jugador;
                        $asignaciones[] = array("jugador" => $jugador->toJson(), "desafio" => $desafio->toJson());
                    }

                }   
                $juego=array("nivel_nombre" => $nivel->getNivelNombre(), "adicional" =>$nivel->getAdicional() , "num_desafios" =>$nivel->getNumeroDesafios(),"asignaciones" =>$asignaciones);
                $juegos[]=$juego;
                
            }
        
            return $juegos;
    }
}
?>

