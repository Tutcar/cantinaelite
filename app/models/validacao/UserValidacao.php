<?php

namespace app\models\validacao;

use app\core\Validacao;
use app\models\service\Service;

class UserValidacao
{
    public static function salvar($User)

    {
        $qu = Service::get("user", "login_cli", $User->login_cli);
        if ($qu->id_user > 1) {
            $quant = 1;
        } else {
            $quant = 0;
        }
        $validacao = new Validacao();

        $validacao->setData("login_cli", $User->login_cli);
        $validacao->setData("senha", $User->senha);
        $validacao->setData("e_mail", $User->e_mail);

        //Fazendo a validação

        $validacao->getData("login_cli")->isVazio()->isMinimo(4)->isUnico($quant);
        $validacao->getData("senha")->isVazio()->isMinimo(6);
        $validacao->getData("e_mail")->isVazio();

        return $validacao;
    }
}
