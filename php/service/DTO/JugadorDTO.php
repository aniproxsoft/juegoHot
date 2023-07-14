<?php

class JugadorDTO {
    private $jugadorId;
    private $jugadorNombre;
    private $usuarioId;
    private $jugadorSexo;

    public function getJugadorId() {
        return $this->jugadorId;
    }

    public function setJugadorId($jugadorId) {
        $this->jugadorId = $jugadorId;
    }

    public function getJugadorNombre() {
        return $this->jugadorNombre;
    }

    public function setJugadorNombre($jugadorNombre) {
        $this->jugadorNombre = $jugadorNombre;
    }

    public function getUsuarioId() {
        return $this->usuarioId;
    }

    public function setUsuarioId($usuarioId) {
        $this->usuarioId = $usuarioId;
    }

    public function getJugadorSexo() {
        return $this->jugadorSexo;
    }

    public function setJugadorSexo($jugadorSexo) {
        $this->jugadorSexo = $jugadorSexo;
    }

    public function toString() {
        return "JugadorDTO { jugadorId = " . $this->jugadorId . ", jugadorNombre = " . $this->jugadorNombre . ", usuarioId = " . $this->usuarioId . ", jugadorSexo = " . $this->jugadorSexo . " }";
    }
    public function toJson() {
        $data = array(
            'jugadorId' => $this->jugadorId,
            'jugadorNombre' => $this->jugadorNombre,
            'usuarioId' => $this->usuarioId,
            'jugadorSexo' => $this->jugadorSexo
        );
        
        return json_encode($data);
    }
}
?>