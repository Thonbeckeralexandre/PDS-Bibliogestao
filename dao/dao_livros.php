<?php

$path = '/wamp64/www/gestao_biblio';

require_once($path . '/vo/vo_livros.php');
require_once($path . '/db/conecta.php');

class dao_livros
{
    public $tabela = 'livros';

    public function inserir($vo_livros)
    {
        $sql = "INSERT INTO
                    $this->tabela ( 
                                id_livro,
                                nome,
                                edicao,
                                colecao,
                                obs,
                                ex_categoria,
                                disponivel,
                                isbn,
                                codigo
                               )
                    VALUES (
                                :id_livro,
                                :nome,
                                :edicao,
                                :colecao,
                                :obs,
                                :ex_categoria,
                                :disponivel,
                                :isbn,
                                :codigo
                            )";
        $sql = db::prepare($sql);
        $sql->bindValue(':id_livro', $vo_livros->get_id_livro(), PDO::PARAM_STR);
        $sql->bindValue(':nome', $vo_livros->get_nome(), PDO::PARAM_STR);
        $sql->bindValue(':edicao', $vo_livros->get_edicao(), PDO::PARAM_STR);
        $sql->bindValue(':colecao', $vo_livros->get_colecao(), PDO::PARAM_STR);
        $sql->bindValue(':obs', $vo_livros->get_obs(), PDO::PARAM_STR);
        $sql->bindValue(':ex_categoria', $vo_livros->get_ex_categoria(), PDO::PARAM_STR);
        $sql->bindValue(':disponivel', $vo_livros->get_disponivel(), PDO::PARAM_STR);
        $sql->bindValue(':isbn', $vo_livros->get_isbn(), PDO::PARAM_STR);
        $sql->bindValue(':codigo', $vo_livros->get_codigo(), PDO::PARAM_STR);
        if ($sql->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function editar($vo_livros)
    {
        $sql = "UPDATE 
                    $this->tabela
                SET
                    nome = :nome,
                    edicao = :edicao,
                    colecao = :colecao,
                    obs = :obs,
                    ex_categoria = :ex_categoria,
                    disponivel = :disponivel,
                    isbn = :isbn,
                    codigo = :codigo
                WHERE                    
                    id_livro = :id_livro
            ";
        $sql = db::prepare($sql);
        $sql->bindValue(':id_livro', $vo_livros->get_id_livro(), PDO::PARAM_STR);
        $sql->bindValue(':nome', $vo_livros->get_nome(), PDO::PARAM_STR);
        $sql->bindValue(':edicao', $vo_livros->get_edicao(), PDO::PARAM_STR);
        $sql->bindValue(':colecao', $vo_livros->get_colecao(), PDO::PARAM_STR);
        $sql->bindValue(':obs', $vo_livros->get_obs(), PDO::PARAM_STR);
        $sql->bindValue(':ex_categoria', $vo_livros->get_ex_categoria(), PDO::PARAM_STR);
        $sql->bindValue(':disponivel', $vo_livros->get_disponivel(), PDO::PARAM_STR);
        $sql->bindValue(':isbn', $vo_livros->get_isbn(), PDO::PARAM_STR);
        $sql->bindValue(':codigo', $vo_livros->get_codigo(), PDO::PARAM_STR);
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
                $vo_livros = new vo_livros();
                $vo_livros->construtor_vo_livros($sql_temp);
                array_push($retorno, $vo_livros);
            }
            return $retorno;
        } else {
            return false;
        }
    }

    public function carrega_select()
    {
        $sql = "SELECT 
                    a.id_livro as id_livro,
                    a.nome as nome,
                    a.codigo as codigo,
                    a.edicao as edicao
                FROM 
                    $this->tabela a
                WHERE
                    a.disponivel = 'S'
                ORDER BY 
                    a.nome";
        $sql = db::prepare($sql);
        $sql->execute();
        $sql = $sql->fetchAll();
        if ($sql) {
            return $sql;
        } else {
            return false;
        }
    }

    public function carrega_select_devolucao($ex_locacao)
    {
        $sql = "SELECT 
                    a.id_livro as id_livro,
                    a.nome as nome,
                    a.codigo as codigo,
                    a.edicao as edicao
                FROM 
                    $this->tabela a
                INNER JOIN
                    livros_nn_locacoes c ON a.id_livro = c.ex_livro
                WHERE
                    c.ex_locacao = :ex_locacao
                ORDER BY 
                    a.nome";
        $sql = db::prepare($sql);
        $sql->bindParam(':ex_locacao', $ex_locacao);
        $sql->execute();
        $sql = $sql->fetchAll();
        if ($sql) {
            return $sql;
        } else {
            return false;
        }
    }

    public function carrega_datatable($disponivel)
    {
        if ($disponivel == 'T') {
            $where = " ";
            
        } else {
            $where = " WHERE a.disponivel = '" . $disponivel . "' ";
        }
        $sql = "SELECT
                    a.id_livro as id_livro,
                    a.nome as nome,
                    a.disponivel as disponivel,
                    a.codigo as codigo,
                    b.nome as categoria
                FROM 
                    $this->tabela a
                INNER JOIN
                    categorias b ON a.ex_categoria = b.id_categoria
                    $where                          
                ORDER BY 
                    a.nome";
        $sql = db::prepare($sql);
        $sql->execute();
        $sql = $sql->fetchAll();
        return $sql;
    }

    public function carrega_objeto($id_livro)
    {
        $sql = "SELECT 
                    * 
                FROM 
                    $this->tabela 
                WHERE 
                    id_livro = :id_livro";
        $sql = db::prepare($sql);
        $sql->bindParam(':id_livro', $id_livro);
        $sql->execute();
        $sql = $sql->fetch();
        if ($sql) {
            $vo_livros = new vo_livros();
            $vo_livros->construtor_vo_livros($sql);
            return $vo_livros;
        } else {
            return null;
        }
    }

    public function count_por_codigo($codigo)
    {
        $sql = "SELECT
                    count(a.id_livro) as total
                FROM
                    $this->tabela
                WHERE
                    codigo = :codigo";
        $sql = db::prepare($sql);
        $sql->bindParam(':codigo', $codigo);
        $sql->execute();
        $sql = $sql->fetch();
        if ($sql) {
            return $sql->total;
        } else {
            return null;
        }
    }

    public function conta_livros()
    {
        $sql = "SELECT
                    count(id_livro) as total
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

    public function conta_livros_locados()
    {
        $sql = "SELECT
                    count(id_livro) as total
                FROM
                    $this->tabela
                WHERE
                    disponivel = 'N'";
        $sql = db::prepare($sql);
        $sql->execute();
        $sql = $sql->fetch();
        if ($sql) {
            return $sql->total;
        } else {
            return null;
        }
    }

    public function atualiza_disponibilidade($id_livro, $status)
    {
        $sql = "UPDATE 
                    $this->tabela
                SET
                    disponivel = :status
                WHERE                    
                    id_livro = :id_livro";
        $sql = db::prepare($sql);
        $sql->bindParam(':id_livro', $id_livro);
        $sql->bindParam(':status', $status);
        if ($sql->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function inserir_livros_nn_autores($ex_livro, $ex_autor)
    {
        $sql = "INSERT INTO 
                    livros_nn_autores (
                                ex_livro,
                                ex_autor
                                )
                VALUES (
                                :ex_livro,
                                :ex_autor
                                )";
        $sql = db::prepare($sql);
        $sql->bindParam(":ex_livro", $ex_livro);
        $sql->bindParam(":ex_autor", $ex_autor);
        return $sql->execute();
    }

    public function consulta_livros_nn_autores($ex_livro, $ex_autor)
    {
        $sql = "SELECT
                    count(ex_livro) as total
                FROM
                    livros_nn_autores
                WHERE
                    ex_livro = :ex_livro
                AND
                    ex_autor = :ex_autor";
        $sql = db::prepare($sql);
        $sql->bindParam(":ex_livro", $ex_livro);
        $sql->bindParam(":ex_autor", $ex_autor);
        $sql->execute();
        $sql = $sql->fetch();
        if ($sql) {
            return $sql->total;
        } else {
            return null;
        }
    }

    public function carrega_autores_por_livro($ex_livro)
    {
        
        $sql = "SELECT
                    GROUP_CONCAT(b.nome SEPARATOR ', ') as nome
                FROM 
                    livros_nn_autores a
                INNER JOIN
                    autor b ON a.ex_autor = b.id_autor
                WHERE
                    a.ex_livro = :ex_livro
                GROUP BY
                    a.ex_livro";
        $sql = db::prepare($sql);        
        $sql->bindParam(':ex_livro', $ex_livro);
        $sql->execute();
        $sql = $sql->fetch();
        if ($sql) {
            return $sql;
        } else {
            return false;
        }
    }

    public function carrega_autores_por_livro_select($ex_livro)
    {        
        $sql = "SELECT
                    b.id_autor
                FROM 
                    livros_nn_autores a
                INNER JOIN
                    autor b ON a.ex_autor = b.id_autor
                WHERE
                    ex_livro = :ex_livro";
        $sql = db::prepare($sql);        
        $sql->bindParam(':ex_livro', $ex_livro);
        $sql->execute();
        $sql = $sql->fetchAll();
        if ($sql) {
            return $sql;
        } else {
            return false;
        }
    }

    public function verifica_codigo($codigo)
    {
        $sql = "SELECT 
                    COUNT(id_livro) as total
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