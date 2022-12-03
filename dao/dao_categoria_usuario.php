<?php

$path = '/wamp64/www/gestao_biblio';

require_once($path . '/vo/vo_categoria_usuario.php');
require_once($path . '/db/conecta.php');

class dao_categoria_usuario
{
    public $tabela = 'categoria_usuario';

    public function inserir($vo_categoria_usuario)
    {
        $sql = "INSERT INTO
                    $this->tabela ( 
                                id_categoria_usuario,
                                nome
                               )
                    VALUES (
                                :id_categoria_usuario,
                                :nome
                            )";
        $sql = db::prepare($sql);
        $sql->bindValue(':id_categoria_usuario', $vo_categoria_usuario->get_id_categoria_usuario(), PDO::PARAM_STR);
        $sql->bindValue(':nome', $vo_categoria_usuario->get_nome(), PDO::PARAM_STR);
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
                $vo_categoria_usuario = new vo_categoria_usuario();
                $vo_categoria_usuario->construtor_vo_categoria_usuario($sql_temp);
                array_push($retorno, $vo_categoria_usuario);
            }
            return $retorno;
        } else {
            return false;
        }
    }
}