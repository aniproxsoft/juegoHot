<?php
class DesafioDTO {
    private $desafioId;
    private $nivelId;
    private $desafioDesc;
    private $usuarioId;
    private $tiempoSegundos;
    private $status;
    private $nivelNombre;
    private $nivelDesc;
    private $adicional;
    private $numeroDesafios;

    public function getDesafioId() {
        return $this->desafioId;
    }

    public function setDesafioId($desafioId) {
        $this->desafioId = $desafioId;
    }

    public function getNivelId() {
        return $this->nivelId;
    }

    public function setNivelId($nivelId) {
        $this->nivelId = $nivelId;
    }

    public function getDesafioDesc() {
        return $this->desafioDesc;
    }

    public function setDesafioDesc($desafioDesc) {
        $this->desafioDesc = $desafioDesc;
    }

    public function getUsuarioId() {
        return $this->usuarioId;
    }

    public function setUsuarioId($usuarioId) {
        $this->usuarioId = $usuarioId;
    }

    public function getTiempoSegundos() {
        return $this->tiempoSegundos;
    }

    public function setTiempoSegundos($tiempoSegundos) {
        $this->tiempoSegundos = $tiempoSegundos;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
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
        return "DesafioDTO [desafioId=" . $this->desafioId . ", nivelId=" . $this->nivelId . ", desafioDesc=" . $this->desafioDesc . ", usuarioId=" . $this->usuarioId . ", tiempoSegundos=" . $this->tiempoSegundos . ", status=" . $this->status . ", nivelNombre=" . $this->nivelNombre . ", nivelDesc=" . $this->nivelDesc . ", adicional=" . $this->adicional . ", numeroDesafios=" . $this->numeroDesafios . "]";
    }
    public function toJson() {
        $data = array(
            'desafioId' => $this->desafioId,
            'nivelId' => $this->nivelId,
            'desafioDesc' => $this->desafioDesc,
            'usuarioId' => $this->usuarioId,
            'tiempoSegundos' => $this->tiempoSegundos,
            'status' => $this->status,
            'nivelNombre' => $this->nivelNombre,
            'nivelDesc' => $this->nivelDesc,
            'adicional' => $this->adicional,
            'numeroDesafios' => $this->numeroDesafios
        );
        
        return json_encode($data);
    }
}
?>