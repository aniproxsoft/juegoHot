<?php

    class TipoUsuarioDTO {
        private $usuarioId;
        private $rolId;
        private $nombreRol;

        

        public function getUsuarioId() {
            return $this->usuarioId;
        }
        
        public function setUsuarioId($usuarioId) {
            $this->usuarioId = $usuarioId;
        }
        
        public function getRolId() {
            return $this->rolId;
        }
        
        public function setRolId($rolId) {
            $this->rolId = $rolId;
        }
        
        public function getNombreRol() {
            return $this->nombreRol;
        }
        
        public function setNombreRol($nombreRol) {
            $this->nombreRol = $nombreRol;
        }
        public function toString() {
            return "TipoUsuarioDTO { usuarioId = " . $this->usuarioId . ", rolId = " . $this->rolId . ", nombreRol = " . $this->nombreRol . " }";
        }
       
    }
?>