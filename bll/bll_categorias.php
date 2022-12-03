<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

require_once('/app/dao/dao_categorias.php');
require_once('/app/apoio/apoio.php');

$acao = !empty($_POST['acao']) ? $_POST['acao'] : $_GET['acao'];

if ($acao === 'inserir') {
    $retorno = false;
    $vo_categorias = new vo_categorias();
    $dao_categorias = new dao_categorias();

    $id_categoria = !empty($_POST['id_categoria']) ? $_POST['id_categoria'] : false;

    if ($id_categoria) {
        $vo_categorias = $dao_categorias->carrega_objeto($id_tipo_locatario);
    } else {
        $vo_categorias->set_id_categoria(gera_uuid_v4());
    }
        
    $vo_categorias->set_nome(isset($_POST['nome_categoria']) ? $_POST['nome_categoria'] : null);
    $vo_categorias->set_cor(isset($_POST['cor']) ? $_POST['cor'] : null);

    if ($id_categoria) {
        if ($dao_categorias->editar($vo_categorias)) {
            $retorno = trim($vo_categorias->get_id_categoria());
        }
    } else {
        if ($dao_categorias->inserir($vo_categorias)) {
            $retorno = trim($vo_categorias->get_id_categoria());
        }
    }
    
    echo json_encode(array(
        'id_categoria' => $retorno,
        'resposta' => 'sucesso'
    ));
};

if ($acao === "carrega_selected") {

    $retorno = array();

    $dao_categorias = new dao_categorias();

    $vo_categorias = $dao_categorias->carrega_tudo();

    if ($vo_categorias) {
        foreach ($vo_categorias as $temp) {
            array_push($retorno, array(
                'id' => trim($temp->get_id_categoria()),
                'nome' => trim($temp->get_nome())
            ));
        }
    }

    echo json_encode($retorno);
}