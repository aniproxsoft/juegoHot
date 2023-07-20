<?php
  require_once 'CtrlAdmin.php';

  $ctrlAdmin = new CtrlAdmin();
 
  $jsonDesafios = $ctrlAdmin->getDesafios(1);
  
  $jsonResponse=json_encode($jsonDesafios);
  echo $jsonResponse;

?>