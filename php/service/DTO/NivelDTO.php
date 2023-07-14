<?php
class NivelDTO {
    private $nivelId;
    private $nivelNombre;
    private $nivelDesc;
    private $adicional;
    
    private $numeroDesafios;

    public function getNivelId() {
        return $this->nivelId;
    }

    public function setNivelId($nivelId) {
        $this->nivelId = $nivelId;
    }

    public function getNivelNombre() {
        return $this->nivelNombre;
    }

    public function setNivelNombre($nivelNombre) {
        $this->nivelNombre = $nivelNombre;
    }

    public function getNivelDesc() {
        return $this->nivelDesc;
    }

    public function setNivelDesc($nivelDesc) {
        $this->nivelDesc = $nivelDesc;
    }

    public function getAdicional() {
        return $this->adicional;
    }

    public function setAdicional($adicional) {
        $this->adicional = $adicional;
    }
    public function getNumeroDesafios() {
        return $this->numeroDesafios;
    }

    public function setNumeroDesafios($numeroDesafios) {
        $this->numeroDesafios = $numeroDesafios;
    }
    public function toString() {
        return "NivelDTO [nivelId=" . $this->nivelId . ", nivelNombre=" . $this->nivelNombre . ", nivelDesc=" . $this->nivelDesc . ", adicional=" . $this->adicional . "]". ", numeroDesafios=" . $this->numeroDesafios . "]";
    }
}
?>