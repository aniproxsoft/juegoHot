<?php
  require_once 'CtrlJuego.php';
  require_once './DTO/UsuarioDTO.php';
  $ctrlJuego = new CtrlJuego();
  $user = $_GET['user'];
  $jugadoresDesafiosArray = $ctrlJuego->getJuego($user);
  
  //echo '<br> Json final'.json_encode($jugadoresDesafiosArray); 
  $jsonJuego=json_encode($jugadoresDesafiosArray);
  echo $jsonJuego;

?>