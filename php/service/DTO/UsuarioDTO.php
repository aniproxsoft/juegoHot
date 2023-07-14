<?php
    require_once "TipoUsuarioDTO.php";
    class UsuarioDTO {
        private $usuarioId;
        private $usuarioEmail;
        private $flag;
        private $tipoUsuario;

        public function __construct()
        {
            $this->tipoUsuario= new TipoUsuarioDTO();
        }
        public function getUsuarioId() {
            return $this->usuarioId;
        }

        public function setUsuarioId($usuarioId) {
            $this->usuarioId = $usuarioId;
        }

        public function getUsuarioEmail() {
            return $this->usuarioEmail;
        }

        public function setUsuarioEmail($usuarioEmail) {
            $this->usuarioEmail = $usuarioEmail;
        }
        public function getFlag() {
            return $this->flag;
        }
        
        public function setFlag($flag) {
            $this->flag = $flag;
        }
        public function getTipoUsuario()
        {
            return $this->tipoUsuario;
        }
        public function setTipoUsuario($tipoUsuario)
        {
             $this->tipoUsuario=$this->validaNull($tipoUsuario);
        }

        public function toString() {
            $tipoUsuario = $this->tipoUsuario !== null ? $this->tipoUsuario->toString() : 'null';
    
            return "UsuarioDTO { usuarioId = " . $this->usuarioId . ", usuarioEmail = " . $this->usuarioEmail . ", flag = " . $this->flag . ", tipoUsuario = " . $tipoUsuario . " }";
        }

        public function validaNull($object){
            if($object==null){
                return '';
            }else{
                return $object;
            }

        }
    }
?>