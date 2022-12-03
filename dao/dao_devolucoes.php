<?php

$path = '/wamp64/www/gestao_biblio';

require_once($path . '/vo/vo_devolucoes.php');
require_once($path . '/db/conecta.php');

class dao_devolucoes
{
    public $tabela = 'devolucoes';

    public function inserir($vo_devolucoes)
    {
        $sql = "INSERT INTO
                    $this->tabela ( 
                                ex_livro,
                                ex_locacao,
                                datahora_entrega,
                                obs,
                                ex_usuario
                               )
                    VALUES (
                                :ex_livro,
                                :ex_locacao,
                                :datahora_entrega,
                                :obs,
                                :ex_usuario
                            )";
        $sql = db::prepare($sql);
        $sql->bindValue(':ex_livro', $vo_devolucoes->get_ex_livro(), PDO::PARAM_STR);
        $sql->bindValue(':ex_locacao', $vo_devolucoes->get_ex_locacao(), PDO::PARAM_STR);
        $sql->bindValue(':datahora_entrega', $vo_devolucoes->get_datahora_entrega(), PDO::PARAM_STR);
        $sql->bindValue(':obs', $vo_devolucoes->get_obs(), PDO::PARAM_STR);
        $sql->bindValue(':ex_usuario', $vo_devolucoes->get_ex_usuario(), PDO::PARAM_STR);
        if ($sql->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function devolucao($ex_livro, $ex_locacao, $datahora_entrega, $obs)
    {
        $sql = "UPDATE 
                    $this->tabela
                SET
                    datahora_entrega = :datahora_entrega,
                    obs = :obs
                WHERE                    
                    ex_livro = :ex_livro
                AND
                    ex_locacao = :ex_locacao";
        $sql = db::prepare($sql);
        $sql->bindParam(':datahora_entrega', $datahora_entrega);
        $sql->bindParam(':ex_livro', $ex_livro);
        $sql->bindParam(':ex_locacao', $ex_locacao);
        $sql->bindParam(':obs', $obs);
        if ($sql->execute()) {
            return true;
        } else {
            return false;
        }
    }

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

    public function carrega_datahora_entrega($ex_locacao)
    {        
        $sql = "SELECT
                    datahora_entrega as datahora
                FROM 
                    $this->tabela
                WHERE
                    ex_locacao = :ex_locacao";
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

    public function carrega_objeto_por_locacao($ex_locacao)
    {
        $sql = "SELECT 
                    * 
                FROM 
                    $this->tabela 
                WHERE 
                    ex_locacao = :ex_locacao";
        $sql = db::prepare($sql);
        $sql->bindParam(':ex_locacao', $ex_locacao);
        $sql->execute();
        $sql = $sql->fetch();
        if ($sql) {
            $vo_devolucoes = new vo_devolucoes();
            $vo_devolucoes->construtor_vo_devolucoes($sql);
            return $vo_devolucoes;
        } else {
            return null;
        }
    }
}