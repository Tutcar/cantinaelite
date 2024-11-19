<?php

namespace app\models\validacao;

use app\core\Validacao;
use app\models\service\Service;

class RestricoesValidacao
{
    public static function salvar($restricoes)
    {

        $validacao = new Validacao();
        $validacao->setData("id_cliente", $restricoes->id_cliente);
        $validacao->setData("id_produtos", $restricoes->id_produtos);

        //Fazendo a validação
        $validacao->getData("id_cliente")->isVazio();
        $validacao->getData("id_produtos")->isVazio();

        return $validacao;
    }
}
