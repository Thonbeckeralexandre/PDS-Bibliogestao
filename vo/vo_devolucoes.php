<?php

class vo_devolucoes {

    private $ex_livro;
    private $ex_locacao;
    private $datahora_entrega;
    private $obs;
    private $ex_usuario;

    public function construtor_vo_devolucoes($sql) {
        $this->ex_livro = $sql->ex_livro;
        $this->ex_locacao = $sql->ex_locacao;
        $this->datahora_entrega = $sql->datahora_entrega;
        $this->obs = $sql->obs;
        $this->ex_usuario = $sql->ex_usuario;
    }

    public function get_ex_livro()
    {
        return $this->ex_livro;
    }
    public function set_ex_livro($ex_livro)
    {
        $this->ex_livro = $ex_livro;

        return $this;
    }

    public function get_ex_locacao()
    {
        return $this->ex_locacao;
    }
    public function set_ex_locacao($ex_locacao)
    {
        $this->ex_locacao = $ex_locacao;

        return $this;
    }

    public function get_datahora_entrega()
    {
        return $this->datahora_entrega;
    }
    public function set_datahora_entrega($datahora_entrega)
    {
        $this->datahora_entrega = $datahora_entrega;

        return $this;
    }

    public function get_obs()
    {
        return $this->obs;
    }
    public function set_obs($obs)
    {
        $this->obs = $obs;

        return $this;
    }

    public function get_ex_usuario()
    {
        return $this->ex_usuario;
    }
    public function set_ex_usuario($ex_usuario)
    {
        $this->ex_usuario = $ex_usuario;

        return $this;
    }
}