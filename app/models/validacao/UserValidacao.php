<?php

namespace app\models\validacao;

use app\core\Validacao;
use app\models\service\Service;

class UserValidacao
{
    public static function salvar($User)

    {

        $validacao = new Validacao();

        $validacao->setData("login_cli", $User->login_cli);
        $validacao->setData("senha", $User->senha);
        $validacao->setData("e_mail", $User->e_mail);

        //Fazendo a validação

        $validacao->getData("User")->isVazio()->isMinimo(4);
        $validacao->getData("senha")->isVazio()->isMinimo(6);
        $validacao->getData("e_mail")->isVazio();

        return $validacao;
    }
}
