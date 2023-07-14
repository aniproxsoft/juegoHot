<?php

require_once './php/service/CtrlJuego.php';
require_once './php/service/CtrlLogin.php';
    $ctrlLogin = new CtrlLogin();
    
    $usuario = $ctrlLogin->login('aniproxtoartmusic@gmail.com','hotGame132*');
    echo $usuario->toString();
    $ctrlJuego = new CtrlJuego();
    
    $juego = $ctrlJuego->getJuego($usuario->getUsuarioId());
    
    echo '<br> Json final'.json_encode($juego);  

