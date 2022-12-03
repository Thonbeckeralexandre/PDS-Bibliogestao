<?php

$path = '/app';

require_once($path . '/vo/vo_locatarios.php');
require_once($path . '/db/conecta.php');

class dao_locatarios
{
    public $tabela = 'locatarios';

    public function inserir($vo_locatarios)
    {
        $sql = "INSERT INTO
                    $this->tabela ( 
                                id_locatario,
                                nome,
                                endereco,
                                telefone,
                                responsavel,
                                ex_tipo,
                                email,
                                codigo
                               )
                    VALUES (
                                :id_locatario,
                                :nome,
                                :endereco,
                                :telefone,
                                :responsavel,
                                :ex_tipo,
                                :email,
                                :codigo
                            )";
        $sql = db::prepare($sql);
        $sql->bindValue(':id_locatario', $vo_locatarios->get_id_locatario(), PDO::PARAM_STR);
        $sql->bindValue(':nome', $vo_locatarios->get_nome(), PDO::PARAM_STR);
        $sql->bindValue(':endereco', $vo_locatarios->get_endereco(), PDO::PARAM_STR);
        $sql->bindValue(':telefone', $vo_locatarios->get_telefone(), PDO::PARAM_INT);
        $sql->bindValue(':responsavel', $vo_locatarios->get_responsavel(), PDO::PARAM_STR);
        $sql->bindValue(':ex_tipo', $vo_locatarios->get_ex_tipo(), PDO::PARAM_STR);
        $sql->bindValue(':email', $vo_locatarios->get_email(), PDO::PARAM_STR);
        $sql->bindValue(':codigo', $vo_locatarios->get_codigo(), PDO::PARAM_STR);
        if ($sql->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function editar($vo_locatarios)
    {
        $sql = "UPDATE 
                    $this->tabela
                SET
                    nome = :nome,
                    endereco = :endereco,
                    telefone = :telefone,
                    responsavel = :responsavel,
                    ex_tipo = :ex_tipo,
                    email = :email,
                    codigo = :codigo
                WHERE                    
                    id_locatario = :id_locatario
            ";
        $sql = db::prepare($sql);
        $sql->bindValue(':id_locatario', $vo_locatarios->get_id_locatario(), PDO::PARAM_STR);
        $sql->bindValue(':nome', $vo_locatarios->get_nome(), PDO::PARAM_STR);
        $sql->bindValue(':endereco', $vo_locatarios->get_endereco(), PDO::PARAM_STR);
        $sql->bindValue(':telefone', $vo_locatarios->get_telefone(), PDO::PARAM_INT);
        $sql->bindValue(':responsavel', $vo_locatarios->get_responsavel(), PDO::PARAM_STR);
        $sql->bindValue(':ex_tipo', $vo_locatarios->get_ex_tipo(), PDO::PARAM_STR);
        $sql->bindValue(':email', $vo_locatarios->get_email(), PDO::PARAM_STR);
        $sql->bindValue(':codigo', $vo_locatarios->get_codigo(), PDO::PARAM_STR);
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
                $vo_locatarios = new vo_locatarios();
                $vo_locatarios->construtor_vo_locatarios($sql_temp);
                array_push($retorno, $vo_locatarios);
            }
            return $retorno;
        } else {
            return false;
        }
    }

    public function carrega_objeto($id_locatario)
    {
        $sql = "SELECT 
                    * 
                FROM 
                    $this->tabela 
                WHERE 
                    id_locatario = :id_locatario";
        $sql = db::prepare($sql);
        $sql->bindParam(':id_locatario', $id_locatario);
        $sql->execute();
        $sql = $sql->fetch();
        if ($sql) {
            $vo_locatario = new vo_locatarios();
            $vo_locatario->construtor_vo_locatarios($sql);
            return $vo_locatario;
        } else {
            return null;
        }
    }

    public function carrega_com_locacao_ativa()
    {
        $retorno = array();
        $sql = "SELECT 
                    * 
                FROM 
                    $this->tabela a
                INNER JOIN
                    locacoes b ON a.id_locatario = b.ex_locatario
                WHERE
                    b.status = 'A'
                ORDER BY 
                    nome";
        $sql = db::prepare($sql);
        $sql->execute();
        $sql = $sql->fetchAll();
        if ($sql) {
            foreach ($sql as $sql_temp) {
                $vo_locatarios = new vo_locatarios();
                $vo_locatarios->construtor_vo_locatarios($sql_temp);
                array_push($retorno, $vo_locatarios);
            }
            return $retorno;
        } else {
            return false;
        }
    }

    public function conta_locatarios()
    {
        $sql = "SELECT
                    count(id_locatario) as total
                FROM
                    $this->tabela";
        $sql = db::prepare($sql);
        $sql->execute();
        $sql = $sql->fetch();
        if ($sql) {
            return $sql->total;
        } else {
            return null;
        }
    }

    public function verifica_codigo($codigo)
    {
        $sql = "SELECT 
                    COUNT(id_locatario) as total
                FROM 
                    $this->tabela
                WHERE 
                    codigo = :codigo
                ";
        $sql = db::prepare($sql);
        $sql->bindParam(":codigo", $codigo);
        $sql->execute();
        $sql = $sql->fetch();
        if ($sql) {
            return $sql->total;
        } else {
            return null;
        }
    }
}