<?php

class vo_livros {

    private $id_livro;
    private $nome;
    private $edicao;
    private $colecao;
    private $obs;
    private $ex_categoria;
    private $disponivel;
    private $isbn;
    private $codigo;

    public function construtor_vo_livros($sql) {
        $this->id_livro = $sql->id_livro;
        $this->nome = $sql->nome;
        $this->edicao = $sql->edicao;
        $this->colecao = $sql->colecao;
        $this->obs = $sql->obs;
        $this->ex_categoria = $sql->ex_categoria;
        $this->disponivel = $sql->disponivel;
        $this->isbn = $sql->isbn;
        $this->codigo = $sql->codigo;
    }

    public function get_id_livro()
    {
        return $this->id_livro;
    }
    public function set_id_livro($id_livro)
    {
        $this->id_livro = $id_livro;

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

    public function get_edicao()
    {
        return $this->edicao;
    }
    public function set_edicao($edicao)
    {
        $this->edicao = $edicao;

        return $this;
    }

    public function get_colecao()
    {
        return $this->colecao;
    }
    public function set_colecao($colecao)
    {
        $this->colecao = $colecao;

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

    public function get_ex_categoria()
    {
        return $this->ex_categoria;
    }
    public function set_ex_categoria($ex_categoria)
    {
        $this->ex_categoria = $ex_categoria;

        return $this;
    }

    public function get_disponivel()
    {
        return $this->disponivel;
    }
    public function set_disponivel($disponivel)
    {
        $this->disponivel = $disponivel;

        return $this;
    }

    public function get_isbn()
    {
        return $this->isbn;
    }
    public function set_isbn($isbn)
    {
        $this->isbn = $isbn;

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