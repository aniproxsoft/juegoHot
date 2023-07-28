<?php
  require_once 'CtrlAdmin.php';

  $ctrlAdmin = new CtrlAdmin();
  $user = $_GET['user'];
  $jsonDesafios = $ctrlAdmin->getDesafios($user);
  
  $jsonResponse=json_encode($jsonDesafios);
  echo $jsonResponse;

?>