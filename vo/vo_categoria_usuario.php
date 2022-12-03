<?php

class vo_categoria_usuario {

    private $id_categoria_usuario;
    private $nome;

    public function construtor_vo_categoria_usuario($sql) {
        $this->id_categoria_usuario = $sql->id_categoria_usuario;
        $this->nome = $sql->nome;
    }

    public function get_id_categoria_usuario()
    {
        return $this->id_categoria_usuario;
    }
    public function set_id_categoria_usuario($id_categoria_usuario)
    {
        $this->id_categoria_usuario = $id_categoria_usuario;

        return $this;
    }

    public function get_nome()
    {
        return $this->nome;
    }
    public function set_nome($nome)
    {
        $this->nome = $nome;

        return $this;
    }
}