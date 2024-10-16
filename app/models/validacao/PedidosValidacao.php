<?php

namespace app\models\validacao;

use app\core\Validacao;
use app\models\service\Service;

class pedidosValidacao
{
    public static function salvar($pedidos)

    {

        $validacao = new Validacao();

        //$validacao->setData("login", $pedidos->login);

        //Fazendo a validação

        //$validacao->getData("pedidos")->isVazio()->isMinimo(4);

        return $validacao;
    }
}
