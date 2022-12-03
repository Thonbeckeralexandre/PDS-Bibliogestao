<?php

$path = '/wamp64/www/gestao_biblio';

require_once($path . '/vo/vo_locacoes.php');
require_once($path . '/db/conecta.php');

class dao_locacoes
{
    public $tabela = 'locacoes';

    public function carrega_datatable($status)
    {
        $retorno = array();
        $sql = "SELECT 
                    a.id_locacao as id_locacao,
                    b.nome as locatario,
                    a.datahora_locacao as datahora_locacao,
                    a.ex_locatario as ex_locatario
                FROM 
                    $this->tabela a
                INNER JOIN
                    locatarios b ON a.ex_locatario = b.id_locatario
                WHERE
                    status = :status
                ORDER BY 
                    b.nome";
        $sql = db::prepare($sql);        
        $sql->bindParam(':status', $status);
        $sql->execute();
        $sql = $sql->fetchAll();
        if ($sql) {
            return $sql;
        } else {
            return false;
        }
    }

    public function inserir($vo_locacoes)
    {
        $sql = "INSERT INTO
                    $this->tabela ( 
                                id_locacao,
                                datahora_locacao,
                                ex_locatario,
                                ex_usuario,
                                obs,
                                status
                               )
                    VALUES (
                                :id_locacao,
                                :datahora_locacao,
                                :ex_locatario,
                                :ex_usuario,
                                :obs,
                                :status
                            )";
        $sql = db::prepare($sql);
        $sql->bindValue(':id_locacao', $vo_locacoes->get_id_locacao(), PDO::PARAM_STR);
        $sql->bindValue(':datahora_locacao', $vo_locacoes->get_datahora_locacao(), PDO::PARAM_STR);
        $sql->bindValue(':ex_locatario', $vo_locacoes->get_ex_locatario(), PDO::PARAM_STR);
        $sql->bindValue(':ex_usuario', $vo_locacoes->get_ex_usuario(), PDO::PARAM_STR);
        $sql->bindValue(':obs', $vo_locacoes->get_obs(), PDO::PARAM_STR);
        $sql->bindValue(':status', $vo_locacoes->get_status(), PDO::PARAM_STR);
        if ($sql->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function carrega_objeto($id_locacao)
    {
        $sql = "SELECT 
                    * 
                FROM 
                    $this->tabela 
                WHERE 
                    id_locacao = :id_locacao";
        $sql = db::prepare($sql);
        $sql->bindParam(':id_locacao', $id_locacao);
        $sql->execute();
        $sql = $sql->fetch();
        if ($sql) {
            $vo_locacoes = new vo_locacoes();
            $vo_locacoes->construtor_vo_locacoes($sql);
            return $vo_locacoes;
        } else {
            return null;
        }
    }

    public function devolucao($id_locacao)
    {
        $sql = "UPDATE 
                    $this->tabela
                SET
                    status = 'I'
                WHERE                    
                    id_locacao = :id_locacao";
        $sql = db::prepare($sql);
        $sql->bindParam(':id_locacao', $id_locacao);
        $sql->execute();
        if ($sql->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function verifica_locatario($ex_locatario)
    {
        $sql = "SELECT 
                    COUNT(id_locacao) as total
                FROM 
                    $this->tabela 
                WHERE 
                    ex_locatario = :ex_locatario
                AND
                    status = 'A'";
        $sql = db::prepare($sql);
        $sql->bindParam(':ex_locatario', $ex_locatario);
        $sql->execute();
        $sql = $sql->fetch();
        if ($sql) {
            return $sql->total;
        } else {
            return null;
        }
    }

    public function conta_locacoes_ativas()
    {
        $sql = "SELECT
                    count(id_locacao) as total
                FROM
                    $this->tabela
                WHERE
                    status = 'A'";
        $sql = db::prepare($sql);
        $sql->execute();
        $sql = $sql->fetch();
        if ($sql) {
            return $sql->total;
        } else {
            return null;
        }
    }

    public function conta_locacoes_inativas()
    {
        $sql = "SELECT
                    count(id_locacao) as total
                FROM
                    $this->tabela
                WHERE
                    status = 'I'";
        $sql = db::prepare($sql);
        $sql->execute();
        $sql = $sql->fetch();
        if ($sql) {
            return $sql->total;
        } else {
            return null;
        }
    }
}