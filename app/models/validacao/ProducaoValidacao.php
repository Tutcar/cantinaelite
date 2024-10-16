<?php

namespace app\models\validacao;

use app\core\Validacao;
use app\models\service\Service;

class ProducaoValidacao
{
    public static function salvar($Producao)

    {

        $validacao = new Validacao();
        // $validacao->setData("nome", $Produtos->nome);
        // $validacao->setData("tipo", $Produtos->tipo);
        // $validacao->setData("venda", $Produtos->venda);
        // //Fazendo a validação
        // $validacao->getData("nome")->isVazio();
        // $validacao->getData("tipo")->isVazio();
        // $validacao->getData("venda")->isVazio();
        return $validacao;
    }
}
