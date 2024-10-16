<?php

namespace app\models\validacao;

use app\core\Validacao;
use app\models\service\Service;

class TipoacValidacao
{
    public static function salvar($tipoac)
    {
        $validacao = new Validacao();

        $validacao->setData("ac_tipo", $tipoac->ac_tipo);
        if (!$_SESSION['UNICO']) {
            $unico = 0;
        } else {
            $unico = 1;
        }
        unset($_SESSION['UNICO']);
        //Fazendo a validação
        $validacao->getData("ac_tipo")->isVazio()->isUnico($unico);

        return $validacao;
    }
}
