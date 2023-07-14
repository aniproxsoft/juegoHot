<?php
	header("Cache-Control: no-cache");
	require_once "ClassConnection.php";
	require_once "./php/service/DTO/UsuarioDTO.php";
    require_once "./php/service/DTO/TipoUsuarioDTO.php";

Class CtrlLogin{
	public function login($email , $password){
		$db       = new connectionDB();
		$conexion = $db->get_connection();
		
		//$conexion->exec("set names utf8");
		//error_reporting(0);

		
		
		

	
		try {
			$usuario = new UsuarioDTO();
			$tipoUsuario=new TipoUsuarioDTO();
			$statement = $conexion->prepare("CALL sp_autentifica(?,?)");
			$statement->bindParam(1,$email);
			$statement->bindParam(2,$password);
			$statement->execute();

			$respuesta = array();

			while($row=$statement->fetch(PDO::FETCH_ASSOC)){
			
				$respuesta[] = $row;
			
			}

			$usuario->setFlag($respuesta[0]["flag"]);
			$usuario->setUsuarioId($respuesta[0]["usuario_id"]);
			$usuario->setUsuarioEmail($respuesta[0]["usuario_email"]);

			
			$tipoUsuario->setNombreRol($respuesta[0]["nombre_rol"]);
			$tipoUsuario->setRolId($respuesta[0]["rol_id"]);
			$usuario->setTipoUsuario($tipoUsuario);

			$statement->closeCursor(); // opcional en MySQL, dependiendo del controlador de base de datos puede ser obligatorio
			$statement = null; // obligado para cerrar la conexión
			$db = null;
			$conexion=null;

			return $usuario;

		}catch(PDOException $e){
			echo 'Error al conectar con la base de datos: ' . $e->getMessage();
		}


		/*if ($usuario->getFlag() == 1 and $usuario->getTipoUsuario()->getNombreRol()=='Administrador') {
			session_start();
			$_SESSION['usuario'] = serialize($usuario);
			echo 'Login true admin';
			//header("Location:../../vistas/adm/reportes.php");
		} else if($usuario->getFlag() == 1 and $usuario->getTipoUsuario()->getNombreRol()=='Usuario'){
			date_default_timezone_set('America/Mexico_City');
			echo 'Login true user';
			//header("Location:../../vistas/recepcionista/checkin.php");
		}else {
			
			echo '<script type="text/javascript">alert("Error, contraseña y/o usuario incorrecto");location.href="../../index.html";</script>';
		}*/
	}
}
?>

