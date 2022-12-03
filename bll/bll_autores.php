<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

require_once('/dao/dao_autores.php');
require_once('/dao/dao_livros.php');
require_once('/apoio/apoio.php');

$acao = !empty($_POST['acao']) ? $_POST['acao'] : $_GET['acao'];

if ($acao === 'inserir') {
    $retorno = false;
    $vo_autores = new vo_autores();
    $dao_autores = new dao_autores();

    $id_autor = !empty($_POST['id_autor']) ? $_POST['id_autor'] : false;

    if ($id_autor) {
        $vo_autores = $dao_autores->carrega_objeto($id_autor);
    } else {
        $vo_autores->set_id_autor(gera_uuid_v4());
    }
        
    $vo_autores->set_nome(isset($_POST['nome_autor']) ? $_POST['nome_autor'] : null);

    if ($id_autor) {
        if ($dao_autores->editar($vo_autores)) {
            $retorno = trim($vo_autores->get_id_autor());
        }
    } else {
        if ($dao_autores->inserir($vo_autores)) {
            $retorno = trim($vo_autores->get_id_autor());
        }
    }
    
    echo json_encode(array(
        'id_autor' => $retorno,
        'resposta' => 'sucesso'
    ));
};

if ($acao === "carrega_selected") {

    $retorno = array();

    $dao_autores = new dao_autores();
    $dao_livros = new dao_livros();

    $vo_autores = $dao_autores->carrega_tudo();

    if ($vo_autores) {
        foreach ($vo_autores as $temp) {
            array_push($retorno, array(
                'id_autor' => trim($temp->get_id_autor()),
                'nome' => trim($temp->get_nome())
            ));
        }
    }

    echo json_encode($retorno);
}