<?php

namespace app\models\validacao;

use app\core\Validacao;
use app\models\service\Service;

class CaixafechaValidacao
{
    public static function salvar($Caixafecha)

    {

        $validacao = new Validacao();

        //$validacao->setData("login", $Caixafecha->login);

        //Fazendo a validação

        //$validacao->getData("Caixafecha")->isVazio()->isMinimo(4);

        return $validacao;
    }
}
