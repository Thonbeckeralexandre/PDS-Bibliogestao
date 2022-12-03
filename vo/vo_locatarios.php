<?php

class vo_locatarios {

    private $id_locatario;
    private $nome;
    private $endereco;
    private $telefone;
    private $responsavel;
    private $ex_tipo;
    private $email;
    private $codigo;

    public function construtor_vo_locatarios($sql) {
        $this->id_locatario = $sql->id_locatario;
        $this->nome = $sql->nome;
        $this->endereco = $sql->endereco;
        $this->telefone = $sql->telefone;
        $this->responsavel = $sql->responsavel;
        $this->ex_tipo = $sql->ex_tipo;
        $this->email = $sql->email;
        $this->codigo = $sql->codigo;
    }

    public function get_id_locatario()
    {
        return $this->id_locatario;
    }
    public function set_id_locatario($id_locatario)
    {
        $this->id_locatario = $id_locatario;

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

    public function get_endereco()
    {
        return $this->endereco;
    }
    public function set_endereco($endereco)
    {
        $this->endereco = $endereco;

        return $this;
    }

    public function get_telefone()
    {
        return $this->telefone;
    }
    public function set_telefone($telefone)
    {
        $this->telefone = $telefone;

        return $this;
    }

    public function get_responsavel()
    {
        return $this->responsavel;
    }
    public function set_responsavel($responsavel)
    {
        $this->responsavel = $responsavel;

        return $this;
    }

    public function get_ex_tipo()
    {
        return $this->ex_tipo;
    }
    public function set_ex_tipo($ex_tipo)
    {
        $this->ex_tipo = $ex_tipo;

        return $this;
    }

    public function get_email()
    {
        return $this->email;
    }
    public function set_email($email)
    {
        $this->email = $email;

        return $this;
    }

    public function get_codigo()
    {
        return $this->codigo;
    }
    public function set_codigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }
}