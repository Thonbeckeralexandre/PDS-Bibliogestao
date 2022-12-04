<?php

function gera_uuid_v4($tabela = null)
{
    $registro = sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),

        // 16 bits for "time_mid"

        mt_rand(0, 0xffff),
        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand(0, 0x0fff) | 0x4000,
        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand(0, 0x3fff) | 0x8000,
        // 48 bits for "node"
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    );
    $verifica_uuid = consulta_padrao($tabela, $registro);
    while ($verifica_uuid > 0) {
        $registro = gera_uuid_v4($tabela);
    }
    return $registro;
}

function consulta_padrao($tabela, $registro)
{
    $tabela = filter_var($tabela);

    if ($tabela != null) {
        $sql = "SELECT COUNT(*) as total FROM $tabela WHERE registro = :registro";
        $sql = db::prepare($sql);
        $sql->bindParam(':registro', $registro);
        $sql->execute();
        $sql = $sql->fetch();
        if ($sql) {
            return $sql->total;
        } else {
            return false;
        }
    } else {
        return 0;
    }
}

function ConverteDataHoraPTBR($datahora)
{
    if ($datahora) {

        $temp = explode(' ', $datahora);
        $data_pt = implode("/", array_reverse(explode("-", $temp[0])));
        $data_final = $data_pt . ' ' . $temp[1];
        return $data_final;
    } else {
        return '';
    }
}

function get_datahora()
{
    return date('Y-m-d H:i:s');
}

function verifica_login() {
    if (!isset($_SESSION)) {
        session_start();
    }
    if (!isset($_SESSION['usuario'])) {
        session_destroy();
        header('Location: /login.php');
    }
}