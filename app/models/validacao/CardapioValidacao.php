<?php

namespace app\models\validacao;

use app\core\Validacao;
use app\models\service\Service;

class CardapioValidacao
{
    public static function salvar($Cardapio)

    {

        $validacao = new Validacao();
        $validacao->setData("nome", $Cardapio->nome);
        $validacao->setData("descricao", $Cardapio->descricao);
        $validacao->setData("dia", $Cardapio->dia);
        $validacao->setData("venda", $Cardapio->venda);
        //Fazendo a validação
        $validacao->getData("nome")->isVazio();
        $validacao->getData("descricao")->isVazio();
        $validacao->getData("dia")->isVazio();
        $validacao->getData("venda")->isVazio();
        return $validacao;
    }
}
