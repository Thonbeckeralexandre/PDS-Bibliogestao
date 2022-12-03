<?php

class vo_tipo_locatario {

    private $id_tipo_locatario;
    private $tipo;

    public function construtor_vo_tipo_locatario($sql) {
        $this->id_tipo_locatario = $sql->id_tipo_locatario;
        $this->tipo = $sql->tipo;
    }

    public function get_id_tipo_locatario()
    {
        return $this->id_tipo_locatario;
    }
    public function set_id_tipo_locatario($id_tipo_locatario)
    {
        $this->id_tipo_locatario = $id_tipo_locatario;

        return $this;
    }

    public function get_tipo()
    {
        return $this->tipo;
    }
    public function set_tipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }
}