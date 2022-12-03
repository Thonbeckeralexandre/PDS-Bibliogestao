<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

require_once('/app/dao/dao_categoria_usuario.php');
require_once('/app/apoio/apoio.php');

$acao = !empty($_POST['acao']) ? $_POST['acao'] : $_GET['acao'];

$vo_categoria_usuario = new vo_categoria_usuario();
$dao_categoria_usuario = new dao_categoria_usuario();

if ($acao === 'inserir') {

    $retorno = false;

    $vo_categoria_usuario->set_id_categoria_usuario(gera_uuid_v4());
        
    $vo_categoria_usuario->set_nome(isset($_POST['nome']) ? $_POST['nome'] : null);
    if ($dao_categoria_usuario->inserir($vo_categoria_usuario)) {
        $retorno = trim($vo_categoria_usuario->get_id_categoria_usuario());
    }
    
    echo json_encode(array(
        'id_categoria_usuario' => $retorno,
        'resposta' => 'sucesso'
    ));
};

if ($acao === "carrega_selected") {

    $retorno = array();

    $vo_categoria_usuario = $dao_categoria_usuario->carrega_tudo();

    if ($vo_categoria_usuario) {
        foreach ($vo_categoria_usuario as $temp) {
            array_push($retorno, array(
                'id_categoria_usuario' => trim($temp->get_id_categoria_usuario()),
                'nome' => trim($temp->get_nome())
            ));
        }
    }

    echo json_encode($retorno);
}