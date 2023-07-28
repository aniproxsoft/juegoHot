<?php

	header("Cache-Control: no-cache");
	require_once "ClassConnection.php";
	require_once "./DTO/UsuarioDTO.php";
    require_once "./DTO/TipoUsuarioDTO.php";
	if(isset($_POST['pass'])){
		$password=$_POST['pass'];
	}
	if(isset($_POST['usuario'])){
		$user=$_POST['usuario'];
	}
	
		$db       = new connectionDB();
		$conexion = $db->get_connection();
		
		//$conexion->exec("set names utf8");
		//error_reporting(0);
		try {
			$usuario = new UsuarioDTO();
			$tipoUsuario=new TipoUsuarioDTO();
			$statement = $conexion->prepare("CALL sp_autentifica(?,?)");
			$statement->bindParam(1,$user);
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

		}catch(PDOException $e){
			echo 'Error al conectar con la base de datos: ' . $e->getMessage();
		}


		if ($usuario->getFlag() == 1 and $usuario->getTipoUsuario()->getNombreRol()=='Administrador') {
			session_start();
			$_SESSION['usuario'] = serialize($usuario);
			echo 'Login true admin';
			header("Location:../../vistas/adminJugar.php");
		} else if($usuario->getFlag() == 1 and $usuario->getTipoUsuario()->getNombreRol()=='Usuario'){
			session_start();
			$_SESSION['usuario'] = serialize($usuario);
			echo 'Login true user';
			header("Location:../../vistas/userJugar.php");
		}else {
			
			echo '<script type="text/javascript">alert("Error, contraseña y/o usuario incorrecto"); location.href = "../../index.php";</script>';
		}

?>