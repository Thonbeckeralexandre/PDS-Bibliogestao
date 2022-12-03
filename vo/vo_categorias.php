<?php

class vo_categorias {

    private $id_categoria;
    private $nome;
    private $cor;

    public function construtor_vo_categorias($sql) {
        $this->id_categoria = $sql->id_categoria;
        $this->nome = $sql->nome;
        $this->cor = $sql->cor;
    }

    public function get_id_categoria()
    {
        return $this->id_categoria;
    }
    public function set_id_categoria($id_categoria)
    {
        $this->id_categoria = $id_categoria;

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

    public function get_cor()
    {
        return $this->cor;
    }
    public function set_cor($cor)
    {
        $this->cor = $cor;

        return $this;
    }
}