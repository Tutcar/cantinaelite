<?php

namespace app\models\validacao;

use app\core\Validacao;
use app\models\service\Service;

class CaixaabreValidacao
{
    public static function salvar($Caixaabre)

    {

        $validacao = new Validacao();

        //$validacao->setData("login", $Caixaabre->login);

        //Fazendo a validação

        //$validacao->getData("Caixaabre")->isVazio()->isMinimo(4);

        return $validacao;
    }
}
