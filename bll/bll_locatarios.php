<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

require_once('/app/dao/dao_locatarios.php');
require_once('/app/dao/dao_tipo_locatario.php');
require_once('/app/apoio/apoio.php');

$acao = !empty($_POST['acao']) ? $_POST['acao'] : $_GET['acao'];


$dao_locatarios = new dao_locatarios();
$vo_locatarios = new vo_locatarios();

if ($acao == 'carrega_datatable_locatarios') {

    $retorno = false;
    $dados['data'] = array();

    $dao_tipo_locatario = new dao_tipo_locatario();

    $vo_locatarios = $dao_locatarios->carrega_tudo();

    if ($vo_locatarios) {
        foreach ($vo_locatarios as $temp) {

            $tipo = $dao_tipo_locatario->carrega_objeto($temp->get_ex_tipo());

            $funcoes = '<center>';
            $funcoes .= '&nbsp<button onclick="editar_locatario(\'' . $temp->get_id_locatario() . '\')" type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" title="Abrir/Editar"><i  class="fa fa-folder-open"></i></button>';
            $funcoes .= '</center>';

            $retorno = array(
                'nome' => $temp->get_nome() ? trim($temp->get_nome()) : null,
                'telefone' => $temp->get_telefone() ? trim($temp->get_telefone()) : null,
                'tipo' => $tipo->get_tipo() ? trim($tipo->get_tipo()) : null,
                'codigo' => $temp->get_codigo() ? trim($temp->get_codigo()) : null,
                'funcoes' => $funcoes
            );
            array_push($dados['data'], $retorno);

        }        
    }
    echo json_encode($dados);
}

if ($acao === 'inserir') {
    $retorno = false;

    $id_locatario = !empty($_POST['id_locatario']) ? $_POST['id_locatario'] : false;

    if ($id_locatario) {
        $vo_locatarios = $dao_locatarios->carrega_objeto($id_locatario);
    } else {
        $vo_locatarios->set_id_locatario(gera_uuid_v4());
    }
        
    $vo_locatarios->set_nome(isset($_POST['nome']) ? $_POST['nome'] : null);
    $vo_locatarios->set_endereco(isset($_POST['endereco']) ? $_POST['endereco'] : null);
    $vo_locatarios->set_telefone(isset($_POST['telefone']) ? $_POST['telefone'] : null);
    $vo_locatarios->set_responsavel(isset($_POST['responsavel']) ? $_POST['responsavel'] : null);
    $vo_locatarios->set_ex_tipo(isset($_POST['select_tipo']) ? $_POST['select_tipo'] : null);
    $vo_locatarios->set_email(isset($_POST['email']) ? $_POST['email'] : null);
    $vo_locatarios->set_codigo(isset($_POST['codigo']) ? $_POST['codigo'] : null);

    if ($id_locatario) {
        if ($dao_locatarios->editar($vo_locatarios)) {
            $retorno = $vo_locatarios->get_id_locatario() ? trim($vo_locatarios->get_id_locatario()) : null;
        }
    } else {
        if ($dao_locatarios->inserir($vo_locatarios)) {
            $retorno = $vo_locatarios->get_id_locatario() ? trim($vo_locatarios->get_id_locatario()) : null;
        }
    }
    
    echo json_encode(array(
        'id_locatario' => $retorno,
        'resposta' => 'sucesso'
    ));
};


if ($acao == 'carrega_objeto') {

    $dao_tipo_locatario = new dao_tipo_locatario();

    $id_locatario = !empty($_POST['id_locatario']) ? $_POST['id_locatario'] : null;

    $vo_locatarios = $dao_locatarios->carrega_objeto($id_locatario);
    $tipo_locatario = $dao_tipo_locatario->carrega_objeto($vo_locatarios->get_ex_tipo());

    $retorno = false;

    if ($vo_locatarios) {
        $retorno = array(
            'id_locatario' => $vo_locatarios->get_id_locatario() ? trim($vo_locatarios->get_id_locatario()) : null,
            'nome' => $vo_locatarios->get_nome() ? trim($vo_locatarios->get_nome()) : null,
            'endereco' => $vo_locatarios->get_endereco() ? trim($vo_locatarios->get_endereco()) : null,
            'telefone' => $vo_locatarios->get_telefone() ? trim($vo_locatarios->get_telefone()) : null,
            'responsavel' => $vo_locatarios->get_responsavel() ? trim($vo_locatarios->get_responsavel()) : null,
            'ex_tipo' => $tipo_locatario->get_id_tipo_locatario() ? trim($tipo_locatario->get_id_tipo_locatario()) : null,
            'email' => $vo_locatarios->get_email() ? trim($vo_locatarios->get_email()) : null,
            'codigo' => $vo_locatarios->get_codigo() ? trim($vo_locatarios->get_codigo()) : null
        );
    }
    echo json_encode($retorno);
}

if ($acao === "carrega_select") {

    $retorno = array();

    $funcao = !empty($_POST['funcao']) ? $_POST['funcao'] : null;

    if($funcao == 'D') {
        $vo_locatarios = $dao_locatarios->carrega_com_locacao_ativa();
    } else {        
        $vo_locatarios = $dao_locatarios->carrega_tudo();
    }

    if ($vo_locatarios) {
        foreach ($vo_locatarios as $temp) {
            array_push($retorno, array(
                'id_locatario' => $temp->get_id_locatario() ? trim($temp->get_id_locatario()) : null,
                'nome' => $temp->get_nome() ? trim($temp->get_nome()) : null,                
                'codigo' => $temp->get_codigo() ? trim($temp->get_codigo()) : null              
            ));
        }
    }
    echo json_encode($retorno);
}

if ($acao === 'verifica_codigo') {

    $codigo = !empty($_POST['codigo']) ? $_POST['codigo'] : null;
    $id_locatario = !empty($_POST['id_locatario']) ? $_POST['id_locatario'] : null;

    $verifica = $dao_locatarios->verifica_codigo($codigo);

    if ($id_locatario) {        
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