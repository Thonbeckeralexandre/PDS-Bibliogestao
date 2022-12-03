<?php

class vo_reservas {

    private $id_reserva;
    private $ex_locatario;
    private $ex_livro;

    public function construtor_vo_reservas($sql) {
        $this->id_reserva = $sql->id_reserva;
        $this->ex_locacao = $sql->ex_locacao;
        $this->datahora_entrega = $sql->datahora_entrega;
    }

    public function get_id_reserva()
    {
        return $this->id_reserva;
    }
    public function set_id_reserva($id_reserva)
    {
        $this->id_reserva = $id_reserva;

        return $this;
    }

    public function get_ex_locatario()
    {
        return $this->ex_locatario;
    }
    public function set_ex_locatario($ex_locatario)
    {
        $this->ex_locatario = $ex_locatario;

        return $this;
    }

    public function get_ex_livro()
    {
        return $this->ex_livro;
    }
    public function set_ex_livro($ex_livro)
    {
        $this->ex_livro = $ex_livro;

        return $this;
    }
}