<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION)) {
    session_start();
}

require_once('/app/dao/dao_locacoes.php');
require_once('/app/dao/dao_devolucoes.php');
require_once('/app/dao/dao_livros_nn_locacoes.php');
require_once('/app/dao/dao_livros_nn_locacoes_historico.php');
require_once('/app/dao/dao_livros.php');
require_once('/app/apoio/apoio.php');

$acao = !empty($_POST['acao']) ? $_POST['acao'] : $_GET['acao'];

if ($acao == 'carrega_datatable') {

    $retorno = false;
    $dados['data'] = array();

    $dao_locacoes = new dao_locacoes();
    $dao_devolucoes = new dao_devolucoes();
    $dao_livros_nn_locacoes = new dao_livros_nn_locacoes();
    $dao_livros_nn_locacoes_historico = new dao_livros_nn_locacoes_historico();
    $vo_locacoes = new vo_locacoes();

    // A = Ativo
    // I = Inativo
    $status = !empty($_POST['status']) ? $_POST['status'] : 'A';

    $vo_locacoes = $dao_locacoes->carrega_datatable($status);

    if ($vo_locacoes) {

        foreach ($vo_locacoes as $temp) {

            $livros = '';
            $array_id = array();
            $livros_array = $dao_livros_nn_locacoes->carrega_id_livros_por_locacao($temp->id_locacao);

            if ($livros_array) {
                foreach ($livros_array as $temp2) {
                    array_push($array_id, $temp2->id_livro);
                }
            }           

            $livros_array = str_replace('"', "'", json_encode($array_id));

            if ($status == 'A') {                
                $livros = $dao_livros_nn_locacoes->carrega_livros_por_locacao($temp->id_locacao);
                $funcoes = '<center>';
                $funcoes .= '&nbsp<button onclick="realizar_devolucao(\'' . $temp->ex_locatario . '\', ' . $livros_array . ', \'' . $temp->id_locacao . '\')" type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" title="Abrir/Editar"><i  class="fa fa-folder-open"></i></button>';
                $funcoes .= '</center>';
                $datahora = $temp->datahora_locacao;
            } else {
                $livros = $dao_devolucoes->carrega_livros_por_locacao($temp->id_locacao);
                $funcoes = '<center>';
                $funcoes .= '&nbsp<button onclick="abre_obs(\'' . $temp->id_locacao . '\')" type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" title="Observações"><i  class="fa fa-eye"></i></button>';
                $funcoes .= '</center>';
                $datahora_inicial = $dao_devolucoes->carrega_datahora_entrega($temp->id_locacao);
                $datahora = $datahora_inicial->datahora;
            }

            if ($livros != false) {
                $a = strval($livros->nome);
            } else {
                $a = '';
            }

            $retorno = array(
                'locatario' => $temp->locatario,
                'livros' => $a,
                'datahora_locacao' => ConverteDataHoraPTBR($datahora),
                'funcoes' => $funcoes
            );
            array_push($dados['data'], $retorno);

        }        
    }
    echo json_encode($dados);
}

if ($acao === 'verifica_locatario') {
    $retorno = false;    
    $dao_locacoes = new dao_locacoes();

    $locatario = !empty($_POST['locatario']) ? $_POST['locatario'] : null;

    if ($locatario) {
        $verificacao = $dao_locacoes->verifica_locatario($locatario);
        if ($verificacao == '0') {
            $retorno = true;
        }
    }

    echo json_encode($retorno);
}

if ($acao === 'inserir') {
    $retorno = false;
    $vo_locacoes = new vo_locacoes();
    $vo_devolucoes = new vo_devolucoes();
    $dao_livros_nn_locacoes = new dao_livros_nn_locacoes();
    $dao_locacoes = new dao_locacoes();
    $dao_devolucoes = new dao_devolucoes();
    $dao_livros = new dao_livros();

    $id_locacao = !empty($_POST['id_locacao']) ? $_POST['id_locacao'] : false;

    if (!$id_locacao) {      
        $id_locacao_new = gera_uuid_v4();
        $vo_locacoes->set_id_locacao($id_locacao_new);
        $vo_locacoes->set_datahora_locacao(get_datahora());
        $vo_locacoes->set_ex_locatario(!empty($_POST['select_locatario']) ? $_POST['select_locatario'] : null);
        $vo_locacoes->set_ex_usuario($_SESSION['usuario']);
        $vo_locacoes->set_obs(!empty($_POST['obs_locacao']) ? $_POST['obs_locacao'] : null);
        $vo_locacoes->set_status('A');

        if ($dao_locacoes->inserir($vo_locacoes)) {
            $retorno = trim($vo_locacoes->get_id_locacao());
        }        

        $array_livros = !empty($_POST['array_livros']) ? $_POST['array_livros'] : null;
        if ($array_livros) {
            foreach ($array_livros as $livros) {
                $dao_livros_nn_locacoes->inserir_livros_nn_locacao($vo_locacoes->get_id_locacao(), $livros);

                $vo_devolucoes->set_datahora_entrega(null);
                $vo_devolucoes->set_ex_locacao($id_locacao_new);
                $vo_devolucoes->set_obs(null);
                $vo_devolucoes->set_ex_usuario($_SESSION['usuario']);
                $vo_devolucoes->set_ex_livro($livros);
                $dao_devolucoes->inserir($vo_devolucoes);
                $dao_livros->atualiza_disponibilidade($livros, 'N');
            }
        }

        echo json_encode(array(
            'id_locacao' => $retorno,
            'resposta' => 'sucesso'
        ));

    } else {
        return $retorno;
    }   
    
};

if ($acao === 'devolucao') {
    $retorno = false;
    $vo_locacoes = new vo_locacoes();
    $vo_devolucoes = new vo_devolucoes();
    $dao_livros_nn_locacoes = new dao_livros_nn_locacoes();
    $dao_livros_nn_locacoes_historico = new dao_livros_nn_locacoes_historico();
    $dao_locacoes = new dao_locacoes();
    $dao_devolucoes = new dao_devolucoes();
    $dao_livros = new dao_livros();

    $id_locacao = !empty($_POST['id_devolucao']) ? $_POST['id_devolucao'] : false;
    $obs = !empty($_POST['obs_devolucao']) ? $_POST['obs_devolucao'] : null;

    if ($id_locacao) {      

        $array_livros = !empty($_POST['array_livros_devolucao']) ? $_POST['array_livros_devolucao'] : null;

        foreach($array_livros as $livros) {           

            $dao_devolucoes->devolucao($livros, $id_locacao, get_datahora(), $obs);
            $dao_livros_nn_locacoes->delete_livros_nn_locacao($id_locacao, $livros);
            $dao_livros->atualiza_disponibilidade($livros, 'S');
        }

        $livros_remanescentes = $dao_livros_nn_locacoes->confere_devolucao_completa($id_locacao);
        if ($livros_remanescentes == '0') {            
            $dao_locacoes->devolucao($id_locacao);
        }

        echo json_encode(array(
            'id_locacao' => $retorno,
            'resposta' => 'sucesso'
        ));

    } else {
        return $retorno;
    }   
    
};