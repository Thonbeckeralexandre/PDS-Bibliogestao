<?php

$path = '/wamp64/www/gestao_biblio';

require_once($path . '/vo/vo_categorias.php');
require_once($path . '/db/conecta.php');

class dao_categorias
{
    public $tabela = 'categorias';

    public function inserir($vo_categorias)
    {
        $sql = "INSERT INTO
                    $this->tabela ( 
                                id_categoria,
                                nome,
                                cor
                               )
                    VALUES (
                                :id_categoria,
                                :nome,
                                :cor
                            )";
        $sql = db::prepare($sql);
        $sql->bindValue(':id_categoria', $vo_categorias->get_id_categoria(), PDO::PARAM_STR);
        $sql->bindValue(':nome', $vo_categorias->get_nome(), PDO::PARAM_STR);
        $sql->bindValue(':cor', $vo_categorias->get_cor(), PDO::PARAM_STR);
        if ($sql->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function editar($vo_categorias)
    {
        $sql = "UPDATE 
                    $this->tabela
                SET
                    nome = :nome,
                    cor = :cor
                WHERE                    
                    id_categoria = :id_categoria    
                ";
        $sql = db::prepare($sql);
        $sql->bindValue(':id_categoria', $vo_categorias->get_id_categoria(), PDO::PARAM_STR);
        $sql->bindValue(':nome', $vo_categorias->get_nome(), PDO::PARAM_STR);
        $sql->bindValue(':cor', $vo_categorias->get_cor(), PDO::PARAM_STR);
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
                $vo_categorias = new vo_categorias();
                $vo_categorias->construtor_vo_categorias($sql_temp);
                array_push($retorno, $vo_categorias);
            }
            return $retorno;
        } else {
            return false;
        }
    }

    public function carrega_objeto($id_categoria)
    {
        $sql = "SELECT 
                    * 
                FROM 
                    $this->tabela 
                WHERE 
                    id_categoria = :id_categoria";
        $sql = db::prepare($sql);
        $sql->bindParam(':id_categoria', $id_categoria);
        $sql->execute();
        $sql = $sql->fetch();
        if ($sql) {
            $vo_categorias = new vo_categorias();
            $vo_categorias->construtor_vo_categorias($sql);
            return $vo_categorias;
        } else {
            return null;
        }
    }
}