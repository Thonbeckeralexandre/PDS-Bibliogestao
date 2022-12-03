<?php

$path = '/app';

require_once($path . '/vo/vo_livros_nn_locacoes_historico.php');
require_once($path . '/db/conecta.php');

class dao_livros_nn_locacoes_historico
{
    public $tabela = 'livros_nn_locacoes_historico';

    public function carrega_livros_por_locacao($ex_locacao)
    {
        
        $sql = "SELECT
                    GROUP_CONCAT(b.nome SEPARATOR ' | ') as nome
                FROM 
                    $this->tabela a
                INNER JOIN
                    livros b ON a.ex_livro = b.id_livro
                WHERE
                    a.ex_locacao = :ex_locacao
                GROUP BY
                    a.ex_locacao";
        $sql = db::prepare($sql);        
        $sql->bindParam(':ex_locacao', $ex_locacao);
        $sql->execute();
        $sql = $sql->fetch();
        if ($sql) {
            return $sql;
        } else {
            return false;
        }
    }

    public function inserir($ex_locacao, $ex_livro)
    {
        $sql = "INSERT INTO 
                    $this->tabela (
                                ex_locacao,
                                ex_livro
                                )
                VALUES (
                                :ex_locacao,
                                :ex_livro
                                )";
        $sql = db::prepare($sql);
        $sql->bindParam(":ex_locacao", $ex_locacao);
        $sql->bindParam(":ex_livro", $ex_livro);
        return $sql->execute();
    }

    public function carrega_datahora($ex_locacao)
    {
        
        $sql = "SELECT
                    GROUP_CONCAT(b.nome SEPARATOR ' | ') as nome
                FROM 
                    $this->tabela a
                INNER JOIN
                    livros b ON a.ex_livro = b.id_livro
                WHERE
                    a.ex_locacao = :ex_locacao
                GROUP BY
                    a.ex_locacao";
        $sql = db::prepare($sql);        
        $sql->bindParam(':ex_locacao', $ex_locacao);
        $sql->execute();
        $sql = $sql->fetch();
        if ($sql) {
            return $sql;
        } else {
            return false;
        }
    }
}