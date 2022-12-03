<?php

$path = '/app';

require_once($path . '/vo/vo_autor.php');
require_once($path . '/db/conecta.php');

class dao_autores
{
    public $tabela = 'autor';

    public function inserir($vo_autor)
    {
        $sql = "INSERT INTO
                    $this->tabela ( 
                                id_autor,
                                nome
                               )
                    VALUES (
                                :id_autor,
                                :nome
                            )";
        $sql = db::prepare($sql);
        $sql->bindValue(':id_autor', $vo_autor->get_id_autor(), PDO::PARAM_STR);
        $sql->bindValue(':nome', $vo_autor->get_nome(), PDO::PARAM_STR);
        if ($sql->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    Public function editar($vo_autor)
    {
        $sql = "UPDATE 
                    $this->tabela
                SET
                    nome = :nome
                WHERE                    
                    id_autor = :id_autor    
                ";
        $sql = db::prepare($sql);
        $sql->bindValue(':id_autor', $vo_autor->get_id_autor(), PDO::PARAM_STR);
        $sql->bindValue(':nome', $vo_autor->get_nome(), PDO::PARAM_STR);
        if ($sql->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function carrega_tudo()
    {
        $retorno = array();
        $sql = "SELECT 
                    * 
                FROM 
                    $this->tabela 
                ORDER BY 
                    nome";
        $sql = db::prepare($sql);
        $sql->execute();
        $sql = $sql->fetchAll();
        if ($sql) {
            foreach ($sql as $sql_temp) {
                $vo_autor = new vo_autores();
                $vo_autor->construtor_vo_autor($sql_temp);
                array_push($retorno, $vo_autor);
            }
            return $retorno;
        } else {
            return false;
        }
    }

    public function carrega_objeto($id_autor)
    {
        $sql = "SELECT 
                    * 
                FROM 
                    $this->tabela 
                WHERE 
                    id_autor = :id_autor";
        $sql = db::prepare($sql);
        $sql->bindParam(':id_autor', $id_autor);
        $sql->execute();
        $sql = $sql->fetch();
        if ($sql) {
            $vo_autor = new vo_autores();
            $vo_autor->construtor_vo_autor($sql);
            return $vo_autor;
        } else {
            return null;
        }
    }

    public function carrega_by_livro($ex_livro)
    {
        $retorno = array();
        $sql = "SELECT 
                    * 
                FROM 
                    $this->tabela a
                INNER JOIN
                    livros_nn_autores b ON b.ex_autor = a.id_autor
                WHERE
                    b.ex_livro = :ex_livro
                ORDER BY 
                    a.nome";
        $sql = db::prepare($sql);
        $sql->bindParam(':ex_livro', $ex_livro);
        $sql->execute();
        $sql = $sql->fetchAll();
        if ($sql) {
            foreach ($sql as $sql_temp) {
                $vo_autor = new vo_autores();
                $vo_autor->construtor_vo_autor($sql_temp);
                array_push($retorno, $vo_autor);
            }
            return $retorno;
        } else {
            return false;
        }
    }
}