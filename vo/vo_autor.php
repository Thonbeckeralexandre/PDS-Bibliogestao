<?php

class vo_autores {

    private $id_autor;
    private $nome;

    public function construtor_vo_autor($sql) {
        $this->id_autor = $sql->id_autor;
        $this->nome = $sql->nome;
    }

    public function get_id_autor()
    {
        return $this->id_autor;
    }
    public function set_id_autor($id_autor)
    {
        $this->id_autor = $id_autor;

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