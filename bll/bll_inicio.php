<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION)) {
    session_start();
}

require_once('/app/dao/dao_locatarios.php');
require_once('/app/dao/dao_locacoes.php');
require_once('/app/dao/dao_livros.php');
require_once('/app/apoio/apoio.php');

$acao = !empty($_POST['acao']) ? $_POST['acao'] : $_GET['acao'];

if ($acao == 'carrega_dash') {   
    
    $dao_locatarios = new dao_locatarios();
    $dao_locacoes = new dao_locacoes();
    $dao_livros = new dao_livros();

    $retorno = false;

    $livros_cadastrados = $dao_livros->conta_livros();
    $livros_locados = $dao_livros->conta_livros_locados();
    $locatarios_cadastrados = $dao_locatarios->conta_locatarios();
    $locacoes_ativas = $dao_locacoes->conta_locacoes_ativas();
    $locacoes_finalizadas = $dao_locacoes->conta_locacoes_inativas();

    
    $retorno = array(
        'livros_cadastrados' => 'Livros cadastrados: ' . $livros_cadastrados,
        'livros_locados' => 'Livros locados: ' . $livros_locados,
        'locatarios_cadastrados' => 'Locatários cadastrados: ' . $locatarios_cadastrados,
        'locacoes_ativas' => 'Locações ativas: ' . $locacoes_ativas,
        'locacoes_finalizadas' => 'Locações finalizadas: ' . $locacoes_finalizadas
    );
    
    echo json_encode($retorno);
}