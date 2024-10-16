<?php

namespace app\models\validacao;

use app\core\Validacao;
use app\models\service\Service;

class RecsenhaValidacao
{
    public static function salvar($recsenha)
    {

        $validacao = new Validacao();
        $validacao->setData("token", $recsenha->token);
        //Fazendo a validação
        $validacao->getData("token")->isVazio();
        return $validacao;
    }
}
