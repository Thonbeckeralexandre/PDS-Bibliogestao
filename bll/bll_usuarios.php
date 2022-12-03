<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

require_once('/wamp64/www/gestao_biblio/dao/dao_usuarios.php');
require_once('/wamp64/www/gestao_biblio/apoio/apoio.php');

$acao = !empty($_POST['acao']) ? $_POST['acao'] : $_GET['acao'];


$dao_usuarios = new dao_usuarios();
$vo_usuarios = new vo_usuarios();

if ($acao == 'login') {
    $retorno = false;

    $user = !empty($_POST['usuario']) ? $_POST['usuario'] : null;
    $senha = !empty($_POST['senha']) ? sha1($_POST['senha']) : null;

    $consulta = $dao_usuarios->login($user, $senha);

    if ($consulta) {
        $retorno = true;

        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['usuario'] = $consulta->id_usuario;
    }

    echo json_encode($retorno);
}

if ($acao === 'inserir') {
    $retorno = false;

    $id_usuario = !empty($_POST['id_usuario']) ? $_POST['id_usuario'] : false;
        
    $vo_usuarios->set_id_usuario(gera_uuid_v4());
    $vo_usuarios->set_datahora_cadastro(get_datahora());
        
    $vo_usuarios->set_nome_user(isset($_POST['nome_user']) ? $_POST['nome_user'] : null);
    $vo_usuarios->set_senha(isset($_POST['senha_cadastro']) ? sha1($_POST['senha_cadastro']) : null);
    $vo_usuarios->set_login(isset($_POST['login']) ? $_POST['login'] : null);
    $vo_usuarios->set_ex_categoria_usuario(isset($_POST['select_categoria']) ? $_POST['select_categoria'] : null);

    
    if ($dao_usuarios->inserir($vo_usuarios)) {
        $retorno = trim($vo_usuarios->get_id_usuario());
    }
    
    echo json_encode(array(
        'id_usuario' => $retorno,
        'resposta' => 'sucesso'
    ));
};

