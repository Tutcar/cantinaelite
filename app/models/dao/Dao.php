<?php

namespace app\models\dao;

use app\core\Model;

class Dao extends Model
{
    public function getCompensado($tabela, $campoAgregacao, $campo, $valor, $id_corretora)
    {
        return  $this->findCompensado($this->db, $tabela, $campoAgregacao, $campo, $valor, $id_corretora);
    }
    public function getCredito($tabela, $campoAgregacao, $campo, $valor, $id_corretora)
    {
        return  $this->findCredito($this->db, $tabela, $campoAgregacao, $campo, $valor, $id_corretora);
    }
    public function getDebito($tabela, $campoAgregacao, $campo, $valor, $id_corretora)
    {
        return  $this->findDebito($this->db, $tabela, $campoAgregacao, $campo, $valor, $id_corretora);
    }
    public function getAcompensar($tabela, $campoAgregacao, $campo, $valor, $id_corretora)
    {
        return  $this->findAcompensar($this->db, $tabela, $campoAgregacao, $campo, $valor, $id_corretora);
    }
    public function listaCorr($tabela, $id_corretora)
    {
        return  $this->all3($this->db, $tabela, $id_corretora);
    }
    public function getLikeC($tabela, $campo, $valor, $id_corretora, $eh_lista, $posicao)
    {
        return  $this->findlikeC($this->db, $campo, $valor, $id_corretora, $tabela, $eh_lista, $posicao);
    }
    public function lista($tabela)
    {
        return  $this->all($this->db, $tabela);
    }

    public function get($tabela, $campo, $valor, $eh_lista)
    {
        return  $this->find($this->db, $campo, $valor, $tabela, $eh_lista);
    }
    public function getGeral($tabela, $campo, $operador, $valor, $eh_lista)
    {
        return  $this->findGeral($this->db, $campo, $operador, $valor, $tabela, $eh_lista);
    }

    public function getEntre($tabela, $campo, $valor1, $valor2)
    {
        return  $this->findEntre($this->db, $campo, $valor1, $valor2, $tabela);
    }

    public function getLike($tabela, $campo, $valor, $eh_lista, $posicao)
    {
        return  $this->findlike($this->db, $campo, $valor, $tabela, $eh_lista, $posicao);
    }

    public function getTotal($tabela, $campoAgregacao, $campo, $valor)
    {
        return  $this->findAgrega($this->db, 'total', $campoAgregacao, $tabela, $campo, $valor);
    }

    public function getSoma($tabela, $campoAgregacao, $campo, $valor)
    {
        return  $this->findAgrega($this->db, 'soma', $campoAgregacao, $tabela, $campo, $valor);
    }
    public function getSoma2($tabela, $campoAgregacao, $campo, $valor)
    {
        return  $this->findAgrega2($this->db, 'soma', $campoAgregacao, $tabela, $campo, $valor);
    }

    public function getMaximo($tabela, $campoAgregacao, $campo, $valor)
    {
        return  $this->findAgrega($this->db, 'max', $campoAgregacao, $tabela, $campo, $valor);
    }
    public function getMinimo2($tabela, $campoAgregacao, $campo, $valor)
    {
        return  $this->findAgrega2($this->db, 'min', $campoAgregacao, $tabela, $campo, $valor);
    }

    public function getMinimo($tabela, $campoAgregacao, $campo, $valor)
    {
        return  $this->findAgrega($this->db, 'min', $campoAgregacao, $tabela, $campo, $valor);
    }

    public function getMedia($tabela, $campoAgregacao, $campo, $valor)
    {
        return  $this->findAgrega($this->db, 'media', $campoAgregacao, $tabela, $campo, $valor);
    }
    public function inserir($valores, $tabela)
    {
        return $this->add($this->db,  $valores, $tabela);
    }

    public function editar($valores, $campo, $tabela)
    {
        return $this->edit($this->db,  $valores,  $campo, $tabela);
    }

    public function excluir($tabela, $campo, $valor)
    {
        return $this->del($this->db, $campo, $valor, $tabela);
    }
    public function excluiritem($tabela, $campo, $valor, $valor2 = null)
    {
        return $this->del2($this->db, $campo, $valor, $valor2 = null, $tabela);
    }
}
