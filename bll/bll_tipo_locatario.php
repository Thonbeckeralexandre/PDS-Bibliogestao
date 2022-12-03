<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

require_once('/app/dao/dao_tipo_locatario.php');
require_once('/app/apoio/apoio.php');

$acao = !empty($_POST['acao']) ? $_POST['acao'] : $_GET['acao'];

if ($acao === 'inserir') {
    $retorno = false;
    $vo_tipo_locatario = new vo_tipo_locatario();
    $dao_tipo_locatarios = new dao_tipo_locatario();

    $id_tipo_locatario = !empty($_POST['id_tipo_locatario']) ? $_POST['id_tipo_locatario'] : false;
    $tipo_locatario = !empty($_POST['tipo_locatario']) ? $_POST['tipo_locatario'] : null;

    if ($id_tipo_locatario) {
        $vo_tipo_locatario = $dao_tipo_locatarios->carrega_objeto($id_tipo_locatario);
    } else {
        $vo_tipo_locatario->set_id_tipo_locatario(gera_uuid_v4());
    }
        
    $vo_tipo_locatario->set_tipo($tipo_locatario);

    if ($id_tipo_locatario) {
        if ($dao_tipo_locatarios->editar($vo_tipo_locatario)) {
            $retorno = trim($vo_tipo_locatario->get_id_tipo_locatario());
        }
    } else {
        if ($dao_tipo_locatarios->inserir($vo_tipo_locatario)) {
            $retorno = trim($vo_tipo_locatario->get_id_tipo_locatario());
        }
    }
    
    echo json_encode(array(
        'id_tipo_locatario' => $retorno,
        'resposta' => 'sucesso'
    ));
};

if ($acao === "carrega_selected") {

    $retorno = array();

    $dao_tipo_locatario = new dao_tipo_locatario();

    $vo_tipo_locatario = $dao_tipo_locatario->carrega_tudo();

    if ($vo_tipo_locatario) {
        foreach ($vo_tipo_locatario as $temp) {
            array_push($retorno, array(
                'id_tipo_locatario' => trim($temp->get_id_tipo_locatario()),
                'tipo' => trim($temp->get_tipo())
            ));
        }
    }

    echo json_encode($retorno);
}