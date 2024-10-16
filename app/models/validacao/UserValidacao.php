<?php

namespace app\models\validacao;

use app\core\Validacao;
use app\models\service\Service;

class UserValidacao
{
    public static function salvar($User)

    {

        $validacao = new Validacao();

        $validacao->setData("login", $User->login);

        //Fazendo a validação

        $validacao->getData("User")->isVazio()->isMinimo(4);

        return $validacao;
    }
}
