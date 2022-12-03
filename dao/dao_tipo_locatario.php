<?php

$path = '/wamp64/www/gestao_biblio';

require_once($path . '/vo/vo_tipo_locatario.php');
require_once($path . '/db/conecta.php');

class dao_tipo_locatario
{
    public $tabela = 'tipo_locatario';

    public function inserir($vo_tipo_locatario)
    {
        $sql = "INSERT INTO
                    $this->tabela ( 
                                id_tipo_locatario,
                                tipo
                               )
                    VALUES (
                                :id_tipo_locatario,
                                :tipo                    
                            )";
        $sql = db::prepare($sql);
        $sql->bindValue(':id_tipo_locatario', $vo_tipo_locatario->get_id_tipo_locatario(), PDO::PARAM_STR);
        $sql->bindValue(':tipo', $vo_tipo_locatario->get_tipo(), PDO::PARAM_STR);
        if ($sql->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function editar($vo_tipo_locatarios)
    {
        $sql = "UPDATE 
                    $this->tabela
                SET
                    tipo = :tipo
                WHERE                    
                    id_tipo_locatario = :id_tipo_locatario
            ";
        $sql = db::prepare($sql);
        $sql->bindValue(':id_tipo_locatario', $vo_tipo_locatarios->get_id_tipo_locatario(), PDO::PARAM_STR);
        $sql->bindValue(':tipo', $vo_tipo_locatarios->get_tipo(), PDO::PARAM_STR);
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
                    tipo";
        $sql = db::prepare($sql);
        $sql->execute();
        $sql = $sql->fetchAll();
        if ($sql) {
            foreach ($sql as $sql_temp) {
                $vo_tipo_locatario = new vo_tipo_locatario();
                $vo_tipo_locatario->construtor_vo_tipo_locatario($sql_temp);
                array_push($retorno, $vo_tipo_locatario);
            }
            return $retorno;
        } else {
            return false;
        }
    }

    public function carrega_objeto($id_tipo_locatario)
    {
        $sql = "SELECT 
                    * 
                FROM 
                    $this->tabela 
                WHERE 
                    id_tipo_locatario = :id_tipo_locatario";
        $sql = db::prepare($sql);
        $sql->bindParam(':id_tipo_locatario', $id_tipo_locatario);
        $sql->execute();
        $sql = $sql->fetch();
        if ($sql) {
            $vo_tipo_locatario = new vo_tipo_locatario();
            $vo_tipo_locatario->construtor_vo_tipo_locatario($sql);
            return $vo_tipo_locatario;
        } else {
            return null;
        }
    }
}