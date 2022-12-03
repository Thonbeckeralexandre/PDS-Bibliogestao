<?php

class vo_livros_nn_locacoes_historico {

    private $ex_livros;
    private $ex_locacoes;

    public function construtor_vo_livros_nn_locacoes_historico($sql) {
        $this->ex_livros = $sql->ex_livros;
        $this->ex_locacoes = $sql->ex_locacoes;
    }

    public function get_ex_livros()
    {
        return $this->ex_livros;
    }
    public function set_ex_livros($ex_livros)
    {
        $this->ex_livros = $ex_livros;

        return $this;
    }

    public function get_ex_locacoes()
    {
        return $this->ex_locacoes;
    }
    public function set_ex_locacoes($ex_locacoes)
    {
        $this->ex_locacoes = $ex_locacoes;

        return $this;
    }
}