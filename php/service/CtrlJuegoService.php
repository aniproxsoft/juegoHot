<?php
  require_once 'CtrlJuego.php';
  require_once './DTO/UsuarioDTO.php';
  $ctrlJuego = new CtrlJuego();
  $usuario = new UsuarioDTO();  
  $jugadoresDesafiosArray = $ctrlJuego->getJuego($usuario->getUsuarioId());
  
  //echo '<br> Json final'.json_encode($jugadoresDesafiosArray); 
  $jsonJuego=json_encode($jugadoresDesafiosArray);
  echo $jsonJuego;

?>