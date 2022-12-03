<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

require_once('/app/dao/dao_livros.php');
require_once('/app/dao/dao_locacoes.php');
require_once('/app/apoio/apoio.php');

$acao = !empty($_POST['acao']) ? $_POST['acao'] : $_GET['acao'];

$dao_livros = new dao_livros();
$vo_livros = new vo_livros();

if ($acao == 'carrega_datatable_livros') {

    $retorno = false;
    $dados['data'] = array();

    $disponivel = !empty($_POST['disponivel']) ? $_POST['disponivel'] : false;

    $sql = $dao_livros->carrega_datatable($disponivel);

    if ($sql) {
        foreach ($sql as $temp) {

            $autores = '';

            $autores = $dao_livros->carrega_autores_por_livro($temp->id_livro);

            if ($autores != false) {
                $a = strval($autores->nome);
            } else {
                $a = '';
            }

            $disponivel = "<center>";
            switch($temp->disponivel){
                case "S":
                    $disponivel .= '<button type="button" class="btn btn-default btn-xs"><span title="Disponível" style="color:green" class="fa fa-check-square fa-2x"></span></button>';
                    break;
                case "N":
                    $disponivel .= '<button class="btn btn-default btn-xs"><span title="Indisponível" style="color:red" class="fa fa-minus-square fa-2x"></span></button>';
                    break;
            }
            $disponivel .= "</center>";

            $funcoes = '<center>';
            $funcoes .= '&nbsp<button onclick="editar_livro(\'' . $temp->id_livro . '\')" type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" title="Abrir/Editar"><i  class="fa fa-folder-open"></i></button>';
            $funcoes .= '</center>';

            $retorno = array(
                'nome' => $temp->nome,
                'categoria' => $temp->categoria,
                'disponivel' => $disponivel,
                'codigo' => $temp->codigo,
                'autor' => $a,
                'funcoes' => $funcoes
            );
            array_push($dados['data'], $retorno);

        }        
    }
    echo json_encode($dados);
}

if ($acao === 'inserir') {
    $retorno = false;

    $id_livro = !empty($_POST['id_livro']) ? $_POST['id_livro'] : false;

    if ($id_livro) {
        $vo_livros = $dao_livros->carrega_objeto($id_livro);
    } else {
        $vo_livros->set_id_livro(gera_uuid_v4());
    }
        
    $vo_livros->set_nome(isset($_POST['nome']) ? $_POST['nome'] : null);
    $vo_livros->set_obs(isset($_POST['obs']) ? $_POST['obs'] : null);
    $vo_livros->set_colecao(isset($_POST['colecao']) ? $_POST['colecao'] : null);
    $vo_livros->set_edicao(isset($_POST['edicao']) ? $_POST['edicao'] : null);
    $vo_livros->set_isbn(isset($_POST['isbn']) ? $_POST['isbn'] : null);
    $vo_livros->set_disponivel(isset($_POST['select_disponivel']) ? $_POST['select_disponivel'] : 'S');
    $vo_livros->set_ex_categoria(isset($_POST['select_categoria']) ? $_POST['select_categoria'] : null);
    $vo_livros->set_codigo(isset($_POST['codigo']) ? $_POST['codigo'] : null);

    if ($id_livro) {
        if ($dao_livros->editar($vo_livros)) {
            $retorno = trim($vo_livros->get_id_livro());
        }
    } else {
        if ($dao_livros->inserir($vo_livros)) {
            $retorno = trim($vo_livros->get_id_livro());
        }
    }

    $array_autores = !empty($_POST['array_autores']) ? $_POST['array_autores'] : null;
    if ($array_autores) {
        foreach ($array_autores as $autores) {
            $consulta = $dao_livros->consulta_livros_nn_autores($vo_livros->get_id_livro(), $autores);
            if ($consulta == 0) {
                $dao_livros->inserir_livros_nn_autores($vo_livros->get_id_livro(), $autores);
            }
        }
    }
    
    echo json_encode(array(
        'id_livro' => $retorno,
        'resposta' => 'sucesso'
    ));
};

if ($acao == 'carrega_objeto') {

    $id_livro = !empty($_POST['id_livro']) ? $_POST['id_livro'] : null;

    $vo_livros = $dao_livros->carrega_objeto($id_livro);

    $array_id = array();
    $array_autores = $dao_livros->carrega_autores_por_livro_select($id_livro);

    // if ($array_autores) {
    //     foreach ($array_autores as $temp) {
    //         array_push($array_id, $temp->id_autor);
    //     }
    // }           

    // $array_autores = str_replace('"', "'", json_encode($array_id));

    $retorno = false;

    if ($vo_livros) {
        $retorno = array(
            'id_livro' => trim($vo_livros->get_id_livro()),
            'nome' => trim($vo_livros->get_nome()),
            'edicao' => trim($vo_livros->get_edicao()),
            'colecao' => trim($vo_livros->get_colecao()),
            'obs' => trim($vo_livros->get_obs()),
            'ex_categoria' => trim($vo_livros->get_ex_categoria()),
            'disponivel' => trim($vo_livros->get_disponivel()),
            'isbn' => trim($vo_livros->get_isbn()),
            'array_autores' => $array_autores,
            'codigo' => trim($vo_livros->get_codigo())
        );
    }

    echo json_encode($retorno);
}

if ($acao === "carrega_select") {

    $retorno = array();

    $dao_livros = new dao_livros();
    $dao_locacoes = new dao_locacoes();

    $funcao = !empty($_POST['funcao']) ? $_POST['funcao'] : null;
    $ex_locacao = !empty($_POST['ex_locacao']) ? $_POST['ex_locacao'] : null;

    $vo_locacoes = $dao_locacoes->carrega_objeto($ex_locacao);

    if($funcao == 'D') {
        if($vo_locacoes) {            
            $vo_livros = $dao_livros->carrega_select_devolucao($vo_locacoes->get_id_locacao());
        }
    } else {
        $vo_livros = $dao_livros->carrega_select();
    }

    if ($vo_livros) {
        foreach ($vo_livros as $temp) {         
            $autor = $dao_livros->carrega_autores_por_livro($temp->id_livro);
            array_push($retorno, array(
                'id_livro' => $temp->id_livro,
                'nome' => $temp->nome,
                'autor' => $autor->nome,
                'codigo' => $temp->codigo,
                'edicao' => $temp->edicao
            ));
        }
    }

    echo json_encode($retorno);
}

if ($acao === 'verifica_codigo') {

    $codigo = !empty($_POST['codigo']) ? $_POST['codigo'] : null;
    $id_livro = !empty($_POST['id_livro']) ? $_POST['id_livro'] : null;

    $verifica = $dao_livros->verifica_codigo($codigo);

    if ($id_livro) {        
        if($verifica == 1) {
            $retorno = true;
        } else {
            $retorno = false;
        }
    } else {
        if($verifica == 0) {
            $retorno = true;
        } else {
            $retorno = false;
        }
    }    

    echo json_encode($retorno);
}