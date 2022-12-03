<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION)) {
    session_start();
}

require_once('dao/dao_devolucoes.php');
require_once('apoio/apoio.php');

$acao = !empty($_POST['acao']) ? $_POST['acao'] : $_GET['acao'];

if ($acao == 'carrega_objeto') {   
    
    $dao_devolucoes = new dao_devolucoes();

    $retorno = false;
    $obs = !empty($_POST['obs_modal']) ? $_POST['obs_modal'] : null;
    $ex_locacao = !empty($_POST['ex_locacao']) ? $_POST['ex_locacao'] : null;

    $vo_devolucoes = $dao_devolucoes->carrega_objeto_por_locacao($ex_locacao);

    if ($vo_devolucoes) {
        $retorno = array(
            'ex_livro' => trim($vo_devolucoes->get_ex_livro()),
            'ex_locacao' => trim($vo_devolucoes->get_ex_locacao()),
            'datahora_entrega' => trim($vo_devolucoes->get_datahora_entrega()),
            'obs' => trim($vo_devolucoes->get_obs()),
            'ex_usuario' => trim($vo_devolucoes->get_ex_usuario())
        );
    }

    echo json_encode($retorno);
}