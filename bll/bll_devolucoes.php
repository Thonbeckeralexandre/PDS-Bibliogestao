<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION)) {
    session_start();
}

require_once('/app/dao/dao_devolucoes.php');
require_once('/app/apoio/apoio.php');

$acao = !empty($_POST['acao']) ? $_POST['acao'] : $_GET['acao'];

if ($acao == 'carrega_objeto') {   
    
    $dao_devolucoes = new dao_devolucoes();

    $retorno = false;
    $obs = !empty($_POST['obs_modal']) ? $_POST['obs_modal'] : null;
    $ex_locacao = !empty($_POST['ex_locacao']) ? $_POST['ex_locacao'] : null;

    $vo_devolucoes = $dao_devolucoes->carrega_objeto_por_locacao($ex_locacao);
    $obs = $dao_devolucoes->concat_obs($ex_locacao);
    $a = strval($obs->obs);    

    if ($vo_devolucoes) {
        $retorno = array(
            'ex_livro' => $vo_devolucoes->get_ex_livro() ? trim($vo_devolucoes->get_ex_livro()) : null,
            'ex_locacao' => $vo_devolucoes->get_ex_locacao() ? trim($vo_devolucoes->get_ex_locacao()) : null,
            'datahora_entrega' => $vo_devolucoes->get_datahora_entrega() ? trim($vo_devolucoes->get_datahora_entrega()) : null,
            'obs' => $a,
            'ex_usuario' => $vo_devolucoes->get_ex_usuario() ? trim($vo_devolucoes->get_ex_usuario()) : null
        );
    }

    echo json_encode($retorno);
}