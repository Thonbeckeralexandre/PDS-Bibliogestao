<?php

class vo_usuarios {

    private $id_usuario;
    private $login;
    private $senha;
    private $datahora_cadastro;
    private $nome_user;
    private $ex_categoria_usuario;

    public function construtor_vo_usuarios($sql) {
        $this->id_usuario = $sql->id_usuario;
        $this->login = $sql->login;
        $this->senha = $sql->senha;
        $this->datahora_cadastro = $sql->datahora_cadastro;
        $this->nome_user = $sql->nome_user;
        $this->ex_categoria_usuario = $sql->ex_categoria_usuario;
    }

    public function get_id_usuario()
    {
        return $this->id_usuario;
    }
    public function set_id_usuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;

        return $this;
    }

    public function get_login()
    {
        return $this->login;
    }
    public function set_login($login)
    {
        $this->login = $login;

        return $this;
    }

    public function get_senha()
    {
        return $this->senha;
    }
    public function set_senha($senha)
    {
        $this->senha = $senha;

        return $this;
    }

    public function get_datahora_cadastro()
    {
        return $this->datahora_cadastro;
    }
    public function set_datahora_cadastro($datahora_cadastro)
    {
        $this->datahora_cadastro = $datahora_cadastro;

        return $this;
    }

    public function get_nome_user()
    {
        return $this->nome_user;
    }
    public function set_nome_user($nome_user)
    {
        $this->nome_user = $nome_user;

        return $this;
    }

    public function get_ex_categoria_usuario()
    {
        return $this->ex_categoria_usuario;
    }
    public function set_ex_categoria_usuario($ex_categoria_usuario)
    {
        $this->ex_categoria_usuario = $ex_categoria_usuario;

        return $this;
    }
}