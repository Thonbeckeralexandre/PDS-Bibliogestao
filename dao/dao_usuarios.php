<?php

$path = '/wamp64/www/gestao_biblio';

require_once($path . '/vo/vo_usuarios.php');
require_once($path . '/db/conecta.php');

class dao_usuarios
{
    public $tabela = 'usuarios';

    public function login($usuario, $senha)
    {
        $sql = "SELECT 
                    *   
                FROM 
                    $this->tabela 
                WHERE
                    login = :login
                AND
                    senha = :senha";
        $sql = db::prepare($sql);
        $sql->bindValue(':login', $usuario, PDO::PARAM_STR);
        $sql->bindValue(':senha', $senha, PDO::PARAM_STR);
        $sql->execute();
        $sql = $sql->fetch();
        if ($sql) {
            return $sql;
        } else {
            return false;
        }
    }
    
    public function inserir($vo_usuarios)
    {
        $sql = "INSERT INTO
                    $this->tabela ( 
                                id_usuario,
                                login,
                                senha,
                                datahora_cadastro,
                                nome_user,
                                ex_categoria_usuario
                               )
                    VALUES (
                                :id_usuario,
                                :login,
                                :senha,
                                :datahora_cadastro,
                                :nome_user,
                                :ex_categoria_usuario
                            )";
        $sql = db::prepare($sql);
        $sql->bindValue(':id_usuario', $vo_usuarios->get_id_usuario(), PDO::PARAM_STR);
        $sql->bindValue(':login', $vo_usuarios->get_login(), PDO::PARAM_STR);
        $sql->bindValue(':senha', $vo_usuarios->get_senha(), PDO::PARAM_STR);
        $sql->bindValue(':datahora_cadastro', $vo_usuarios->get_datahora_cadastro(), PDO::PARAM_STR);
        $sql->bindValue(':nome_user', $vo_usuarios->get_nome_user(), PDO::PARAM_STR);
        $sql->bindValue(':ex_categoria_usuario', $vo_usuarios->get_ex_categoria_usuario(), PDO::PARAM_STR);
        if ($sql->execute()) {
            return true;
        } else {
            return false;
        }
    }
}