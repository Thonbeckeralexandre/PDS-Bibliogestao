<?php

class vo_locacoes {

    private $id_locacao;
    private $datahora_locacao;
    private $ex_locatario;
    private $ex_usuario;
    private $obs;
    private $status;

    public function construtor_vo_locacoes($sql) {
        $this->id_locacao = $sql->id_locacao;
        $this->datahora_locacao = $sql->datahora_locacao;
        $this->ex_locatario = $sql->ex_locatario;
        $this->ex_usuario = $sql->ex_usuario;
        $this->obs = $sql->obs;
        $this->status = $sql->status;
    }

    public function get_id_locacao()
    {
        return $this->id_locacao;
    }
    public function set_id_locacao($id_locacao)
    {
        $this->id_locacao = $id_locacao;

        return $this;
    }

    public function get_datahora_locacao()
    {
        return $this->datahora_locacao;
    }
    public function set_datahora_locacao($datahora_locacao)
    {
        $this->datahora_locacao = $datahora_locacao;

        return $this;
    }

    public function get_ex_locatario()
    {
        return $this->ex_locatario;
    }
    public function set_ex_locatario($ex_locatario)
    {
        $this->ex_locatario = $ex_locatario;

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

    public function get_obs()
    {
        return $this->obs;
    }
    public function set_obs($obs)
    {
        $this->obs = $obs;

        return $this;
    }

    public function get_status()
    {
        return $this->status;
    }
    public function set_status($status)
    {
        $this->status = $status;

        return $this;
    }
}